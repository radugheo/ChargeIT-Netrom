<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CLocationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cityArray = ['Bucuresti', 'Arad', 'Timisoara', 'Cluj', 'Craiova', 'Vaslui', 'Botosani'];
        $nameArray = ['Parcare', 'Statii de incarcare', 'Loc acumulatoare'];
        $placeArray = ['Centru', 'Lidl', 'Kaufland', 'Auchan', 'Subteran', 'Teatru'];
        for ($i = 0; $i < 150; $i++){
            $location = new Location();
            $location->setName($nameArray[rand(0, 2)] . ' ' . $placeArray[rand(0, 5)]);
            $location->setNumberOfStations(rand(3, 10));
            $location->setLatitude(rand(215, 275)/10);
            $location->setLongitude(rand(432, 475)/10);
            $location->setPrice(rand(2, 6));
            $location->setCity($cityArray[rand(0, 6)]);
            $manager->persist($location);
        }
        $manager->flush();
    }
}
