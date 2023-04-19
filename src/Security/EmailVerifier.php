<?php

namespace App\Security;

use App\Entity\Compte;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface            $mailer,
    )
    {
    }

    public function sendConfirmationEmail(Compte $user): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'app_verify_email',
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );

        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@mdl.fr', 'no-reply'))
            ->to($user->getEmail())
            ->subject('Confirmation de votre compte')
            ->htmlTemplate('security/confirmation_email.html.twig')
            ->context([
                'signedUrl' => $signatureComponents->getSignedUrl(),
                'expiresAtMessageKey' => $signatureComponents->getExpirationMessageKey(),
                'expiresAtMessageData' => $signatureComponents->getExpirationMessageData(),
            ]);
        $this->mailer->send($email);
    }

    public function sendResetEmail(Compte $user, ResetPasswordToken $resetToken): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@mdl.fr', 'no-reply'))
            ->to($user->getEmail())
            ->subject('Demande de réinitialisation de mot de passe')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ]);
        $this->mailer->send($email);
    }

    public function sendConfirmationReset(Compte $user): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@mdl.fr', 'no-reply'))
            ->to($user->getEmail())
            ->subject('Confirmation de la réinitialisation de votre mot de passe')
            ->htmlTemplate('reset_password/confirmation_reset.html.twig');
        $this->mailer->send($email);
    }
}