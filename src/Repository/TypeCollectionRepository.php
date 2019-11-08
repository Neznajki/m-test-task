<?php declare(strict_types=1);


namespace App\Repository;


use App\Contract\ContainsTypeInterface;
use App\Entity\TypeCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

/**
 * Class TypeCollectionRepository
 * @package App\Repository
 *
 * @method TypeCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeCollection[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method TypeCollection[] findAll()
 * @method TypeCollection|null find($id, $lockMode = null, $lockVersion = null)
 */
class TypeCollectionRepository extends EntityRepository
{
    /**
     * @param ContainsTypeInterface $feedEntry
     * @return TypeCollection
     * @throws ORMException
     */
    public function getOrCreateEntityByData(
        ContainsTypeInterface $feedEntry
    ): TypeCollection {
        $existing = $this->findOneBy(
            [
                'typeName' => $feedEntry->getType(),
            ]
        );

        if ($existing) {
            return $existing;
        }

        $new = new TypeCollection();

        $new->setTypeName($feedEntry->getType());
        $this->getEntityManager()->persist($new);
        $this->getEntityManager()->flush($new);

        return $new;
    }
}
