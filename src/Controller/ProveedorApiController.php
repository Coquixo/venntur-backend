<?php

namespace App\Controller;

use App\Repository\ProveedorRepository;
use App\Repository\ActividadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/proveedores')]
class ProveedorApiController extends AbstractController
{
    private $proveedorRepository;
    private $actividadRepository;
    private $logger;
    private $serializer;

    public function __construct(
        ProveedorRepository $proveedorRepository,
        ActividadRepository $actividadRepository,
        LoggerInterface $logger,
        SerializerInterface $serializer
    ) {
        $this->proveedorRepository = $proveedorRepository;
        $this->actividadRepository = $actividadRepository;
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    #[Route('', name: 'api_proveedores_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $proveedores = $this->proveedorRepository->findAll();

        // Serializamos con el grupo 'list' para mostrar solo campos básicos
        $json = $this->serializer->serialize($proveedores, 'json', ['groups' => ['list']]);

        return JsonResponse::fromJsonString($json, 200, [], false);
    }

    #[Route('/actividades', name: 'api_actividades_proveedor', methods: ['GET'])]
    public function actividadesConYSinProveedor(): JsonResponse
    {
        $actividadesConProveedor = $this->actividadRepository->createQueryBuilder('a')
            ->where('a.proveedor IS NOT NULL')
            ->getQuery()
            ->getResult();

        $actividadesSinProveedor = $this->actividadRepository->createQueryBuilder('a')
            ->where('a.proveedor IS NULL')
            ->getQuery()
            ->getResult();

        // Serializamos las actividades con grupo 'list' para excluir descripcion_larga
        $jsonConProveedor = $this->serializer->serialize($actividadesConProveedor, 'json', ['groups' => ['list']]);
        $jsonSinProveedor = $this->serializer->serialize($actividadesSinProveedor, 'json', ['groups' => ['list']]);

        return new JsonResponse([
            'con_proveedor' => json_decode($jsonConProveedor, true),
            'sin_proveedor' => json_decode($jsonSinProveedor, true),
        ], 200, [], false);
    }
}
