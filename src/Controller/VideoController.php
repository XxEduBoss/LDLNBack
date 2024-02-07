<?php

namespace App\Controller;

use App\Dto\CanalDTO;
use App\Dto\UsuarioDTO;
use App\Dto\VideoDTO;
use App\Entity\Canal;
use App\Entity\Etiquetas;
use App\Entity\EtiquetasVideo;
use App\Entity\TipoVideo;
use App\Entity\Video;
use App\Repository\EtiquetasRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/video')]
class VideoController extends AbstractController
{
    #[Route('/listar', name: 'listar_videos', methods: ["GET"])]
    public function listar(VideoRepository $videoRepository): JsonResponse
    {
       $videos = $videoRepository->findAll();

       $listaVideosDTOs = [];

       foreach ($videos as $v){

           $video = new VideoDTO();

           $video->setId($v->getId());
           $video->setTitulo($v->getTitulo());
           $video->setDescripcion($v->getDescripcion());
           $video->setUrl($v->getUrl());
           $video->setTipoVideo($v->getTipoVideo());
           $video->setFechaCreacion($v->getFechaCreacion());
           $video->setFechaPublicacion($v->getFechaPublicacion());

           $canal = new CanalDTO();
           $canal->setId($v->getCanal()->getId());
           $canal->setNombre($v->getCanal()->getNombre());
           $canal->setApellidos($v->getCanal()->getApellidos());
           $canal->setNombreCanal($v->getCanal()->getNombreCanal());
           $canal->setTelefono($v->getCanal()->getTelefono());
           $canal->setFechaNacimiento($v->getCanal()->getFechaNacimiento());
           $canal->setFechaCreacion($v->getCanal()->getFechaCreacion());

           $user = new UsuarioDTO();
           $user->setId($v->getCanal()->getUsuario()->getId());
           $user->setUsername($v->getCanal()->getUsuario()->getUsername());
           $user->setPassword($v->getCanal()->getUsuario()->getPassword());
           $user->setRolUsuario($v->getCanal()->getUsuario()->getRolUsuario());
           $user->setActivo($v->getCanal()->getUsuario()->isActivo());

           $canal->setUsuario($user);
           $canal->setActivo($v->getCanal()->isActivo());

           $video->setCanal($canal);
           $video->setActivo($v->isActivo());

           $listaVideosDTOs[] = $video;

       }

       return $this->json($listaVideosDTOs);
    }

    #[Route('/{id}', name: "video_by_id", methods: ["GET"])]
    public function getById(EtiquetasRepository $etiquetasRepository, Video $v):JsonResponse
    {

        $video = new VideoDTO();

        $video->setId($v->getId());
        $video->setTitulo($v->getTitulo());
        $video->setDescripcion($v->getDescripcion());
        $video->setUrl($v->getUrl());
        $video->setTipoVideo($v->getTipoVideo());
        $video->setFechaCreacion($v->getFechaCreacion());
        $video->setFechaPublicacion($v->getFechaPublicacion());
        $video->setMiniatura($v->getMiniatura());


        $etiquetas = $etiquetasRepository->getEtiquetasPorVideo(["id"=>$v->getId()]);

        $video->setEtiquetas($etiquetas);
        $video->setActivo($v->isActivo());

        $canal = new CanalDTO();
        $canal->setId($v->getCanal()->getId());
        $canal->setNombre($v->getCanal()->getNombre());
        $canal->setApellidos($v->getCanal()->getApellidos());
        $canal->setNombreCanal($v->getCanal()->getNombreCanal());
        $canal->setTelefono($v->getCanal()->getTelefono());
        $canal->setFechaNacimiento($v->getCanal()->getFechaNacimiento());
        $canal->setFechaCreacion($v->getCanal()->getFechaCreacion());
        $canal->setActivo($v->getCanal()->isActivo());

        $video->setCanal($canal);

        $user = new UsuarioDTO();
        $user->setId($v->getCanal()->getUsuario()->getId());
        $user->setUsername($v->getCanal()->getUsuario()->getUsername());
        $user->setPassword($v->getCanal()->getUsuario()->getPassword());
        $user->setComunidadAutonoma($v->getCanal()->getUsuario()->getComunidadAutonoma());
        $user->setRolUsuario($v->getCanal()->getUsuario()->getRolUsuario());
        $user->setActivo($v->getCanal()->getUsuario()->isActivo());

        $canal->setUsuario($user);

        return $this->json($video);

    }

    #[Route('/crear', name:"video_crear" , methods : ["POST"])]
    public function crearVideo(EntityManagerInterface $entityManager , Request $request) :JsonResponse
    {

        $json = json_decode($request->getContent(), true );

        $nuevoVideo = new Video();
        $nuevoVideo-> setTitulo($json["titulo"]);
        $nuevoVideo-> setDescripcion($json["descripcion"]);
        $nuevoVideo->setUrl($json["url"]);

        $tipo_video = $entityManager->getRepository(TipoVideo::class)->findBy(["descripcion"=>$json["tipo"]]);
        $nuevoVideo->setTipoVideo($tipo_video[0]);

        $nuevoVideo->setFechaCreacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $fechaRecibida = \DateTimeImmutable::createFromFormat('Y-m-d\TH:i', $json["fecha_publicacion"]);

        $nuevoVideo->setFechaPublicacion($fechaRecibida);

        $canal = $entityManager->getRepository(Canal::class)->findBy(["id"=>$json["id_canal"]]);
        $nuevoVideo->setCanal($canal[0]);

        $nuevoVideo->setMiniatura($json['miniatura']);

        $nuevoVideo->setActivo(true);

        if (isset($json['etiquetas']) && is_array($json['etiquetas'])) {
            foreach ($json['etiquetas'] as $etiquetaId) {
                $etiquetaVideo = $entityManager->getRepository(Etiquetas::class)->findOneBy(["descripcion"=>$etiquetaId] );
                if ($etiquetaVideo instanceof Etiquetas) {
                    $nuevoVideo->addEtiqueta($etiquetaVideo);
                }
            }
        }

        $entityManager->persist($nuevoVideo);
        $entityManager->flush();

        return $this->json(['message' => 'Video creado'], Response::HTTP_CREATED);

    }

    #[Route('/{id}', name:"video_modificar" , methods : ["PUT"])]
    public function modificarVideo(EntityManagerInterface $entityManager , Request $request , Video $video) :JsonResponse
    {

        $json = json_decode($request->getContent(), true );


        $video-> setTitulo($json["titulo"]);
        $video-> setDescripcion($json["descripcion"]);

        if (isset($json['etiquetas']) && is_array($json['etiquetas'])) {
            foreach ($json['etiquetas'] as $etiquetaId) {
                $etiquetaVideo = $entityManager->getRepository(Etiquetas::class)->findOneBy(["descripcion"=>$etiquetaId] );
                if ($etiquetaVideo instanceof Etiquetas) {
                    $video->addEtiqueta($etiquetaVideo);
                }
            }
        }

        $video->setFechaCreacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));
        $fechaPublicacionDateTime = \DateTime::createFromFormat('d/m/Y H:i:s', $json["fecha_publicacion"]);
        $video->setFechaPublicacion(new \DateTime($fechaPublicacionDateTime));
        $video->setUrl($json["url"]);

        $canal = $entityManager->getRepository(Canal::class)->find($json["id_canal"]);
        $video->setCanal($canal[0]);

        $video->setMiniatura($json['miniatura']);



        $entityManager->flush();

        return $this->json(['message' => 'Video modificado'], Response::HTTP_OK);


    }

    #[Route('/borrar/{id}', name: "delete_by_id", methods: ["PUT"])]
    public function deleteById(EntityManagerInterface $entityManager, Canal $canal):JsonResponse
    {

        $canal->setActivo(false);
        $entityManager->flush();

        return $this->json(['message' => 'Video eliminado'], Response::HTTP_OK);

    }

    //Los videos de tus canales suscritos
    #[Route('/canalessuscritos', name: "get_videos_canales_suscritos", methods: ["POST"])]
    public function getVideosSuscritosController(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $listaVideos = $entityManager->getRepository(Video::class)->getVideosSuscritos(["id"=> $data["id"]]);

        return $this->json([$listaVideos], Response::HTTP_OK);
    }

    //Los videos de por etiquetas
    #[Route('/poretiquetas', name: "get_videos_por_etiquetas", methods: ["POST"])]
    public function getVideosEtiquetasController(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $listaVideos = $entityManager->getRepository(Video::class)->getVideosPorEtiqueta(["etiqueta"=> $data["etiqueta"]]);

        return $this->json($listaVideos, Response::HTTP_OK);
    }

    //Los videos en funcion de las etiquetas del video y del usuario
    #[Route('/poretiquetausuario', name: "get_videos_usuario_etiquetas", methods: ["POST"])]
    public function getVideosEtiquetasUsuarioController(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $listaVideos = $entityManager->getRepository(Video::class)->getVideosEtiquetasUsuarios(["id"=> $data["id"]]);

        return $this->json($listaVideos, Response::HTTP_OK);
    }

    //Los videos de tu canal
    #[Route('/porcanal', name: "get_videos_por_canal", methods: ["POST"])]
    public function VideosPorCAnal(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $listaVideos = $entityManager->getRepository(Video::class)->getVideosPorCanal(["id"=>$data['id_canal']]);

        return $this->json(['Videos por su canal' => $listaVideos], Response::HTTP_OK);
    }


}
