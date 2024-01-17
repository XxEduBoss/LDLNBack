<?php

namespace App\Dto;

use App\Entity\Usuario;

class VisitaDTO
{
    private ?int $id = null;
    private ?\DateTimeInterface $fecha_visita = null;
    private ?Video $video = null;
    private ?Usuario $usuario = null;
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
     * @return \DateTimeInterface|null
     */
    public function getFechaVisita(): ?\DateTimeInterface
    {
        return $this->fecha_visita;
    }

    /**
     * @param \DateTimeInterface|null $fecha_visita
     */
    public function setFechaVisita(?\DateTimeInterface $fecha_visita): void
    {
        $this->fecha_visita = $fecha_visita;
    }

    /**
     * @return Video|null
     */
    public function getVideo(): ?Video
    {
        return $this->video;
    }

    /**
     * @param Video|null $video
     */
    public function setVideo(?Video $video): void
    {
        $this->video = $video;
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
        $this->Activo = $activo;
    }


}