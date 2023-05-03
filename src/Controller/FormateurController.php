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
    #[Route('/formateur', name: 'app_formateur')]
    public function index(ManagerRegistry $doctrine): Response
    {
                // récupère touts les Formateur de la bdd en une collection d'objet entreprise
                $formateurs = $doctrine->getRepository(Formateur::class)->findAll();
        return $this->render('formateur/index.html.twig', [
            'formateurs' => $formateurs
        ]);
    }

    


    #[Route('/formateur/add', name: 'add_formateur')]
    #[Route('/formateur/{id}/edit', name: 'edit_formateur')]
    public function add(ManagerRegistry $doctrine, Formateur $formateur = null, Request $request): Response 
{
    // Si l'formateur n'existe pas
    if(!$formateur) {
        $formateur = new Formateur();
    }
    // construit un formulaire qui se repose sur le $builder dans formateurType 
    $form = $this->createForm(FormateurType::class, $formateur);
    // analyse de ce qui se passe dans mon form
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) 
    {
        // récupère les données saisient dans le form et ça les inject (setter), ça les hydrate = donne des valeurs
        $formateur = $form->getData();
        $entityManager = $doctrine->getManager();
        // retiens l'objet en mémoire (prepare)
        $entityManager->persist($formateur);
        // flush = tirer la chasse d'eau = envoye des données à la BDD (insert into (execute))
        $entityManager->flush();

        return $this->redirectToRoute('app_formateur');
    }
    
    // vue formulaire add
    return $this->render('formateur/add.html.twig', [
        // create view = génère la vue du formulaire
        'formAddFormateur' => $form->createView(),
        'edit' => $formateur->getId()
    ]);  
}









    #[Route('/formateur/{id}/delete', name: 'delete_formateur')]

    public function delete(ManagerRegistry $doctrine, Formateur $formateur): Response
{
    $entityManager = $doctrine->getManager();
    $entityManager->remove($formateur);
    $entityManager->flush();

    return $this->redirectToRoute('app_formateur');
}






#[Route('/formateur/{id}', name: 'show_formateur')]

public function show(Formateur $formateur): Response
{

    return $this->render('formateur/show.html.twig', [
            'formateur' => $formateur
        ]);
    }
}
