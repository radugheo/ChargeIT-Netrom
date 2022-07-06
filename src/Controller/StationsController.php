<?php

namespace App\Controller;


use App\Form\BookingFormType;
use App\Form\BookStationFormType;
use App\Form\StationFilterFormType;
use App\Repository\LocationRepository;
use App\Repository\StationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StationsController extends AbstractController
{

    #[Route('/', name: 'app_stations')]
    public function index(Request $request, StationRepository $stationRepository, LocationRepository $locationRepository, ManagerRegistry $manager): Response
    {
        $allStations = $manager->getRepository('App\Entity\Station')->findAll();
        $form = $this->createForm(StationFilterFormType::class);
        $form->handleRequest($request);
        $answers = [];
        if ($form->isSubmitted() && $form->isValid()){
            $answers = $form->getData();
        }
        if (sizeof($answers) > 0) {
            $locations = $locationRepository->findBy(['city' => $answers['city']]);
            $stations = $stationRepository->findBy(['location' => $locations, 'charge_type' => $answers['charge_type']]);
            if ($answers['charge_type'] == -1) {
                $stations = $stationRepository->findBy(['location' => $locations]);
            }
            if ($answers['city'] == 'Select city') {
                $stations = $stationRepository->findBy(['charge_type' => $answers['charge_type']]);
            }
            if ($answers['city'] == 'Select city' && $answers['charge_type'] == -1) {
                $stations = $allStations;
            }
        }
        else{
            $stations = $allStations;
        }
        return $this->render('stations/index.html.twig', [
            'controller_name' => 'StationsController',
            'stations' => $stations,
            'formFilter' => $form->createView(),
            'url' => '/book'
        ]);
    }

}
