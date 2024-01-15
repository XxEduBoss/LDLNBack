<?php

namespace App\Entity;

use App\Repository\NotificacionRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use TipoNotificacion;

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

    #[ORM\Column(name:'tipo', type: Types::INTEGER)]
    private ?TipoNotificacion $tipo = null;

    #[ORM\Column(name:'fecha_notificacion', type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $fecha_notificacion = null;

    #[ORM\ManyToOne(inversedBy: 'notificaciones')]
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

    public function getTipo(): ?TipoNotificacion
    {
        return $this->tipo;
    }

    public function setTipo(TipoNotificacion $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getFechaNotificacion(): ?string
    {
        return $this->fecha_notificacion->format('d/m/Y H:i:s');
    }

    public function setFechaNotificacion(String $fecha_notificacion): static
    {
        $this->fecha_notificacion = \DateTime::createFromFormat('d/m/Y H:i:s', $fecha_notificacion);

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
