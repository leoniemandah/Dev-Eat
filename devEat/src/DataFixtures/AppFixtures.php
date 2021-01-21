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
        ->setRoles([''])
        ->setPassword($this->passwordEncoder->encodePassword($user, '154876923'))
        ->setFirstName($faker->firstName)
        ->setLastName($faker->lastName)
        ->setSolde($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000))
        ->setAddress($faker->address);


      $manager->persist($user);
    }

    for ($i = 0; $i < 25; $i++) {
      $user = new User;
      $user
        ->setEmail($faker->freeEmail)
        ->setRoles(['ROLE_RESTAURAT'])
        ->setPassword($this->passwordEncoder->encodePassword($user, '154876923'))
        ->setFirstName($faker->firstName)
        ->setLastName($faker->lastName)
        ->setSolde($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000))
        ->setAddress($faker->address);


      $manager->persist($user);
    }

    $user = new User;
    $user
      ->setEmail('admin@admin.com')
      ->setRoles(['ROLE_ADMIN'])
      ->setPassword($this->passwordEncoder->encodePassword($user, '154876923'))
      ->setFirstName('admin')
      ->setLastName('admin')
      ->setSolde($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000))
      ->setAddress('No address');

    $manager->persist($user);


    for ($i = 0; $i < 25; $i++) {
      $restaurant = new Restaurant;
      $restaurant
        ->setName($faker->word())
        ->setLogo('BKCesson-660x371.jpg');

      $manager->persist($restaurant);
    }

    for ($i = 0; $i < 75; $i++) {
      $meal = new Meal;
      $meal
        ->setName($faker->word())
        ->setPicture('pexels-valeria-boltneva-1639557.jpg')
        ->setPrice($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 20))
        ->setCategory('burger');

      $manager->persist($meal);
    }









    $manager->flush();
  }
}
