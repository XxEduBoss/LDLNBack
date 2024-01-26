<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[ORM\Table(name: 'usuario',schema: 'apollo')]
class Usuario implements UserInterface,PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'username', length: 50)]
    private ?string $username = null;

    #[ORM\Column(name: 'password', length: 1000)]
    private ?string $password = null;

    #[ORM\Column(name: 'id_rol_usuario')]
    private ?int $rol_usuario = null;

    #[ORM\Column(name: 'activo')]
    private ?bool $activo = true;

    #[ORM\Column(name: 'email')]
    private ?string $email = null;

    #[ORM\ManyToMany(targetEntity: Etiquetas::class)]
    #[ORM\JoinTable(name: "etiquetas_usuario", schema: "apollo")]
    #[ORM\JoinColumn(name: "id_usuario", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "id_etiqueta", referencedColumnName: "id")]
    private Collection $etiquetas;

    #[ORM\OneToOne(mappedBy: 'usuario')]
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

    public function getEmail(): ?int
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email= $email;

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
        if ($canal->getUsuario() !== $this) {
            $canal->setUsuario($this);
        }

        $this->canal = $canal;

        return $this;
    }

    /**
     * @return Collection<int, Etiquetas>
     */
    public function getEtiqueta(): Collection
    {
        return $this->etiquetas;
    }

    public function addEtiqueta(Etiquetas $etiqueta): static
    {
        if (!$this->etiquetas->contains($etiqueta)) {
            $this->etiquetas->add($etiqueta);
        }

        return $this;
    }

    public function removeEtiqueta(Etiquetas $etiqueta): static
    {
        $this->etiquetas->removeElement($etiqueta);

        return $this;
    }

    /**
     * @return Collection<int, Suscripcion>
     */
    public function getSuscripciones(): Collection
    {
        return $this->suscripciones;
    }

    public function addSuscripciones(Suscripcion $suscripcion): static
    {
        if (!$this->suscripciones->contains($suscripcion)) {
            $this->suscripciones->add($suscripcion);
            $suscripcion->setUsuario($this);
        }

        return $this;
    }

    public function removeSuscripciones(Suscripcion $suscripcion): static
    {
        if ($this->suscripciones->removeElement($suscripcion)) {
            // set the owning side to null (unless already changed)
            if ($suscripcion->getUsuario() === $this) {
                $suscripcion->setUsuario(null);
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

    public function addMensajeEmisor(Mensaje $mensaje_emisor): static
    {
        if (!$this->mensajes_emisor->contains($mensaje_emisor)) {
            $this->mensajes_emisor->add($mensaje_emisor);
            $mensaje_emisor->setUsuarioEmisor($this);
        }

        return $this;
    }

    public function removeMensajeEmisor(Mensaje $mensaje_emisor): static
    {
        if ($this->mensajes_emisor->removeElement($mensaje_emisor)) {
            // set the owning side to null (unless already changed)
            if ($mensaje_emisor->getUsuarioEmisor() === $this) {
                $mensaje_emisor->setUsuarioEmisor(null);
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

    public function addMensajeReceptor(Mensaje $mensaje_receptor): static
    {
        if (!$this->mensajes_receptor->contains($mensaje_receptor)) {
            $this->mensajes_receptor->add($mensaje_receptor);
            $mensaje_receptor->setUsuarioEmisor($this);
        }

        return $this;
    }

    public function removeMensajeReceptor(Mensaje $mensaje_receptor): static
    {
        if ($this->mensajes_receptor->removeElement($mensaje_receptor)) {
            // set the owning side to null (unless already changed)
            if ($mensaje_receptor->getUsuarioEmisor() === $this) {
                $mensaje_receptor->setUsuarioEmisor(null);
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
            $token->setUsuario($this);
        }

        return $this;
    }

    public function removeToken(Token $token): static
    {
        if ($this->tokens->removeElement($token)) {
            // set the owning side to null (unless already changed)
            if ($token->getUsuario() === $this) {
                $token->setUsuario(null);
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

    public function addNotificacion(Notificacion $notificacion): static
    {
        if (!$this->notificaciones->contains($notificacion)) {
            $this->notificaciones->add($notificacion);
            $notificacion->setUsuario($this);
        }

        return $this;
    }

    public function removeNotificacion(Notificacion $notificacion): static
    {
        if ($this->notificaciones->removeElement($notificacion)) {
            // set the owning side to null (unless already changed)
            if ($notificacion->getUsuario() === $this) {
                $notificacion->setUsuario(null);
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
            $visita->setUsuario($this);
        }

        return $this;
    }

    public function removeVisita(Visita $visita): static
    {
        if ($this->visitas->removeElement($visita)) {
            // set the owning side to null (unless already changed)
            if ($visita->getUsuario() === $this) {
                $visita->setUsuario(null);
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
            $comentario->setUsuario($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): static
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getUsuario() === $this) {
                $comentario->setUsuario(null);
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

    public function addValoracionesPositiva(ValoracionPositiva $valoracionPositiva): static
    {
        if (!$this->valoracionesPositivas->contains($valoracionPositiva)) {
            $this->valoracionesPositivas->add($valoracionPositiva);
            $valoracionPositiva->setUsuario($this);
        }

        return $this;
    }

    public function removeValoracionesPositiva(ValoracionPositiva $valoracionPositiva): static
    {
        if ($this->valoracionesPositivas->removeElement($valoracionPositiva)) {
            // set the owning side to null (unless already changed)
            if ($valoracionPositiva->getUsuario() === $this) {
                $valoracionPositiva->setUsuario(null);
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

    public function addValoracionesNegativa(ValoracionNegativa $valoracionNegativa): static
    {
        if (!$this->valoracionesNegativas->contains($valoracionNegativa)) {
            $this->valoracionesNegativas->add($valoracionNegativa);
            $valoracionNegativa->setUsuario($this);
        }

        return $this;
    }

    public function removeValoracionNegativa(ValoracionNegativa $valoracionNegativa): static
    {
        if ($this->valoracionesNegativas->removeElement($valoracionNegativa)) {
            // set the owning side to null (unless already changed)
            if ($valoracionNegativa->getUsuario() === $this) {
                $valoracionNegativa->setUsuario(null);
            }
        }

        return $this;
    }
    public function getRoles(): array
    {
        $roles = [];
        $roles[] = $this->getRolUsuario();
        return  $roles;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this-> getUsername();
    }

}
