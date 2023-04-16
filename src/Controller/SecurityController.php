<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
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

    public function __construct(EmailVerifier $emailVerifier, CompteRepository $compteRepository)
    {
        $this->emailVerifier = $emailVerifier;
        $this->compteRepository= $compteRepository;
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
