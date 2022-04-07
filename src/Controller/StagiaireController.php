<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
    // La fonction index permet de préparer les informations à afficher dans la vue index.html.twig

    /**
     * @Route("/stagiaire", name="index_stagiaire")
     */
    public function index(ManagerRegistry $doctrine): Response // on injecte le service Doctrine dans la méthode index de notre controller, ce qui nous servira à interagir avec notre base de données
    {
        $stagiaires = $doctrine->getRepository(Stagiaire::class)->findAll(); // on désigne la classe à gérer à notre gestionnaire $doctrine puis on récupère toutes les instances de cette classe

        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    // /**
    //  * @Route("/stagiaire", name="add_stagiaire")
    //  */
    // public function index(ManagerRegistry $doctrine): Response
    // {
    //     $stagiaireManager = $doctrine->getManager(); // On récupère l'entity manager propre à la classe Stagiaire qui nous permet de sauvegarder/récupérer des objets dans/depuis notre bdd

    //     return $this->render('stagiaire/index.html.twig', [
    //         'message' => "Nouveau stagiaire bien ajouté avec l'id ".$newStagiaire->getId(),
    //         'stagiaire' => $stagiaires,
    //     ]);
    // }

    // La fonction show permet de préparer un objet de la classe Stagiaire en particulier, ici identifié par son id

    /**
     * @Route("/stagiaire/{id}", name="show_stagiaire")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $stagiaire = $doctrine->getRepository(Stagiaire::class)->find($id); // on récupère l'objet de la classe "Stagiaire" ayant pour id "$id"

        if (! $stagiaire) {
            throw $this->createNotFoundException(
                "Aucun stagiaire répertorié avec l'id $id"
            );
        }

        return $this->render('stagiaire/show.html.twig', [ // notre méthode rend le template "stagiaire/show.html.twig" où on pourra afficher les informations accessibles de notre objet stagiaire avec "{{ stagiaire }}"
            'stagiaire' => $stagiaire,
        ]);
    }
}
