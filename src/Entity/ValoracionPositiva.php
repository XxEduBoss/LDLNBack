<?php

namespace App\Entity;

use App\Repository\ValoracionPositivaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValoracionPositivaRepository::class)]
#[ORM\Table(name: 'valoracion_positiva',schema: 'apollo')]
class ValoracionPositiva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $likes = null;

    #[ORM\ManyToOne(inversedBy: 'valoracionesPositivas')]
    #[ORM\JoinColumn(name:'id_video', nullable: false)]
    private ?Video $video = null;

    #[ORM\ManyToOne(inversedBy: 'valoracionesPositivas')]
    #[ORM\JoinColumn(name:'id_usuario', nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\Column]
    private ?bool $activo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLikes(): ?bool
    {
        return $this->likes;
    }

    public function setLikes(?bool $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): static
    {
        $this->video = $video;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->Activo;
    }

    public function setActivo(bool $activo): static
    {
        $this->Activo = $activo;

        return $this;
    }
}
