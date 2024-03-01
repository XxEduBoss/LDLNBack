<?php

namespace App\Controller;

use App\Dto\CanalDTO;
use App\Entity\Canal;
use App\Entity\Suscripcion;
use App\Entity\Usuario;
use App\Entity\Video;
use App\Repository\SuscripcionRepository;
use App\Service\NotificacionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/suscripcion')]

class SuscripcionController extends AbstractController
{

    //Listar suscripciones
    #[Route('/listar', name: "lista_de_suscripciones", methods: ["GET"])]
    public function list(SuscripcionRepository $suscripcionRepository):JsonResponse
    {
        $suscripciones = $suscripcionRepository->findAll();

        $listaSuscripcionDTOs = [];

        foreach ($suscripciones as $s){

            $suscripcion = new CanalDTO();
            $suscripcion->setId($s->getId());
            $suscripcion->setNombre($s->getFechaSuscripcion());
            $suscripcion->setApellidos($s->getUsuario());
            $suscripcion->setNombreCanal($s->getCanal());
            $suscripcion->setActivo($s->isActivo());

            $listaSuscripcionDTOs[] = $suscripcion;

        }

        return $this->json($listaSuscripcionDTOs);

    }

    //Buscar suscripciones por id
    #[Route('/{id}', name: "suscripcion_by_id", methods: ["GETS"])]
    public function getById(Suscripcion $suscripcion):JsonResponse
    {
        return $this->json($suscripcion);
    }


    //Crear una suscripcion
    #[Route('/crear', name: "crear_suscripcion", methods: ["POST"])]
    public function crearSuscripcion(EntityManagerInterface $entityManager, Request $request, NotificacionService $notificacionService):JsonResponse
    {
        $json = json_decode($request->getContent(), true);

        $nuevaSuscripcion = new Suscripcion();
        $nuevaSuscripcion->setFechaSuscripcion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $canal = $entityManager->getRepository(Canal::class)->findOneBy(["id"=>$json["canal"]]);
        $nuevaSuscripcion->setCanal($canal);

        $usuario = $entityManager->getRepository(Usuario::class)->findOneBy(["id"=>$json["usuario"]]);
        $nuevaSuscripcion->setUsuario($usuario);

        $nuevaSuscripcion->setActivo(true);

        $usuarioReceptorArray = $entityManager->getRepository(Usuario::class)->getUsuarioPorCanal(["id_canal"=>$canal->getId()]);

        $usuarioCanal = $entityManager->getRepository(Usuario::class)->findOneBy(["id" => $usuarioReceptorArray[0]['id']]);

        $notificacionService->crearNotificacionSuscripcion($entityManager, $usuarioCanal, $usuario);

        $entityManager->persist($nuevaSuscripcion);
        $entityManager->flush();

        return $this->json(['message' => 'Suscripción creada'], Response::HTTP_CREATED);
    }

    //Desactivar suscripcion
    #[Route('/borrar/{id}', name: "suscripcion_desactivar", methods: ["DELETE"])]
    public function deletedById(EntityManagerInterface $entityManager, Suscripcion $suscripcion):JsonResponse
    {
        $entityManager->remove($suscripcion);
        $entityManager->flush();

        return $this->json(['message' => 'Suscripcion desactivada'], Response::HTTP_OK);
    }

    //Activar suscripcion
    #[Route('/activar/{id}', name: "suscripcion_activar", methods: ["PUT"])]
    public function activarById(EntityManagerInterface $entityManager, Suscripcion $suscripcion):JsonResponse
    {
        $suscripcion-> setActivo(true);
        $entityManager->flush();

        return $this->json(['message' => 'Suscripcion activada'], Response::HTTP_OK);
    }


    // Buscar suscripciones por id_canal
    #[Route('/buscar', name: 'find_suscripcion', methods: ['POST', 'OPTIONS'])]
    public function getSuscripcionByIdUsuario(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Verifica si los datos necesarios están presentes en la solicitud
        if (!isset($data['usuario']) || !isset($data['canal'])) {
            return $this->json(['error' => 'Datos incompletos'], 400);
        }

        $id_usuario = $data['usuario'];
        //$canal = $data['canal'];
        $id_canal = $data['canal'];

        $suscripcion = $entityManager->getRepository(Suscripcion::class)->getSuscripcionByIdUsuarioRepository([
            "id_usuario" => $id_usuario,
            "id_canal" => $id_canal
        ]);

        // Verificar si la Suscripcion fue encontrada
        if (!$suscripcion) {
            // Reportar false en caso que la Suscripcion no fue encontrada
            return $this->json(['exists' => false]);
        } else {
            // Reportar la información de la Suscripcion en caso que fue encontrada
            return $this->json([
                'exists' => true,
                'id' => $suscripcion[0]['id'],
                'id_usuario' => $suscripcion[0]['id_usuario'],
                'id_canal' => $suscripcion[0]['id_canal'],
                'activo' => $suscripcion[0]['activo'],
            ]);
        }
    }

    //Los videos de tus canales suscritos
    #[Route('/suscriptoresporcanal', name: "suscriptores_por_canal", methods: ["POST"])]
    public function SuscriptoresPorCanal(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $listaSuscriptores = $entityManager->getRepository(Suscripcion::class)->getSuscriptoresPorCanal(["id"=> $data["id"]]);

        return $this->json($listaSuscriptores, Response::HTTP_OK);
    }


    #[Route('/canalessuscritosporusuario', name: "canales_suscritos_usuario", methods: ["POST"])]
    public function CanalesSuscritosUsuario(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $listaCanales = $entityManager->getRepository(Suscripcion::class)->getCanalaesSuscritosPorCanal(["id_usuario"=> $data["id"]]);

        return $this->json($listaCanales, Response::HTTP_OK);
    }



}
