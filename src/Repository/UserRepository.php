<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    //recherche d'un user via un critère de recherche
    public function findUserLocalite($codePostal = null, $localite = null, $commune = null)
    {

        $codePostal = isset($codePostal) ? $codePostal : "";
        $localite = isset($localite) ? $localite : "";
        $commune = isset($commune) ? $commune : "";

        // ajout de code postal, localite et commune
        $qb = $this->createQueryBuilder('u')
            ->leftJoin('u.code_postal', 'b', 'WITH', 'u.code_postal = b.id')
            ->leftJoin('u.localite', 'c', 'WITH', 'u.localite = c.id')
            ->leftJoin('u.commune', 'a', 'WITH', 'u.commune = a.id')


            ->addSelect('b.code_postal AS code_postal')
            ->addSelect('c.localite AS localite')
            ->addSelect('a.Commune AS commune')
            ->addSelect('u.id AS userId');

        // si cp est rempli donc on met une condition pour retourner le cp demandé
        if ($codePostal !== "") {
            $qb
                ->andWhere('b.id = :code_postal')
                ->setParameter('code_postal', $codePostal);
        }

        if ($localite !== "") {
            $qb
                ->andWhere('c.id = :localite')
                ->setParameter('localite', $localite);
        }

        if ($commune !== "") {
            $qb
                ->andWhere('a.id = :commune')
                ->setParameter('commune', $commune);
        }


        return  $qb->getQuery()->getResult();
    }



    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
