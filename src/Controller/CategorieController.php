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
    #[Route('/categorie', name: 'app_categorie')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // récupère touts les Categorie de la bdd en une collection d'objet entreprise
        $categories = $doctrine->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories
        ]);
    }







    #[Route('/categorie/add', name: 'add_categorie')]
    #[Route('/categorie/{id}/edit', name: 'edit_categorie')]
    public function add(ManagerRegistry $doctrine, Categorie $categorie = null, Request $request): Response 
{
    // Si l'categorie n'existe pas
    if(!$categorie) {
        $categorie = new Categorie();
    }
    // construit un formulaire qui se repose sur le $builder dans categorieType 
    $form = $this->createForm(CategorieType::class, $categorie);
    // analyse de ce qui se passe dans mon form
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) 
    {
        // récupère les données saisient dans le form et ça les inject (setter), ça les hydrate = donne des valeurs
        $categorie = $form->getData();
        $entityManager = $doctrine->getManager();
        // retiens l'objet en mémoire (prepare)
        $entityManager->persist($categorie);
        // flush = tirer la chasse d'eau = envoye des données à la BDD (insert into (execute))
        $entityManager->flush();

        return $this->redirectToRoute('app_categorie');
    }
    
    // vue formulaire add
    return $this->render('categorie/add.html.twig', [
        // create view = génère la vue du formulaire
        'formAddCategorie' => $form->createView(),
        'edit' => $categorie->getId()
    ]);  
}









    #[Route('/categorie/{id}/delete', name: 'delete_categorie')]

    public function delete(ManagerRegistry $doctrine, Categorie $categorie): Response
{
    $entityManager = $doctrine->getManager();
    $entityManager->remove($categorie);
    $entityManager->flush();

    return $this->redirectToRoute('app_categorie');
}






#[Route('/categorie/{id}', name: 'show_categorie')]

public function show(Categorie $categorie): Response
{

    return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie
        ]);
    }
}
