<?php

namespace App\Entity;

use App\Repository\MensajeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MensajeRepository::class)]
class Mensaje
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'texto', length: 10000)]
    private ?string $texto = null;

    #[ORM\Column(name:'fecha_envio', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_envio = null;

    #[ORM\ManyToOne(inversedBy: '$mensajes_emisor')]
    #[ORM\JoinColumn(name:'id_usuario_emisor', nullable: false)]
    private ?Usuario $id_usuario_emisor = null;

    #[ORM\ManyToOne(inversedBy: 'mensajes_receptor')]
    #[ORM\JoinColumn(name:'id_usuario_receptor', nullable: false)]
    private ?Usuario $id_usuario_receptor = null;

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

    public function getFechaEnvio(): ?\DateTimeInterface
    {
        return $this->fecha_envio;
    }

    public function setFechaEnvio(\DateTimeInterface $fecha_envio): static
    {
        $this->fecha_envio = $fecha_envio;

        return $this;
    }

    public function getIdUsuarioEmisor(): ?Usuario
    {
        return $this->id_usuario_emisor;
    }

    public function setIdUsuarioEmisor(?Usuario $id_usuario_emisor): static
    {
        $this->id_usuario_emisor = $id_usuario_emisor;

        return $this;
    }

    public function getIdUsuarioReceptor(): ?Usuario
    {
        return $this->id_usuario_receptor;
    }

    public function setIdUsuarioReceptor(?Usuario $id_usuario_receptor): static
    {
        $this->id_usuario_receptor = $id_usuario_receptor;

        return $this;
    }
}
