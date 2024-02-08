<?php

namespace App\Entity;

use App\Repository\SuscripcionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuscripcionRepository::class)]
#[ORM\Table(name: 'suscripcion',schema: 'apollo')]
class Suscripcion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_suscripcion = null;

    #[ORM\ManyToOne(targetEntity: Canal::class,inversedBy: "suscripciones")]
    #[ORM\JoinColumn(name:'id_canal', nullable: false)]
    private ?Canal $canal = null;

    #[ORM\ManyToOne(inversedBy: 'suscripciones')]
    #[ORM\JoinColumn(name:'id_usuario', nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\Column]
    private ?bool $activo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaSuscripcion(): ?string
    {
        return $this->fecha_suscripcion->format('d/m/Y H:i:s');
    }

    public function setFechaSuscripcion(\DateTimeInterface $fecha_suscripcion): static
    {
        $this->fecha_suscripcion = $fecha_suscripcion;

        return $this;
    }

    public function getCanal(): ?Canal
    {
        return $this->canal;
    }

    public function setCanal(?Canal $canal): static
    {
        $this->canal = $canal;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): static
    {
        $this->activo = $activo;

        return $this;
    }
}
