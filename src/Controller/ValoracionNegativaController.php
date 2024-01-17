<?php

namespace App\Controller;

use App\Dto\ValoracionNegativaDTO;
use App\Entity\Usuario;
use App\Entity\ValoracionNegativa;
use App\Entity\Video;
use App\Repository\ValoracionNegativaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/valoracion_negativa')]
class ValoracionNegativaController extends AbstractController
{
    //Listar valoraciones negativas
    #[Route('/listar', name: "lista_de_valoracion_negativa", methods: ["GET"])]
    public function list(ValoracionNegativaRepository $valoracionNegativaRepository):JsonResponse
    {

        $valoracionesNegativas = $valoracionNegativaRepository->findAll();

        $listaValoracionesNegativasDTOs = [];

        foreach ($valoracionesNegativas as $vN) {

            $valoracionNegativa = new ValoracionNegativaDTO();
            $valoracionNegativa->setId($vN->getId());
            $valoracionNegativa->setDislikes($vN->isDislikes());
            $valoracionNegativa->setUsuario($vN->getUsuario());
            $valoracionNegativa->setVideo($vN->getVideo());
            $valoracionNegativa->setActivo($vN->isActivo());

            $listaValoracionesNegativasDTOs[] = $valoracionNegativa;
        }
        return $this->json($listaValoracionesNegativasDTOs);
    }

    //Buscar valoraciones negativas por id
    #[Route('/{id}', name: "valoraciones_negativas_by_id", methods: ["GETS"])]
    public function getById(ValoracionNegativa $valoracionNegativa):JsonResponse
    {
        return $this->json($valoracionNegativa);
    }

    //Crear valoraciones negativas
    #[Route('/crear', name: "crear_valoracion_negativa", methods: ["POST"])]
    public function crearCanal(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $json = json_decode($request->getContent(), true);

        $nuevaValoracionNegativa = new ValoracionNegativa();
        $nuevaValoracionNegativa->setDislikes(true);

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$json["usuario"]]);
        $nuevaValoracionNegativa->setUsuario($usuario[0]);

        $video = $entityManager->getRepository(Video::class)->findBy(["id"=>$json["usuario"]]);
        $nuevaValoracionNegativa->setVideo($video[0]);

        $nuevaValoracionNegativa->setActivo(true);

        $entityManager->persist($nuevaValoracionNegativa);
        $entityManager->flush();

        return $this->json(['message' => 'Valoracion negativa creado'], Response::HTTP_CREATED);
    }

    //Desactivar valoracion negativa
    #[Route('/borrar/{id}', name: "valoracion_negativa_desactivar", methods: ["PUT"])]
    public function deletedById(EntityManagerInterface $entityManager, ValoracionNegativa $valoracionNegativa):JsonResponse
    {
        $valoracionNegativa-> setActivo(false);
        $entityManager->flush();

        return $this->json(['message' => 'Valoracion negativa desactivada'], Response::HTTP_OK);
    }
}
