<?php

namespace App\Controller;

use App\Entity\Canal;
use App\Entity\Video;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
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
       $list = $videoRepository->findAll();

       return $this->json($list);
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
        $nuevoVideo->setEtiquetas($json["etiquetas"]);
        $nuevoVideo-> setFechaCreacion($json["fecha_creacion"]);
        $nuevoVideo->setFechaPublicacion($json["fecha_publicaion"]);
        $nuevoVideo->setUrl($json["url"]);

        $canal = $entityManager->getRepository(Canal::class)->find($json["id_canal"]);
        $nuevoVideo->setIdCanal($canal[0]);


        $entityManager->persist($nuevoVideo);
        $entityManager->flush();

        return $this->json(['message' => 'Video creado'], Response::HTTP_CREATED);


    }

    #[Route('/{id}', name:"video_crear" , methods : ["PUT"])]
    public function modificarVideo(EntityManagerInterface $entityManager , Request $request , Video $video) :JsonResponse
    {

        $json = json_decode($request->getContent(), true );


        $video-> setTitulo($json["titulo"]);
        $video-> setDescripcion($json["descripcion"]);
        $video->setEtiquetas($json["etiquetas"]);
        $video-> setFechaCreacion($json["fecha_creacion"]);
        $video->setFechaPublicacion($json["fecha_publicaion"]);
        $video->setUrl($json["url"]);

        $canal = $entityManager->getRepository(Canal::class)->find($json["id_canal"]);
        $video->setIdCanal($canal[0]);


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
