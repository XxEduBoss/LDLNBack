<?php

namespace App\Controller;

use App\Dto\CanalDTO;
use App\Dto\UsuarioDTO;
use App\Entity\Canal;
use App\Entity\Usuario;
use App\Entity\Video;
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

        $canales = $canalRepository->findAll();

        $listaCanalesDTOs = [];

        foreach ($canales as $c){

            $canal = new CanalDTO();
            $canal->setId($c->getId());
            $canal->setNombre($c->getNombre());
            $canal->setApellidos($c->getApellidos());
            $canal->setNombreCanal($c->getNombreCanal());
            $canal->setTelefono($c->getTelefono());
            $canal->setFechaNacimiento($c->getFechaNacimiento());
            $canal->setFechaCreacion($c->getFechaCreacion());

            $user = new UsuarioDTO();
            $user->setId($c->getUsuario()->getId());
            $user->setUsername($c->getUsuario()->getUsername());
            $user->setPassword($c->getUsuario()->getPassword());
            $user->setRolUsuario($c->getUsuario()->getRolUsuario());
            $user->setActivo($c->getUsuario()->isActivo());

            $canal->setUsuario($user);
            $canal->setActivo($c->isActivo());

            $listaCanalesDTOs[] = $canal;

        }


        return $this->json($listaCanalesDTOs);

    }

    //Buscar canales por id
    #[Route('/{id}', name: "canal_by_id", methods: ["GET"])]
    public function getById(Canal $canal):JsonResponse
    {

        $canalDTO = new CanalDTO();
        $canalDTO->setId($canal->getId());
        $canalDTO->setNombre($canal->getNombre());
        $canalDTO->setApellidos($canal->getApellidos());
        $canalDTO->setNombreCanal($canal->getNombreCanal());
        $canalDTO->setTelefono($canal->getTelefono());
        $canalDTO->setFechaNacimiento($canal->getFechaNacimiento());
        $canalDTO->setFechaCreacion($canal->getFechaCreacion());

        $user = new UsuarioDTO();
        $user->setId($canal->getUsuario()->getId());
        $user->setUsername($canal->getUsuario()->getUsername());
        $user->setPassword($canal->getUsuario()->getPassword());
        $user->setRolUsuario($canal->getUsuario()->getRolUsuario());
        $user->setActivo($canal->getUsuario()->isActivo());

        $canalDTO->setUsuario($user);
        $canalDTO->setActivo($canal->isActivo());

        return $this->json($canalDTO);
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
        $fechaNacimientoDateTime = \DateTimeImmutable::createFromFormat('Y-m-d\TH:i', $fechaNacimientoString);


        $nuevoCanal->setFechaNacimiento($fechaNacimientoDateTime);
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

    //Busqueda de canal por su nombre
    #[Route('/busquedanombre', name: "busqueda_nombre", methods: ["POST"])]
    public function getCanalPorNombre(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $listaCanales = $entityManager->getRepository(Canal::class)->getCanalesPorNombre($data["nombre_canal"]);

        $listaCanalesDTOs = [];

        foreach ($listaCanales as $c){

            $canal = new CanalDTO();
            $canal->setId($c->getId());
            $canal->setNombre($c->getNombre());
            $canal->setApellidos($c->getApellidos());
            $canal->setNombreCanal($c->getNombreCanal());
            $canal->setTelefono($c->getTelefono());
            $canal->setFechaNacimiento($c->getFechaNacimiento());
            $canal->setFechaCreacion($c->getFechaCreacion());

            $user = new UsuarioDTO();
            $user->setId($c->getUsuario()->getId());
            $user->setUsername($c->getUsuario()->getUsername());
            $user->setPassword($c->getUsuario()->getPassword());
            $user->setEmail($c->getUsuario()->getEmail());
            $user->setRolUsuario($c->getUsuario()->getRolUsuario());
            $user->setActivo($c->getUsuario()->isActivo());

            $canal->setUsuario($user);
            $canal->setActivo($c->isActivo());

            $listaCanalesDTOs[] = $canal;

        }

        return $this->json(['Canales por nombre' => $listaCanalesDTOs], Response::HTTP_OK);

    }

}
