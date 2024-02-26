<?php

namespace App\Controller;

use App\Dto\ComentarioDTO;
use App\Dto\VisitaDTO;
use App\Entity\Comentario;
use App\Entity\Usuario;
use App\Entity\Video;
use App\Entity\Visita;
use App\Repository\ComentarioRepository;
use App\Repository\VisitaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/visita')]
class VisitaController extends AbstractController
{
    #[Route('/listar', name: 'listar_visitas', methods: ['GET'])]
    public function listar(VisitaRepository $visitaRepository): JsonResponse
    {
        $visitas = $visitaRepository->findAll();

        $listaVisitasDTOs = [];

        foreach ($visitas as $v){

            $visita = new VisitaDTO();
            $visita->setId($v->getId());
            $visita->setFechaVisita($v->getFechaVisita());
            $visita->setVideo($v->getVideo());
            $visita->setUsuario($v->getVideo());
            $visita->setActivo($v->isActivo());

            $listaVisitasDTOs[] = $visita;

        }


        return $this->json($listaVisitasDTOs);
    }

    #[Route('/{id}', name: 'visita_by_id', methods: ['GET'])]
    public function buscarPorId(Visita $visita): JsonResponse
    {
        return $this->json($visita);
    }

    #[Route('/crear', name: 'crear_visita', methods: ['POST'])]
    public function crear(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $visita = new Visita();
        $visita->setFechaVisita(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $video = $entityManager->getRepository(Video::class)->findBy(["id"=>$data["id_video"]]);
        $visita->setVideo($video[0]);

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$data["id_usuario"]]);
        $visita->setUsuario($usuario[0]);

        $visita->setActivo(true);


        $entityManager->persist($visita);
        $entityManager->flush();

        return $this->json(['message' => 'Visita creada'], Response::HTTP_CREATED);

    }

//    #[Route('/{id}', name: 'update_visita', methods: ['PUT'])]
//    public function update(EntityManagerInterface $entityManager, Request $request, Visita $visita): JsonResponse
//    {
//        $data = json_decode($request->getContent(), true);
//
//        $visita->setFechaVisita(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));
//
//        $video = $entityManager->getRepository(Video::class)->findBy(["id"=>$data["id_video"]]);
//        $visita->setVideo($video[0]);
//
//        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$data["id_usuario"]]);
//        $visita->setUsuario($usuario[0]);
//
//        $visita->setActivo(true);
//
//        $entityManager->flush();
//
//        return $this->json(['message' => 'Visita actualizada']);
//    }

    #[Route('/borrar/{id}', name: 'borrar_visita', methods: ['PUT'])]
    public function borrar(EntityManagerInterface $entityManager, Visita $visita): JsonResponse
    {
        $visita->setActivo(false);
        $entityManager->flush();

        return $this->json(['message' => 'Visita eliminada']);
    }

    #[Route('/porvideo', name: 'visita_por_video', methods: ['POST'])]
    public function porVideo(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $listaVisitas = $entityManager->getRepository(Visita::class)->getVisitasPorVideo(["id"=>$data["id_video"]]);

        return $this->json($listaVisitas);

    }

    #[Route('/historial', name: 'historial_por_usuario', methods: ['POST'])]
    public function historialUsuario(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $historial = $entityManager->getRepository(Visita::class)->getHistorialUsuario(["id_usuario"=>$data["id_usuario"]]);

        return $this->json($historial);

    }

}
