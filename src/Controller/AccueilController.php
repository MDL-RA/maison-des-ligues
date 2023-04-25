<?php

namespace App\Controller;

use App\Security\Voter\PasswordResetVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function accueil(): Response {

        return $this->render('accueil/accueil.html.twig');
    }
    
}
