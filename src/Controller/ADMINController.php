<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ADMINController extends AbstractController
{
    #[Route('/a/d/m/i/n', name: 'app_a_d_m_i_n')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'ADMINController',
        ]);
    }
}
