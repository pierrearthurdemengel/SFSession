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
                // récupère touts les stagiaire de la bdd en une collection d'objet entreprise
                $modules = $doctrine->getRepository(Module::class)->findAll();
        return $this->render('module/index.html.twig', [
            'modules' => $modules
        ]);
    }
}
