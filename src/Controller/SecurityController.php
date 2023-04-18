<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\ExpiredTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Security\EmailVerifier;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Compte;
use App\Form\RegistrationFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use App\Service\APIService;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;


class SecurityController extends AbstractController
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

    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, APIService $apiService, APIController $apiController, MailerInterface $mailer): Response
    {
        if($this->getUser()){
            return $this->redirectToRoute('app_accueil');
        }
        $user = new Compte();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $numLicenceForm = $form->getData()->getNumlicence();
            if(!$apiController->getInfoLicencie($numLicenceForm)) {
                $form->get('numLicence')->addError(new FormError('Veuillez changer de numéro de licencié'));
            }else{
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    ));
                $user->setEmail(($apiService->getLicencieById($numLicenceForm))[0]['mail']);
                $entityManager->persist($user);
                $entityManager->flush();
                $this->emailVerifier->sendConfirmationEmail($mailer, $user);
                $this->addFlash('notice', 'Pour confirmer votre inscription, veuillez cliquer sur le lien envoyé par e-mail à l\'adresse associée à votre compte.');
                return $this->redirectToRoute('app_login');
            }
        }
        return $this->render('security/inscription.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email/', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userId = $request->query->get('id');
        $user = $this->compteRepository->find($userId);
        if (!$user) {
            // Ajoutez un message d'erreur, par exemple dans un flashBag
            $this->addFlash('warning','Une erreur est survenu');
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

    #[Route(path: '/deconnexion', name: 'app_deconnexion')]
    public function deconnexion(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
             return $this->redirectToRoute('app_accueil');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/connexion.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


}
