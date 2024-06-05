<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Person extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create('fr_FR');
       for($i=0;$i<100;$i++){
           $personne=new \App\Entity\Person();
           $personne->setName($faker->name);
           $personne->setFirstname($faker->firstName);
           $personne->setLastname($faker->lastName);
           $personne->setAge($faker->numberBetween(5,50));
           $manager->persist($personne);

       }

        $manager->flush();
    }
}
