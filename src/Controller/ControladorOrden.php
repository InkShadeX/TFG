<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Orden;
use App\Entity\Producto;

class ControladorOrden extends AbstractController
{
    #[Route('/orden/{id}', name: 'orden')]
    public function orden($id, EntityManagerInterface $entityManager)
    {
        // Obtener la orden usando el ID (o crear una nueva si no existe)
        $orden = $entityManager->getRepository(Orden::class)->find($id);

        if (!$orden) {
            throw $this->createNotFoundException('orden no encontrada');
        }

        $productos = $orden->getProductos();

        return $this->render('pagina_ordenes.html.twig', [
            'productos' => $productos,
        ]);
    }

    #[Route('/añadir-al-orden/{id_producto}', name: 'añadir_al_orden')]
    public function añadirAlCarrito($id_producto, Request $request, EntityManagerInterface $entityManager)
    {
        $producto = $entityManager->getRepository(Producto::class)->find($id_producto);

        if (!$producto) {
            throw $this->createNotFoundException('Producto no encontrado');
        }

        $cantidad = $request->request->get('cantidad', 1);

        // Aquí hay que manejar añadir al carrito
        // Por ejemplo, guardarlo en la base de datos, etc.

        // Ejemplo de como crear una nueva orden
        $orden = new Orden();
        $orden->setProducto($producto);
        $orden->setCantidad($cantidad);
        $orden->setEstado('pendiente'); // O el estado que desees
        $orden->setUsuario(1); // Aquí deberías poner el ID del usuario si es necesario

        $entityManager->persist($orden);
        $entityManager->flush();

        $this->addFlash('success', 'Producto añadido al carrito.');

        return $this->redirectToRoute('producto_detalle', ['id' => $id_producto]);
    }
}
