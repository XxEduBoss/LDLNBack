<?php

namespace App\Controller;

use App\Dto\ValoracionPositivaDTO;
use App\Entity\Usuario;
use App\Entity\ValoracionPositiva;
use App\Entity\Video;
use App\Repository\ValoracionPositivaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/valoracion_negativa')]

class ValoracionPositivaController extends AbstractController
{
    //Listar valoraciones positiva
    #[Route('/listar', name: "lista_de_valoracion_positiva", methods: ["GET"])]
    public function list(ValoracionPositivaRepository $valoracionPositivaRepository):JsonResponse
    {

        $valoracionesPositivas = $valoracionPositivaRepository->findAll();

        $listaValoracionesPositivasDTOs = [];

        foreach ($valoracionesPositivas as $vP) {

            $valoracionPositiva = new ValoracionPositivaDTO();
            $valoracionPositiva->setId($vP->getId());
            $valoracionPositiva->setLikes($vP->isLikes());
            $valoracionPositiva->setUsuario($vP->getUsuario());
            $valoracionPositiva->setVideo($vP->getVideo());
            $valoracionPositiva->setActivo($vP->isActivo());

            $listaValoracionesPositivasDTOs[] = $valoracionPositiva;
        }
        return $this->json($listaValoracionesPositivasDTOs);
    }

    //Buscar valoraciones positivas por id
    #[Route('/{id}', name: "valoraciones_positivas_by_id", methods: ["GETS"])]
    public function getById(ValoracionPositiva $valoracionPositiva):JsonResponse
    {
        return $this->json($valoracionPositiva);
    }

    //Crear valoraciones positivas
    #[Route('/crear', name: "crear_valoracion_positiva", methods: ["POST"])]
    public function crearCanal(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $json = json_decode($request->getContent(), true);

        $nuevaValoracionPositiva = new ValoracionPositiva();
        $nuevaValoracionPositiva->setLikes(true);

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$json["usuario"]]);
        $nuevaValoracionPositiva->setUsuario($usuario[0]);

        $video = $entityManager->getRepository(Video::class)->findBy(["id"=>$json["usuario"]]);
        $nuevaValoracionPositiva->setVideo($video[0]);

        $nuevaValoracionPositiva->setActivo(true);

        $entityManager->persist($nuevaValoracionPositiva);
        $entityManager->flush();

        return $this->json(['message' => 'Valoracion positiva creado'], Response::HTTP_CREATED);
    }

    //Desactivar valoracion positiva
    #[Route('/borrar/{id}', name: "valoracion_positiva_desactivar", methods: ["PUT"])]
    public function deletedById(EntityManagerInterface $entityManager, ValoracionPositiva $valoracionPositiva):JsonResponse
    {
        $valoracionPositiva-> setActivo(false);
        $entityManager->flush();

        return $this->json(['message' => 'Valoracion positiva desactivada'], Response::HTTP_OK);
    }
}
