<?php

namespace App\Controller;

use App\Dto\CanalDTO;
use App\Dto\UsuarioDTO;
use App\Entity\Canal;
use App\Entity\Etiquetas;
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

        if (isset($json['etiquetas']) && is_array($json['etiquetas'])) {
            foreach ($json['etiquetas'] as $etiquetaId) {
                $etiquetaVideo = $entityManager->getRepository(Etiquetas::class)->findOneBy(["descripcion"=>$etiquetaId] );
                if ($etiquetaVideo instanceof Etiquetas) {
                    $nuevoCanal->addEtiqueta($etiquetaVideo);
                }
            }
        }

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

        $fechaNacimientoString = $json["fecha_nacimiento"];
        $fechaNacimientoDateTime = \DateTimeImmutable::createFromFormat('Y-m-d\TH:i', $fechaNacimientoString);

        $canal->setFechaNacimiento($fechaNacimientoDateTime);


        $entityManager->flush();

        return $this->json(['message' => 'Canal modificado'], Response::HTTP_OK);
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
            $user->setComunidadAutonoma($c->getUsuario()->getComunidadAutonoma());
            $user->setRolUsuario($c->getUsuario()->getRolUsuario());
            $user->setActivo($c->getUsuario()->isActivo());

            $canal->setUsuario($user);
            $canal->setActivo($c->isActivo());

            $listaCanalesDTOs[] = $canal;

        }

        return $this->json(['Canales por nombre' => $listaCanalesDTOs], Response::HTTP_OK);

    }

    #[Route('/numsuscriptoresporcanal', name: "get_num_suscriptores_por_canal", methods: ["POST"])]
    public function NumSuscriptoresPorCanal(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $numeroSucriptores = $entityManager->getRepository(Canal::class)->getNumSuscriptoresPorCanal(["id"=>$data['id']]);

        return $this->json($numeroSucriptores[0], Response::HTTP_OK);
    }

    #[Route('/etiquetasporcanal', name: "get_etiquetas_por_canal", methods: ["POST"])]
    public function EtiquetassPorCanal(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $etiquetasCanal = $entityManager->getRepository(Canal::class)->getEtiquetasPorCanal(["id"=>$data['id']]);

        return $this->json($etiquetasCanal, Response::HTTP_OK);
    }

    #[Route('/sucriptoresporcanal', name: "get_sucriptores_por_canal", methods: ["POST"])]
    public function SucriptoresPorCanal(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $suscriptoresCanal = $entityManager->getRepository(Canal::class)->getSuscriptoresPorCanal(["id"=>$data['id']]);

        return $this->json($suscriptoresCanal, Response::HTTP_OK);
    }

    #[Route('/videosporcanal', name: "get_videos_por_canal", methods: ["POST"])]
    public function VideosPorCanalController(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $videosCanal = $entityManager->getRepository(Canal::class)->getVideosPorCanal(["id"=>$data['id']]);

        return $this->json($videosCanal, Response::HTTP_OK);
    }

    #[Route('/canalporusuario', name: "get_canal_por_usuario", methods: ["POST"])]
    public function CanalPorUsuario(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $usuarioCanal = $entityManager->getRepository(Canal::class)->getCanalPorUsuario(["id"=>$data['id']]);

        return $this->json($usuarioCanal[0], Response::HTTP_OK);
    }

}
