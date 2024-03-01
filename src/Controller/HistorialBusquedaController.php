<?php

namespace App\Controller;

use App\Entity\Canal;
use App\Entity\HistorialBusqueda;
use App\Entity\Mensaje;
use App\Entity\Usuario;
use App\Service\NotificacionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Clock\now;

#[Route('/api/historial_busquedas')]
class HistorialBusquedaController extends AbstractController
{
    #[Route('/insertar', name: "insertar_busqueda", methods: ["POST"])]
    public function insertarBusqueda(EntityManagerInterface $entityManager, Request $request, NotificacionService $notificacionService):JsonResponse
    {
        $json = json_decode($request->getContent(), true);

        $nuevaBusqueda = new HistorialBusqueda();
        $nuevaBusqueda->setTexto($json["texto"]);
        $nuevaBusqueda->setFechaBusqueda(date_create(now()->format('Y-m-d H:i:s')));
        $nuevaBusqueda->setActivo(true);

        $idUsuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=> $json["id"]]);
        $nuevaBusqueda->setUsuario($idUsuario[0]);

        $entityManager->persist($nuevaBusqueda);
        $entityManager->flush();

        return $this->json(['message' => 'Búsqueda guardada con éxito'], Response::HTTP_CREATED);
    }

    //Listar busquedas por id_usuario
    #[Route('/listar', name: "listar_busqueda", methods: ["POST"])]
    public function HistorialBusquedaPorUsuario(EntityManagerInterface $entityManager, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $historial = $entityManager->getRepository(HistorialBusqueda::class)->getHistorialPorId(["id"=>$data["id"]]);

        return $this->json($historial, Response::HTTP_OK);
    }

}
