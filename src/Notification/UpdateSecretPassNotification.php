<?php

namespace App\Notification;

use App\Entity\User;
use Twig\Environment;

class UpdateSecretPassNotification
{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function notify(User $user, $secretPass)
    {
        $message = (new \Swift_Message('IHungry'))
            ->setFrom('noreply@ihungry.fr')
            ->setTo('contact@ihungry.fr')
            ->setReplyTo($user->getEmail())
            ->setBody($this->twig->render('email/updateSecretpass.html.twig', [
                'user' => $user,
                'secretpass' => $secretPass
            ]), 'text/html');
        $this->mailer->send($message);
    }

}