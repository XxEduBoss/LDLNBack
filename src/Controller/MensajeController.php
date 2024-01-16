<?php

namespace App\Controller;

use App\Entity\Mensaje;
use App\Entity\Usuario;
use App\Repository\MensajeRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
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
        $list = $mensajeRepository->findAll();

        return $this->json($list);
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
        $nuevoMensaje -> setUsuarioEmisor($json["usuarioEmisor"]);
        $nuevoMensaje -> setUsuarioReceptor($json["usuarioReceptor"]);
        $nuevoMensaje -> setFechaEnvio($json(date_create(now())));


        return $this->json(['message' => 'Clase creada'], Response::HTTP_CREATED);

    }



}