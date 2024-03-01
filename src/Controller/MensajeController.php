<?php

namespace App\Controller;

use App\Dto\MensajeDTO;
use App\Entity\Canal;
use App\Entity\Mensaje;
use App\Entity\Usuario;
use App\Repository\MensajeRepository;
use App\Service\NotificacionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use function Symfony\Component\Clock\now;

#[Route('/api/chat')]
class MensajeController extends AbstractController
{

    #[Route('', name: "mensaje_list", methods: ["POST"])]
    public function mensajeList(MensajeRepository $mensajeRepository, Request $request , EntityManagerInterface $entityManager): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $lista_mensaje = $entityManager->getRepository(Mensaje::class)->getMensajesEntreUsuarios(["id_canal1" => $data["id_canal1"], "id_canal2"=>$data["id_canal2"]]);

        return $this->json($lista_mensaje);
    }


    // Controller para listar mensajes
   /* #[Route('', name: "mensaje_list", methods: ["GET"])]
    public function list(MensajeRepository $mensajeRepository):JsonResponse
    {
        $mensajes = $mensajeRepository->findAll();

        $listaMensajesDTO = [];

        foreach ($mensajes as $m){

            $mensaje = new MensajeDTO();
            $mensaje->setId($m->getId());
            $mensaje->setTexto($m->getTexto());
            $mensaje->setFechaEnvio($m->getFechaEnvio());
            $mensaje->setLeido($m->getLeido());
            $mensaje->setUsuarioEmisor($m->getUsuarioEmisor());
            $mensaje->setUsuarioReceptor($m->getUsuarioReceptor());

            $listaMensajesDTO[] = $mensaje;
        }
        return $this->json($listaMensajesDTO);
    }*/

    // Controller para mostrar mensaje por id
    #[Route('/{:id}', name: "mensaje_by_id", methods: ["GET"])]
    public function getById(Mensaje $mensaje):JsonResponse
    {
        return $this->json($mensaje);
    }

    // Controller para enviar mensaje
    #[Route('/enviar', name: "enviar_mensaje", methods: ["POST"])]
    public function enviarMensaje(EntityManagerInterface $entityManager, Request $request, NotificacionService $notificacionService):JsonResponse
    {
        $json = json_decode($request -> getContent(), true);

        $nuevoMensaje = new Mensaje();
        $nuevoMensaje -> setTexto($json["texto"]);
        $nuevoMensaje->setFechaEnvio(date_create(now()->format('Y-m-d H:i:s')));
        $nuevoMensaje-> setLeido(false);
        $nuevoMensaje-> setActivo(true);

        $emisor = $entityManager->getRepository(Canal::class)->findBy(["id"=> $json["id_canal_emisor"]]);
        $nuevoMensaje->setCanalEmisor($emisor[0]);

        $receptor = $entityManager->getRepository(Canal::class)->findBy(["id"=> $json["id_canal_receptor"]]);
        $nuevoMensaje->setCanalReceptor($receptor[0]);

        $usuarioReceptorArray = $entityManager->getRepository(Usuario::class)->getUsuarioPorCanal(["id_canal"=>$receptor[0]->getId()]);

        $usuarioReceptor = $entityManager->getRepository(Usuario::class)->findOneBy(["id" => $usuarioReceptorArray[0]['id']]);

        $notificacionService->crearNotificacionMensaje($entityManager, $emisor[0], $usuarioReceptor);

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