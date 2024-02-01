<?php

namespace App\Controller;

use App\Dto\EtiquetasDTO;
use App\Repository\EtiquetasRepository;
use App\Repository\TipoNotificacionRepository;
use App\Repository\TipoVideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/tipos')]
class TiposController extends AbstractController
{
    #[Route('/notificaciones', name: 'tipos_notificacion', methods: ['GET'])]
    public function tiposNotificacion(TipoNotificacionRepository $tipoNotificacionRepository): JsonResponse
    {
        $tiposNotificacion = $tipoNotificacionRepository->findAll();

        return $this->json($tiposNotificacion);
    }

    #[Route('/videos', name: 'tipos_video', methods: ['GET'])]
    public function tiposVideo(TipoVideoRepository $tipoVideoRepository): JsonResponse
    {
        $tiposVideos = $tipoVideoRepository->findAll();

        return $this->json($tiposVideos);
    }

    #[Route('/etiquetas', name: 'etiquetas', methods: ['GET'])]
    public function etiquetas(EtiquetasRepository $etiquetasRepository): JsonResponse
    {
        $listaEtiquetas = $etiquetasRepository->findAll();

        $listaEtiquetasDTOs = [];

        foreach ($listaEtiquetas as $e){

            $etiqueta = new EtiquetasDTO();

            $etiqueta->setId($e->getId());
            $etiqueta->setDescripcion($e->getDescripcion());

            $listaEtiquetasDTOs[] = $etiqueta;

        }

        return $this->json($listaEtiquetasDTOs);

    }

}
