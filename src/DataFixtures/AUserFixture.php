<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AUserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cityArray = ['Bucuresti', 'Arad', 'Timisoara', 'Cluj', 'Craiova', 'Vaslui', 'Botosani'];
        $firstNameArray = ['Andrei', 'Alexandru', 'Ben', 'Cristian', 'Denis', 'Gabriel', 'Radu', 'Mihai', 'Ion', 'Bogdan', 'Marcu', 'Matei'];
        $lastNameArray = ['Popescu', 'Ionescu', 'Alexandrescu', 'Gheorghe', 'Georgescu', 'Mateescu', 'Budescu', 'Tanase', 'Olaru', 'Popa', 'Burcanescu', 'Papuceanu'];
        $emailArray = ['@gmail.com', '@yahoo.com', '@hotmail.com'];
        for ($i = 0; $i < 150; $i++){
            $user = new User();
            $user->setCity($cityArray[rand(0, 6)]);
            $user->setName($firstNameArray[rand(0, 11)] . ' ' . $lastNameArray[rand(0, 11)]);
            $user->setEmail(strtolower($user->getName() . $emailArray[rand(0, 2)]));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
