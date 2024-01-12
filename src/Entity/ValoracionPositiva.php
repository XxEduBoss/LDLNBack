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
    #[ORM\JoinColumn(nullable: false)]
    private ?Video $id_video = null;

    #[ORM\ManyToOne(inversedBy: 'valoracionesPositivas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $id_usuario = null;

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
}
