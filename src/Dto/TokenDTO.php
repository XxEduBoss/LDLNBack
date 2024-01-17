<?php

namespace App\Dto;

use App\Entity\Usuario;

class TokenDTO
{

    private ?int $id = null;
    private ?string $apikey = null;
    private ?\DateTimeInterface $fecha_expedicion = null;
    private ?\DateTimeInterface $fecha_creacion = null;
    private ?Usuario $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getApikey(): ?string
    {
        return $this->apikey;
    }

    public function setApikey(?string $apikey): void
    {
        $this->apikey = $apikey;
    }

    public function getFechaExpedicion(): ?\DateTimeInterface
    {
        return $this->fecha_expedicion;
    }

    public function setFechaExpedicion(?\DateTimeInterface $fecha_expedicion): void
    {
        $this->fecha_expedicion = $fecha_expedicion;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(?\DateTimeInterface $fecha_creacion): void
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): void
    {
        $this->usuario = $usuario;
    }

}