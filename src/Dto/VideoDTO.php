<?php

namespace App\Dto;

use App\Entity\Canal;
use phpDocumentor\Reflection\Types\Boolean;

class VideoDTO
{

    private ?int $id = null;
    private ?string $titulo = null;
    private ?string $descripcion = null;
    private ?string $url = null;
    private ?int $etiquetas = null;
    private ?\DateTimeInterface $fecha_publicacion = null;
    private ?\DateTimeInterface $fecha_creacion = null;
    private ?Canal $canal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(?string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getEtiquetas(): ?int
    {
        return $this->etiquetas;
    }

    public function setEtiquetas(?int $etiquetas): void
    {
        $this->etiquetas = $etiquetas;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(?\DateTimeInterface $fecha_publicacion): void
    {
        $this->fecha_publicacion = $fecha_publicacion;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(?\DateTimeInterface $fecha_creacion): void
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getCanal(): ?Canal
    {
        return $this->canal;
    }

    public function setCanal(?Canal $canal): void
    {
        $this->canal = $canal;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(?bool $activo): void
    {
        $this->activo = $activo;
    }
    private ?bool $activo = null;

}