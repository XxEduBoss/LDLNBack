<?php

namespace App\Dto;

use App\Entity\Usuario;
use App\Entity\Video;

class ValoracionPositivaDTO
{
    private ?int $id = null;
    private ?bool $likes = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool|null
     */
    public function getLikes(): ?bool
    {
        return $this->likes;
    }

    /**
     * @param bool|null $likes
     */
    public function setLikes(?bool $likes): void
    {
        $this->likes = $likes;
    }

    /**
     * @return Video|null
     */
    public function getVideo(): ?Video
    {
        return $this->video;
    }

    /**
     * @param Video|null $video
     */
    public function setVideo(?Video $video): void
    {
        $this->video = $video;
    }

    /**
     * @return Usuario|null
     */
    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    /**
     * @param Usuario|null $usuario
     */
    public function setUsuario(?Usuario $usuario): void
    {
        $this->usuario = $usuario;
    }


    private ?Video $video = null;
    private ?Usuario $usuario = null;



}