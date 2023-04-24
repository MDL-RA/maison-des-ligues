<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class CheckEmailVerificationSubscriber implements EventSubscriberInterface
{
    private FlashBagInterface $flashBag;
    private UrlGeneratorInterface $urlGenerator;
    private TokenStorageInterface $tokenStorage;
    private SessionInterface $session;

    public function __construct(FlashBagInterface $flashBag, UrlGeneratorInterface $urlGenerator,TokenStorageInterface $tokenStorage,SessionInterface $session)
    {
        $this->flashBag = $flashBag;
        $this->urlGenerator = $urlGenerator;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
    }

    /**
     * Méthode qui dit à l'eventSusbcriber d'écouter l'evenement 'onLoginSucces'
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess',
        ];
    }

    /**
     * Méthode qui va vérifier si utilisateur à vérifier son compte pour qu'il puisse accéder à l'application
     * @param LoginSuccessEvent $event
     * @return void
     */
    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        $user = $event->getUser();
        if(!$user->isVerified()){
            $this->tokenStorage->setToken(null);
            $this->session->invalidate();
            $this->flashBag->add('warning', 'Vous devez vérifier votre e-mail avant de pouvoir vous connecter.');
            $url = $this->urlGenerator->generate('app_login');
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        }
    }


}
