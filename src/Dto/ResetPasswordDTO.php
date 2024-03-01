<?php

namespace App\Dto;

use App\Entity\Usuario;

class ResetPasswordDTO
{
    private ?int $id = null;
    private ?string $selector = null;
    private ?string $hashedToken = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getSelector(): ?string
    {
        return $this->selector;
    }

    public function setSelector(?string $selector): void
    {
        $this->selector = $selector;
    }

    public function setHashedToken(?string $hashedToken): void
    {
        $this->hashedToken = $hashedToken;
    }

    public function getHashedToken(): ?string
    {
        return $this->hashedToken;
    }





}