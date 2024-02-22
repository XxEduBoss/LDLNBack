<?php

namespace App\Controller;

use App\Dto\ValoracionPositivaDTO;
use App\Entity\Canal;
use App\Entity\Usuario;
use App\Entity\ValoracionPositiva;
use App\Entity\Video;
use App\Repository\ValoracionPositivaRepository;
use App\Service\NotificacionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/valoracion_positiva')]

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
    public function crearCanal(EntityManagerInterface $entityManager, Request $request, NotificacionService $notificacionService):JsonResponse
    {
        $json = json_decode($request->getContent(), true);

        $nuevaValoracionPositiva = new ValoracionPositiva();
        $nuevaValoracionPositiva->setLikes(true);

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$json["usuario"]["id"]]);
        $nuevaValoracionPositiva->setUsuario($usuario[0]);

        $video = $entityManager->getRepository(Video::class)->findBy(["id"=>$json["video"]["id"]]);
        $nuevaValoracionPositiva->setVideo($video[0]);

        $notificacionService->crearNotificacionLike($entityManager, $video[0], $usuario[0]);

        $entityManager->persist($nuevaValoracionPositiva);
        $entityManager->flush();

        return $this->json(['message' => 'Valoracion positiva creado'], Response::HTTP_CREATED);
    }

    //Eliminar valoracion positiva
    #[Route('/borrar/{id}', name: "valoracion_positiva_eliminar", methods: ["DELETE"])]
    public function deletedById(EntityManagerInterface $entityManager, ValoracionPositiva $valoracionPositiva):JsonResponse
    {
        $entityManager->remove($valoracionPositiva);
        $entityManager->flush();

        return $this->json(['message' => 'Valoracion positiva eliminada'], Response::HTTP_OK);
    }

    // Conseguir los datos de valoracion Positiva
    #[Route('/buscar', name: "valoracion_positiva_get_id", methods: ["POST", 'OPTIONS'])]
    public function getByUsernameAndVideoId(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Verifica si los datos necesarios están presentes en la solicitud
        if (!isset($data['usuario']) || !isset($data['video'])) {
            return $this->json(['error' => 'Datos incompletos'], 400);
        }
        $usuario = $data['usuario'];
        $id_usuario = $usuario['id'];
        $video = $data['video'];
        $id_video = $video['id'];

        $like = $entityManager->getRepository(ValoracionPositiva::class)->getValoracionPositivaByIdUsuarioRepository([
            "id_usuario" => $id_usuario,
            "id_video" => $id_video
        ]);

        // Verificar si la Like fue encontrada
        if (!$like) {
            // Reportar false en caso que el Like no fue encontrada
            return $this->json(['exists' => false]);
        } else {
            // Reportar la información de el Like en caso que fue encontrada
            return $this->json([
                'exists' => true,
                'id' => $like[0]['id'],
                'id_usuario' => $like[0]['id_usuario'],
                'id_video' => $like[0]['id_video'],
            ]);
        }
    }
}
