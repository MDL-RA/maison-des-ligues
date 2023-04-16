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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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


class SecurityController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private CompteRepository $compteRepository;
    private TokenStorageInterface  $tokenStorage;
    private SessionInterface $session;

    public function __construct(EmailVerifier $emailVerifier, CompteRepository $compteRepository,TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
        $this->emailVerifier = $emailVerifier;
        $this->compteRepository= $compteRepository;
        $this->session= $session;
        $this->tokenStorage = $tokenStorage;
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
                $user->setConfirmationToken(md5(uniqid()));
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

    #[Route('/verify/email/{token}', name: 'app_verify_email')]
    public function verifyUserEmail(String $token, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'adresse e-mail de l'utilisateur à partir du token
        $user = $this->compteRepository->findOneBy(['confirmationToken' => $token]);
        if (!$user) {
            $this->addFlash('warning', 'Le lien que vous avez utilisé n\'est pas valide. Veuillez vérifier et utiliser un lien correct.');
        }
        // Valider le lien de confirmation et activer le compte utilisateur
        try {
            $user->setIsVerified(true);
            $user->setConfirmationToken(null);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success','Votre compte est activé ! Veuillez utiliser l\'adresse e-mail associée à votre compte pour vous connecter.');
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('warning', $exception->getReason());
        }
        return $this->redirectToRoute('app_login');
    }

    #[Route('/reinitialiser-motdepasse', name: 'app_reinitialiser-motdepasse')]
    public function reinitialiserMotDePasse(): Response
    {
        return $this->render('security/reinitialiser-email.html.twig', [
        ]);
    }

    #[Route('/reinitialiser-motdepasse-email', name: 'app_reinitialiser-motdepasse-email')]
    public function reinitialiserMotDePasseEnvoiMail(Request $request, EntityManagerInterface $entityManager,  MailerInterface $mailer,JWTTokenManagerInterface $jwtManager): Response
    {
        $email = $request->request->get('_username');
        $user = $this->compteRepository->findOneBy(['email'=> $email]);
        if($user){
            $token = $jwtManager->create($user);
            $user->setIsPasswordReset(true);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->emailVerifier->sendResetEmail($mailer, $user, $token);
        }
        return $this->redirectToRoute('app_login');
    }

    #[Route('/reinitialiser-motdepasse/{token}', name: 'app_reinitialiser-motdepasse-token')]
    public function reinitialiserMotDePasseToken(string $token, JWTTokenManagerInterface $jwtManager, UserPasswordHasherInterface $passwordEncoder): Response
    {
        try {
            $decodedToken = $jwtManager->parse($token);
        } catch (ExpiredTokenException $e) {
            // Token expiré
            $this->addFlash('warning', "Le lien de réinitialisation du mot de passe est invalide ou a expiré.");
            dd('token-expiré');
            return $this->redirectToRoute('app_reinitialiser-motdepasse');
//        } catch (JWTDecodeFailureException $e) {
//            $this->addFlash('warning', "Le lien de réinitialisation du mot de passe est invalide ou a expiré.");
//            dd('decodage échoué');
//            return $this->redirectToRoute('app_reinitialiser-motdepasse');
        }

        $userEmail = $decodedToken['username'];

        // Récupérer l'utilisateur
        $user = $this->compteRepository->findOneBy(['email'=> $userEmail]);

        if (!$user) {
            $this->addFlash('error', "Le lien de réinitialisation du mot de passe est invalide ou a expiré.");
            dd('utilisateur pas trouvé');
            return $this->redirectToRoute('app_reinitialiser-motdepasse');
        }

        // Connecter l'utilisateur
        $newToken = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($newToken);
        $this->session->set('_security_main', serialize($token));

        // Rediriger l'utilisateur vers la page de réinitialisation du mot de passe
        return $this->redirectToRoute('app_reset_password');
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
