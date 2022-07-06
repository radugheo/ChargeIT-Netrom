<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EBookingFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        /*$booking = new Booking();
        $cars = $manager->getRepository("App\Entity\Car")->findAll();
        $stations = $manager->getRepository("App\Entity\Station")->findAll();
        $booking->setCarId($cars[0]);
        $booking->setStation($stations[0]);
        $booking->setChargeStart(DateTime("2018-12-31 13:05:21")->format("YW"));
        $booking->setChargeEnd(DateTime("2018-12-31 13:05:21")->format("YW"));
        $manager->persist($booking);*/
        $manager->flush();
    }
}
