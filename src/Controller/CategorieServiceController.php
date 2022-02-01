<?php

namespace App\Controller;


use App\Entity\CategorieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieServiceController extends AbstractController
{
    //---------------------------------------------------
    //affichage de la liste des catégories
    //---------------------------------------------------
    
    /**
     * @Route("/categorie/service", name="categorie_service")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(CategorieService::class);
        $categorieServices = $repository->findAll();

        return $this->render('categorie_service/index.html.twig', [
            'controller_name' => 'CategorieServiceController',
            'categorieServices' =>$categorieServices
        ]);
    }
    //--------------------------------------------------
    //affichage d'une categorie selon l'id
    //--------------------------------------------------

    /**
     * @Route("/categorie/service/{id}", name="cat_detail")
     */


    public function detailcat(CategorieService $categorieService): Response
    {
       $prestataires=$categorieService->getPrestataires();
        //on fait un render pour le detail en passant l'id du prestataire
        return $this->render('categorie_service/detail.html.twig', [
            'categorieService'=>$categorieService, 
            'prestataires'=>$prestataires   

        ]);
    }

    
}
