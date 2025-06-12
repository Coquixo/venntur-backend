<?php
// src/Controller/SecurityController.php

namespace App\Controller;

use Psr\Log\LoggerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'login', methods: ['POST'])]
    public function login(AuthenticationUtils $authenticationUtils, LoggerInterface $logger)
    {
        // obtener el error de login si hay
        
        $error = $authenticationUtils->getLastAuthenticationError();
        // último email ingresado por el usuario (Symfony llama a getLastUsername pero aquí será email)
        $lastEmail = $authenticationUtils->getLastUsername();
        $logger->info('Intento de login', [
            'lastEmail' => $lastEmail,
            'error' => $error ? $error->getMessage() : null,
        ]);

        if ($error) {
            return new JsonResponse([
                'error' => $error->getMessage(),
                'last_email' => $lastEmail,
            ], 401);
        }

        // Si no hay error, normalmente Symfony redirige o da token, 
        // aquí solo devolvemos mensaje para ejemplo
        return new JsonResponse([
            'message' => 'Login exitoso',
            'email' => $lastEmail,
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout()
    {
        // Este método puede estar vacío, lo maneja Symfony automáticamente
        throw new \Exception('Este método puede estar vacío - lo maneja Symfony');
    }
}
