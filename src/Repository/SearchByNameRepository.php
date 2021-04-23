<?php

namespace App\Repository;

use App\Entity\SearchByName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SearchByName|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchByName|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchByName[]    findAll()
 * @method SearchByName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchByNameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchByName::class);
    }

    // /**
    //  * @return SearchByName[] Returns an array of SearchByName objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SearchByName
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
