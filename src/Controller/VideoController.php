<?php

namespace App\Controller;

use App\Dto\VideoDTO;
use App\Entity\Canal;
use App\Entity\Etiquetas;
use App\Entity\EtiquetasVideo;
use App\Entity\TipoVideo;
use App\Entity\Video;
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
           $video->setEtiquetas($v->getEtiquetas());
           $video->setFechaCreacion($v->getFechaCreacion());
           $video->setFechaPublicacion($v->getFechaPublicacion());
           $video->setUrl($v->getUrl());
           $video->setCanal($v->getCanal());
           $video->setActivo($v->isActivo());

           $listaVideosDTOs = $video;

       }

       return $this->json($listaVideosDTOs);
    }

    #[Route('/{id}', name: "video_by_id", methods: ["GET"])]
    public function getById(Video $video):JsonResponse
    {
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

        $fechaPublicacionDateTime = \DateTime::createFromFormat('d/m/Y H:i:s', $json["fecha_publicacion"]);
        $nuevoVideo->setFechaPublicacion(new \DateTime($fechaPublicacionDateTime));

        $canal = $entityManager->getRepository(Canal::class)->findBy(["id"=>$json["canal"]]);
        $nuevoVideo->setCanal($canal[0]);

        $nuevoVideo->setActivo(true);

        $entityManager->persist($nuevoVideo);
        $entityManager->flush();

        $videoCreado = $entityManager->getRepository(Video::class)->findBy(["titulo"=>$json["titulo"]]);

        foreach ($json['etiquetas'] as $etiqueta){

            $nuevoEtiquetasVideo = new EtiquetasVideo();

            $nuevaEtiqueta = $entityManager->getRepository(Etiquetas::class)->findBy(["descripcion"=>$etiqueta]);

            $nuevoEtiquetasVideo->setEtiqueta($nuevaEtiqueta[0]);
            $nuevoEtiquetasVideo->setVideo($videoCreado[0]);

            $entityManager->persist($nuevoEtiquetasVideo);
            $entityManager->flush();

        }

        return $this->json(['message' => 'Video creado'], Response::HTTP_CREATED);

    }

    #[Route('/{id}', name:"video_modificar" , methods : ["PUT"])]
    public function modificarVideo(EntityManagerInterface $entityManager , Request $request , Video $video) :JsonResponse
    {

        $json = json_decode($request->getContent(), true );


        $video-> setTitulo($json["titulo"]);
        $video-> setDescripcion($json["descripcion"]);
        $video->setEtiquetas($json["etiquetas"]);
        $video->setFechaCreacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));
        $fechaPublicacionDateTime = \DateTime::createFromFormat('d/m/Y H:i:s', $json["fecha_publicacion"]);
        $video->setFechaPublicacion(new \DateTime($fechaPublicacionDateTime));
        $video->setUrl($json["url"]);

        $canal = $entityManager->getRepository(Canal::class)->find($json["id_canal"]);
        $video->setCanal($canal[0]);


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


}
