<?php

namespace App\Repository;

use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meal::class);
    }


    public function findByRestaurantId()
    {
        return $this->createQueryBuilder('m')
            ->innerJoin( 'm.Restaurant', 'Restaurant', 'WITH', 'Restaurant.id = m.Restaurant')
            ->Where('m.Restaurant = Restaurant.id')
            ->getQuery()
            ->getResult()
        ;
    }
   
}
