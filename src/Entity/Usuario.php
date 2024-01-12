<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'username', length: 50)]
    private ?string $username = null;

    #[ORM\Column(name: 'password', length: 1000)]
    private ?string $password = null;

    #[ORM\Column(name: 'rol_usuario')]
    private ?int $rol_usuario = null;

    #[ORM\Column(name: 'activo')]
    private ?bool $activo = true;

    #[ORM\OneToOne(mappedBy: 'id_usuario', cascade: ['persist', 'remove'])]
    private ?Canal $canal = null;

    #[ORM\OneToMany(mappedBy: 'id_usuario', targetEntity: Suscripcion::class, orphanRemoval: true)]
    private Collection $suscripciones;

    #[ORM\OneToMany(mappedBy: 'id_usuario_emisor', targetEntity: Mensaje::class, orphanRemoval: true)]
    private Collection $mensajes_emisor;

    #[ORM\OneToMany(mappedBy: 'id_usuario_receptor', targetEntity: Mensaje::class, orphanRemoval: true)]
    private Collection $mensajes_receptor;

    #[ORM\OneToMany(mappedBy: 'id_usuario', targetEntity: Token::class, orphanRemoval: true)]
    private Collection $tokens;

    #[ORM\OneToMany(mappedBy: 'id_usuario', targetEntity: Notificacion::class, orphanRemoval: true)]
    private Collection $notificaciones;

    #[ORM\OneToMany(mappedBy: 'id_usuario', targetEntity: Visita::class, orphanRemoval: true)]
    private Collection $visitas;

    #[ORM\OneToMany(mappedBy: 'id_usuario', targetEntity: Comentario::class, orphanRemoval: true)]
    private Collection $comentarios;

    #[ORM\OneToMany(mappedBy: 'id_usuario', targetEntity: ValoracionPositiva::class, orphanRemoval: true)]
    private Collection $valoracionesPositivas;

    #[ORM\OneToMany(mappedBy: 'id_usuario', targetEntity: ValoracionNegativa::class, orphanRemoval: true)]
    private Collection $valoracionesNegativas;

    public function __construct()
    {
        $this->suscripciones = new ArrayCollection();
        $this->mensajes_emisor = new ArrayCollection();
        $this->mensajes_receptor = new ArrayCollection();
        $this->tokens = new ArrayCollection();
        $this->notificaciones = new ArrayCollection();
        $this->visitas = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
        $this->valoracionesPositivas = new ArrayCollection();
        $this->valoracionesNegativas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRolUsuario(): ?int
    {
        return $this->rol_usuario;
    }

    public function setRolUsuario(int $rol_usuario): static
    {
        $this->rol_usuario = $rol_usuario;

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

    public function getCanal(): ?Canal
    {
        return $this->canal;
    }

    public function setCanal(Canal $canal): static
    {
        // set the owning side of the relation if necessary
        if ($canal->getIdUsuario() !== $this) {
            $canal->setIdUsuario($this);
        }

        $this->canal = $canal;

        return $this;
    }

    /**
     * @return Collection<int, Suscripcion>
     */
    public function getSuscripciones(): Collection
    {
        return $this->suscripciones;
    }

    public function addSuscripciones(Suscripcion $suscripciones): static
    {
        if (!$this->suscripciones->contains($suscripciones)) {
            $this->suscripciones->add($suscripciones);
            $suscripciones->setIdUsuario($this);
        }

        return $this;
    }

    public function removeSuscripciones(Suscripcion $suscripciones): static
    {
        if ($this->suscripciones->removeElement($suscripciones)) {
            // set the owning side to null (unless already changed)
            if ($suscripciones->getIdUsuario() === $this) {
                $suscripciones->setIdUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mensaje>
     */
    public function getMensajesEmisor(): Collection
    {
        return $this->mensajes_emisor;
    }

    public function addMensajeEmisor(Mensaje $mensajes_emisor): static
    {
        if (!$this->$mensajes_emisor->contains($mensajes_emisor)) {
            $this->$mensajes_emisor->add($mensajes_emisor);
            $mensajes_emisor->setIdUsuarioEmisor($this);
        }

        return $this;
    }

    public function removeMensajeEmisor(Mensaje $mensajes_emisor): static
    {
        if ($this->$mensajes_emisor->removeElement($mensajes_emisor)) {
            // set the owning side to null (unless already changed)
            if ($mensajes_emisor->getIdUsuarioEmisor() === $this) {
                $mensajes_emisor->setIdUsuarioEmisor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mensaje>
     */
    public function getMensajesReceptor(): Collection
    {
        return $this->mensajes_receptor;
    }

    public function addMensajeReceptor(Mensaje $mensajes_receptor): static
    {
        if (!$this->$mensajes_receptor->contains($mensajes_receptor)) {
            $this->$mensajes_receptor->add($mensajes_receptor);
            $mensajes_receptor->setIdUsuarioEmisor($this);
        }

        return $this;
    }

    public function removeMensajeReceptor(Mensaje $mensajes_receptor): static
    {
        if ($this->$mensajes_receptor->removeElement($mensajes_receptor)) {
            // set the owning side to null (unless already changed)
            if ($mensajes_receptor->getIdUsuarioEmisor() === $this) {
                $mensajes_receptor->setIdUsuarioEmisor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Token>
     */
    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function addToken(Token $token): static
    {
        if (!$this->tokens->contains($token)) {
            $this->tokens->add($token);
            $token->setIdUsuario($this);
        }

        return $this;
    }

    public function removeToken(Token $token): static
    {
        if ($this->tokens->removeElement($token)) {
            // set the owning side to null (unless already changed)
            if ($token->getIdUsuario() === $this) {
                $token->setIdUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notificacion>
     */
    public function getNotificaciones(): Collection
    {
        return $this->notificaciones;
    }

    public function addNotificacione(Notificacion $notificacione): static
    {
        if (!$this->notificaciones->contains($notificacione)) {
            $this->notificaciones->add($notificacione);
            $notificacione->setIdUsuario($this);
        }

        return $this;
    }

    public function removeNotificacione(Notificacion $notificacione): static
    {
        if ($this->notificaciones->removeElement($notificacione)) {
            // set the owning side to null (unless already changed)
            if ($notificacione->getIdUsuario() === $this) {
                $notificacione->setIdUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Visita>
     */
    public function getVisitas(): Collection
    {
        return $this->visitas;
    }

    public function addVisita(Visita $visita): static
    {
        if (!$this->visitas->contains($visita)) {
            $this->visitas->add($visita);
            $visita->setIdUsuario($this);
        }

        return $this;
    }

    public function removeVisita(Visita $visita): static
    {
        if ($this->visitas->removeElement($visita)) {
            // set the owning side to null (unless already changed)
            if ($visita->getIdUsuario() === $this) {
                $visita->setIdUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comentario>
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentario $comentario): static
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios->add($comentario);
            $comentario->setIdUsuario($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): static
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getIdUsuario() === $this) {
                $comentario->setIdUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ValoracionPositiva>
     */
    public function getValoracionesPositivas(): Collection
    {
        return $this->valoracionesPositivas;
    }

    public function addValoracionesPositiva(ValoracionPositiva $valoracionesPositiva): static
    {
        if (!$this->valoracionesPositivas->contains($valoracionesPositiva)) {
            $this->valoracionesPositivas->add($valoracionesPositiva);
            $valoracionesPositiva->setIdUsuario($this);
        }

        return $this;
    }

    public function removeValoracionesPositiva(ValoracionPositiva $valoracionesPositiva): static
    {
        if ($this->valoracionesPositivas->removeElement($valoracionesPositiva)) {
            // set the owning side to null (unless already changed)
            if ($valoracionesPositiva->getIdUsuario() === $this) {
                $valoracionesPositiva->setIdUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ValoracionNegativa>
     */
    public function getValoracionesNegativas(): Collection
    {
        return $this->valoracionesNegativas;
    }

    public function addValoracionesNegativa(ValoracionNegativa $valoracionesNegativa): static
    {
        if (!$this->valoracionesNegativas->contains($valoracionesNegativa)) {
            $this->valoracionesNegativas->add($valoracionesNegativa);
            $valoracionesNegativa->setIdUsuario($this);
        }

        return $this;
    }

    public function removeValoracionesNegativa(ValoracionNegativa $valoracionesNegativa): static
    {
        if ($this->valoracionesNegativas->removeElement($valoracionesNegativa)) {
            // set the owning side to null (unless already changed)
            if ($valoracionesNegativa->getIdUsuario() === $this) {
                $valoracionesNegativa->setIdUsuario(null);
            }
        }

        return $this;
    }

}
