<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Internaute;
use App\Form\InternauteType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InternauteController extends AbstractController
{
    //----------------------------------------------------------------
    //Création de l'internaute 
    //----------------------------------------------------------------

    /**
     * @Route("/internaute/creation/{id}", name="creationInternaute")
     */
    
        public function creationInternaute($id, UserRepository $userRepository, Request $request, EntityManagerInterface $manager): Response
        {
        //On récupère le user grâce à son id via la fonction findOneBy
        $user = $userRepository -> findOneBy(['id' => $id]);
    
        //On crée un nouvel internaute
        $internaute = new Internaute();

        //On va lier l'internaute au user qui a été précédemment créé
        $internaute -> setUser($user);


        //création formulaire pour l' internaute
        $internForm = $this->createForm(InternauteType::class, $internaute);
        $internForm ->handleRequest($request);

        //si le formulaire est envoyé et valide
        if($internForm -> isSubmitted() && $internForm -> isValid()) {
            //On récupère les données du formulaire via le getData()
            $internaute = $internForm -> getData();

            //Ajout d'image
            // On récupère l'image
            $image = $internForm->get('images')->getData();
            //s'il existe une image
            if($image) {
                // génération d'un nouveau nom de fichier pour le stocker 
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                // copie le fichier dans /uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // création de l'image dans la DB
                $img = new Image();
                $img -> setImage($fichier);
                $internaute -> setImage($img);
                $manager -> persist($img);
            }

            //On remet le token à "null"  
            $user->setToken(null);
            //On remet la "InscripConf à "true" dans la base de données
            $user->setInscriptConf(true);
            //On persist l'utilisateur 
            $manager -> persist($user);
            //On persist l'internaute 
            $manager -> persist($internaute);
            //On insère dans la db
            $manager -> flush();

            //Message succes 
            $this -> addFlash('success', 'Vous êtez bien inscrit!'); 

            return $this->redirectToRoute('accueil');

        }
        return $this->render('internaute/creatInternaute.html.twig', [
            'internForm' => $internForm -> createView()
        ]);
    }
}
