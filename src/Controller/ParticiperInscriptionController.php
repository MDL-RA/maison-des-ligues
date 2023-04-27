<?php

namespace App\Controller;

use App\Repository\CategorieChambreRepository;
use App\Service\APIService;
use App\Service\AtelierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HotelRepository;

#[Route('/participer')]
class ParticiperInscriptionController extends AbstractController
{
    #[Route('', name: 'app_participer')]
    public function index(APIService $apiService): Response
    {
        $user = $apiService->getLicencieById($this->getUser()->getNumlicence());
        return $this->render('participer_inscription/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/inscription', name: 'app_participer_inscription')]
    public function participerInscription(AtelierService $atelierService,HotelRepository $hotelRepo, CategorieChambreRepository $categorie) : Response
    {
        $ateliers = $atelierService->getAllAteliers();
        $hotels = $hotelRepo->findAll();
        $categories = $categorie->findAll();
        return $this->render('participer_inscription/inscription.html.twig',[
            'ateliers' => $ateliers,
            'hotels' => $hotels,
            'categories' => $categories,
        ]);
    }
}
