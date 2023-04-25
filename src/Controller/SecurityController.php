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
    public function __construct( private EmailVerifier $emailVerifier,){

    }

    /**
     * Méthode permettant d'inscrire un licencié à l'application
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface $entityManager
     * @param APIService $apiService
     * @param APIController $apiController
     * @return Response
     */
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, APIService $apiService, APIController $apiController): Response
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
                $entityManager->persist($user);
                $entityManager->flush();
                $this->emailVerifier->sendConfirmationEmail($user);
                $this->addFlash('notice', 'Pour confirmer votre inscription, veuillez cliquer sur le lien envoyé par e-mail à l\'adresse associée à votre compte.');
                return $this->redirectToRoute('app_login');
            }
        }
        return $this->render('security/inscription.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    /**
     * Méthode permettant de se déconnecter de l'application
     * @return void
     */
    #[Route(path: '/deconnexion', name: 'app_deconnexion')]
    public function deconnexion(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * Méthode permettant de se connecter à l'application
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
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
