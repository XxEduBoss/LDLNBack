<?php

namespace App\Entity;

use App\Repository\EtiquetasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtiquetasRepository::class)]
class Etiquetas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1000)]
    private ?string $descripcion = null;

    #[ORM\ManyToMany(targetEntity: Canal::class, mappedBy: 'id_etiqueta')]
    private Collection $canales;

    public function __construct()
    {
        $this->canales = new ArrayCollection();
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
     * @return Collection<int, Canal>
     */
    public function getCanales(): Collection
    {
        return $this->canales;
    }

    public function addCanale(Canal $canale): static
    {
        if (!$this->canales->contains($canale)) {
            $this->canales->add($canale);
            $canale->addIdEtiquetum($this);
        }

        return $this;
    }

    public function removeCanale(Canal $canale): static
    {
        if ($this->canales->removeElement($canale)) {
            $canale->removeIdEtiquetum($this);
        }

        return $this;
    }
}
