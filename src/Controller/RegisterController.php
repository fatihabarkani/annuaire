<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Service\Mailer;
use App\Form\RegisterType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    //------------------------------------------------
    // creation formulaire d'inscription
    //------------------------------------------------

    /**
     * @Route("/inscription", name="register")
     */

    public function index(Request $request, UserPasswordHasherInterface $encoder, MailerInterface $mailer): Response
    {

        //une notification 

        $notification=null;

        $user = new User();
        $user -> setInscription(new DateTime());
        $user -> setRoles(['ROLES_USER']);
        $user -> setBanni(false);
        $user -> setInscriptConf(false);
        $user -> setToken(null);
        $user -> setNbEssais(0);
        $user -> setInternaute(null);
        $form = $this->createForm(RegisterType::class, $user);
        $form ->handleRequest($request);

        // verification de la validité du formulaire inscription
        if($form->isSubmitted() && $form->isValid()){
            // récupération des infos de l'utilisateur
            $user = $form->getData();

            //traitement des données de l'utilisateur donc s'il existe
            $user_find = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            // si l'utilisateur n'existe pas il pourra entrer un nouveau mot de passe
            if(!$user_find){
                // récupération du mot de passe de l'utilisateur
                $password = $encoder->hashPassword($user, $user->getPassword());

                //setter le password
                $user->setPassword($password);
            }
            //generation du token pour l'utilisateur
            $user->setToken($this->generateToken());
            

            //persister les données en DB
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $message = (new TemplatedEmail())
                ->from('fatiha.barkani@hotmail.fr')
                ->to(new Address($user->getEmail()))
                ->subject('vous avez un nouvel email concernant votre inscription')
                ->htmlTemplate('emails/signup.html.twig')
                ->context([
                    'token'=>$user ->getToken()
                ])
            ;

            //envoi de mail
            $mailer -> send($message);

         

            //on fait appel à la notification que tout s'est bien déroulé
            $notification='Votre inscription s\'est bien déroulée';
        }

        

        return $this->render('register/index.html.twig', [
           'form'=>$form->createView(),
           'notification'=>$notification
        ]);
    }

    //--------------------------------------------------------------
    //création de route pour la validation
    //--------------------------------------------------------------

    /**
     * @Route("/inscription/validation/{token}", name="validation")
     */

     public function validation($token, UserRepository $repository ): Response
     {
        //recup user avec token
        $user=$repository -> findOneBy(["token"=>$token]);
        
        //s'il existe un user avec ce token on redirige vers le bon formulaire
        if($user){
            //recup de son ID pour passer vers la création <int>
            $id=$user->getId();

            if($user->getTypeUtilisateur() === "Internaute"){
                //redirect vers le form inscr internaute
                return $this->redirectToRoute('creationInternaute', [
                    'id'=>$id
                ]);

            }else if($user->getTypeUtilisateur() === "Prestataire"){
                //redirect vers le form inscr internaute
                return $this->redirectToRoute('creationPrestataire', [
                    'id'=>$id
                ]);
            }
        }else {
         $this->addFlash(
            'Erreur',
            'Message erreur'
         );
         return $this->redirectToRoute('Accueil');
        }
    }

    //fonction qui permet de générer des token
    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
