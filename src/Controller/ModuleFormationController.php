<?php

namespace App\Controller;

use App\Entity\ModuleFormation;
use App\Form\ModuleFormationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleFormationController extends AbstractController
{
    // La fonction index permet de préparer les informations à afficher dans la vue index.html.twig

    /**
     * @Route("/module", name="index_module")
     */
    public function index(ManagerRegistry $doctrine): Response // on injecte le service Doctrine dans la méthode index de notre controller, ce qui nous servira à interagir avec notre base de données
    {
        $modules = $doctrine->getRepository(ModuleFormation::class)->findAll(); // on désigne la classe à gérer à notre gestionnaire $doctrine puis on récupère toutes les instances de cette classe

        return $this->render('module/index.html.twig', [
            'modules' => $modules,
        ]);
    }

    /**
     * @Route("/module/add", name="add_module")
     * @Route("/module/update/{id}", name="update_module")
     */
    public function add(ManagerRegistry $doctrine, ModuleFormation $moduleFormation = NULL, Request $request) {

        if (! $moduleFormation) {
            $moduleFormation = new ModuleFormation();
        }

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(ModuleFormationType::class, $moduleFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moduleFormation = $form->getData();
            $entityManager->persist($moduleFormation);
            $entityManager->flush();

            return $this->redirectToRoute('index_module');
        }

        return $this->render('module/add.html.twig', [
            'formModuleFormation' => $form->createView(),
        ]);
    }

    /**
     * @Route("/module/{id}", name="show_module")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $module = $doctrine->getRepository(ModuleFormation::class)->find($id); // on récupère l'objet de la classe "moduleFormation" ayant pour id "$id"

        if (! $module) {
            throw $this->createNotFoundException(
                "Aucun module répertoriée avec l'id $id"
            );
        }

        return $this->render('module/show.html.twig', [ // notre méthode rend le template "module/show.html.twig" où on pourra afficher les informations accessibles de notre objet module avec "{{ module }}"
            'module' => $module,
        ]);
    }
}
