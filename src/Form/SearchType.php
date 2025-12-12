<?php

namespace App\Form;

use DateTime;
use App\Entity\Car;
use App\Entity\Trip;
use App\Entity\User;
use App\Repository\CarEnergyEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateType::class, [
                'label' => 'Date de départ',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('startingPoint', TextType::class, [
                'label' => 'Depart',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Départ',
                    'aria-describedby' => 'basic-addon1'
                ]
            ])
            ->add('energy', EnumType::class, [
                'class' => CarEnergyEnum::class,
                'required' => false,
                'mapped' => false,
                'placeholder' => 'Tous les carburants',
            ])
            ->add('destination', TextType::class, [
                'label' => 'Arrivée',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Arrivée',
                    'aria-describedby' => 'basic-addon2'
                ]
            ])
            ->add('maxPrice', NumberType::class, [
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Prix max',
                ]
            ])
            ->add('places', NumberType::class, [
                'required' => false,
                'attr' => [
                    'aria-describedby' => 'basic-addon4',
                    'min' => '1',
                    'max' => '7',
                    'placeholder' => '1 Passager'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
