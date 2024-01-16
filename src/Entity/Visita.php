<?php

namespace App\Entity;

use App\Repository\VisitaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitaRepository::class)]
#[ORM\Table(name: 'visita',schema: 'apollo')]
class Visita
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'fecha_visita', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_visita = null;

    #[ORM\ManyToOne(inversedBy: 'visitas')]
    #[ORM\JoinColumn(name:'id_video', nullable: false)]
    private ?Video $video = null;

    #[ORM\ManyToOne(inversedBy: 'visitas')]
    #[ORM\JoinColumn(name:'id_usuario', nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\Column]
    private ?bool $Activo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaVisita(): ?string
    {
        return $this->fecha_visita->format('d/m/Y H:i:s');
    }

    public function setFechaVisita(String $fecha_visita): static
    {
        $this->fecha_visita = \DateTime::createFromFormat('d/m/Y H:i:s', $fecha_visita);;

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

    public function setActivo(bool $Activo): static
    {
        $this->Activo = $Activo;

        return $this;
    }
}
