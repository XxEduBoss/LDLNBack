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

    #[ORM\ManyToOne(inversedBy: 'videos')]
    #[ORM\JoinColumn(name:'id_tipo_video', nullable: false)]
    private ?TipoVideo $tipo_video = null;

    #[ORM\Column(name:'fecha_publicacion', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_publicacion = null;

    #[ORM\Column(name:'fecha_creacion', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_creacion = null;

    #[ORM\ManyToMany(targetEntity: Etiquetas::class)]
    #[ORM\JoinTable(name: "etiquetas_video", schema: "apollo")]
    #[ORM\JoinColumn(name: "id_video", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "id_etiqueta", referencedColumnName: "id")]
    private Collection $etiquetas;

    #[ORM\Column(name: 'activo')]
    private ?bool $Activo = null;

    #[ORM\ManyToOne(targetEntity: Canal::class,inversedBy: "videos")]
    #[ORM\JoinColumn(name:'id_canal', nullable: false)]
    private ?Canal $canal = null;

    #[ORM\OneToMany(mappedBy: 'id_video', targetEntity: Visita::class, orphanRemoval: true)]
    private Collection $visitas;

    #[ORM\OneToMany(mappedBy: 'id_video', targetEntity: Comentario::class, orphanRemoval: true)]
    private Collection $comentarios;

    #[ORM\OneToMany(mappedBy: 'id_video', targetEntity: ValoracionPositiva::class, orphanRemoval: true)]
    private Collection $valoracionesPositivas;

    #[ORM\OneToMany(mappedBy: 'id_video', targetEntity: ValoracionNegativa::class, orphanRemoval: true)]
    private Collection $valoracionesNegativas;

    #[ORM\Column(length: 10000)]
    private ?string $miniatura = null;

    public function __construct()
    {
        $this->etiquetas = new ArrayCollection();
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

    public function getFechaPublicacion(): ?string
    {
        return $this->fecha_publicacion->format('d/m/Y H:i:s');
    }

    public function setFechaPublicacion(\DateTimeInterface $fecha_publicacion): static
    {
        $this->fecha_publicacion = $fecha_publicacion;

        return $this;
    }

    public function getFechaCreacion(): ?string
    {
        return $this->fecha_creacion->format('d/m/Y H:i:s');
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): static
    {
        $this->fecha_creacion = $fecha_creacion;

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
            $visita->setVideo($this);
        }

        return $this;
    }

    public function removeVisita(Visita $visita): static
    {
        if ($this->visitas->removeElement($visita)) {
            // set the owning side to null (unless already changed)
            if ($visita->getVideo() === $this) {
                $visita->setVideo(null);
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
            $comentario->setVideo($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): static
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getVideo() === $this) {
                $comentario->setVideo(null);
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

    public function addValoracionPositiva(ValoracionPositiva $valoracionPositiva): static
    {
        if (!$this->valoracionesPositivas->contains($valoracionPositiva)) {
            $this->valoracionesPositivas->add($valoracionPositiva);
            $valoracionPositiva->setVideo($this);
        }

        return $this;
    }

    public function removeValoracionPositiva(ValoracionPositiva $valoracionPositiva): static
    {
        if ($this->valoracionesPositivas->removeElement($valoracionPositiva)) {
            // set the owning side to null (unless already changed)
            if ($valoracionPositiva->getVideo() === $this) {
                $valoracionPositiva->setVideo(null);
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

    public function addValoracionesNegativa(ValoracionNegativa $valoracionNegativa): static
    {
        if (!$this->valoracionesNegativas->contains($valoracionNegativa)) {
            $this->valoracionesNegativas->add($valoracionNegativa);
            $valoracionNegativa->setVideo($this);
        }

        return $this;
    }

    public function removeValoracionesNegativa(ValoracionNegativa $valoracionNegativa): static
    {
        if ($this->valoracionesNegativas->removeElement($valoracionNegativa)) {
            // set the owning side to null (unless already changed)
            if ($valoracionNegativa->getVideo() === $this) {
                $valoracionNegativa->setVideo(null);
            }
        }

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->Activo;
    }

    public function setActivo(bool $Activo): static
    {
        $this->Activo = $Activo;

        return $this;
    }

    public function getTipoVideo(): ?TipoVideo
    {
        return $this->tipo_video;
    }

    public function setTipoVideo(?TipoVideo $tipo_video): static
    {
        $this->tipo_video = $tipo_video;

        return $this;
    }

    public function getMiniatura(): ?string
    {
        return $this->miniatura;
    }

    public function setMiniatura(string $miniatura): static
    {
        $this->miniatura = $miniatura;

        return $this;
    }

}
