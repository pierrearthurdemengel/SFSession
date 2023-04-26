<?php

namespace App\Controller;

use App\Entity\ADMIN;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ADMINController extends AbstractController
{
    #[Route('/a/d/m/i/n', name: 'app_a_d_m_i_n')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // récupère touts les Admin de la bdd en une collection d'objet entreprise
        $ADMINS = $doctrine->getRepository(ADMIN::class)->findAll();        
        return $this->render('admin/index.html.twig', [
            'ADMINS' => $ADMINS
        ]);
    }
}
