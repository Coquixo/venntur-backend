<?php

namespace App\Controller;

use App\Repository\ActividadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/actividades')]
class ActividadApiController extends AbstractController
{
    private $actividadRepository;

    public function __construct(ActividadRepository $actividadRepository)
    {
        $this->actividadRepository = $actividadRepository;
    }

    #[Route('', name: 'api_actividades_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'No autenticado'], 401);
        }
        $actividades = $this->actividadRepository->findAll();

        $data = array_map(function ($actividad) {
            return [
                'id' => $actividad->getId(),
                'nombre' => $actividad->getNombre(),
                'descripcion_corta' => $actividad->getDescripcionCorta(),

                'precio' => $actividad->getPrecio(),
                'proveedor' => $actividad->getProveedor() ? $actividad->getProveedor()->getNombre() : null,
            ];
        }, $actividades);

        return $this->json($data, 200, [], ['json_encode_options' => JSON_UNESCAPED_UNICODE]);
    }

    #[Route('/{id}', name: 'api_actividad_detail', methods: ['GET'])]
    public function detail(int $id): JsonResponse
    {
        $actividad = $this->actividadRepository->find($id);

        if (!$actividad) {
            return $this->json(['error' => 'Actividad no encontrada'], 404, [], ['json_encode_options' => JSON_UNESCAPED_UNICODE]);
        }

        $data = [
            'id' => $actividad->getId(),
            'nombre' => $actividad->getNombre(),
            'descripcion_corta' => $actividad->getDescripcionCorta(),
            'descripcion_larga' => $actividad->getDescripcionLarga(),
            'precio' => $actividad->getPrecio(),
            'proveedor' => $actividad->getProveedor() ? $actividad->getProveedor()->getNombre() : null,
        ];

        return $this->json($data, 200, [], ['json_encode_options' => JSON_UNESCAPED_UNICODE]);
    }

    #[Route('/search', name: 'api_actividad_search', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('q', '');

        $actividades = $this->actividadRepository->createQueryBuilder('a')
            ->where('a.nombre LIKE :q')
            ->setParameter('q', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        $data = array_map(function ($actividad) {
            return [
                'id' => $actividad->getId(),
                'nombre' => $actividad->getNombre(),
                'descripcion_corta' => $actividad->getDescripcionCorta(),
                'precio' => $actividad->getPrecio(),
                'proveedor' => $actividad->getProveedor() ? $actividad->getProveedor()->getNombre() : null,
            ];
        }, $actividades);

        return $this->json($data, 200, [], ['json_encode_options' => JSON_UNESCAPED_UNICODE]);
    }
}
