<?php

namespace App\Entity;

use App\Repository\CanalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Scalar\String_;

#[ORM\Entity(repositoryClass: CanalRepository::class)]
#[ORM\Table(name: 'canal',schema: 'apollo')]
class Canal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'nombre', length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(name:'apellidos', length: 100, nullable: true)]
    private ?string $apellidos = null;

    #[ORM\Column(name:'nombre_canal',length: 100, nullable: true)]
    private ?string $nombre_canal = null;

    #[ORM\Column(name:'telefono', length: 10, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(name:'fecha_nacimiento', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_nacimiento = null;

    #[ORM\Column(name:'fecha_creacion', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_creacion = null;

    #[ORM\Column(name:'etiquetas', nullable: true)]
    private ?int $etiquetas = null;

    #[ORM\OneToOne(inversedBy: 'canal', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name:'usuario', nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\OneToMany(mappedBy: 'canal', targetEntity: Video::class, orphanRemoval: true)]
    private Collection $videos;

    #[ORM\OneToMany(mappedBy: 'canal', targetEntity: Suscripcion::class)]
    private Collection $suscripciones;

    #[ORM\Column]
    private ?bool $activo = null;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->suscripciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(?string $apellidos): static
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getNombreCanal(): ?string
    {
        return $this->nombre_canal;
    }

    public function setNombreCanal(?string $nombre_canal): static
    {
        $this->nombre_canal = $nombre_canal;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }


    public function getFechaNacimiento(): ?string
    {
        return $this->fecha_nacimiento->format('d/m/Y H:i:s');
    }

    public function setFechaNacimiento(String $fecha_nacimiento): static
    {
        $this->fecha_nacimiento = \DateTime::createFromFormat('d/m/Y H:i:s', $fecha_nacimiento);

        return $this;
    }

    public function getFechaCreacion(): ?string
    {
        return $this->fecha_creacion->format('d/m/Y H:i:s');
    }

    public function setFechaCreacion(String $fecha_creacion): static
    {
        $this->fecha_creacion = \DateTime::createFromFormat('d/m/Y H:i:s', $fecha_creacion);

        return $this;
    }

    public function getEtiquetas(): ?int
    {
        return $this->etiquetas;
    }

    public function setEtiquetas(?int $etiquetas): static
    {
        $this->etiquetas = $etiquetas;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario): static
    {
        $this->usuario = $usuario;

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
            $video->setCanal($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): static
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getCanal() === $this) {
                $video->setCanal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Suscripcion>
     */
    public function getSuscripciones(): Collection
    {
        return $this->suscripciones;
    }

    public function addSuscripciones(Suscripcion $suscripcion): static
    {
        if (!$this->suscripciones->contains($suscripcion)) {
            $this->suscripciones->add($suscripcion);
            $suscripcion->setCanal($this);
        }

        return $this;
    }

    public function removeSuscripciones(Suscripcion $suscripcion): static
    {
        if ($this->suscripciones->removeElement($suscripcion)) {
            // set the owning side to null (unless already changed)
            if ($suscripcion->getCanal() === $this) {
                $suscripcion->setCanal(null);
            }
        }

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