<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\AddCarFormType;
use App\Form\StationFilterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $car = new Car();
        $em = $this->getUser()->getUserIdentifier();
        $user = $entityManager->getRepository('App\Entity\User')->findOneBy(['name'=>$em]);
        $userCars = $entityManager->getRepository('App\Entity\Car')->findBy(['user'=>$user]);
        $userBookings = $entityManager->getRepository('App\Entity\Booking')->getUserBookingsByCarId($user);
        $form = $this->createForm(AddCarFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $car->setLicensePlate(
                $form->get('license_plate')->getData()
            );
            $car->setChargeType(
                $form->get('charge_type')->getData()
            );
            $car->setUser($user);
            $entityManager->persist($car);
            $entityManager->flush();
        }
        return $this->render('profile/index.html.twig', [
            'addCarForm' => $form->createView(),
            'userCars' => $userCars,
            'userBookings' => $userBookings
        ]);
    }
}
