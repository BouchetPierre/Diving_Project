<?php

namespace App\DataFixtures;

use App\Entity\Diving;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;
use Faker\Factory;

class DivingFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $fakerDiv = Factory::create('FR fr');

        for ($i = 1; $i <= 6; $i++) {

            $diving = new Diving();
            $description = $fakerDiv->paragraph(5);
            $date = $fakerDiv->date();
            $location = $fakerDiv->city;

            $dateDiving = new DateTime($date);
            $diving->setDate($dateDiving)
                ->setDescription($description)
                ->setLocation($location)
                ->setPlaces(mt_rand(5, 20))
                ->setLevelMin("N2");

            $manager->persist($diving);
        }
        $manager->flush();
    }
}
