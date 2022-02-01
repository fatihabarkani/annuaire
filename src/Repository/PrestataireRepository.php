<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Prestataire;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Prestataire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestataire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestataire[]    findAll()
 * @method Prestataire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestataireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestataire::class);
    }

   

    /**
    * @return Prestataire[] Returns an array of Prestataire objects
    */

      //recherche prestataire par nom
    public function findPrestByName($nom)
    {
        return $this->createQueryBuilder('p') 
            ->where('p.nom LIKE :nom')
            ->setParameter('nom', $nom)
            ->orderBy('p.nom', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // recherche tous les noms de prestataires

    public function findNoms()
    {
        return $this->createQueryBuilder('p')
                            ->addSelect('p.nom')
                            ->orderBy('p.nom')
                            ->getQuery()
                            ->getResult();
    }

    //recherche prestataire en passant par le formulaire
    public function findPrestSearch($nom=null,$categorieService =null, $commune=null, $cp=null, $localite=null)
    {
        //liaison des tables
        $queryBuilder = $this ->createQueryBuilder('p')
                            //   ->join('p.categorieServices', 'cs')
                            //   ->join('p.utilisateur', 'u')
                            //   ->join('u.commune', 'c')
                            //   ->join('u.codePostal', 'cp')
                            //   ->join('u.localite', 'loc')
                            //   ->addSelect('cp')
                            //   ->addSelect('c')
                            //   ->addSelect('u')
                            //   ->addSelect('cs')
                            //   ->addSelect('loc')
                            ;
          
         // si le nom est bien rempli  
        if($nom){
            $queryBuilder
                ->andWhere('p.nom LIKE :nom')
                ->setParameter(':nom', '%' .$nom.'%');
        }
        if($cp){
            $queryBuilder
                ->join('p.utilisateur', 'u')
                ->join('u.codePostal', 'cp')
                ->andWhere('cp.codePostal = :cp')
                ->setParameter(':cp', $cp );
        }
        if($commune){
            $queryBuilder
                ->join('p.utilisateur', 'u')
                ->join('u.commune', 'c')
                ->andWhere('c.commune= :commune')
                ->setParameter(':commune', $commune );
        }

        if($localite){
            $queryBuilder
                ->join('p.utilisateur', 'u')
                ->join('u.localite', 'loc')
                ->andWhere('loc.localite= :localite')
                ->setParameter(':localite', $localite);
        }
        $query = $queryBuilder->getQuery();
        return $query->getResult();
        
    }

    //affichage des 4 derniers prestataires
    public function findLastPrestataires($nb=4)
    {
        return  $this->createQueryBuilder('p')
                    ->join('p.utilisateur', 'u')//p=table prestataire ---utilisateur=$utilisateur dans l'entity
                    ->orderBy('u.inscription', 'DESC')//u= table user ds la db --inscription = l'attribut dans l'entity
                    ->setMaxResults($nb)
                    ->getQuery()
                    ->getResult();
        
    }

   
    /*
    public function findOneBySomeField($value): ?Prestataire
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


}
