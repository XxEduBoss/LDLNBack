<?php

namespace App\Entity;

use App\Repository\MensajeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpCsFixer\Tokenizer\Analyzer\Analysis\CaseAnalysis;

#[ORM\Entity(repositoryClass: MensajeRepository::class)]
#[ORM\Table(name: 'mensaje',schema: 'apollo')]
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

    #[ORM\Column(name:'leido')]
    private ?bool $leido = null;

    #[ORM\ManyToOne(inversedBy: '$mensajes_emisor')]
    #[ORM\JoinColumn(name:'id_canal_emisor', nullable: false)]
    private ?Canal $canal_emisor = null;

    #[ORM\ManyToOne(inversedBy: 'mensajes_receptor')]
    #[ORM\JoinColumn(name:'id_canal_receptor', nullable: false)]
    private ?Canal $canal_receptor = null;

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

    public function getLeido(): ?bool
    {
        return $this->leido;
    }

    public function setLeido(bool $leido): static
    {
        $this->leido = $leido;

        return $this;
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

    public function getCanalEmisor(): ?Canal
    {
        return $this->canal_emisor;
    }

    public function setCanalEmisor(?Canal $canal_emisor): static
    {
        $this->canal_emisor = $canal_emisor;

        return $this;
    }

    public function getCanalReceptor(): ?Canal
    {
        return $this->canal_receptor;
    }

    public function setCanalReceptor(?Canal $canal_receptor): static
    {
        $this->canal_receptor = $canal_receptor;

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
