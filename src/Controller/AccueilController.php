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
        $this->denyAccessUnlessGranted(PasswordResetVoter::PASSWORD_RESET, null, "Vous devez réinitialiser votre mot de passe avant d'accéder à cette fonctionnalité.");

        return $this->render('accueil/accueil.html.twig');
    }
    
}
