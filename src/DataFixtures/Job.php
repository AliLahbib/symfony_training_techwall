<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Job extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $jobs = ["Médecin généraliste", "Architecte", "Développeur de logiciels", "Infirmier", "Chef de projet",
            "Avocat", "Enseignant", "Designer graphique", "Ingénieur", "Comptable"
        ];
        for ($i = 0; $i < 10; $i++) {
            $newJob = new \App\Entity\Job();
            $newJob->setDesignation($jobs[$i]);
            $manager->persist($newJob);
        }

        $manager->flush();
    }
}
