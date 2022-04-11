<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Form\FormateurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    // La fonction index permet de préparer les informations à afficher dans la vue index.html.twig

    /**
     * @Route("/formateur", name="index_formateur")
     */
    public function index(ManagerRegistry $doctrine): Response // on injecte le service Doctrine dans la méthode index de notre controller, ce qui nous servira à interagir avec notre base de données
    {
        $formateurs = $doctrine->getRepository(Formateur::class)->findBy([], [
            'nom' => 'ASC'
        ]); // on désigne la classe à gérer à notre gestionnaire $doctrine puis on récupère toutes les instances de cette classe

        return $this->render('formateur/index.html.twig', [
            'formateurs' => $formateurs,
        ]);
    }

    /**
     * @Route("/formateur/add", name="add_formateur")
     * @Route("/formateur/update/{id}", name="update_formateur")
     */
    public function add(ManagerRegistry $doctrine, Formateur $formateur = NULL, Request $request) {

        if (! $formateur) {
            $formateur = new Formateur();
        }

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(FormateurType::class, $formateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formateur = $form->getData();
            $entityManager->persist($formateur);
            $entityManager->flush();

            return $this->redirectToRoute('index_formateur');
        }

        return $this->render('formateur/add.html.twig', [
            'formFormateur' => $form->createView(),
        ]);
    }

        /**
     * @Route("/formateur/{id}", name="show_formateur")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $formateur = $doctrine->getRepository(Formateur::class)->find($id); // on récupère l'objet de la classe "Formateur" ayant pour id "$id"

        if (! $formateur) {
            throw $this->createNotFoundException(
                "Aucun formateur répertorié avec l'id $id"
            );
        }

        return $this->render('formateur/show.html.twig', [ // notre méthode rend le template "formateur/show.html.twig" où on pourra afficher les informations accessibles de notre objet formateur avec "{{ formateur }}"
            'formateur' => $formateur,
        ]);
    }
}
