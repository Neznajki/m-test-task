<?php declare(strict_types=1);


namespace App\Repository;


use App\Entity\ExternalId;
use App\Entity\FeedSummary;
use App\Entity\TypeCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

/**
 * Class FeedSummaryRepository
 * @package App\Repository
 *
 * @method FeedSummary|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeedSummary[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method FeedSummary[] findAll()
 * @method FeedSummary|null find($id, $lockMode = null, $lockVersion = null)
 */
class FeedSummaryRepository extends EntityRepository
{

    /**
     * @param \App\ValueObject\FeedSummary $feedEntry
     * @param ExternalId $externalId
     * @param TypeCollection $type
     * @return FeedSummary
     * @throws ORMException
     */
    public function getOrCreateEntityByData(
        \App\ValueObject\FeedSummary $feedEntry,
        ExternalId $externalId,
        TypeCollection $type
    ): FeedSummary {
        $existing = $this->findOneBy(
            [
                'external' => $externalId,
            ]
        );

        if ($existing) {
            $existing->setType($type);
            $existing->setContent($feedEntry->getContent());

            return $existing;
        }

        $new = new FeedSummary();

        $new->setExternal($externalId);
        $new->setType($type);
        $new->setContent($feedEntry->getContent());

        $this->getEntityManager()->persist($new);

        return $new;
    }
}
