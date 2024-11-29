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

    #[Route('/añadir_orden/{id_producto}', name: 'añadir_orden')]
    public function añadirAlCarrito($id_producto, Request $request, EntityManagerInterface $entityManager)
    { 

        if ($this->getUser() == null) {
            return $this->render("anuncio_error.html.twig", [ "mensaje" => "Si no estás logeado, no puedes acceder :(" ]);
        }
        else {
            if ($request->isMethod('GET')) {
                return $this->render("anuncio_error.html.twig", [
                    "mensaje" => "Debes usar el formulario para añadir productos al carrito."
                ]);
            }
            
            $producto = $entityManager->getRepository(Producto::class)->find($id_producto);

            if (!$producto) {
                throw $this->createNotFoundException('Producto no encontrado');
            }

            $cantidad = $request->request->get('cantidad', 1);

            $user = $this->getUser();

            if (!$user) {
                throw $this->createAccessDeniedException('No estás autenticado.');
            }
        
            $idUsuario = $user->getIdUsuario();

            // Ejemplo de como crear una nueva orden
            $orden = new Orden();
            $orden->setProducto($producto);
            $orden->setCantidad($cantidad);
            $orden->setEstado('En espera'); // O el estado que desees
            $orden->setUsuario($idUsuario); // Aquí deberías poner el ID del usuario si es necesario

            $entityManager->persist($orden);
            $entityManager->flush();

            $this->addFlash('success', 'Producto añadido al carrito.');

            return $this->redirectToRoute('producto_detalle', ['id' => $id_producto]);
        }
    }
}
