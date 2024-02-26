<?php

namespace App\Service;

use App\Entity\Canal;
use App\Entity\Notificacion;
use App\Entity\TipoNotificacion;
use App\Entity\Usuario;
use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;

class NotificacionService
{

    public function crearNotificacionVideo(EntityManagerInterface $entityManager, Canal $canal, int $id_usuario)
    {

        $nuevaNotificacion = new Notificacion();

        $nombre_canal = $canal->getNombreCanal();

        $nuevaNotificacion -> setTexto("$nombre_canal ha subido un nuevo video.");
        $nuevaNotificacion -> setTipoNotificacion($entityManager->getRepository(TipoNotificacion::class)->findOneBy(["id"=>1]));
        $nuevaNotificacion ->setFechaNotificacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>[$id_usuario]]);
        $nuevaNotificacion->setUsuario($usuario[0]);

        $nuevaNotificacion->setActivo(true);

        $entityManager->persist($nuevaNotificacion);
        $entityManager->flush();

    }

    public function crearNotificacionComentario(EntityManagerInterface $entityManager, Canal $canal, Usuario $usuario)
    {

        $nuevaNotificacion = new Notificacion();

        $nombre_usuario = $usuario->getUsername();

        $nuevaNotificacion -> setTexto("$nombre_usuario te ha comentado.");
        $nuevaNotificacion -> setTipoNotificacion($entityManager->getRepository(TipoNotificacion::class)->findOneBy(["id"=>4]));
        $nuevaNotificacion ->setFechaNotificacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $usuarioCanal = $entityManager->getRepository(Usuario::class)->getUsuarioPorCanal(["id_canal"=>$canal->getId()]);

        $usuarioNuevo = $entityManager->getRepository(Usuario::class)->findOneBy(["id"=>$usuarioCanal['0']['id']]);

        $nuevaNotificacion->setUsuario($usuarioNuevo);

        $nuevaNotificacion->setActivo(true);

        $entityManager->persist($nuevaNotificacion);
        $entityManager->flush();

    }

    public function crearNotificacionMensaje(EntityManagerInterface $entityManager, Canal $emisor, Usuario $receptor)
    {

        $nuevaNotificacion = new Notificacion();

        $nombre_canal = $emisor->getNombreCanal();

        $nuevaNotificacion -> setTexto("$nombre_canal te ha enviado un nuevo mensaje.");
        $nuevaNotificacion -> setTipoNotificacion($entityManager->getRepository(TipoNotificacion::class)->findOneBy(["id"=>3]));
        $nuevaNotificacion ->setFechaNotificacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $nuevaNotificacion->setUsuario($receptor);

        $nuevaNotificacion->setActivo(true);

        $entityManager->persist($nuevaNotificacion);
        $entityManager->flush();

    }

    public function crearNotificacionSuscripcion(EntityManagerInterface $entityManager, Usuario $usuarioCanal, Usuario $usuario)
    {

        $nuevaNotificacion = new Notificacion();

        $nombre_usuario = $usuario->getUsername();

        $nuevaNotificacion -> setTexto("$nombre_usuario se ha suscrito a tu canal.");
        $nuevaNotificacion -> setTipoNotificacion($entityManager->getRepository(TipoNotificacion::class)->findOneBy(["id"=>2]));
        $nuevaNotificacion ->setFechaNotificacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $nuevaNotificacion->setUsuario($usuarioCanal);

        $nuevaNotificacion->setActivo(true);

        $entityManager->persist($nuevaNotificacion);
        $entityManager->flush();

    }

    public function crearNotificacionLike(EntityManagerInterface $entityManager, Video $video, Usuario $usuario)
    {

        $id_canal = $video->getCanal()->getId();

        $canal = $entityManager->getRepository(Canal::class)
            ->findOneBy(["id" => $id_canal]);

        $nuevaNotificacion = new Notificacion();

        $nombre_usuario = $usuario->getUsername();
        $nombre_video = $video->getTitulo();

        $nuevaNotificacion -> setTexto("$nombre_usuario le ha dado like a tu video $nombre_video.");
        $nuevaNotificacion -> setTipoNotificacion($entityManager->getRepository(TipoNotificacion::class)->findOneBy(["id"=>2]));
        $nuevaNotificacion ->setFechaNotificacion(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));

        $usuarioCanal = $entityManager->getRepository(Usuario::class)->getUsuarioPorCanal(["id_canal"=>$canal->getId()]);

        $usuarioNuevo = $entityManager->getRepository(Usuario::class)->findOneBy(["id"=>$usuarioCanal['0']['id']]);

        $nuevaNotificacion->setUsuario($usuarioNuevo);

        $nuevaNotificacion->setActivo(true);

        $entityManager->persist($nuevaNotificacion);
        $entityManager->flush();

    }

}