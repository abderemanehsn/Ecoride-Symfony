<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\User;
use App\Entity\Brand;
use PhpParser\Builder\Enum_;
use App\Repository\CarEnergyEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model')
            ->add('immatriculation')
            ->add('energy', EnumType::class, [
                'label' => 'Moteur',
                'class' => CarEnergyEnum::class
            ])
            ->add('color', ColorType::class, [
                'label' => 'Couleur'
            ])
            ->add('firstImmatriculationAt')
            ->add('brand', EntityType::class, [
                'label' => 'Marque',
                'class' => Brand::class,
                'choice_label' => 'name',
            ])
        /*     ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'pseudo',
                
            ]) */

            ->add('save', SubmitType::class, [
                'label' => 'Ajouter',
                'row_attr' => [
                    'class' => 'text-center'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
