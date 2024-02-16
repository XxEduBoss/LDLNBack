<?php

namespace App\Entity;

use App\Repository\ValoracionNegativaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValoracionNegativaRepository::class)]
#[ORM\Table(name: 'valoracion_negativa',schema: 'apollo')]
class ValoracionNegativa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $dislikes = null;

    #[ORM\ManyToOne(inversedBy: 'valoracionesNegativas')]
    #[ORM\JoinColumn(name:'id_video', nullable: false)]
    private ?Video $video = null;

    #[ORM\ManyToOne(inversedBy: 'valoracionesNegativas')]
    #[ORM\JoinColumn(name:'id_usuario', nullable: false)]
    private ?Usuario $usuario = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function isDislikes(): ?bool
    {
        return $this->dislikes;
    }

    public function setDislikes(?bool $dislikes): static
    {
        $this->dislikes = $dislikes;

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

}
