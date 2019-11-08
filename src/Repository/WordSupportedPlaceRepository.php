<?php declare(strict_types=1);


namespace App\Repository;

use App\Entity\WordSupportedPlace;
use Doctrine\ORM\EntityRepository;

/**
 * Class WordSupportedPlaceRepository
 * @package App\Repository
 *
 * @method WordSupportedPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordSupportedPlace[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method WordSupportedPlace[] findAll()
 * @method WordSupportedPlace|null find($id, $lockMode = null, $lockVersion = null)
 */
class WordSupportedPlaceRepository extends EntityRepository
{

}
