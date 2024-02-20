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

    private ?string $banner = null;
    private ?\DateTimeInterface $fecha_nacimiento = null;
    private ?\DateTimeInterface $fecha_creacion = null;
    private ?UsuarioDTO $usuario = null;
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
     * @return UsuarioDTO|null
     */
    public function getUsuario(): ?UsuarioDTO
    {
        return $this->usuario;
    }

    /**
     * @param UsuarioDTO|null $usuario
     */
    public function setUsuario(?UsuarioDTO $usuario): void
    {
        $this->usuario = $usuario;
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


    public function getBanner(): ?string
    {
        return $this->banner;
    }

    /**
     * @param string|null $banner
     */
    public function setBanner(?string $banner): void
    {
        $this->banner = $banner;
    }










}