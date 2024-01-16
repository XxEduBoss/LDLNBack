<?php

namespace App\Controller;

use App\Entity\Canal;
use App\Entity\Usuario;
use App\Repository\CanalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/canal')]
class CanalController extends AbstractController
{
    //Listar canales
    #[Route('/listar', name: "lista_de_canales", methods: ["GET"])]
    public function list(CanalRepository $canalRepository):JsonResponse
    {
        $list = $canalRepository->findAll();

        return $this->json($list);
    }

    //Buscar canales por id
    #[Route('/{id}', name: "canal_by_id", methods: ["GETS"])]
    public function getById(Canal $canal):JsonResponse
    {
        return $this->json($canal);
    }

    //Crear un canal
    #[Route('/crear', name: "crear_canal", methods: ["POST"])]
    public function crearCanal(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $json = json_decode($request->getContent(), true);

        $nuevoCanal = new Canal();
        $nuevoCanal->setNombre($json["nombre"]);
        $nuevoCanal->setApellidos($json["apellidos"]);
        $nuevoCanal->setNombreCanal($json["nombre_canal"]);
        $nuevoCanal->setTelefono($json["telefono"]);

        $fechaNacimientoString = $json["fecha_nacimiento"];
        $fechaNacimientoDateTime = \DateTime::createFromFormat('d/m/Y', $fechaNacimientoString);

        $nuevoCanal->setFechaNacimiento(new \DateTime($fechaNacimientoDateTime, '00:00:00.000000'));
        $nuevoCanal->setFechaCreacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));


        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$json["usuario"]]);
        $nuevoCanal->setUsuario($usuario[0]);
        $nuevoCanal->setActivo(true);

        $entityManager->persist($nuevoCanal);
        $entityManager->flush();

        return $this->json(['message' => 'Canal creado'], Response::HTTP_CREATED);
    }

    //Modificar canal
    #[Route('/{id}', name: "editar_canal", methods: ["PUT"])]
    public function editar(EntityManagerInterface $entityManager, Request $request, Canal $canal):JsonResponse
    {
        $json = json_decode($request-> getContent(), true);

        $canal->setNombre($json["nombre"]);
        $canal->setApellidos($json["apellidos"]);
        $canal->setNombreCanal($json["nombre_canal"]);
        $canal->setTelefono($json["telefono"]);
        $canal->setFechaNacimiento($json["fecha_nacimiento"]);
        $canal->setFechaCreacion($json["fecha_creacion"]);

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$json["usuario"]]);
        $canal->setUsuario($usuario[0]);

        $entityManager->flush();

        return $this->json(['message' => 'Canal modificada'], Response::HTTP_OK);
    }

    //Desactivar canal
    #[Route('/borrar/{id}', name: "delete_by_id", methods: ["PUT"])]
    public function deletedById(EntityManagerInterface $entityManager, Canal $canal):JsonResponse
    {
        $canal-> setActivo(false);
        $entityManager->flush();

        return $this->json(['message' => 'Canal eliminado'], Response::HTTP_OK);
    }

}
