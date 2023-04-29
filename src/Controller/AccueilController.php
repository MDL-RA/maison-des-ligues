<?php

namespace App\Controller;

use App\Security\Voter\PasswordResetVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AtelierRepository;
use App\Repository\HotelRepository;

class AccueilController extends AbstractController {

    /**
     * Méthode permettant de rediriger à la page d'accueil
     * @return Response
     */
    #[Route('/', name: 'app_index')]
    public function index(): Response {
        return $this->redirectToRoute('app_accueil');
    }

    /**
     * Méthode permettant d'afficher la page d'accueil
     * @return Response
     */
    #[Route('/accueil', name: 'app_accueil')]
    public function accueil(AtelierRepository $atelierRepo, HotelRepository $hotelRepo): Response {
        $ateliers = $atelierRepo->findAll();
        $hotels = $hotelRepo->findAll();
        return $this->render('accueil/accueil.html.twig',[
            'ateliers' => $ateliers,
            'hotels' => $hotels,
        ]);
    }

}
