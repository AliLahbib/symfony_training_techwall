<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Hobby extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $hobbies = [
            "Lire",
            "Voyager",
            "Jardiner",
            "Photographie",
            "Cuisine",
            "Peinture",
            "Faire du sport",
            "Jouer de la musique",
            "Bricolage",
            "Pêche"
        ];
        foreach ($hobbies as $hobby){
            $newHobby=new \App\Entity\Hobby();
            $newHobby->setDesignation($hobby);
            $manager->persist($newHobby);
        }


        $manager->flush();
    }
}
