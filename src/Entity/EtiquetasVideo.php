<?php

namespace App\Entity;

use App\Repository\EtiquetasVideoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtiquetasVideoRepository::class)]
#[ORM\Table(name: 'etiquetas_video',schema: 'apollo', )]
class EtiquetasVideo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'etiquetasVideos')]
    #[ORM\JoinColumn(name:'id_etiqueta', nullable: false)]
    private ?Etiquetas $etiqueta = null;

    #[ORM\ManyToOne(inversedBy: 'etiquetasVideos')]
    #[ORM\JoinColumn(name:'id_video', nullable: false)]
    private ?Video $video = null;


//    public function getId(): ?int
//    {
//        return $this->id;
//    }

    public function getEtiqueta(): ?Etiquetas
    {
        return $this->etiqueta;
    }

    public function setEtiqueta(?Etiquetas $etiqueta): static
    {
        $this->etiqueta = $etiqueta;

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
}
