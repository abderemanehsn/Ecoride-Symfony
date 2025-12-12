<?php

namespace App\Form;

use App\Entity\Trip;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
           /*  ->add('roles') */
          /*   ->add('password') */
            ->add('name', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('pseudo')
            ->add('number')
            ->add('adress', TextType::class, [
                'label' => 'Votre adresse'
            ])
            ->add('dob', BirthdayType::class, [
                'label' => 'Date de naissance'
            ])
            ->add('thumbnail', FileType::class, [
                'label' => 'Photo de profile',
                'required' => false
            ])
       /*      ->add('createAt', null, [
                'widget' => 'single_text',
            ])
            ->add('isVerified')
            ->add('trip', EntityType::class, [
                'class' => Trip::class,
                'choice_label' => 'id',
                'multiple' => true,
            ]) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
