<?php

namespace App\Repository;

use App\Entity\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Department|null find($id, $lockMode = null, $lockVersion = null)
 * @method Department|null findOneBy(array $criteria, array $orderBy = null)
 * @method Department[]    findAll()
 * @method Department[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }

    // /**
    //  * @return Department[] Returns an array of Department objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findOneBySomeField($department): ?Department
    {
        return $this->createQueryBuilder("q")
            ->where("q.department = :departmentid")
            ->setParameter("departmentid", $department->getId())
            ->getQuery()
            ->getResult();
        ;
    }

    public function findDepartment($request): ?Department
    {
        return $this->createQueryBuilder("q")
            ->where("q.department = :departmentid")
            ->setParameter("departmentid", $request->query->get("departmentid"))
            ->getQuery()
            ->getResult();
        ;
    }
    
    public function findById($value): ?Department
     {
 
         $result = $this->createQueryBuilder('d')
             ->andWhere('d.id = :val')
             ->setParameter('val', $value)
             ->getQuery()
             ->getOneOrNullResult()
         ;
         return $result;
         
     }
}
