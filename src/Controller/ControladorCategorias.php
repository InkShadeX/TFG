<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categoria;
use App\Entity\Producto;

class ControladorCategorias extends AbstractController
{
    #[Route('/categoria/{idCategoria}', name: 'categoria')]
    public function paginaCategoria($idCategoria, EntityManagerInterface $entityManager)
    {
        $categoria = $entityManager->getRepository(Categoria::class)->find($idCategoria);

        if (!$categoria) {
            throw $this->createNotFoundException('Categoría no encontrada');
        }

        // Obtener los productos asociados a la categoría
        $productos = $entityManager->getRepository(Producto::class)->findBy(['categoria' => $categoria]);

        // Renderiza la vista con los detalles de la categoría
         // Renderiza la vista con los detalles de la categoría y productos
         return $this->render('pagina_categoria.html.twig', [
            'categoria' => $categoria,
            'productos' => $productos,
        ]);
    }
}
   