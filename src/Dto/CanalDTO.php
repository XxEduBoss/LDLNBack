<?php

namespace App\Dto;

use App\Entity\Usuario;
use Doctrine\Common\Collections\Collection;

class CanalDTO
{
    private ?int $id = null;
    private ?string $nombre = null;
    private ?string $apellidos = null;
    private ?string $nombre_canal = null;
    private ?string $telefono = null;
    private ?\DateTimeInterface $fecha_nacimiento = null;
    private ?\DateTimeInterface $fecha_creacion = null;
    private ?int $etiquetas = null;
    private ?Usuario $usuario = null;
    private Collection $videos;
    private Collection $suscripciones;
    private ?bool $activo = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * @param string|null $nombre
     */
    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string|null
     */
    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    /**
     * @param string|null $apellidos
     */
    public function setApellidos(?string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return string|null
     */
    public function getNombreCanal(): ?string
    {
        return $this->nombre_canal;
    }

    /**
     * @param string|null $nombre_canal
     */
    public function setNombreCanal(?string $nombre_canal): void
    {
        $this->nombre_canal = $nombre_canal;
    }

    /**
     * @return string|null
     */
    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    /**
     * @param string|null $telefono
     */
    public function setTelefono(?string $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fecha_nacimiento;
    }

    /**
     * @param \DateTimeInterface|null $fecha_nacimiento
     */
    public function setFechaNacimiento(?\DateTimeInterface $fecha_nacimiento): void
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    /**
     * @param \DateTimeInterface|null $fecha_creacion
     */
    public function setFechaCreacion(?\DateTimeInterface $fecha_creacion): void
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    /**
     * @return int|null
     */
    public function getEtiquetas(): ?int
    {
        return $this->etiquetas;
    }

    /**
     * @param int|null $etiquetas
     */
    public function setEtiquetas(?int $etiquetas): void
    {
        $this->etiquetas = $etiquetas;
    }

    /**
     * @return Usuario|null
     */
    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    /**
     * @param Usuario|null $usuario
     */
    public function setUsuario(?Usuario $usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return Collection
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    /**
     * @param Collection $videos
     */
    public function setVideos(Collection $videos): void
    {
        $this->videos = $videos;
    }

    /**
     * @return Collection
     */
    public function getSuscripciones(): Collection
    {
        return $this->suscripciones;
    }

    /**
     * @param Collection $suscripciones
     */
    public function setSuscripciones(Collection $suscripciones): void
    {
        $this->suscripciones = $suscripciones;
    }

    /**
     * @return bool|null
     */
    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    /**
     * @param bool|null $activo
     */
    public function setActivo(?bool $activo): void
    {
        $this->activo = $activo;
    }












}