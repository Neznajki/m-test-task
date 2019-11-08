<?php declare(strict_types=1);


namespace App\Repository;


use App\Entity\ExternalId;
use App\Entity\FeedLink;
use App\Entity\RelCollection;
use App\Entity\TypeCollection;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

/**
 * Class FeedLinkRepository
 * @package App\Repository
 *
 * @method FeedLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeedLink[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method FeedLink[] findAll()
 * @method FeedLink|null find($id, $lockMode = null, $lockVersion = null)
 */
class FeedLinkRepository extends EntityRepository
{
    /**
     * @param \App\ValueObject\FeedLink $feedEntry
     * @param ExternalId $externalId
     * @param TypeCollection $type
     * @param RelCollection $rel
     * @return FeedLink
     * @throws ORMException
     */
    public function getOrCreateEntityByData(
        \App\ValueObject\FeedLink $feedEntry,
        ExternalId $externalId,
        TypeCollection $type,
        RelCollection $rel
    ): FeedLink {
        $existing = $this->findOneBy(
            [
                'external' => $externalId->getId(),
                'href'       => $feedEntry->getHref(),
            ]
        );

        if ($existing) {
            $existing->setRel($rel);
            $existing->setType($type);

            return $existing;
        }

        $new = new FeedLink();

        $new->setExternal($externalId);
        $new->setRel($rel);
        $new->setType($type);
        $new->setHref($feedEntry->getHref());
        $new->setImported(new DateTime());

        $this->getEntityManager()->persist($new);

        return $new;
    }
}
