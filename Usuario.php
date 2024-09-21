<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'usuario')]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer', name: 'id_usuario')]
    #[ORM\GeneratedValue]
    private $id_usuario;

    #[ORM\Column(type: 'string', name: 'nombre_usuario')]
    private $nombre;

    #[ORM\Column(type: 'string', name: 'apellido_usuario')]
    private $apellidos;

    #[ORM\Column(type: 'string', name: 'email')]
    private $email;

    #[ORM\Column(type: 'string', name: 'contrasena')]
    private $contrasena;

    #[ORM\Column(type: 'string', name: 'direccion')]
    private $direccion;


    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function getNombreUsuario() {
        return $this->nombre;
    }

    public function setNombreUsuario($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellidoUsuario() {
        return $this->apellidos;
    }

    public function setApellidoUsuario($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    // Implementación de métodos obligatorios para UserInterface
    public function getRoles(): array {
        return ['ROLE_USER']; // Puedes añadir más roles si lo necesitas
    }

    public function getUserIdentifier(): string {
        return $this->getEmail();
    }

    public function getPassword(): ?string {
        return $this->getContrasena();
    }

    public function getSalt(): ?string {
        // Si usas bcrypt o sodium, puedes devolver null
        return null;
    }
    
    public function eraseCredentials(): void {
        
    }

}