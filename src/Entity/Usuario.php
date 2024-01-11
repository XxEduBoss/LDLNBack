<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'username', length: 50)]
    private ?string $username = null;

    #[ORM\Column(name: 'password', length: 1000)]
    private ?string $password = null;

    #[ORM\Column(name: 'rol_usuario')]
    private ?int $rol_usuario = null;

    #[ORM\Column(name: 'activo')]
    private ?bool $activo = true;

    #[ORM\OneToOne(mappedBy: 'id_usuario', cascade: ['persist', 'remove'])]
    private ?Canal $canal = null;

    #[ORM\ManyToMany(targetEntity: Suscripcion::class, mappedBy: 'id_usuario')]
    private Collection $suscripciones;

    public function __construct()
    {
        $this->suscripciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRolUsuario(): ?int
    {
        return $this->rol_usuario;
    }

    public function setRolUsuario(int $rol_usuario): static
    {
        $this->rol_usuario = $rol_usuario;

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

    public function getCanal(): ?Canal
    {
        return $this->canal;
    }

    public function setCanal(Canal $canal): static
    {
        // set the owning side of the relation if necessary
        if ($canal->getIdUsuario() !== $this) {
            $canal->setIdUsuario($this);
        }

        $this->canal = $canal;

        return $this;
    }

    /**
     * @return Collection<int, Suscripcion>
     */
    public function getSuscripciones(): Collection
    {
        return $this->suscripciones;
    }

    public function addSuscripcion(Suscripcion $suscripcion): static
    {
        if (!$this->suscripciones->contains($suscripcion)) {
            $this->suscripciones->add($suscripcion);
            $suscripcion->addIdUsuario($this);
        }

        return $this;
    }

    public function removeSuscripcion(Suscripcion $suscripcion): static
    {
        if ($this->suscripciones->removeElement($suscripcion)) {
            $suscripcion->removeIdUsuario($this);
        }

        return $this;
    }

}
