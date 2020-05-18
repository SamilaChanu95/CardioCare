<?php

namespace App\Repository;

use App\Entity\Unit;
use App\Entity\Department;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine;

/**
 * @method Unit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unit[]    findAll()
 * @method Unit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unit::class);
    }

    /*
    public function findByUnits($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQueryBuilder()
                    ->select('u')
                    ->from(Unit::class, 'u')
                    ->from(Department::class, 'd')
                    ->where('u.Department = d.id')
                    ->getQuery();

        $unit = $query->getSingleResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
        
        return $unit;
        
        /*
        return $this->createQueryBuilder('unit')
            ->addSelect('unit')
            ->from(Unit::class, 'unit')
            ->from(Department::class, 'department')
            ->where("unit.Department = department.id")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        */
        //$units = (array) $queryBuilder;             
        //return $units;

        /*
        $query = $entityManager->createQuery(
            'SELECT u.UnitName
            FROM App\Entity\Unit u
            FROM App\Entity\Department d
            WHERE d.id = u.Department'
        );
        
        // returns an array of Product objects
        return $query->getResult();
        

        //$query->select('u')
        //      ->innerJoin(Department::class, 'd', Join::WITH, 'd.id = u.Department');            
        //return $query;

    }
    */

    /*
    public function findOneBySomeField($value): ?Unit
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
