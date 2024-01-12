<?php

namespace App\Entity;

use App\Repository\SuscripcionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuscripcionRepository::class)]
class Suscripcion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_suscripcion = null;

    #[ORM\ManyToOne(inversedBy: 'suscripciones')]
    #[ORM\JoinColumn(name:'id_canal', nullable: false)]
    private ?Canal $id_canal = null;

    #[ORM\ManyToOne(inversedBy: 'suscripciones')]
    #[ORM\JoinColumn(name:'id_usuario', nullable: false)]
    private ?Usuario $id_usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaSuscripcion(): ?\DateTimeInterface
    {
        return $this->fecha_suscripcion;
    }

    public function setFechaSuscripcion(\DateTimeInterface $fecha_suscripcion): static
    {
        $this->fecha_suscripcion = $fecha_suscripcion;

        return $this;
    }

    public function getIdCanal(): ?Canal
    {
        return $this->id_canal;
    }

    public function setIdCanal(?Canal $id_canal): static
    {
        $this->id_canal = $id_canal;

        return $this;
    }

    public function getIdUsuario(): ?Usuario
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?Usuario $id_usuario): static
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }
}
