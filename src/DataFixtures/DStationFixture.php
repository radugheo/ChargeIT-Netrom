<?php

namespace App\DataFixtures;

use App\Entity\Station;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DStationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $locations = $manager->getRepository("App\Entity\Location")->findAll();
        for ($i = 0; $i < sizeof($locations); $i++){
            $station = new Station();
            $station->setChargeType(rand(1, 2));
            $station->setPower(rand(7, 100));
            $station->setLocation($locations[$i]);
            $manager->persist($station);
        }
        $manager->flush();
    }
}
