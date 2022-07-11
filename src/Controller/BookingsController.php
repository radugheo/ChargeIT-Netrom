<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Station;
use App\Form\BookStationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingsController extends AbstractController
{
    #[Route('{id}/book', name: 'app_bookings')]
    public function index(Request $request, ManagerRegistry $manager, Station $station, EntityManagerInterface $entityManager): Response
    {
        $station = $manager->getRepository(Station::class)->findOneBy(array('id' => $station->getId()));
        $bookings = $manager->getRepository(Booking::class)->getBookingsById($station->getId());
        $em = $this->getUser()->getUserIdentifier();
        $user = $entityManager->getRepository('App\Entity\User')->findOneBy(['name'=>$em]);
        $formBooking = $this->createForm(BookStationFormType::class, null, ['user'=>$user]);
        $formBooking->handleRequest($request);
        $infoMessage = 'Choose a suitable interval for you and make a booking.';
        if ($formBooking->isSubmitted() && $formBooking->isValid()) {
            $chargeStart = $formBooking->getData()['start'];
            $chargeEnd = $formBooking->getData()['end'];
            $carPlate = $formBooking->getData()['car'];
            $car = $entityManager->getRepository('App\Entity\Car')->findOneBy(['license_plate'=>$carPlate]);
            foreach($bookings as $booking) {
                $bookingStart = $booking->getChargeStart();
                $bookingEnd = $booking->getChargeEnd();
                if(($bookingStart <= $chargeStart && $bookingEnd >= $chargeStart) || ($bookingStart <= $chargeEnd && $bookingEnd >= $chargeEnd)) {
                    $infoMessage = 'Another reservation already exists in that interval.';
                    break;
                }
            }
            if ($infoMessage == 'Choose a suitable interval for you and make a booking.') {
                $booking = new Booking();
                $booking->setChargeStart($chargeStart);
                $booking->setChargeEnd($chargeEnd);
                $booking->setStation($station);
                $booking->setCarId($car);
                $manager->getManager()->persist($booking);
                $manager->getManager()->flush();
                $infoMessage = 'Succesfully made a reservation.';
                $bookings = $manager->getRepository(Booking::class)->getBookingsById($station->getId());
            }
        }
        return $this->render('bookings/index.html.twig', [
            'controller_name' => 'BookingsController',
            'idStation' => $station->getId(),
            'nameStation' => $station->getLocation(),
            'formBooking' => $formBooking->createView(),
            'bookings' => $bookings,
            'infoMessage' => $infoMessage
        ]);
    }
}
