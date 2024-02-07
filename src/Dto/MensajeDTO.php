<?php

namespace App\Dto;

use App\Entity\Usuario;

class MensajeDTO
{

    private ?int $id = null;
    private ?string $texto = null;

    private ?bool $leido = null;
    private ?\DateTimeInterface $fecha_envio = null;
    private ?Usuario $usuario_emisor = null;
    private ?Usuario $usuario_receptor = null;
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

    public function getLeido(): ?bool
    {
        return $this->leido;
    }

    public function setLeido(bool $leido): void
    {
        $this->leido = $leido;

    }

    public function getFechaEnvio(): ?\DateTimeInterface
    {
        return $this->fecha_envio;
    }

    public function setFechaEnvio(?\DateTimeInterface $fecha_envio): void
    {
        $this->fecha_envio = $fecha_envio;
    }

    public function getUsuarioEmisor(): ?Usuario
    {
        return $this->usuario_emisor;
    }

    public function setUsuarioEmisor(?Usuario $usuario_emisor): void
    {
        $this->usuario_emisor = $usuario_emisor;
    }

    public function getUsuarioReceptor(): ?Usuario
    {
        return $this->usuario_receptor;
    }

    public function setUsuarioReceptor(?Usuario $usuario_receptor): void
    {
        $this->usuario_receptor = $usuario_receptor;
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