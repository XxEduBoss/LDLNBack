<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
#[ORM\Table(name: 'video',schema: 'apollo')]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'titulo', length: 100)]
    private ?string $titulo = null;

    #[ORM\Column(name:'descripcion', length: 500, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(name:'url', length: 10000)]
    private ?string $url = null;

    #[ORM\Column(name:'etiquetas')]
    private ?int $etiquetas = null;

    #[ORM\Column(name:'fecha_publicacion', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_publicacion = null;

    #[ORM\Column(name:'fecha_creacion', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_creacion = null;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    #[ORM\JoinColumn(name:'id_canal', nullable: false)]
    private ?Canal $id_canal = null;

    #[ORM\OneToMany(mappedBy: 'id_video', targetEntity: Visita::class, orphanRemoval: true)]
    private Collection $visitas;

    #[ORM\OneToMany(mappedBy: 'id_video', targetEntity: Comentario::class, orphanRemoval: true)]
    private Collection $comentarios;

    #[ORM\OneToMany(mappedBy: 'id_video', targetEntity: ValoracionPositiva::class, orphanRemoval: true)]
    private Collection $valoracionesPositivas;

    #[ORM\OneToMany(mappedBy: 'id_video', targetEntity: ValoracionNegativa::class, orphanRemoval: true)]
    private Collection $valoracionesNegativas;

    public function __construct()
    {
        $this->visitas = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
        $this->valoracionesPositivas = new ArrayCollection();
        $this->valoracionesNegativas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getEtiquetas(): ?int
    {
        return $this->etiquetas;
    }

    public function setEtiquetas(int $etiquetas): static
    {
        $this->etiquetas = $etiquetas;

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(\DateTimeInterface $fecha_publicacion): static
    {
        $this->fecha_publicacion = $fecha_publicacion;

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

    public function getIdCanal(): ?Canal
    {
        return $this->id_canal;
    }

    public function setIdCanal(?Canal $id_canal): static
    {
        $this->id_canal = $id_canal;

        return $this;
    }

    /**
     * @return Collection<int, Visita>
     */
    public function getVisitas(): Collection
    {
        return $this->visitas;
    }

    public function addVisita(Visita $visita): static
    {
        if (!$this->visitas->contains($visita)) {
            $this->visitas->add($visita);
            $visita->setIdVideo($this);
        }

        return $this;
    }

    public function removeVisita(Visita $visita): static
    {
        if ($this->visitas->removeElement($visita)) {
            // set the owning side to null (unless already changed)
            if ($visita->getIdVideo() === $this) {
                $visita->setIdVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comentario>
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentario $comentario): static
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios->add($comentario);
            $comentario->setIdVideo($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): static
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getIdVideo() === $this) {
                $comentario->setIdVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ValoracionPositiva>
     */
    public function getValoracionesPositivas(): Collection
    {
        return $this->valoracionesPositivas;
    }

    public function addValoracionesPositiva(ValoracionPositiva $valoracionesPositiva): static
    {
        if (!$this->valoracionesPositivas->contains($valoracionesPositiva)) {
            $this->valoracionesPositivas->add($valoracionesPositiva);
            $valoracionesPositiva->setIdVideo($this);
        }

        return $this;
    }

    public function removeValoracionesPositiva(ValoracionPositiva $valoracionesPositiva): static
    {
        if ($this->valoracionesPositivas->removeElement($valoracionesPositiva)) {
            // set the owning side to null (unless already changed)
            if ($valoracionesPositiva->getIdVideo() === $this) {
                $valoracionesPositiva->setIdVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ValoracionNegativa>
     */
    public function getValoracionesNegativas(): Collection
    {
        return $this->valoracionesNegativas;
    }

    public function addValoracionesNegativa(ValoracionNegativa $valoracionesNegativa): static
    {
        if (!$this->valoracionesNegativas->contains($valoracionesNegativa)) {
            $this->valoracionesNegativas->add($valoracionesNegativa);
            $valoracionesNegativa->setIdVideo($this);
        }

        return $this;
    }

    public function removeValoracionesNegativa(ValoracionNegativa $valoracionesNegativa): static
    {
        if ($this->valoracionesNegativas->removeElement($valoracionesNegativa)) {
            // set the owning side to null (unless already changed)
            if ($valoracionesNegativa->getIdVideo() === $this) {
                $valoracionesNegativa->setIdVideo(null);
            }
        }

        return $this;
    }
}
