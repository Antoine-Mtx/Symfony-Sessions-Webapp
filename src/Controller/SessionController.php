<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    // La fonction index permet de préparer les informations à afficher dans la vue index.html.twig

    /**
     * @Route("/session", name="index_session")
     */
    public function index(ManagerRegistry $doctrine): Response // on injecte le service Doctrine dans la méthode index de notre controller, ce qui nous servira à interagir avec notre base de données
    {
        $sessions = $doctrine->getRepository(Session::class)->findAll(); // on désigne la classe à gérer à notre gestionnaire $doctrine puis on récupère toutes les instances de cette classe

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    /**
     * @Route("/session/add", name="add_session")
     * @Route("/session/update/{id}", name="update_session")
     */
    public function add(ManagerRegistry $doctrine, Session $session = NULL, Request $request) {

        if (! $session) {
            $session = new Session();
        }

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('index_session');
        }

        return $this->render('session/add.html.twig', [
            'formSession' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id}", name="show_session")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $session = $doctrine->getRepository(Session::class)->find($id); // on récupère l'objet de la classe "Session" ayant pour id "$id"

        if (! $session) {
            throw $this->createNotFoundException(
                "Aucune session répertoriée avec l'id $id"
            );
        }

        return $this->render('session/show.html.twig', [ // notre méthode rend le template "session/show.html.twig" où on pourra afficher les informations accessibles de notre objet session avec "{{ session }}"
            'session' => $session,
        ]);
    }
}
