<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use App\Service\APIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    public function __construct(private readonly APIService $apiService, private CompteRepository $compteRepository){}

    #[Route('/clubs', name: 'app_clubs')]
    public function index(): Response
    {
        
        return $this->render('api/index.html.twig', [
//            'dataClub' => $apiService->getClub(),
            'dataLicencie' => $this->apiService->getLicencieById(16381117915),
            'dataAllLicencie' => $this->apiService->getLicencie(),
//            'dataQualite' =>$apiService->getQualite()
        ]);
    }


    #[Route('/get/api/licencie/{numlicence}' , name: 'app_infos_licencie', methods: ['GET'])]
    public function getInfoLicencie(int $numlicence): Response|bool
    {
        $inAPI = $this->apiService->getLicencieById($numlicence);
        $inDatabase= $this->compteRepository->findByNumLicence($numlicence);
        if($inDatabase === null)
        {
            return $this->json($inAPI[0]['mail']);
        }else{
            return false;
        }
    }
}
