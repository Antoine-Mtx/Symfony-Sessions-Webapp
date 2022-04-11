<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    // La fonction index permet de préparer les informations à afficher dans la vue index.html.twig

    /**
     * @Route("/formation", name="index_formation")
     */
    public function index(ManagerRegistry $doctrine): Response // on injecte le service Doctrine dans la méthode index de notre controller, ce qui nous servira à interagir avec notre base de données
    {
        $formations = $doctrine->getRepository(Formation::class)->findAll(); // on désigne la classe à gérer à notre gestionnaire $doctrine puis on récupère toutes les instances de cette classe

        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/formation/add", name="add_formation")
     * @Route("/formation/update/{id}", name="update_formation")
     */
    public function add(ManagerRegistry $doctrine, Formation $formation = NULL, Request $request) {

        if (! $formation) {
            $formation = new Formation();
        }

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formation = $form->getData();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('index_formation');
        }

        return $this->render('formation/add.html.twig', [
            'formFormation' => $form->createView(),
        ]);
    }

    /**
     * @Route("/formation/{id}", name="show_formation")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $formation = $doctrine->getRepository(Formation::class)->find($id); // on récupère l'objet de la classe "Formation" ayant pour id "$id"

        if (! $formation) {
            throw $this->createNotFoundException(
                "Aucune formation répertoriée avec l'id $id"
            );
        }

        return $this->render('formation/show.html.twig', [ // notre méthode rend le template "formation/show.html.twig" où on pourra afficher les informations accessibles de notre objet formation avec "{{ formation }}"
            'formation' => $formation,
        ]);
    }
}