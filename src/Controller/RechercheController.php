<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Entity\Localite;
use App\Entity\CodePostal;
use App\Entity\Prestataire;
use App\Form\SearchPresType;
use App\Entity\CategorieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RechercheController extends AbstractController
{
  
    /**
     * @Route("/recherche", name="recherche")
     */
    public function recherche(EntityManagerInterface $entityManager, Request $request): Response
    {
        //récupération des noms des prestataires
       $prestRepo = $entityManager -> getRepository(Prestataire::class);
       $noms = $prestRepo -> findNoms();
       //récupération des services
       $catServiceRepo = $entityManager -> getRepository(CategorieService::class);
       $categorieServices = $catServiceRepo -> findAll();
       //récupération des communes
       $communeRepo = $entityManager -> getRepository(Commune::class);
       $communes = $communeRepo -> findAll();
       //récupération des cp
       $cpRepo = $entityManager -> getRepository(CodePostal::class);
       $cps = $cpRepo -> findAll();
       //récupération des localités
       $locRepo = $entityManager -> getRepository(Localite::class);
       $localites = $locRepo -> findAll();
       

       return $this->render('recherche/_recherche.html.twig', [
           'categorieServices' => $categorieServices,
           'communes' => $communes,
           'cps' => $cps,
           'localites' => $localites,
           'noms' => $noms
       ]);
    }
     
}
