<?php declare(strict_types=1);


namespace App\Repository;


use App\Entity\ExternalId;
use App\Entity\FeedAuthor;
use App\ValueObject\FeedEntry;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

/**
 * Class ExternalIdRepository
 * @package App\Repository
 *
 * @method ExternalId|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExternalId[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ExternalId[] findAll()
 * @method ExternalId|null find($id, $lockMode = null, $lockVersion = null)
 */
class ExternalIdRepository extends EntityRepository
{
    /**
     * @param FeedEntry $feedEntry
     * @param FeedAuthor $author
     * @return ExternalId
     * @throws ORMException
     */
    public function getOrCreateEntityByData(FeedEntry $feedEntry, FeedAuthor $author): ExternalId
    {
        $existing = $this->findOneBy([
            'externalId' => $feedEntry->getId(),
        ]);

        if ($existing) {
            $existing->setAuthor($author);
            $existing->setLastImportTime(new DateTime());
            $existing->setLastUpdateTime($feedEntry->getUpdated());

            return $existing;
        }

        $new = new ExternalId();

        $new->setAuthor($author);
        $new->setExternalId($feedEntry->getId());
        $new->setLastImportTime(new DateTime());
        $new->setImported(new DateTime());
        $new->setLastUpdateTime($feedEntry->getUpdated());

        $this->getEntityManager()->persist($new);
        $this->getEntityManager()->flush($new);

        return $new;
    }
}
