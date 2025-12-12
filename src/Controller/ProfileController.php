<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Trip;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile', name: 'app_profile')]
final class ProfileController extends AbstractController
{
    #[Route('/', name: '', methods: ['POST','GET'])]
    public function show( EntityManagerInterface $em, Request $request): Response
    {
        $user = $this->getUser();

         if(!$user) 
        {
            return $this->redirectToRoute('app_home');

        }

        $limit =3;
        $page = $request->query-> getInt('page', 1);

        /* dd($user); */
        $data = $em->getRepository(Car::class) -> paginationCarsByUser($user, $limit, $page);
        $dataT = $em->getRepository(Trip::class) -> paginationTripByUser($user, $limit, $page);


        

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'trips' => $dataT['trip'],
            'cars' => $data['cars'],
            'maxPages' => $data['maxPages'],
           /*  'max' => $data['max'] */
        ]);
    }






    #[Route('/edit', name: '_edit', methods: ['POST','GET'])]
    public function edit( Request $request, EntityManagerInterface $em ): Response
    {

        $user = $this->getUser();
        $form = $this-> createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if(!$user) 
        {
            return $this->redirectToRoute('app_home');

        }

        if($form-> isSubmitted() && $form-> isValid()) {

        

            // Faire les modifications en bdd
            $em-> flush();

            $this-> addFlash('success', "L'utilisateur à été modifié ");


            // rediriger vers le tableau de bord
            return $this->redirectToRoute('app_home');
        }


        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);

    }
}
