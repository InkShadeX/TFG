<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity] 
#[ORM\Table(name: 'producto')]
class Producto
{
	#[ORM\Id]
    #[ORM\Column(type:'integer', name:'ID_PRODUCTO')]
    #[ORM\GeneratedValue]
    private $id_producto;

    #[ORM\Column(type:'string', name:'NOMBRE_PRODUCTO')]
    private $nombre_producto;

    #[ORM\Column(type:'string', name:'DESCRIPCION_PRODUCTO')]
    private $descripcion_producto;

    #[ORM\Column(type:'decimal', name:'PRECIO')]
    private $precio;

    #[ORM\ManyToOne(targetEntity: 'Categoria', inversedBy: 'producto')]
    #[ORM\JoinColumn(name: 'categoria', referencedColumnName: 'ID_CATEGORIA')]
    private $categoria;

    #[ORM\Column(type:'string', name:'FOTO')]
    private $foto;


    public function getId_producto(){
        return $this->id_producto;
    }
    public function setId_producto($id_producto){
        $this->id_producto = $id_producto;
    }

    public function getNombre_producto(){
        return $this->nombre_producto;
    }
    public function setNombre_producto($nombre_producto){
        $this->nombre_producto = $nombre_producto;
    }

    public function getDescripcion_producto(){
        return $this->descripcion_producto;
    }
    public function setDescripcion_producto($descripcion_producto){
        $this->descripcion_producto = $descripcion_producto;
    }

    public function getPrecio(){
        return $this->precio;
    }
    public function setPrecio($precio){
        $this->precio = $precio;
    }
    
    public function getCategoria(){
        return $this->categoria;
    }
    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }

    public function getFoto(){
        return $this->foto;
    }
    public function setFoto($foto){
        $this->foto = $foto;
    }


}