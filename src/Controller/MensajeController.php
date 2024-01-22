<?php

namespace App\Controller;

use App\Dto\MensajeDTO;
use App\Entity\Mensaje;
use App\Entity\Usuario;
use App\Repository\MensajeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Clock\now;

#[Route('/api/mensaje')]
class MensajeController extends AbstractController
{

    // Controller para listar mensajes
    #[Route('', name: "mensaje_list", methods: ["GET"])]
    public function list(MensajeRepository $mensajeRepository):JsonResponse
    {
        $mensajes = $mensajeRepository->findAll();

        $listaMensajesDTO = [];

        foreach ($mensajes as $m){

            $mensaje = new MensajeDTO();
            $mensaje->setId($m->getId());
            $mensaje->setTexto($m->getTexto());
            $mensaje->setFechaEnvio($m->getFechaEnvio());
            $mensaje->setUsuarioEmisor($m->getUsuarioEmisor());
            $mensaje->setUsuarioReceptor($m->getUsuarioReceptor());

            $listaMensajesDTO[] = $mensaje;
        }
        return $this->json($listaMensajesDTO);
    }

    // Controller para mostrar mensaje por id
    #[Route('/{:id}', name: "mensaje_by_id", methods: ["GET"])]
    public function getById(Mensaje $mensaje):JsonResponse
    {


        return $this->json($mensaje);
    }

    // Controller para enviar mensaje
    #[Route('', name: "enviar_mensaje", methods: ["POST"])]
    public function enviarMensaje(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $json = json_decode($request -> getContent(), true);

        $nuevoMensaje = new Mensaje();
        $nuevoMensaje -> setTexto($json["texto"]);
        $nuevoMensaje -> setFechaEnvio($json(date_create(now())));
        $nuevoMensaje-> setActivo(true);

        $emisor = $entityManager->getRepository(Usuario::class)->findBy(["id"=> $json["id_usuario_emisor"]]);
        $nuevoMensaje->setUsuarioEmisor($emisor[0]);

        $receptor = $entityManager->getRepository(Usuario::class)->findBy(["id"=> $json["id_usuario_receptor"]]);
        $nuevoMensaje->setUsuarioEmisor($receptor[0]);




        $entityManager->persist($nuevoMensaje);
        $entityManager->flush();

        return $this->json(['message' => 'Mensaje enviado'], Response::HTTP_CREATED);

    }

    // Controller para desactivar canal
    #[Route('/borrar/{id}', name: "delete_by_id", methods: ["PUT"])]
    public function deletedById(EntityManagerInterface $entityManager, Mensaje $mensaje):JsonResponse
    {
        $mensaje-> setActivo(false);
        $entityManager->flush();

        return $this->json(['message' => 'Mensaje eliminado'], Response::HTTP_OK);
    }

}