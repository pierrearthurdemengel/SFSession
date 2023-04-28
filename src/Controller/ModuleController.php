<?php

namespace App\Controller;

use App\Entity\Module;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // récupère touts les stagiaire de la bdd en une collection d'objet module
        $modules = $doctrine->getRepository(Module::class)->findAll();
        return $this->render('module/index.html.twig', [
            'modules' => $modules
        ]);
    }

    #[Route('/module/add', name: 'add_module')]
    #[Route('/module/{id}/edit', name: 'edit_module')]

    public function add(ManagerRegistry $doctrine, Module $module = null, Request $request): Response
    {
        // Si l'module n'existe pas
        if (!$module) {
            $module = new Module();
        }
        // construit un formulaire qui se repose sur le $builder dans moduleType 
        $form = $this->createForm(ModuleType::class, $module);
        // analyse de ce qui se passe dans mon form
        $form->handleRequest($request);

        if ($form->isSubmited() && $form->isValid()) {
            // récupère les données saisient dans le form et ça les inject (setter), ça les hydrate = donne des valeurs
            $module = $form->getData();
            $entityManager = $doctrine->getManager();
            // retiens l'objet en mémoire (prepare)
            $entityManager->persist($module);
            // flush = tirer la chasse d'eau = envoye des données à la BDD (insert into (execute))
            $entityManager->flush();

            return $this->redirectToRoute('app_module');
        }

        // vue formulaire add
        return $this->render('module/add.html.twig', [
            // create view = génère la vue du formulaire
            'formAddModule' => $form->createView(),
            'edit' => $module->getId()
        ]);
    }


    #[Route('/module/{id}/delete', name: 'delete_module')]

    public function delete(ManagerRegistry $doctrine, Module $module): Response
    {
        $entityManger = $doctrine->getManager();
        $entityManager = remove($module);
        $entityManager->flush();

        return $this->redirectToRoute('app_module');
    }



    #[Route('/module/{id}', name: 'show_module')]

    public function show(Module $module): Response
    {
        return $this->render('module/show.html.twig', [
            'module' => $module
        ]);
    }
}