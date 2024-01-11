<?php

namespace App\Entity;

use App\Repository\SuscripcionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToMany(targetEntity: Canal::class, inversedBy: 'suscripciones')]
    private Collection $id_canal;

    #[ORM\ManyToMany(targetEntity: Usuario::class, inversedBy: 'suscripciones')]
    private Collection $id_usuario;

    public function __construct()
    {
        $this->id_canal = new ArrayCollection();
        $this->id_usuario = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Canal>
     */
    public function getIdCanal(): Collection
    {
        return $this->id_canal;
    }

    public function addIdCanal(Canal $idCanal): static
    {
        if (!$this->id_canal->contains($idCanal)) {
            $this->id_canal->add($idCanal);
        }

        return $this;
    }

    public function removeIdCanal(Canal $idCanal): static
    {
        $this->id_canal->removeElement($idCanal);

        return $this;
    }

    /**
     * @return Collection<int, Usuario>
     */
    public function getIdUsuario(): Collection
    {
        return $this->id_usuario;
    }

    public function addIdUsuario(Usuario $idUsuario): static
    {
        if (!$this->id_usuario->contains($idUsuario)) {
            $this->id_usuario->add($idUsuario);
        }

        return $this;
    }

    public function removeIdUsuario(Usuario $idUsuario): static
    {
        $this->id_usuario->removeElement($idUsuario);

        return $this;
    }
}
