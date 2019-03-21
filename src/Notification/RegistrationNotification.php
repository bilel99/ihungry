<?php

namespace App\Notification;

use App\Entity\User;
use Twig\Environment;

class RegistrationNotification
{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function notify(User $user)
    {
        $message = (new \Swift_Message('IHungry (1)'))
            ->setFrom('noreply@ihungry.fr')
            ->setTo('contact@ihungry.fr')
            ->setReplyTo($user->getEmail())
            ->setBody($this->twig->render('email/registration.html.twig', [
                'user' => $user
            ]), 'text/html');
        $this->mailer->send($message);
    }

}