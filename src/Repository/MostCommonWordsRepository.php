<?php declare(strict_types=1);


namespace App\Repository;


use App\Entity\MostCommonWords;
use Doctrine\ORM\EntityRepository;

/**
 * Class MostCommonWordsRepository
 * @package App\Repository
 *
 * @method MostCommonWords|null findOneBy(array $criteria, array $orderBy = null)
 * @method MostCommonWords[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method MostCommonWords[] findAll()
 * @method MostCommonWords|null find($id, $lockMode = null, $lockVersion = null)
 */
class MostCommonWordsRepository extends EntityRepository
{

}
