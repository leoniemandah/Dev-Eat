<?php

namespace App\Repository;

use App\Entity\OrderMeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderMeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderMeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderMeal[]    findAll()
 * @method OrderMeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderMealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderMeal::class);
    }

    // /**
    //  * @return OrderMeal[] Returns an array of OrderMeal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderMeal
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
