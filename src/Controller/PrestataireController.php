<?php

namespace App\Controller;

use App\Entity\Image;
use App\Data\SearchData;
use App\Form\SearchType;
use App\Entity\Prestataire;
use App\Form\PrestataireType;
use Doctrine\ORM\EntityManager;
use App\Entity\CategorieService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PrestataireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType as TypeSearchType;

class PrestataireController extends AbstractController
{
    //------------------------------------------------------------
    // lister tous les prestataires + pagination
    //------------------------------------------------------------

    /**
     * @Route("/prestataire", name="prestataire")
     */
    
     public function index(Request $request, PaginatorInterface $paginator,  EntityManagerInterface $entityManager): Response
    {
        
        $repository = $entityManager->getRepository(Prestataire::class);
        //on stock la liste des prestataires dans la variable $donnees
        $donnees = $repository->findAll();

        $prestataires = $paginator->paginate(
           //requête contenant les données à paginer ( les prestataires )
           $donnees,
           //numéro de la page en cours, passé dans l'url, 1 si aucune page
           $request->query->getInt('page', 1),
           //nbre de résultats par page
           2
       );
        
        return $this->render('prestataire/index.html.twig', [
            'controller_name' => 'PrestataireController',
            'prestataires'=>$prestataires,
        ]);
    }
    
    //------------------------------------------------------------
    //affichage d'un prestataire avec détails
    //------------------------------------------------------------

    /**
     * @Route("/prestataire/detail/{id}", name="prest_detail")
     */


    public function detailPrest(Prestataire $prestataire): Response
    {
        $categorieServices = $prestataire->getCategorieServices();
      
        //on fait un render pour le detail en passant l'id du prestataire
        return $this->render('prestataire/detail.html.twig', [
            'prestataire'=>$prestataire, 
            'categorieServices'=> $categorieServices  

        ]);
    }

    //------------------------------------------------------------
    //recherche d'un prestataire par nom
    //------------------------------------------------------------

    /**
     * @Route("/prestataire/recherche", name="prest_recherche", methods={"POST", "GET"})
     */


    public function findPrestByName(Request $request, EntityManagerInterface $entityManager): Response
    {
    
        $reposPrest = $entityManager ->getRepository(Prestataire::class);

        //récupération des données du form
         $nom              = $request ->request ->get('nom');
         $categorieService = $request ->request ->get('categorieService');
         $cp               = $request ->request ->get('cp');
         $localite         = $request ->request ->get('localite');
         $commune          = $request ->request ->get('commune');
        

        $prestataires = $reposPrest->findPrestSearch($nom, $categorieService, $commune, $cp, $localite);

        
        return $this->render('prestataire/index.html.twig', [
            'prestataires'=>$prestataires,
            'nom '=>$nom,
            'categorieService'=> $categorieService,
            'cp'=> $cp,
            'localite'=>$localite,
            'commune'=>$commune,


        ]);


    }

    //---------------------------------------------------------------
    //lien entre un prestataire et une categorie de service
    //---------------------------------------------------------------
    
    /**
     * @Route("/prestataire/lien", name="prest_lien")
     */

     
     public function lienPrest(EntityManagerInterface $entityManager): Response 
     
     {

        $reposPrest = $entityManager->getRepository(Prestataire::class);
        $prest = $reposPrest->find(24);

      
        $reposCat = $entityManager->getRepository(CategorieService::class);
        $categorieService = $reposCat->find(12);

        
        $prest->addCategorieService($categorieService);

        $entityManager->persist($prest);
        $entityManager->flush();
        
        return $this->redirectToRoute('accueil');

     }

     //----------------------------------------------------------------
    //Création du prestataire 
    //----------------------------------------------------------------

    /**
     * @Route("/prestataire/creation/{id}", name="creationPrestataire")
     */
    
    public function creationPrestataire($id, UserRepository $userRepository, Request $request, EntityManagerInterface $manager): Response
    {
        //On récupère le user grâce à son id via la fonction findOneBy
        $user = $userRepository -> findOneBy(['id' => $id]);

        //On crée un nouveau prestataire
        $prestataire = new Prestataire();

        //On va lier le prestataire au user qui a été précédemment créé
        $prestataire-> setUtilisateur($user);


        //création formulaire pour le prestataire
        $prestForm = $this->createForm(PrestataireType::class, $prestataire);
        $prestForm->handleRequest($request);

        //si le formulaire est envoyé et valide
        if($prestForm -> isSubmitted() && $prestForm -> isValid()) {
            //On récupère les données du formulaire via le getData()
            $prestataire = $prestForm -> getData();

            //Ajout d'une collection d'image
            // On récupère les images
            $images = $prestForm->get('images')->getData();
            //s'il existe des images
            if($images) {
                //on met le compteur à 1
                $cptOrdre=1;
                //on va boucler sur les images
                foreach( $images as $image){

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
                    $img -> setOrdre($cptOrdre);
                    $prestataire-> addImage($img);
                    $manager -> persist($img);

                    $cptOrdre++;

                }
            }

            //On remet le token à "null"  
            $user->setToken(null);
            //On remet la "InscripConf à "true" dans la base de données
            $user->setInscriptConf(true);
            //On persist l'utilisateur 
            $manager -> persist($user);
            //On persist le prestataire
            $manager -> persist($prestataire);
            //On insère dans la db
            $manager -> flush();

            //Message succes 
            $this -> addFlash('success', 'Vous êtez bien inscrit!'); 

            return $this->redirectToRoute('accueil');

        }
        return $this->render('prestataire/creatPrestataire.html.twig', [
            'prestForm' => $prestForm-> createView()
        ]);
    }

    
}
