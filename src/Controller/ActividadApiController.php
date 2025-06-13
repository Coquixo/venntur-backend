<?php

namespace App\Controller;

use App\Repository\ActividadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/actividades')]
class ActividadApiController extends AbstractController
{
    private $actividadRepository;
    private $serializer;

    public function __construct(ActividadRepository $actividadRepository, SerializerInterface $serializer)
    {
        $this->actividadRepository = $actividadRepository;
        $this->serializer = $serializer;
    }

    #[Route('', name: 'api_actividades_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'No autenticado'], 401);
        }

        $actividades = $this->actividadRepository->findAll();

        $json = $this->serializer->serialize(
            $actividades,
            'json',
            ['groups' => ['list'], 'json_encode_options' => JSON_UNESCAPED_UNICODE]
        );

        return JsonResponse::fromJsonString($json);
    }

    #[Route('/{id}', name: 'api_actividad_detail', methods: ['GET'])]
    public function detail(int $id): JsonResponse
    {
        $actividad = $this->actividadRepository->find($id);

        if (!$actividad) {
            return $this->json(['error' => 'Actividad no encontrada'], 404, [], ['json_encode_options' => JSON_UNESCAPED_UNICODE]);
        }

        $json = $this->serializer->serialize(
            $actividad,
            'json',
            ['groups' => ['detail'], 'json_encode_options' => JSON_UNESCAPED_UNICODE]
        );

        return JsonResponse::fromJsonString($json);
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

        $json = $this->serializer->serialize(
            $actividades,
            'json',
            ['groups' => ['list'], 'json_encode_options' => JSON_UNESCAPED_UNICODE]
        );

        return JsonResponse::fromJsonString($json);
    }
}
