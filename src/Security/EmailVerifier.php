<?php

namespace App\Security;

use App\Entity\Compte;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager,
        private CompteRepository $compteRepository
    ) {
    }

    public function sendConfirmationEmail(MailerInterface $mailer, Compte $user): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@mdl.fr', 'no-reply'))
            ->to($user->getEmail())
            ->subject('Confirmation de votre compte')
            ->htmlTemplate('security/confirmation_email.html.twig')
            ->context([
                'token' => $user->getConfirmationToken(),
            ]);
        $mailer->send($email);

    }

}
