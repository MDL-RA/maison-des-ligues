<?php

namespace App\EventSubscriber;

use App\Entity\Compte;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class ReinitialisationMotDePasseSubscriber implements EventSubscriberInterface
{
    private Security $security;
    private FlashBagInterface $flashBag;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(Security $security, FlashBagInterface $flashBag, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->flashBag = $flashBag;
        $this->urlGenerator = $urlGenerator;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $user = $this->security->getUser();

        if ($user instanceof  Compte && $user->getIsPasswordReset()) {
            $routeName = $event->getRequest()->attributes->get('_route');

            $allowedRoutes = [
                'app_reinitialiser-motdepasse',
                'app_deconnexion'
            ];

            if (!in_array($routeName, $allowedRoutes)) {
                $this->flashBag->add('warning', 'Vous devez réinitialiser votre mot de passe avant de pouvoir accèder à cette fonctionnalité');
                $resetPasswordUrl = $this->urlGenerator->generate('app_reinitialiser-motdepasse'); // Remplacez 'app_reset_password' par le nom de la route de votre page de réinitialisation du mot de passe
                $response = new RedirectResponse($resetPasswordUrl);
                $event->setResponse($response);
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 15],
        ];
    }
}
