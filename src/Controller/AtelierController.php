<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AtelierController extends AbstractController{
    
    #[Route('/ateliers', name: 'app_ateliers')]
    public function ateliers(): Response {
        $this->denyAccessUnlessGranted(PasswordResetVoter::PASSWORD_RESET, null, "Vous devez réinitialiser votre mot de passe avant d'accéder à cette fonctionnalité.");
        return $this->render('ateliers/ateliers.html.twig');
    }
    
}
