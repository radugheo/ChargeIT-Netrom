<?php

namespace App\Form;

use App\Entity\Booking;
use App\Repository\CarRepository;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookStationFormType extends AbstractType
{
    private EntityManagerInterface $entityManager;
    private CarRepository $carRepository;
    public function __construct(EntityManagerInterface $entityManager, CarRepository $carRepository)
    {
        $this->entityManager = $entityManager;
        $this->carRepository = $carRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('start', DateTimeType::class, ['widget' => 'single_text'])
            ->add('end', DateTimeType::class, ['widget' => 'single_text'])
            ->add('car', ChoiceType::class, [
                    'choices' => array_merge(['Select car' => 'Select car'], $this->carRepository->getCarOptions($user)),
                    'choice_label' => function($value){
                        return $value;
                    }]
            )
            ->add('book', SubmitType::class, [
                'label' => 'Book'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
//        $resolver->setDefaults([
//            'data_class' => Booking::class,
//        ]);
        $resolver->setRequired(['user']);
    }
}
