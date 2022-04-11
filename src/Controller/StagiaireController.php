<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/stagiaire/add", name="add_stagiaire")
     * @Route("/stagiaire/update/{id}", name="update_stagiaire")
     */
    public function add(ManagerRegistry $doctrine, Stagiaire $stagiaire = NULL, Request $request) {

        if (! $stagiaire) {
            $stagiaire = new Stagiaire();
        }

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stagiaire = $form->getData();
            $entityManager->persist($stagiaire);
            $entityManager->flush();

            return $this->redirectToRoute('index_stagiaire');
        }

        return $this->render('stagiaire/add.html.twig', [
            'formStagiaire' => $form->createView(),
        ]);
    }

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
