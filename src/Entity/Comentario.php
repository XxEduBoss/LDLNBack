<?php

namespace App\Entity;

use App\Repository\ComentarioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComentarioRepository::class)]
#[ORM\Table(name: 'comentario',schema: 'apollo')]
class Comentario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'texto', length: 10000)]
    private ?string $texto = null;

    #[ORM\Column(name:'fecha_publicacion', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_publicacion = null;

    #[ORM\ManyToOne(inversedBy: 'comentarios')]
    #[ORM\JoinColumn(name:'id_video', nullable: false)]
    private ?Video $id_video = null;

    #[ORM\ManyToOne(inversedBy: 'comentarios')]
    #[ORM\JoinColumn(name:'id_usuario', nullable: false)]
    private ?Usuario $id_usuario = null;

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

    public function getFechaPublicacion(): ?string
    {
        return $this->fecha_publicacion->format('d/m/Y H:i:s');
    }

    public function setFechaPublicacion(String $fecha_publicacion): static
    {
        $this->fecha_publicacion = \DateTime::createFromFormat('d/m/Y H:i:s', $fecha_publicacion);

        return $this;
    }

    public function getIdVideo(): ?Video
    {
        return $this->id_video;
    }

    public function setIdVideo(?Video $id_video): static
    {
        $this->id_video = $id_video;

        return $this;
    }

    public function getIdUsuario(): ?Usuario
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?Usuario $id_usuario): static
    {
        $this->id_usuario = $id_usuario;

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
