<?php

namespace App\Repository;

use App\Entity\Ward;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Ward|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ward|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ward[]    findAll()
 * @method Ward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ward::class);
    }

    // /**
    //  * @return Ward[] Returns an array of Ward objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ward
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
