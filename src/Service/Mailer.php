<?php

namespace App\Service;

use DateTime;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Mailer{
    /**
     * @var MailerInterface 
     */

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendEmail($email, $token){

        $email = (new TemplatedEmail())
        ->from('register@example.com')
        ->to(new Address($email))
        ->subject('Validez votre inscription!')
    
        // path of the Twig template to render
        ->htmlTemplate('emails/registration.html.twig')
    
        // pass variables (name => value) to the template
        ->context([
            'token' => $token,
        ])
    ;
    $this->mailer->send($email);
    }
}