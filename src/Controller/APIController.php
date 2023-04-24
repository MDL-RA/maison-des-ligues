<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use App\Service\APIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController {
    public function __construct(private readonly APIService $apiService, private readonly CompteRepository $compteRepository) {}

    /**
     * Méthode permettant de vérifier si un licencié existe dans la base de donnée de l'api et de l'application
     * @param int $numlicence
     * @return bool
     */
    #[Route('/get/api/licencie/{numlicence}', name: 'app_infos_licencie', methods: ['GET'])]
    public function getInfoLicencie(int $numlicence): bool
    {
        $inAPI = $this->apiService->getLicencieById($numlicence);
        $inDatabase = $this->compteRepository->findByNumLicence($numlicence);

        // Retourne true si le licencié existe dans l'API mais pas dans la base de données locale
        if ($inAPI !== null && $inDatabase === null) {
            return true;
        }

        // Retourne false dans tous les autres cas
        return false;
    }

}
