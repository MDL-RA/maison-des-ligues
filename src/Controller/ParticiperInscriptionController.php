<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Inscription;
use App\Entity\Nuite;
use App\Entity\Restauration;
use App\Repository\AtelierRepository;
use App\Repository\CategorieChambreRepository;
use App\Repository\InscriptionRepository;
use App\Service\APIService;
use App\Service\AtelierService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HotelRepository;

#[Route('/participer')]
class ParticiperInscriptionController extends AbstractController
{
    #[Route('', name: 'app_participer')]
    public function index(APIService $apiService, InscriptionRepository $inscriptionRepository): Response
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

    #[Route('/inscription/envoyer', name: 'app_envoyer_inscription')]
    public function envoyerInscription(Request $request, InscriptionRepository $inscriptionRepository, AtelierRepository $atelierRepository, HotelRepository $hotel, CategorieChambreRepository $categorie, EntityManagerInterface $entityManager) : Response
    {
        $dateSamedi = new DateTime('2022-09-17');
        $dateDimanche = new DateTime('2022-09-18');
        $ateliers = $request->get('ateliers');
        $reservation1 = $request->get('first_reservation_hotel');
        $reservation2 = $request->get('second_reservation_hotel');
        $categorie1 = $request->get('first_reservation_categorie');
        $categorie2 = $request->get('second_reservation_categorie');
        $jourReservationAccompagnant = $request->get('jour-reservation-accompagnant');
        $inscription = new Inscription();
        $inscription->setCompte($this->getUser());
        $inscription->setDateInscription(new DateTime());
        foreach ($ateliers as $atelier) {
            $newAtelier = $atelierRepository->find($atelier);
            $inscription->addAtelier($newAtelier);
        }
        $hotel1 = $hotel->find($reservation1);
        if ($reservation1 != $reservation2) {
            $hotel2 = $hotel->find($reservation2);
        }
        $categorieHotel1 = $categorie->find($categorie1);
        if ($categorie1 != $categorie2) {
            $categorieHotel2 = $categorie->find($categorie2);
        }
        $nuite1 = new Nuite();
        $nuite1->setDateNuitee($dateSamedi);
        $nuite1->setHotel($hotel1);
        $nuite1->setCategorie($categorieHotel1);
        $nuite2 = new Nuite();
        $nuite2->setDateNuitee($dateDimanche);
        if (isset($hotel2)) {
            $nuite2->setHotel($hotel2);
        } else {
            $nuite2->setHotel($hotel1);
        }
        if (isset($categorieHotel2)) {
            $nuite2->setCategorie($categorieHotel2);
        } else {
            $nuite2->setCategorie($categorieHotel1);
        }
        $inscription->addNuite($nuite1);
        $inscription->addNuite($nuite2);
        if (isset($jourReservationAccompagnant)) {
            $accompagnant = new Restauration();
            foreach ($jourReservationAccompagnant as $jour) {
                if ($jour == 'samedi-midi') {
                    $accompagnant->setDateRestauration(new DateTime('2022-09-17 12:00:00'));
                } elseif ($jour == 'samedi-soir') {
                    $accompagnant->setDateRestauration(new DateTime('2022-09-17 20:00:00'));
                } else {
                    $accompagnant->setDateRestauration(new DateTime('2022-09-18'));
                }
            }
            $accompagnant->setTypeRepas('test');
            $inscription->addRestauration($accompagnant);
        }
        $entityManager->persist($inscription);
        $entityManager->flush();
        $this->addFlash('success' ,'Votre inscription a bien été prise en compte');
        return $this->redirectToRoute('app_accueil');
    }
}
