<?php /** @noinspection SqlResolve */
/** @noinspection SqlNoDataSourceInspection */
declare(strict_types=1);


namespace App\Repository;


use App\Entity\ExternalId;
use App\Entity\FeedFoundWord;
use App\Entity\FeedSummary;
use App\Entity\FeedTitle;
use App\Entity\WordsTotalOccurrence;
use App\Entity\WordSupportedPlace;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityRepository;
use RuntimeException;

/**
 * Class WordsTotalOccurrenceRepository
 * @package App\Repository
 *
 * @method WordsTotalOccurrence|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordsTotalOccurrence[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method WordsTotalOccurrence[] findAll()
 * @method WordsTotalOccurrence|null find($id, $lockMode = null, $lockVersion = null)
 */
class WordsTotalOccurrenceRepository extends EntityRepository
{

    /**
     * @param WordSupportedPlace $wordSupportedPlace
     * @throws DBALException
     */
    public function groupInformationExistingData(WordSupportedPlace $wordSupportedPlace)
    {
        $tempTableName = 'temp_words_total';
        $currentTable = $this->getClassMetadata()->getTableName();
        $tableFeedFound = $this->getEntityManager()->getClassMetadata(FeedFoundWord::class)->getTableName();
        $tableExternal = $this->getEntityManager()->getClassMetadata(ExternalId::class)->getTableName();

        switch ($wordSupportedPlace->getSourceName()) {
            case 'title':
                $tableSourcePlace = $this->getEntityManager()->getClassMetadata(FeedTitle::class)->getTableName();
                break;
            case 'summary':
                $tableSourcePlace = $this->getEntityManager()->getClassMetadata(FeedSummary::class)->getTableName();
                break;
            default:
                throw new RuntimeException(sprintf('unsupported place %s', $wordSupportedPlace->getSourceName()));
        }

        $this->getEntityManager()->getConnection()->executeQuery("DROP TABLE IF EXISTS `{$tempTableName}`");
        $this->getEntityManager()->getConnection()->executeQuery("CREATE TABLE `{$tempTableName}` LIKE `{$currentTable}`");

        $this->getEntityManager()->getConnection()->executeQuery(
            "INSERT INTO `{$tempTableName}`
SELECT null, ffw.word_id, {$wordSupportedPlace->getId()}, 1
FROM `{$tableFeedFound}` as ffw
JOIN `{$tableExternal}` as ei on ei.id = ffw.external_id
JOIN `{$tableSourcePlace}` as fs on ei.id = fs.external_id
ON DUPLICATE KEY UPDATE `appeared_times` = `appeared_times` + 1;"
        );

        $oldTableName = "words_total_occurrence_old";
        $this->getEntityManager()->getConnection()->executeQuery("RENAME TABLE `{$currentTable}` TO `{$oldTableName}`");
        $this->getEntityManager()->getConnection()->executeQuery("RENAME TABLE `{$tempTableName}` TO `{$currentTable}`");
        $this->getEntityManager()->getConnection()->executeQuery("DROP TABLE `{$oldTableName}`");
    }
}
