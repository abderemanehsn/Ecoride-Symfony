<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Trip;
use App\Entity\User;
use App\Repository\TripStatusEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class TripType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentUser = $this->security->getUser();

        $builder
            ->add('startDate')
            ->add('endDate')
            ->add('startingPoint')
            ->add('destination')
            ->add('startingTime', null, [
                'widget' => 'single_text',
            ])
            ->add('endingTime')
            ->add('price')
            ->add('status', EnumType::class, [
                'label' => 'Statut',
                'class' => TripStatusEnum::class,
                'choices' => [TripStatusEnum::AVAILABLE]
            ])
            ->add('car', EntityType::class, [
                'class' => Car::class,
                'choice_label' => 'model',
                'choices' => $currentUser ? $currentUser->getCar() : [],
            ])
            /* ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'pseudo',
                'multiple' => true,
            ]) */
           ->add('places')
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
