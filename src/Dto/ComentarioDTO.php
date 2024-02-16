<?php

namespace App\Dto;

use App\Entity\Usuario;
use App\Entity\Video;

class ComentarioDTO
{

    private ?int $id = null;
    private ?string $texto = null;
    private ?string $fecha_publicacion = null;
    private ?VideoDTO $video = null;
    private ?UsuarioDTO $usuario = null;
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

    public function getFechaPublicacion(): ?string
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(?string $fecha_publicacion): void
    {
        $this->fecha_publicacion = $fecha_publicacion;
    }

    public function getVideo(): ?VideoDTO
    {
        return $this->video;
    }

    public function setVideo(?VideoDTO $video): void
    {
        $this->video = $video;
    }

    public function getUsuario(): ?UsuarioDTO
    {
        return $this->usuario;
    }

    public function setUsuario(?UsuarioDTO $usuario): void
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