<?php

namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification
{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('IHungry'))
            ->setFrom('noreply@ihungry.fr')
            ->setTo('contact@ihungry.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->twig->render('email/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message);
    }

}