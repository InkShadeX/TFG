<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'categoria')]
class Categoria
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer', name: 'id_categoria')]
    #[ORM\GeneratedValue]
    private $idCategoria;

    #[ORM\Column(type: 'string', name: 'nombre_categoria')]
    private $nombreCategoria;

    #[ORM\Column(type: 'string', name: 'descripcion_categoria')]
    private $descripcionCategoria;

    #[ORM\Column(type: 'string', name: 'imagen_categoria')]
    private $imagenCategoria;

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getNombreCategoria() {
        return $this->nombreCategoria;
    }

    public function setNombreCategoria($nombreCategoria) {
        $this->nombreCategoria = $nombreCategoria;
    }

    public function getDescripcionCategoria() {
        return $this->descripcionCategoria;
    }

    public function setDescripcionCategoria($descripcionCategoria) {
        $this->descripcionCategoria = $descripcionCategoria;
    }

    public function getImagenCategoria() {
        return $this->imagenCategoria;
    }

    public function setImagenCategoria($imagenCategoria) {
        $this->imagenCategoria = $imagenCategoria;
    }
}
