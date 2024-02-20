<?php

namespace App\Dto;

use App\Entity\TipoNotificacion;
use App\Entity\Usuario;
use DateTimeInterface;

class NotificacionDTO
{
    private ?int $id = null;

    private ?string $texto = null;

    private TipoNotificacion $tipoNotificacion;

    private ?DateTimeInterface $fecha_notificacion = null;

    private ?Usuario $usuario = null;

    private ?bool $activo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(?string $texto): void
    {
        $this->texto = $texto;
    }

    public function getTipoNotificacion(): TipoNotificacion
    {
        return $this->tipo;
    }

    public function setTipoNotificacion(TipoNotificacion $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getFechaNotificacion(): ?DateTimeInterface
    {
        return $this->fecha_notificacion;
    }

    public function setFechaNotificacion(?DateTimeInterface $fecha_notificacion): void
    {
        $this->fecha_notificacion = $fecha_notificacion;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): void
    {
        $this->usuario = $usuario;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(?bool $activo): void
    {
        $this->activo = $activo;
    }

}