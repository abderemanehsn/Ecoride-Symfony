<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\User;
use App\Form\TripType;
use App\Form\SearchType;
use App\Repository\TripRepository;
use App\Repository\TripStatusEnum;
use App\Security\Voter\TripVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/trip')]
final class TripController extends AbstractController
{
    #[Route(name: 'app_trip_index', methods: ['GET'])]
    public function index(TripRepository $tripRepository, Request $request): Response
    {
        $data = new Trip();
        $data->page = $request->get('page', 1);
        

        $form = $this->createForm(SearchType::class, $data);
           $form->handleRequest($request);

          
           $filters = [
              'energy' => $form->has('energy') ? $form->get('energy')->getData() : null,
              'maxPrice' => $form->has('maxPrice') ? $form->get('maxPrice')->getData() : null,
           ];


           return $this->render('trip/index.html.twig', [
               'trips' => $tripRepository->findSearch($data, $filters),
               'form' => $form->createView()
           ]);
    }

    #[Route('/new', name: 'app_trip_new', methods: ['GET', 'POST'])]
    ##trip voter
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trip = new Trip();

         if($user = $this-> getUser()) {
            $trip-> addUser($user) ;
            $trip-> setDriver($user) ;
        }

        $form = $this->createForm(TripType::class, $trip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trip);
            $entityManager->flush();

            return $this->redirectToRoute('app_trip_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trip/new.html.twig', [
            'trip' => $trip,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trip_show', methods: ['GET'])]
    public function show(Trip $trip): Response
    {
        return $this->render('trip/show.html.twig', [
            'trip' => $trip,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_trip_edit', methods: ['GET', 'POST'])]
     #[IsGranted(TripVoter::EDIT , subject: 'trip')]
    public function edit(Request $request, Trip $trip, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TripType::class, $trip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_trip_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trip/edit.html.twig', [
            'trip' => $trip,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trip_delete', methods: ['POST'])]
    #[IsGranted(TripVoter::DELETE , subject: 'trip')]
    public function delete(Request $request, Trip $trip, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trip->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($trip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_trip_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('search', name: 'app_trip_search', methods: ['GET'])]
     public function search(TripRepository $repository, Request $request)
    {
        $data = new Trip();
        $data->page = $request->get('page', 1);

        $form = $this->createForm(SearchType::class, $data);

        $form->handleRequest($request);

        $filters = [
            'energy' => $form->has('energy') ? $form->get('energy')->getData() : null,
            'maxPrice' => $form->has('maxPrice') ? $form->get('maxPrice')->getData() : null,
        ];

        $products = $repository->findSearch($data, $filters);

        return $this->render('trip/_search.html.twig', [
            'trips' => $products,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/join', name: 'app_trip_join', methods: ['GET','POST'])]
/*     #[IsGranted(TripVoter::JOIN , subject: 'trip')] */
    public function participe( Request $request, Trip $trip, EntityManagerInterface $entityManager): Response
    {
        if ($user = $this->getUser()) {

            $trip->addUser($user);
            
            $userCredits = $user->getCredits();
            if ($userCredits >= $trip->getPrice()) {
                $user->setCredits($userCredits - $trip->getPrice());
            }
            
            // Persist and flush changes
            $entityManager->persist($trip);
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profile');
    }
}
