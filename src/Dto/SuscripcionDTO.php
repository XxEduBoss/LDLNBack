<?php

namespace App\Dto;

use App\Entity\Canal;
use App\Entity\Usuario;

class SuscripcionDTO
{

    private ?int $id = null;
    private ?\DateTimeInterface $fecha_suscripcion = null;
    private ?Canal $canal = null;
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

    public function getFechaSuscripcion(): ?\DateTimeInterface
    {
        return $this->fecha_suscripcion;
    }

    public function setFechaSuscripcion(?\DateTimeInterface $fecha_suscripcion): void
    {
        $this->fecha_suscripcion = $fecha_suscripcion;
    }

    public function getCanal(): ?Canal
    {
        return $this->canal;
    }

    public function setCanal(?Canal $canal): void
    {
        $this->canal = $canal;
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