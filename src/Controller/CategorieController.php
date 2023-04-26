<?php

namespace App\Controller;

use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
