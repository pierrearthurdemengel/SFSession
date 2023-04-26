<?php

namespace App\Controller;

use App\Entity\Formateur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
