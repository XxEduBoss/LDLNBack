<?php

namespace App\Controller;

use App\Dto\CanalDTO;
use App\Entity\Canal;
use App\Entity\Suscripcion;
use App\Entity\Usuario;
use App\Repository\SuscripcionRepository;
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
    public function crearSuscripcion(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $json = json_decode($request->getContent(), true);

        $nuevaSuscripcion = new Suscripcion();
        $nuevaSuscripcion->setFechaSuscripcion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $canal = $entityManager->getRepository(Canal::class)->findBy(["id"=>$json["canal"]]);
        $nuevaSuscripcion->setCanal($canal[0]);

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$json["usuario"]]);
        $nuevaSuscripcion->setUsuario($usuario[0]);

        $nuevaSuscripcion->setActivo(true);

        $entityManager->persist($nuevaSuscripcion);
        $entityManager->flush();

        return $this->json(['message' => 'Suscripción creada'], Response::HTTP_CREATED);
    }

    //Desactivar suscripcion
    #[Route('/borrar/{id}', name: "suscripcion_desactivar", methods: ["PUT"])]
    public function deletedById(EntityManagerInterface $entityManager, Suscripcion $suscripcion):JsonResponse
    {
        $suscripcion-> setActivo(false);
        $entityManager->flush();

        return $this->json(['message' => 'Suscripcion desactivada'], Response::HTTP_OK);
    }

    // Buscar Suscripcion por id usuario.
    #[Route('/buscar', name: 'find_usuario', methods: ['POST', 'OPTIONS'])]
    public function findSuscripcionByIdUsuario(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $suscripcion = $entityManager->getRepository(Suscripcion::class)->findOneBy(["id_usuario" => $data['usuario']]);

        // Verificar si la Suscripcion fue encontrado
        if (!$suscripcion) {
            // Manejar el caso en que la Suscripcion no fue encontrado
            return new JsonResponse(['error' => 'Usuario no encontrado'], 404);
        }

        // Devolver los datos de Suscripcion en formato JSON
        $userData = [
            'id' => $suscripcion->getId(),
            'usuario' => $suscripcion->getUsuario(),
            'canal' => $suscripcion->getCanal()
        ];

        return new JsonResponse($userData);
    }



}
