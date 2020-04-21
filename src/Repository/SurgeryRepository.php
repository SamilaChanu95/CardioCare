<?php

namespace App\Repository;

use App\Entity\Surgery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Surgery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Surgery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Surgery[]    findAll()
 * @method Surgery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurgeryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Surgery::class);
    }

    // /**
    //  * @return Surgery[] Returns an array of Surgery objects
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
    public function findOneBySomeField($value): ?Surgery
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
