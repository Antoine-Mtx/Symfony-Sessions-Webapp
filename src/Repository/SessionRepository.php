<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Session $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // la fonction getStagiairesNonInscrits renvoie un tableau contenant tous les stagiaire non inscrits à la session dont l'id est passée en paramètre

    public function getStagiairesNonInscrits($idSession)
    {
        $em = $this->getEntityManager(); // on appelle notre gestionnaire de base de données
        $qb = $em->createQueryBuilder(); //

        $qb->select('s')
            ->from('App\Entity\Stagiaire', 's')
            ->leftJoin('s.session', 'se')
            ->where('se.id = :id');

        $sub = $em->createQueryBuilder();
        $sub->select('st')
            ->from('App\Entity\Stagiaire', 'st')
            ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
            ->setParameter('id', $idSession)
            ->orderBy('st.nom');

        $query = $sub->getQuery();
        return $query->getResult();
    }

    // la fonction getModulesNonProgrammes renvoie un tableau contenant tous les modules de formation non ajoutés à la session dont l'id est passée en paramètre

    public function getModulesNonProgrammes($idSession)
    {
        // on récupère la liste des modules de formation inclus dans la session dont l'id est $idSession
        $em = $this->getEntityManager();

        $sql1 = $em->createQueryBuilder();

        $sql1->select('IDENTITY(p.moduleFormation)')
            // ->from('App\Entity\ModuleFormation','mf')
            ->from('App\Entity\Programme','p')
            // ->where('p.moduleFormation = mf')
            ->leftJoin('p.session','se')
            ->where('se.id = :id');

        // on récupère les modules de formation qui ne figurent pas dans la première requête

        $sql2 = $em->createQueryBuilder();

        $sql2->select('m')
            ->from('App\Entity\ModuleFormation','m')
            ->where($sql2->expr()->notIn('m.id', $sql1->getDQL()))
            ->setParameter('id', $idSession)
            ->orderBy('m.intitule', 'ASC');

        // on exécute la requête complète et on retourne le résultat

        $query = $sql2->getQuery();
              

        return $query->getResult();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Session $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Session[] Returns an array of Session objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Session
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
