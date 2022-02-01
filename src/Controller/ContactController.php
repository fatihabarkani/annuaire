<?php

namespace App\Controller;


use App\Form\ContactType;
use App\Form\UserType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            
            $message = (new Email())
                ->from($contactFormData->getEmail())
                ->to('fatiha.barkani@hotmail.fr')
                ->subject('vous avez reçu un email')
                ->text('Sender : '.$contactFormData->getEmail().\PHP_EOL.
                    $contactFormData->getMessage(),
                    'text/plain');
            $mailer->send($message);
            $this->addFlash('success', 'Vore message a été envoyé');
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}
