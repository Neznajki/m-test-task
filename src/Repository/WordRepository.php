<?php declare(strict_types=1);


namespace App\Repository;


use App\Entity\Word;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class WordRepository
 * @package App\Repository
 *
 * @method Word|null findOneBy(array $criteria, array $orderBy = null)
 * @method Word[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Word[] findAll()
 * @method Word|null find($id, $lockMode = null, $lockVersion = null)
 */
class WordRepository extends EntityRepository
{

    /**
     * @param array $wordList
     * @return Word[]
     */
    public function getExistingWords(array $wordList): array
    {
        return $this->findBy([
            'word' => $wordList,
        ]);
    }

    /**
     * @param string $word
     * @return Word
     * @throws ORMException
     */
    public function createEntityByData(
        string $word
    ): Word {
        $new = new Word();

        $new->setWord($word);

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
