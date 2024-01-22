<?php

namespace App\Entity;

use App\Repository\TipoNotificacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipoNotificacionRepository::class)]
class TipoNotificacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1000)]
    private ?string $descripcion = null;

    #[ORM\OneToMany(mappedBy: 'tipo_notificacion', targetEntity: Notificacion::class, orphanRemoval: true)]
    private Collection $notificaciones;

    public function __construct()
    {
        $this->notificaciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, Notificacion>
     */
    public function getNotificaciones(): Collection
    {
        return $this->notificaciones;
    }

    public function addNotificacione(Notificacion $notificacione): static
    {
        if (!$this->notificaciones->contains($notificacione)) {
            $this->notificaciones->add($notificacione);
            $notificacione->setTipoNotificacion($this);
        }

        return $this;
    }

    public function removeNotificacione(Notificacion $notificacione): static
    {
        if ($this->notificaciones->removeElement($notificacione)) {
            // set the owning side to null (unless already changed)
            if ($notificacione->getTipoNotificacion() === $this) {
                $notificacione->setTipoNotificacion(null);
            }
        }

        return $this;
    }
}
