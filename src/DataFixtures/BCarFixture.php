<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BCarFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository("App\Entity\User")->findAll();
        $countyArray = ['DJ', 'BH', 'GL', 'MH', 'OT', 'TR', 'IF', 'VS', 'TM', 'CJ', 'SB', 'MM'];
        $numberArray = ['36', '72', '24', '78', '11', '67', '90', '99', '34', '37', '89', '05'];
        $letterArray = ['BOS', 'SEF', 'COS', 'TEL', 'AND', 'REI', 'MAR', 'MRU', 'GHE', 'RAS', 'CIM', 'RDU'];
        for ($i = 0; $i < sizeof($users); $i++){
            $car = new Car();
            $car->setUser($users[$i]);
            $car->setLicensePlate($countyArray[rand(0, 11)] . '-' . $numberArray[rand(0, 11)] . '-' . $letterArray[rand(0, 11)]);
            $car->setChargeType(rand(1, 2));
            $manager->persist($car);
        }
        $manager->flush();
    }
}
