<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Profile extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $newProfile=new \App\Entity\Profile();

        $newProfile->setRs('Facebook');
        $newProfile->setUrl("https://www.facebook.com/ali.lahbib.754/");
        $manager->persist($newProfile);
        $newProfile2=new \App\Entity\Profile();
        $newProfile2->setRs('linkedIn');
        $newProfile2->setUrl("https://www.linkedin.com/in/ali-lahbib-5a2241240/");
        $manager->persist($newProfile2);
        $manager->flush();
    }
}
