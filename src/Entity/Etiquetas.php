<?php

namespace App\Entity;

use App\Repository\EtiquetasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtiquetasRepository::class)]
#[ORM\Table(name: 'etiquetas',schema: 'apollo')]
class Etiquetas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1000)]
    private ?string $descripcion = null;

    #[ORM\ManyToMany(targetEntity: Canal::class)]
    #[ORM\JoinTable(name: "etiquetas_canal", schema: "apollo")]
    #[ORM\JoinColumn(name: "id_etiqueta", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "id_canal", referencedColumnName: "id")]
    private Collection $canales;

    #[ORM\ManyToMany(targetEntity: Video::class)]
    #[ORM\JoinTable(name: "etiquetas_video", schema: "apollo")]
    #[ORM\JoinColumn(name: "id_etiqueta", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "id_video", referencedColumnName: "id")]
    private Collection $videos;

    public function __construct()
    {
        $this->canales = new ArrayCollection();
        $this->videos = new ArrayCollection();
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

    public function addCanal(Canal $canal): static
    {
        if (!$this->canales->contains($canal)) {
            $this->canales->add($canal);
            $canal->addEtiqueta($this);
        }

        return $this;
    }

    public function removeCanal(Canal $canal): static
    {
        if ($this->canales->removeElement($canal)) {
            $canal->removeEtiqueta($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): static
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->addEtiqueta($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): static
    {
        if ($this->videos->removeElement($video)) {
            $video->removeEtiqueta($this);
        }

        return $this;
    }

}
