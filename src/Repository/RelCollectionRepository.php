<?php declare(strict_types=1);


namespace App\Repository;


use App\Contract\ContainsRelInterface;
use App\Entity\RelCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

/**
 * Class RelCollectionRepository
 * @package App\Repository
 *
 * @method RelCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelCollection[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method RelCollection[] findAll()
 * @method RelCollection|null find($id, $lockMode = null, $lockVersion = null)
 */
class RelCollectionRepository extends EntityRepository
{
    /**
     * @param ContainsRelInterface $feedEntry
     * @return RelCollection
     * @throws ORMException
     */
    public function getOrCreateEntityByData(
        ContainsRelInterface $feedEntry
    ): RelCollection {
        $existing = $this->findOneBy(
            [
                'relName' => $feedEntry->getRel(),
            ]
        );

        if ($existing) {
            return $existing;
        }

        $new = new RelCollection();

        $new->setRelName($feedEntry->getRel());

        $this->getEntityManager()->persist($new);
        $this->getEntityManager()->flush($new);

        return $new;
    }
}
