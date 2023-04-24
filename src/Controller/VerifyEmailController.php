<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\ChangePasswordFormType;
use App\Form\RegistrationFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\CompteRepository;
use App\Security\EmailVerifier;
use App\Service\APIService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class VerifyEmailController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private CompteRepository $compteRepository;
    private SessionInterface $session;
    private VerifyEmailHelperInterface $verifyEmailHelper;

  public function __construct(EmailVerifier $emailVerifier, CompteRepository $compteRepository, SessionInterface $session,VerifyEmailHelperInterface $verifyEmailHelper)
{
    $this->emailVerifier = $emailVerifier;
    $this->compteRepository= $compteRepository;
    $this->session= $session;
    $this->verifyEmailHelper = $verifyEmailHelper;
}

    /**
     * Méthode permettant d'activer le compte d'un licencié
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/activer/compte/', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userId = $request->query->get('id');
        $user = $this->compteRepository->find($userId);
        if (!$user) {
            // Ajoutez un message d'erreur, par exemple dans un flashBag
            $this->addFlash('warning','Une erreur est survenu');
            return $this->redirectToRoute('app_login');
        }
        if($user->IsVerified()){
            $this->addFlash('warning','Votre compte est déjà activé !');
            return $this->redirectToRoute('app_login');
        }
        try{
            $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('warning','Une erreur est survenu');
            return $this->redirectToRoute('app_login');
        }
        $user->setIsVerified(true);
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success','Votre adresse e-mail a été vérifiée avec succès.');
        return $this->redirectToRoute('app_login');
    }

}
