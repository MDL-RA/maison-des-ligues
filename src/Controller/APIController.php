<?php

namespace App\Controller;

use App\Service\APIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    #[Route('/clubs', name: 'app_clubs')]
    public function index(APIService $apiService): Response
    {
        
        return $this->render('api/index.html.twig', [
            'dataClub' => $apiService->getClub(),
            'dataLicencie' => $apiService->getLicencie(),
            'dataQualite' =>$apiService->getQualite()
        ]);
    }
}
