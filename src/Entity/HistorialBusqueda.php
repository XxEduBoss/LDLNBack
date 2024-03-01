<?php

namespace App\Entity;

use App\Repository\HistorialBusquedaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistorialBusquedaRepository::class)]
#[ORM\Table(name: 'historial_busqueda',schema: 'apollo')]
class HistorialBusqueda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100000)]
    private ?string $texto = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_busqueda = null;

    #[ORM\ManyToOne(inversedBy: '$historialBusqueda')]
    #[ORM\JoinColumn(name:"id_usuario",nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\Column]
    private ?bool $activo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): static
    {
        $this->texto = $texto;

        return $this;
    }

    public function getFechaBusqueda(): ?\DateTimeInterface
    {
        return $this->fecha_busqueda;
    }

    public function setFechaBusqueda(\DateTimeInterface $fecha_busqueda): static
    {
        $this->fecha_busqueda = $fecha_busqueda;

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
