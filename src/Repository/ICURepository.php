<?php

namespace App\Repository;

use App\Entity\ICU;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ICU|null find($id, $lockMode = null, $lockVersion = null)
 * @method ICU|null findOneBy(array $criteria, array $orderBy = null)
 * @method ICU[]    findAll()
 * @method ICU[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ICURepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ICU::class);
    }

    // /**
    //  * @return ICU[] Returns an array of ICU objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ICU
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
