<?php
// src/Controller/SecurityController.php

namespace App\Controller;

use Psr\Log\LoggerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'login', methods: ['POST'])]
    public function login(Request $request, AuthenticationUtils $authenticationUtils, LoggerInterface $logger)
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastEmail = $authenticationUtils->getLastUsername();

        if (!$error) { //TODO: not working, resolve later
            return new JsonResponse([
                'status' => 'success',
                'email' => $email,
            ]);
        }
        return new JsonResponse([
            'status' => 'error',
            'error' => $error->getMessage(),
            'last_email' => $lastEmail,
            'email' => $email,
        ], 402);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout()
    {
        // Este método puede estar vacío, lo maneja Symfony automáticamente
        throw new \Exception('Este método puede estar vacío - lo maneja Symfony');
    }
}
