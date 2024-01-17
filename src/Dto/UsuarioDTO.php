<?php

namespace App\Dto;

class UsuarioDTO
{

    private ?int $id = null;
    private ?string $username = null;
    private ?string $password = null;
    private ?int $rol_usuario = null;
    private ?int $activo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getRolUsuario(): ?int
    {
        return $this->rol_usuario;
    }

    public function setRolUsuario(?int $rol_usuario): void
    {
        $this->rol_usuario = $rol_usuario;
    }

    public function getActivo(): ?int
    {
        return $this->activo;
    }

    public function setActivo(?int $activo): void
    {
        $this->activo = $activo;
    }

}