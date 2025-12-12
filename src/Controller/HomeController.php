<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Repository\TripRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TripRepository $tripRepository, Request $request): Response
    {
        $data = new Trip();
        $data->page = $request->get('page', 1);

        $form = $this->createForm(SearchType::class, $data);
           $form->handleRequest($request);



        return $this->render('home/index.html.twig', [
            'trips' => $tripRepository->findSearch($data),
            'form' => $form->createView()
        ]);
    }
}
