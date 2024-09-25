<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Producto;
use App\Entity\Orden;

class ControladorProducto extends AbstractController
{
    #[Route('/producto/{id}', name: 'producto_detalle')]
    public function productoDetalle($id, Request $request, EntityManagerInterface $entityManager)
    {
        $producto = $entityManager->getRepository(Producto::class)->find($id);

        if (!$producto) {
            throw $this->createNotFoundException('Producto no encontrado');
        }

        if ($request->isMethod('POST')) {
            $cantidad = (int) $request->request->get('cantidad', 1);
            $usuarioId = $this->getUser() ? $this->getUser()->getId() : 0; // Asume que el usuario está autenticado

            // Crear una nueva orden
            $orden = new Orden();
            $orden->setProducto($producto);
            $orden->setCantidad($cantidad);
            $orden->setEstado('Pendiente');
            $orden->setUsuario($usuarioId);


            $entityManager->persist($orden);
            $entityManager->flush();

            $this->addFlash('success', 'Producto añadido al carrito.');

            return $this->redirectToRoute('producto_detalle', ['id' => $id]);
        }

        return $this->render('pagina_producto.html.twig', [
            'producto' => $producto,
        ]);
    }
}
        