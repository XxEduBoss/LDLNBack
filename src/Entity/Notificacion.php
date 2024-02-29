<?php

namespace App\Entity;

use App\Repository\NotificacionRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TipoNotificacion;

#[ORM\Entity(repositoryClass: NotificacionRepository::class)]
#[ORM\Table(name: 'notificacion',schema: 'apollo')]
class Notificacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'texto', length: 10000)]
    private ?string $texto = null;

    #[ORM\Column(name:'fecha_notificacion', type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $fecha_notificacion = null;

    #[ORM\ManyToOne(inversedBy: 'notificaciones')]
    #[ORM\JoinColumn(name:'id_usuario', nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\Column]
    private ?bool $activo = null;

    #[ORM\ManyToOne(inversedBy: 'notificaciones')]
    #[ORM\JoinColumn(name:'id_tipo_notificacion', nullable: false)]
    private ?TipoNotificacion $tipo_notificacion = null;

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

    public function getFechaNotificacion(): ?DateTimeInterface
    {
        return $this->fecha_notificacion;
    }

    public function setFechaNotificacion(DateTimeInterface $fecha_notificacion): static
    {
        $this->fecha_notificacion = $fecha_notificacion;

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
        return $this->activo;
    }

    public function setActivo(bool $activo): static
    {
        $this->activo = $activo;

        return $this;
    }

    public function getTipoNotificacion(): ?TipoNotificacion
    {
        return $this->tipo_notificacion;
    }

    public function setTipoNotificacion(?TipoNotificacion $tipo_notificacion): static
    {
        $this->tipo_notificacion = $tipo_notificacion;

        return $this;
    }
}
