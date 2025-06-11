<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ActividadController extends AbstractController
{
    #[Route('/actividad', name: 'app_actividad')]
    public function index(): Response
    {
        return $this->render('actividad/index.html.twig', [
            'controller_name' => 'ActividadController',
        ]);
    }
}
