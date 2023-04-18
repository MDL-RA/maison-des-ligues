<?php

namespace App\Controller;

use App\Security\Voter\PasswordResetVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController {

    #[Route('/', name: 'app_index')]
    public function index(): Response {
        return $this->redirectToRoute('app_accueil');
    }

    #[Route('/accueil', name: 'app_accueil')]
    public function accueil(): Response {

        return $this->render('accueil/accueil.html.twig');
    }
    
}
