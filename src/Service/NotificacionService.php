<?php

namespace App\Service;

use App\Entity\Canal;
use App\Entity\Notificacion;
use App\Entity\TipoNotificacion;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;

class NotificacionService
{

    public function crearNotificacionVideo(EntityManagerInterface $entityManager, Canal $canal, int $id_usuario)
    {

        $nuevaNotificacion = new Notificacion();

        $nombre_canal = $canal->getNombreCanal();

        $nuevaNotificacion -> setTexto("$nombre_canal ha subido un nuevo video");
        $nuevaNotificacion -> setTipoNotificacion($entityManager->getRepository(TipoNotificacion::class)->findOneBy(["id"=>1]));
        $nuevaNotificacion ->setFechaNotificacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>[$id_usuario]]);
        $nuevaNotificacion->setUsuario($usuario[0]);

        $nuevaNotificacion->setActivo(true);

        $entityManager->persist($nuevaNotificacion);
        $entityManager->flush();

    }

}