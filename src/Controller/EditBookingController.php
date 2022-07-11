<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Station;
use App\Form\BookStationFormType;
use App\Form\EditBookingFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditBookingController extends AbstractController
{
    #[Route('/booking/{id}/edit', name: 'app_edit_booking')]
    public function index(Request $request, Booking $booking, ManagerRegistry $manager, EntityManagerInterface $entityManager): Response
    {
        $bookings = $manager->getRepository(Booking::class)-> getBookingsById($booking->getStation());
        $formBooking = $this->createForm(EditBookingFormType::class);
        $formBooking->handleRequest($request);
        if ($formBooking->isSubmitted() && $formBooking->isValid()) {
            $chargeStart = $formBooking->getData()['start'];
            $chargeEnd = $formBooking->getData()['end'];
            $booking->setChargeStart($chargeStart);
            $booking->setChargeEnd($chargeEnd);
            $manager->getManager()->persist($booking);
            $manager->getManager()->flush();
        }
        return $this->render('edit_booking/index.html.twig', [
            'formBooking' => $formBooking->createView(),
            'booking' => $booking
        ]);
    }
}
