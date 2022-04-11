<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    // La fonction index permet de préparer les informations à afficher dans la vue index.html.twig

    /**
     * @Route("/categorie", name="index_categorie")
     */
    public function index(ManagerRegistry $doctrine): Response // on injecte le service Doctrine dans la méthode index de notre controller, ce qui nous servira à interagir avec notre base de données
    {
        $categories = $doctrine->getRepository(Categorie::class)->findAll(); // on désigne la classe à gérer à notre gestionnaire $doctrine puis on récupère toutes les instances de cette classe

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    // La fonction add permet d'ajouter / modifier une catégorie

    /**
     * @Route("/categorie/add", name="add_categorie")
     * @Route("/categorie/update/{id}", name="update_categorie")
     */

    public function add(ManagerRegistry $doctrine, Categorie $categorie = null, Request $request): Response
    {
        if (! $categorie) { 
            $categorie = new Categorie();
        }
        // si le paramètre passé est NULL on crée une instance de la classe Categorie => c'est le cas ajout
        // si la catégorie est spécifiée, on est dans le cas d'une modification

        $entityManager = $doctrine->getManager(); // permet d'accéder à des méthodes relatives à l'insertion de données dans notre db
        $form = $this->createForm(CategorieType::class, $categorie); // on crée un formulaire dédié à la classe Catégorie, si $categorie est définie, les champs seront préremplis avec les données existantes
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorie  = $form->getData();
            $entityManager->persist($categorie); // persist permet de créer une instance de la classe donnée, on ne s'en sert donc que lors de l'ajout d'un élément. Si on est dans le cas d'unemodification, cette étape est ignorée.
            $entityManager->flush(); // flush permet d'éxécuter notre requête

            return $this->redirectToRoute('index_categorie'); // on termine en affichant la vue de la liste propre à notre classe où on pourra constater l'ajout / la modification effectué(e)
        }

        return $this->render('categorie/add.html.twig', [
            'formCategorie' => $form->createView(),
        ]);
    }

        /**
     * @Route("/categorie/{id}", name="show_categorie")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $categorie = $doctrine->getRepository(Categorie::class)->find($id); // on récupère l'objet de la classe "categorie" ayant pour id "$id"

        if (! $categorie) {
            throw $this->createNotFoundException(
                "Aucun catégorie répertorié avec l'id $id"
            );
        }

        return $this->render('categorie/show.html.twig', [ // notre méthode rend le template "categorie/show.html.twig" où on pourra afficher les informations accessibles de notre objet categorie avec "{{ categorie }}"
            'categorie' => $categorie,
        ]);
    }
}
