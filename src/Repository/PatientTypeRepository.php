<?php

namespace App\Repository;

use App\Entity\PatientType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PatientType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatientType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatientType[]    findAll()
 * @method PatientType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatientType::class);
    }

    /**
     * @return PatientType[] Returns an array of PatientType objects
     */
    
    public function findByPatientType()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.Type' == 'Surgical Patient')
            ->getQuery()
            ->execute()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?PatientType
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
