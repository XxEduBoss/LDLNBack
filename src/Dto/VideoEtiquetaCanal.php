<?php

namespace App\Dto;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class VideoEtiquetaCanal
{

    private Collection $videos;
    private string $etiqueta;

    /**
     * @param Collection $videos
     */
    public function __construct()
    {
        $this->videos = new ArrayCollection();
    }

    public function agregarVideos(array $videos){
        foreach ($videos as $video){
            $this->videos->add($video);
        }
    }

    /**
     * @return Collection
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    /**
     * @param Collection $videos
     */
    public function setVideos(Collection $videos): void
    {
        $this->videos = $videos;
    }

    /**
     * @return string
     */
    public function getEtiqueta(): string
    {
        return $this->etiqueta;
    }

    /**
     * @param string $etiqueta
     */
    public function setEtiqueta(string $etiqueta): void
    {
        $this->etiqueta = $etiqueta;
    }

}