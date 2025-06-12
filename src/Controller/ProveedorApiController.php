<?php

namespace App\Controller;



use App\Repository\ProveedorRepository;
use App\Repository\ActividadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;


#[Route('/api/proveedores')]
class ProveedorApiController extends AbstractController
{
    private $proveedorRepository;
    private $actividadRepository;
    public $logger;

    public function __construct(ProveedorRepository $proveedorRepository, ActividadRepository $actividadRepository, LoggerInterface $logger)
    {
        $this->proveedorRepository = $proveedorRepository;
        $this->actividadRepository = $actividadRepository;
        $this->logger = $logger;
    }

    #[Route('', name: 'api_proveedores_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $proveedores = $this->proveedorRepository->findAll();

        $data = array_map(function ($proveedor) {
            return [
                'id' => $proveedor->getId(),
                'nombre' => $proveedor->getNombre(),
                'tiene_actividades' => (count($proveedor->getActividades()) > 0),
            ];
        }, $proveedores);

        return $this->json($data, 200, [], ['json_encode_options' => JSON_UNESCAPED_UNICODE]);
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


        $serializeActividad = function ($actividad) {
            return [
                'id' => $actividad->getId(),
                'nombre' => $actividad->getNombre(),
                'descripcion_corta' => $actividad->getDescripcionCorta(),

                'precio' => $actividad->getPrecio(),
                'proveedor' => $actividad->getProveedor() ? $actividad->getProveedor()->getNombre() : null,
            ];
        };

        return $this->json([
            'con_proveedor' => array_map($serializeActividad, $actividadesConProveedor),
            'sin_proveedor' => array_map($serializeActividad, $actividadesSinProveedor),
        ], 200, [], ['json_encode_options' => JSON_UNESCAPED_UNICODE]);
    }
}
