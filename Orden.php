<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity] 
#[ORM\Table(name: 'orden')]
class Orden
{

	#[ORM\Id]
    #[ORM\Column(type:'integer', name:'ID_ORDEN')]
    #[ORM\GeneratedValue]
    private $id_orden;

    #[ORM\Column(type:'string', name:'PRODUCTO')]
    private $producto;

    #[ORM\Column(type:'integer', name:'CANTIDAD')]
    private $cantidad;

    #[ORM\Column(type:'string', name:'ESTADO')]
    private $estado;

    #[ORM\Column(type:'integer', name:'USUARIO')]
    private $usuario;

    public function getId_orden(){
        return $this->id_orden;
    }
    public function setId_orden($id_orden){
        $this->id_orden = $id_orden;
    }

    public function getProducto(){
        return $this->producto;
    }
    public function setProducto($producto){
        $this->producto = $producto;
    }

    public function getCantidad(){
        return $this->cantidad;
    }
    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }

    public function getEstado(){
        return $this->estado;
    }
    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function getUsuario(){
        return $this->usuario;
    }
    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }


}