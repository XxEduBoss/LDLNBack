<?php

namespace App\Controller;

use App\Dto\ValoracionNegativaDTO;
use App\Entity\Usuario;
use App\Entity\ValoracionNegativa;
use App\Entity\ValoracionPositiva;
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

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$json["usuario"]["id"]]);
        $nuevaValoracionNegativa->setUsuario($usuario[0]);

        $video = $entityManager->getRepository(Video::class)->findBy(["id"=>$json["video"]["id"]]);
        $nuevaValoracionNegativa->setVideo($video[0]);


        $entityManager->persist($nuevaValoracionNegativa);
        $entityManager->flush();

        return $this->json(['message' => 'Valoracion negativa creado'], Response::HTTP_CREATED);
    }

    //Desactivar valoracion negativa
    #[Route('/borrar/{id}', name: "valoracion_negativa_eliminar", methods: ["DELETE"])]
    public function deletedById(EntityManagerInterface $entityManager, ValoracionNegativa $valoracionNegativa):JsonResponse
    {

        $entityManager->remove($valoracionNegativa);
        $entityManager->flush();

        return $this->json(['message' => 'Valoracion negativa eliminada'], Response::HTTP_OK);
    }

    // Conseguir los datos de valoracion Negativa
    #[Route('/buscar', name: "valoracion_negativa_get_id", methods: ["POST", 'OPTIONS'])]
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

        $like = $entityManager->getRepository(ValoracionNegativa::class)->getValoracionNegativaByIdUsuarioRepository([
            "id_usuario" => $id_usuario,
            "id_video" => $id_video
        ]);

        // Verificar si el Dislike fue encontrado
        if (!$like) {
            // Reportar false en caso que el Dislike no fue encontrada
            return $this->json(['exists' => false]);
        } else {
            // Reportar la información de el Dislike en caso que fue encontrada
            return $this->json([
                'exists' => true,
                'id' => $like[0]['id'],
                'id_usuario' => $like[0]['id_usuario'],
                'id_video' => $like[0]['id_video'],
            ]);
        }
    }

    #[Route('/porvideo', name: 'dislike_por_video', methods: ['POST'])]
    public function porVideo(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $listaDislikes = $entityManager->getRepository(ValoracionNegativa::class)->getDislikesPorVideo(["id"=>$data]);

        return $this->json($listaDislikes);

    }
}
