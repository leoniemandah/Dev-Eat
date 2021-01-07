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
              ->setRoles(['ROLE_USER'])
              ->setPassword($this->passwordEncoder->encodePassword($user,'154876923'))
              ->setFirstName($faker->firstName)
              ->setLastName($faker->lastName)
              ->setSolde($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000))
              ->setAddress($faker->address);


            $manager->persist($user);
          }

      
      
          $manager->flush();
          
    }

}
