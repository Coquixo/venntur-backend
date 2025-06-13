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

        $data = array_map(function ($proveedor) {
            return [
                'id' => $proveedor->getId(),
                'nombre' => $proveedor->getNombre(),
                'tiene_actividades' => count($proveedor->getActividades()) > 0,
                'actividades' => array_map(function ($actividad) {
                    return [
                        'id' => $actividad->getId(),
                        'nombre' => $actividad->getNombre(),
                        'descripcion_corta' => $actividad->getDescripcionCorta(),
                        'precio' => $actividad->getPrecio()
                    ];
                }, $proveedor->getActividades()->toArray())
            ];
        }, $proveedores);

        return $this->json($data, 200, [], ['json_encode_options' => JSON_UNESCAPED_UNICODE]);
    }
}
