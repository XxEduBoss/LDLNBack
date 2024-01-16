<?php

namespace App\Entity;

use App\Repository\TokenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
#[ORM\Table(name: 'token',schema: 'apollo')]
class Token
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'apikey', length: 10000)]
    private ?string $apikey = null;

    #[ORM\Column(name:'fecha_expedicion', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_expedicion = null;

    #[ORM\Column(name:'fecha_creacion', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_creacion = null;

    #[ORM\ManyToOne(inversedBy: 'tokens')]
    #[ORM\JoinColumn(name:'usuario', nullable: false)]
    private ?Usuario $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApikey(): ?string
    {
        return $this->apikey;
    }

    public function setApikey(string $apikey): static
    {
        $this->apikey = $apikey;

        return $this;
    }

    public function getFechaExpedicion(): ? string
    {
        return $this->fecha_expedicion->format('d/m/Y H:i:s');
    }

    public function setFechaExpedicion(\DateTimeInterface $fecha_expedicion): static
    {
        $this->fecha_expedicion = \DateTime::createFromFormat('d/m/Y H:i:s', $fecha_expedicion);

        return $this;
    }

    public function getFechaCreacion(): ? string
    {
        return $this->fecha_creacion->format('d/m/Y H:i:s');
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): static
    {
        $this->fecha_creacion = \DateTime::createFromFormat('d/m/Y H:i:s', $fecha_creacion);

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
