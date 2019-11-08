<?php declare(strict_types=1);


namespace App\Repository;


use App\Entity\FeedAuthor;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class FeedAuthorRepository
 * @package App\Repository
 *
 * @method FeedAuthor|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeedAuthor[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method FeedAuthor[] findAll()
 * @method FeedAuthor|null find($id, $lockMode = null, $lockVersion = null)
 */
class FeedAuthorRepository extends EntityRepository
{
    /**
     * @param \App\ValueObject\FeedAuthor $author
     * @return FeedAuthor
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getOrCreateEntityByData(\App\ValueObject\FeedAuthor $author): FeedAuthor
    {
        $existing = $this->findOneBy([
            'fullName' => $author->getName(),
            'homepageUri' => $author->getUri(),
        ]);

        if ($existing) {
            if ($author->getEmail()) {
                $existing->setEmailAddress($author->getEmail());
            }

            return $existing;
        }

        $new = new FeedAuthor();

        $new->setEmailAddress($author->getEmail());
        $new->setFullName($author->getName());
        $new->setHomepageUri($author->getUri());
        $new->setCreated(new DateTime());

        $this->getEntityManager()->persist($new);
        $this->getEntityManager()->flush($new);

        return $new;
    }
}
