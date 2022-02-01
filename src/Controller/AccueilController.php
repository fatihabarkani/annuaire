<?php

namespace App\Controller;

use App\Entity\Prestataire;
use App\Entity\CategorieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;

    }

    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        //derniers prestataires inscrits
        $prestataire = $this->entityManager->getRepository(Prestataire::class)->findLastPrestataires();
        //retourne toutes les catégories de service
        $categorieServices = $this->entityManager->getRepository(CategorieService::class)->findAll();
        //mise en avant du service du mois
        $catServiceEnavant = $this->entityManager->getRepository(CategorieService::class)->findByEnAvant();
        
        
        return $this->render('accueil/index.html.twig', [
            'prestataire'=>$prestataire,
            'categorieService'=>$categorieServices ,
            'catServiceEnavant'=>$catServiceEnavant,
           

        ]);
    }

  
}
