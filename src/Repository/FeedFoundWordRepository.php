<?php declare(strict_types=1);


namespace App\Repository;


use App\Contract\ContentIncludedEntity;
use App\Entity\FeedFoundWord;
use App\Entity\Word;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class FeedFoundWordRepository
 * @package App\Repository
 *
 * @method FeedFoundWord|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeedFoundWord[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method FeedFoundWord[] findAll()
 * @method FeedFoundWord|null find($id, $lockMode = null, $lockVersion = null)
 */
class FeedFoundWordRepository extends EntityRepository
{

    /**
     * @param ContentIncludedEntity $entity
     */
    public function importBegan(ContentIncludedEntity $entity)
    {
        $qb = $this->createQueryBuilder('ffw')
            ->update()
            ->set('ffw.isMarkedForDelete', 1)
            ->where(sprintf('ffw.external = :external'))
            ->setParameter('external', $entity);

        $query = $qb->getQuery();
        $query->execute();
    }

    /**
     *
     */
    public function importDone()
    {
        $qb = $this->createQueryBuilder('ei')
            ->delete()
            ->where('ei.isMarkedForDelete = 1');

        $qb->getQuery()->execute();
    }

    /**
     * @param Word $word
     * @param ContentIncludedEntity $entity
     * @return FeedFoundWord
     * @throws ORMException
     */
    public function createNewRelationEntity(
        Word $word,
        ContentIncludedEntity $entity
    ): FeedFoundWord {
        $new = new FeedFoundWord();

        $new->setWord($word);
        $new->setExternal($entity->getExternal());
        $new->setIsMarkedForDelete(false);

        $this->getEntityManager()->persist($new);

        return $new;
    }

    /**
     * @param array $entityList
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function flushChanges(array $entityList)
    {
        $this->getEntityManager()->flush($entityList);
    }
}
