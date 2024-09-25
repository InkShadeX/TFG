<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'CATEGORIA')]
class Categoria
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer', name: 'ID_CATEGORIA')]
    #[ORM\GeneratedValue]
    private $idCategoria;

    #[ORM\Column(type: 'string', length: 50, name: 'NOMBRE_CATEGORIA')]
    private $nombreCategoria;

    #[ORM\Column(type: 'string', length: 200, name: 'DESCRIPCION_CATEGORIA')]
    private $descripcionCategoria;

    #[ORM\Column(type: 'string', name: 'IMAGEN_CATEGORIA')]
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
