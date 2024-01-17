<?php

namespace App\Controller;

use App\Dto\ComentarioDTO;
use App\Entity\Comentario;
use App\Entity\Usuario;
use App\Entity\Video;
use App\Repository\ComentarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/comentario')]
class ComentarioController extends AbstractController
{
    #[Route('/listar', name: 'listar_comentarios', methods: ['GET'])]
    public function listar(ComentarioRepository $comentarioRepository): JsonResponse
    {
        $comentarios = $comentarioRepository->findAll();

        $listaComentariosDTOs = [];

        foreach ($comentarios as $c){

            $comentario = new ComentarioDTO();
            $comentario->setId($c->getId());
            $comentario->setTexto($c->getTexto());
            $comentario->setFechaPublicacion($c->getFechaPublicacion());
            $comentario->setVideo($c->getVideo());
            $comentario->setUsuario($c->getUsuario());
            $comentario->setActivo($c->isActivo());

            $listaComentariosDTOs[] = $comentario;

        }


        return $this->json($listaComentariosDTOs);
    }

    #[Route('/{id}', name: 'comentario_by_id', methods: ['GET'])]
    public function buscarPorId(Comentario $comentario): JsonResponse
    {
        return $this->json($comentario);
    }

    #[Route('/crear', name: 'crear_comentario', methods: ['POST'])]
    public function crear(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $comentario = new Comentario();
        $comentario->setTexto($data['texto']);

        $comentario->setFechaPublicacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $video = $entityManager->getRepository(Video::class)->findBy(["id"=>$data["id_video"]]);
        $comentario->setVideo($video[0]);

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$data["id_usuario"]]);
        $comentario->setUsuario($usuario[0]);

        $comentario->setActivo(true);

        $entityManager->persist($comentario);
        $entityManager->flush();

        return $this->json(['message' => 'Comentario creado'], Response::HTTP_CREATED);

    }

    #[Route('/{id}', name: 'update_comentario', methods: ['PUT'])]
    public function update(EntityManagerInterface $entityManager, Request $request, Comentario $comentario): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $comentario->setTexto($data['texto']);

        $comentario->setFechaPublicacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $entityManager->flush();

        return $this->json(['message' => 'Comentario actualizado']);
    }

    #[Route('/borrar/{id}', name: 'borrar_comentario', methods: ['PUT'])]
    public function borrar(EntityManagerInterface $entityManager, Comentario $comentario): JsonResponse
    {
        $comentario->setActivo(false);
        $entityManager->flush();

        return $this->json(['message' => 'Comentario eliminado']);
    }

}
