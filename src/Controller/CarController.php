<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\User;
use App\Form\CarType;
use App\Security\Voter\CarVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/car', name: 'app_car')]

final class CarController extends AbstractController
{
    #[Route('/', name: '')]
    #[IsGranted('ROLE_USER')]
     public function new(Request $request, EntityManagerInterface $em)
    {
        $car = new Car();
        
        if($user = $this-> getUser()) {

            $car-> setUser($user) ;

        }

        $form = $this-> createForm(CarType::class, $car);
        $form->handleRequest($request);


        if($form-> isSubmitted() && $form-> isValid() && $user = $this-> getUser()) {
            // Créer le post
            $em-> persist($car);

            
            $roles = $user->getRoles();
            if (!in_array('ROLE_DRIVER', $roles, true)) {
                $roles[] = 'ROLE_DRIVER';
                $user->setRoles($roles);
                $em->persist($user);
            }

            $em-> flush();

            $this-> addFlash('success', "La voiture a été ajoutée avec succes ");
            return $this->redirectToRoute('app_home');
        }


        return $this->render( 'car/index.html.twig', [
            'car' => $car,
            'form' => $form,
            'title' => "Ajout d'un vehicule"
            
        ]);

    }

    #[Route('edit/{id}', name: '_edit', requirements: ['id' => '\d+'], methods: ['POST','GET'])]
    #[IsGranted(CarVoter::EDIT , subject: 'car')]
    public function edit(Car $car, Request $request, EntityManagerInterface $em /* ,PostRepository $repository */): Response
    {
        $form = $this-> createForm(CarType::class, $car);
        
        // Recuperer les données postées
        $form->handleRequest($request);

        if($form-> isSubmitted() && $form-> isValid()) {

            // Faire les modifications en bdd
            $em-> flush();

            $this-> addFlash('success', "Les informations du véhivule ont été modifiée ");


            // rediriger vers le tableau de bord
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('car/index.html.twig', [
            'car' => $car,
            'form' => $form,
            'title' => "Modification des informations du véhicule"
            
        ]);
    }

    #[Route('delete/{id}', name: '_delete', requirements: ['id' => '\d+']/* , methods: ['DELETE'] */)]
    #[IsGranted(CarVoter::DELETE,  subject: 'car')]
    public function delete(Car $car, EntityManagerInterface $em  )
    {
        $em-> remove($car);
        $em-> flush();

        $this-> addFlash('success', "Le vehicule à été supprimé ");


           
        return $this->redirectToRoute('app_profile');

    }
}
