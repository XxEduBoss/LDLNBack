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
    private ?Video $id_video = null;

    #[ORM\ManyToOne(inversedBy: 'visitas')]
    #[ORM\JoinColumn(name:'id_usuario', nullable: false)]
    private ?Usuario $id_usuario = null;

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
