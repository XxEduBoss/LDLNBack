<?php

namespace App\Controller;

use App\Dto\ComentarioDTO;
use App\Dto\UsuarioDTO;
use App\Dto\VideoDTO;
use App\Entity\Comentario;
use App\Entity\Usuario;
use App\Entity\Video;
use App\Repository\ComentarioRepository;
use App\Service\NotificacionService;
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

            $video = new VideoDTO();

            $video->setId($c->getVideo()->getId());
            $video->setTitulo($c->getVideo()->getTitulo());
            $video->setDescripcion($c->getVideo()->getDescripcion());
            $video->setUrl($c->getVideo()->getUrl());
            $video->setTipoVideo($c->getVideo()->getTipoVideo());
            $video->setFechaCreacion($c->getVideo()->getFechaCreacion());
            $video->setFechaPublicacion($c->getVideo()->getFechaPublicacion());
            $comentario->setVideo($video);

            $user = new UsuarioDTO();
            $user->setId($c->getUsuario()->getId());
            $user->setUsername($c->getUsuario()->getUsername());
            $user->setPassword($c->getUsuario()->getPassword());
            $user->setRolUsuario($c->getUsuario()->getRolUsuario());
            $user->setActivo($c->getUsuario()->isActivo());

            $comentario->setUsuario($user);
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
    public function crear(EntityManagerInterface $entityManager, Request $request, NotificacionService $notificacionService): JsonResponse
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

        $id_canal = $video[0]->getCanal()->getId();

        $canal = $entityManager->getRepository(Video::class)
            ->findOneBy(["id_canal" => $id_canal]);

        $notificacionService->crearNotificacionComentario(
            $entityManager, $canal, $usuario['id_usuario']);

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

    #[Route('/video', name: 'comentario_by_id_video', methods: ['POST'])]
    public function ComentariosPorVideo(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

//        $video = $entityManager->getRepository(Video::class)->findOneBy(["id"=>$data['id']]);

        $listaComentarios = $entityManager->getRepository(Comentario::class)->getComentariosPorVideo(["id"=>$data['id']]);

        $listaComentariosDTOs = [];

        foreach ($listaComentarios as $c){

            $video1 = $entityManager->getRepository(Video::class)->findOneBy(["id"=>$c['id_video']]);
            $usuario1 = $entityManager->getRepository(Usuario::class)->findOneBy(["id"=>$c['id_usuario']]);

            $comentario = new ComentarioDTO();
            $comentario->setId($c['id']);
            $comentario->setTexto($c['texto']);
            $comentario->setFechaPublicacion($c['fecha_publicacion']);

            $video = new VideoDTO();

            $video->setId($video1->getId());
            $video->setTitulo($video1->getTitulo());
            $video->setDescripcion($video1->getDescripcion());
            $video->setUrl($video1->getUrl());
            $video->setTipoVideo($video1->getTipoVideo());
            $video->setFechaCreacion($video1->getFechaCreacion());
            $video->setFechaPublicacion($video1->getFechaPublicacion());

            $comentario->setVideo($video);

            $user = new UsuarioDTO();
            $user->setId($usuario1->getId());
            $user->setUsername($usuario1->getUsername());
            $user->setPassword($usuario1->getPassword());
            $user->setRolUsuario($usuario1->getRolUsuario());
            $user->setActivo($usuario1->isActivo());

            $comentario->setUsuario($user);
            $comentario->setActivo($c['activo']);

            $listaComentariosDTOs[] = $comentario;

        }


        return $this->json($listaComentariosDTOs);

    }

}
