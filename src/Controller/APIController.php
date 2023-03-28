<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use App\Service\APIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController {

    public function __construct(private readonly APIService $apiService, private CompteRepository $compteRepository) {
        
    }

    #[Route('/get/api/licencie/{numlicence}', name: 'app_infos_licencie', methods: ['GET'])]
    public function getInfoLicencie(int $numlicence): Response|bool {
        $inAPI = $this->apiService->getLicencieById($numlicence);
        $inDatabase = $this->compteRepository->findByNumLicence($numlicence);
        if ($inAPI[0]["numlicence"] && $inDatabase === null) {
            return true;
        } else {
            return false;
        }
    }

}
