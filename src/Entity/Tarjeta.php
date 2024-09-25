<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Usuario; // Asegúrate de que la entidad Usuario está correctamente importada

#[ORM\Entity]
#[ORM\Table(name: 'TARJETA')]
class Tarjeta
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer', name: 'ID_TARJETA')]
    #[ORM\GeneratedValue]
    private $idTarjeta;

    // Relación ManyToOne con la entidad Usuario
    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(name: 'USUARIO', referencedColumnName: 'id_usuario', nullable: false)]  // Esto debe enlazar con la clave primaria de la tabla USUARIO
    private $usuario;  // Relación con la entidad Usuario

    #[ORM\Column(type: 'string', length: 100, name: 'NOMBRE_TITULAR')]
    private $nombreTitular;

    #[ORM\Column(type: 'string', length: 16, name: 'NUMERO_TARJETA')]
    private $numeroTarjeta;

    #[ORM\Column(type: 'string', length: 3, name: 'CCV')]
    private $ccv;

    #[ORM\Column(type: 'string', length: 5, name: 'FECHA_EXPIRACION')]
    private $fechaExpiracion;

    // Getters y Setters

    public function getIdTarjeta() {
        return $this->idTarjeta;
    }

    public function getNombreTitular() {
        return $this->nombreTitular;
    }

    public function setNombreTitular($nombreTitular) {
        $this->nombreTitular = $nombreTitular;
    }

    public function getUsuario() {  // Cambiamos el getter de usuario
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario) {  // El setter debe recibir un objeto de la clase Usuario
        $this->usuario = $usuario;
    }

    public function getNumeroTarjeta() {
        return $this->numeroTarjeta;
    }

    public function setNumeroTarjeta($numeroTarjeta) {
        $this->numeroTarjeta = $numeroTarjeta;
    }

    public function getCcv() {
        return $this->ccv;
    }

    public function setCcv($ccv) {
        $this->ccv = $ccv;
    }

    public function getFechaExpiracion() {
        return $this->fechaExpiracion;
    }

    public function setFechaExpiracion($fechaExpiracion) {
        $this->fechaExpiracion = $fechaExpiracion;
    }
}