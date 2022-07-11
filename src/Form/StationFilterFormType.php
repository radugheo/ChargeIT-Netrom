<?php

namespace App\Form;

use App\Entity\Station;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StationFilterFormType extends AbstractType
{
    private EntityManagerInterface $entityManager;
    private LocationRepository $locationRepository;
    public function __construct(EntityManagerInterface $entityManager, LocationRepository $locationRepository)
    {
        $this->entityManager = $entityManager;
        $this->locationRepository = $locationRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('charge_type', ChoiceType::class, [
                'choices' => [
                    'Select type' => -1 ,
                    '1' => '1',
                    '2' => '2'
                ]
            ])
            ->add('city', ChoiceType::class, [
                'choices' => array_merge(['Select city' => 'Select city'], $this->locationRepository->getCityOptions()),
                'choice_label' => function($value){
                    return $value;
                }]
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Filter'
            ]);
    }
}
