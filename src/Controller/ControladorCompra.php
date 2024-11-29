<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Producto;
use App\Entity\Orden;

class ControladorCompra extends AbstractController
{
    #[Route('/procesar_comprar_todo', name: 'procesar_comprar_todo')]
    public function procesar_comprar_todo(Request $request, EntityManagerInterface $entityManager) {

        if ($this->getUser() == null) {
            return $this->render("anuncio_error.html.twig", [ "mensaje" => "Si no estás logeado, no puedes acceder :(" ]);
        }
        else {
            $id_usuario = $request->request->get('id_usuario');
            $ordenes = $entityManager->getRepository(Orden::class)->findBy(['usuario' => $id_usuario, 'estado' => 'En espera']);

            if(!$ordenes) {
                return $this->render('anuncio_error.html.twig', [ 'mensaje' => "Esta orden no existe, o ha habido un error." ]);
            }
            else {
                foreach ($ordenes as $orden) {
                    $orden->setEstado("Efectuado");
                }
                $entityManager->flush();
                return $this->redirectToRoute('procesar_factura', ['ids' => implode(',', array_map(fn($orden) => $orden->getId_orden(), $ordenes))]);
            }
            
        }

    }


    #[Route('/procesar_comprar_separado', name: 'procesar_comprar_separado')]
    public function procesar_comprar_separado(Request $request, EntityManagerInterface $entityManager) {

        if ($this->getUser() == null) {
            return $this->render("anuncio_error.html.twig", [ "mensaje" => "Si no estás logeado, no puedes acceder :(" ]);
        }
        else {
            $id_orden = $request->request->get('id_orden');

            if(!$id_orden) {
                return $this->render('anuncio_error.html.twig', [ 'mensaje' => "Esta orden no existe, o ha habido un error." ]);
            }

            $orden = $entityManager->getRepository(Orden::class)->find($id_orden);

            if (!$orden) {
                return $this->render('anuncio_error.html.twig', ['mensaje' => "Esta orden no existe, o ha habido un error."]);
            } else {
                $orden->setEstado("Efectuado");
                $entityManager->flush();
                return $this->redirectToRoute('procesar_factura', ['ids' => $orden->getId_orden()]);
            }
        }
        
    }

    #[Route('/procesar_eliminacion', name: 'procesar_eliminacion')]
    public function procesar_eliminacion(Request $request, EntityManagerInterface $entityManager) {
        if ($this->getUser() == null) {
            return $this->render("anuncio_error.html.twig", [ "mensaje" => "Si no estás logeado, no puedes acceder :(" ]);
        }
        else {
            $id_orden = $request->request->get('id_orden');
        
            if(!$id_orden) {
                return $this->render('anuncio_error.html.twig', [ 'mensaje' => "Esta orden no existe, o ha habido un error." ]);
            }

            $orden = $entityManager->getRepository(Orden::class)->find($id_orden);

            if(!$orden) {
                return $this->render('anuncio_error.html.twig', [ 'mensaje' => "Esta orden no existe, o ha habido un error." ]);
            }
            else {
                $entityManager->remove($orden);
                $entityManager->flush();
                return $this->render('anuncio_exito.html.twig', [ 'mensaje' => "La orden ha sido eliminada." ]);
            }
        }
    }


    // #[Route('/generar_ticket/{ids}', name: 'generar_ticket')]
    // public function generar_ticket($ids, EntityManagerInterface $entityManager) {
    //     if ($this->getUser() == null) {
    //         return $this->render("anuncio_error.html.twig", [ "mensaje" => "Si no estás logeado, no puedes acceder :(" ]);
    //     }
    //     else {
    //         $idArray = explode(',', $ids);
    //         $ordenes = $entityManager->getRepository(Orden::class)->findBy(['id_orden' => $idArray]);
            
    //         if (count($ordenes) === 0) {
    //             return $this->render('anuncio_error.html.twig', ['mensaje' => "No se encontraron órdenes."]);
    //         }

    //         $totalPrecio = 0;
    //         foreach ($ordenes as $orden) {
    //             $totalPrecio += $orden->getCantidad() * $orden->getProducto()->getPrecio();
    //         }
    

    //         return $this->render('pagina_factura.html.twig', ['ordenes' => $ordenes, 'totalPrecio' => $totalPrecio]);
    //     }
    // }


    #[Route('/procesar_factura/{ids}', name: 'procesar_factura')]
    public function procesar_factura($ids, Request $request, EntityManagerInterface $entityManager) {
        
        if ($this->getUser() == null) {
            return $this->render("anuncio_error.html.twig", [ "mensaje" => "Si no estás logeado, no puedes acceder :(" ]);
        }
        else {

            $idArray = explode(',', $ids);
            $ordenes = $entityManager->getRepository(Orden::class)->findBy(['id_orden' => $idArray]);
            $user_identifier = $this->getUser()->getUserIdentifier();
        
        if (count($ordenes) === 0) {
            return $this->render('anuncio_error.html.twig', ['mensaje' => "No se encontraron órdenes."]);
        }
     
        $totalPrecio = 0;
            foreach ($ordenes as $orden) {
                $totalPrecio += $orden->getCantidad() * $orden->getProducto()->getPrecio();
            }
    
            return $this->render('pagina_factura.html.twig', ['ordenes' => $ordenes, 'fecha' => new \DateTime(), 'total_precio' => $totalPrecio]);
        }
    }
}
        