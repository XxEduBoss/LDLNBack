<?php

namespace App\Entity;

use App\Repository\CanalRepository;
use App\Repository\EtiquetasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CanalRepository::class)]
#[ORM\Table(name: 'canal',schema: 'apollo')]
class Canal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $apellidos = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nombre_canal = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_nacimiento = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_creacion = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(name:"id_usuario", nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\OneToMany(mappedBy: 'canal', targetEntity: Video::class)]
    private Collection $videos;

    #[ORM\OneToMany(mappedBy: 'canal', targetEntity: Suscripcion::class)]
    private Collection $suscripciones;

    #[ORM\Column]
    private ?bool $activo = null;

    #[ORM\ManyToMany(targetEntity: Etiquetas::class)]
    #[ORM\JoinTable(name: "etiquetas_canal", schema: "apollo")]
    #[ORM\JoinColumn(name: "id_canal", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "id_etiqueta", referencedColumnName: "id")]
    private Collection $etiquetas;

    #[ORM\Column(length: 10000)]
    private ?string $banner = null;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->etiquetas = new ArrayCollection();
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

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fecha_nacimiento): static
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): static
    {
        $this->fecha_creacion = $fecha_creacion;

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
     * @return Collection<int, Etiquetas>
     */
    public function getEtiqueta(): Collection
    {
        return $this->etiquetas;
    }

    public function addEtiqueta(Etiquetas $etiqueta): static
    {
        if (!$this->etiquetas->contains($etiqueta)) {
            $this->etiquetas->add($etiqueta);
        }

        return $this;
    }

    public function removeEtiqueta(Etiquetas $etiqueta): static
    {
        $this->etiquetas->removeElement($etiqueta);

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

    public function getSuscripciones(): Collection
    {
        return $this->suscripciones;
    }

    public function addSuscripcion(Video $suscripcion): static
    {
        if (!$this->suscripciones->contains($suscripcion)) {
            $this->suscripciones->add($suscripcion);
            $suscripcion->setCanal($this);
        }

        return $this;
    }

    public function removeSuscripcion(Video $suscripcion): static
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

    public function getBanner(): ?string
    {
        return $this->banner;
    }

    public function setBanner(string $banner): static
    {
        $this->banner = $banner;

        return $this;
    }
}
