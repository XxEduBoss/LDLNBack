<?php

namespace App\Controller;

use App\Dto\NotificacionDTO;
use App\Entity\Canal;
use App\Entity\Notificacion;
use App\Entity\Usuario;
use App\Entity\Video;
use App\Repository\NotificacionRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/api/notificacion')]
class NotificacionController extends AbstractController
{
    #[Route('/listar', name: 'listar_notificacion', methods: ["GET"])]
    public function listar(NotificacionRepository $notificacionRepository): JsonResponse
    {
        $notificaciones = $notificacionRepository->findAll();

        $listaNotificacionDTOs = [];

        foreach ($notificaciones as $noti){

            $notificacion = new NotificacionDTO();

            $notificacion->setId($noti->getId());
            $notificacion->setTexto($noti->getTexto());
            $notificacion->setTipo($noti->getTipo());
            $notificacion->setFechaNotificacion($noti->getFechaNotificacion());
            $notificacion->setUsuario($noti->getUsuario());
            $notificacion->setActivo($noti->isActivo());

            $listaNotificacionDTOs = $notificacion;


        }

        return $this->json($listaNotificacionDTOs);
    }

    #[Route('/{id}', name: "notificacion_by_id", methods: ["GET"])]
    public function getById(Video $video):JsonResponse
    {
        return $this->json($video);

    }
    #[Route('/crear', name:"notificacion_crear" , methods : ["POST"])]
    public function crearNotificacion(EntityManagerInterface $entityManager , Request $request) :JsonResponse
    {

        $json = json_decode($request->getContent(), true );

        $nuevaNotificacion = new Notificacion();

        $nuevaNotificacion -> setTexto($json["texto"]);
        $nuevaNotificacion -> setTipo($json["tipo"]);
        $nuevaNotificacion ->setFechaNotificacion($json["fecha_notificacion"]);

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$json["id_usuario"]]);
        $nuevaNotificacion->setUsuario($usuario);

        $nuevaNotificacion->setUsuario($usuario[0]);


        $nuevaNotificacion->setActivo(true);

        $entityManager->persist($nuevaNotificacion);
        $entityManager->flush();

        return $this->json(['message' => 'Notificacion creada'], Response::HTTP_CREATED);

    }
    #[Route('/modificar', name:"notificacion_modificar" , methods : ["PUT"])]
    public function modificarNotificacion(EntityManagerInterface $entityManager , Request $request , Notificacion $notificacion) :JsonResponse
    {

        $json = json_decode($request->getContent(), true );

        $nuevaNotificacion = new Notificacion();

        $nuevaNotificacion -> setTexto($json["texto"]);
        $nuevaNotificacion -> setTipo($json["tipo"]);
        $nuevaNotificacion ->setFechaNotificacion($json["fecha_notificacion"]);

        $entityManager->flush();

        return $this->json(['message' => 'Notificacion modificado'], Response::HTTP_OK);

    }

    #[Route('/borrar/{id}', name: "delete_by_id", methods: ["PUT"])]
    public function deleteById(EntityManagerInterface $entityManager, Notificacion $notificacion):JsonResponse
    {

        $notificacion->setActivo(false);
        $entityManager->flush();

        return $this->json(['message' => 'notificacion eliminado'], Response::HTTP_OK);

    }
}