<?php

namespace App\DataFixtures;

use App\Entity\Meal;
use App\Entity\Restaurant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Node\SetNode;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)

  {
      $this->passwordEncoder = $passwordEncoder;
  }
  
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 25; $i++) {
            $user = new User;
            $user
              ->setEmail($faker->freeEmail)
              ->setRoles(['ROLE_RESTAURANT'])
              ->setPassword($this->passwordEncoder->encodePassword($user,'test'))
              ->setFirstName($faker->firstName)
              ->setLastName($faker->lastName)
              ->setSolde($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000))
              ->setAddress($faker->address);


            $manager->persist($user);
          }

        for ($i = 0; $i < 25; $i++) {
            $restaurant = new Restaurant;
            $restaurant
              ->setName($faker->sentence(3))
              ->setLogo($faker->imageUrl)
              ->setAddress($faker->address);
        
            $manager->persist($restaurant);
          }

          for ($i = 0; $i < 25; $i++) {
            $meal = new Meal;
            $meal
              ->setName($faker->sentence(3))
              ->setPicture($faker->imageUrl)
              ->setPrice($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 30))
              ->setNote($faker->numberBetween($min = 0, $max = 5))
              ->setRestaurant($restaurant);
            $manager->persist($meal);
          }

      
          $manager->flush();
          
    }

}
