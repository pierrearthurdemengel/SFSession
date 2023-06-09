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
    #[Route('/session', name: 'app_session')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // récupère touts les stagiaire de la bdd en une collection d'objet Session
        $sessions = $doctrine->getRepository(Session::class)->findAll();
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions
        ]);
    }







    #[Route('/session/add', name: 'add_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function add(ManagerRegistry $doctrine, Session $session = null, Request $request): Response 
{
    // Si l'Session n'existe pas
    if(!$session) {
        $session = new Session();
    }
    // construit un formulaire qui se repose sur le $builder dans SessionType 
    $form = $this->createForm(SessionType::class, $session);
    // analyse de ce qui se passe dans mon form
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) 
    {
        // récupère les données saisient dans le form et ça les inject (setter), ça les hydrate = donne des valeurs
        $session = $form->getData();
        $entityManager = $doctrine->getManager();
        // retiens l'objet en mémoire (prepare)
        $entityManager->persist($session);
        // flush = tirer la chasse d'eau = envoye des données à la BDD (insert into (execute))
        $entityManager->flush();

        return $this->redirectToRoute('app_session');
    }
    
    // vue formulaire add
    return $this->render('session/add.html.twig', [
        // create view = génère la vue du formulaire
        'formAddSession' => $form->createView(),
        'edit' => $session->getId()
    ]);  
}









    #[Route('/session/{id}/delete', name: 'delete_session')]

    public function delete(ManagerRegistry $doctrine, Session $session): Response
{
    $entityManager = $doctrine->getManager();
    $entityManager->remove($session);
    $entityManager->flush();

    return $this->redirectToRoute('app_session');
}






#[Route('/session/{id}', name: 'show_session')]

public function show(Session $session): Response
{

    return $this->render('session/show.html.twig', [
            'session' => $session
        ]);
    }
}
