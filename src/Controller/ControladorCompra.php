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
        $id_usuario = $request->request->get('id_usuario');
        $ordenes = $entityManager->getRepository(Orden::class)->findBy(['usuario' => $id_usuario]);

        if(!$ordenes) {
            return $this->render('anuncio.html.twig', [
                'mensaje' => "Esta orden no existe, o ha habido un error."
            ]);
        }
        else {
            foreach ($ordenes as $orden) {
                $orden->setEstado("Efectuado");
            }
            $entityManager->flush();
            return $this->render('anuncio.html.twig', [
                'mensaje' => "Las órdenes han sido compradas."
            ]);
        }

        return $this->render('pagina_login.html.twig');
    }

    #[Route('/procesar_comprar_separado', name: 'procesar_comprar_separado')]
    public function procesar_comprar_separado(Request $request, EntityManagerInterface $entityManager) {
        
        $id_orden = $request->request->get('id_orden');
        $orden = $entityManager->getRepository(Orden::class)->find($id_orden);

        if(!$orden) {
            return $this->render('anuncio.html.twig', [
                'mensaje' => "Esta orden no existe, o ha habido un error."
            ]);
        }
        else {
            $orden->setEstado("Efectuado");
            $entityManager->flush();
            return $this->render('anuncio.html.twig', [
                'mensaje' => "La orden ha sido comprada."
            ]);
        }
        
    }

    #[Route('/procesar_eliminacion', name: 'procesar_eliminacion')]
    public function procesar_eliminacion(Request $request, EntityManagerInterface $entityManager) {
        $id_orden = $request->request->get('id_orden');
        $orden = $entityManager->getRepository(Orden::class)->find($id_orden);

        if(!$orden) {
            return $this->render('anuncio.html.twig', [
                'mensaje' => "Esta orden no existe, o ha habido un error."
            ]);
        }
        else {
            $entityManager->remove($orden);
            $entityManager->flush();
            return $this->render('anuncio.html.twig', [
                'mensaje' => "La orden ha sido eliminada."
            ]);
        }
        

    }
}
        