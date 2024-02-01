<?php

namespace App\Dto;

use App\Entity\Canal;
use App\Entity\TipoVideo;
use phpDocumentor\Reflection\Types\Boolean;

class VideoDTO
{

    private ?int $id = null;
    private ?string $titulo = null;
    private ?string $descripcion = null;
    private ?string $url = null;
    private ?TipoVideo $tipo_video = null;
    private ?string $fecha_publicacion = null;
    private ?string $fecha_creacion = null;
    private ?CanalDTO $canal = null;
    private ?string $miniatura = null;
    private ?array $etiquetas = [];

    private ?bool $activo = null;

    public function getMiniatura(): ?string
    {
        return $this->miniatura;
    }

    public function setMiniatura(?string $miniatura): void
    {
        $this->miniatura = $miniatura;
    }

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

    public function getTipoVideo(): ?TipoVideo
    {
        return $this->tipo_video;
    }

    public function setTipoVideo(?TipoVideo $tipo_video): void
    {
        $this->tipo_video = $tipo_video;
    }

    public function getFechaPublicacion(): ?string
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(?string $fecha_publicacion): void
    {
        $this->fecha_publicacion = $fecha_publicacion;
    }

    public function getFechaCreacion(): ?string
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(?string $fecha_creacion): void
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getCanal(): ?CanalDTO
    {
        return $this->canal;
    }

    public function setCanal(?CanalDTO $canal): void
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

    public function getEtiquetas(): ?array
    {
        return $this->etiquetas;
    }

    public function setEtiquetas(?array $etiquetas): void
    {
        $this->etiquetas = $etiquetas;
    }


}