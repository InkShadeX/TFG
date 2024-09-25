<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuario;
use App\Entity\Tarjeta;
use App\Entity\Orden;
use App\Entity\Producto;
use App\Entity\Categoria;

class ControladorCarrito extends AbstractController
{
    #[Route('/carrito', name: 'carrito')]
    public function paginaCarrito(EntityManagerInterface $entityManager)
    {
        $usuario_identifier = $this->getUser()->getUserIdentifier();
        $id_usuario = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $usuario_identifier])->getIdUsuario();
        $carrito = $entityManager->getRepository(Orden::class)->findBy(['usuario' => $id_usuario, 'estado' => 'En espera']);

        // Una vez hayamos sacado todas las órdenes del usuario, las mandamos a la plantilla.
        return $this->render('pagina_carrito.html.twig', ['carrito' => $carrito, 'id_usuario' => $id_usuario]);
    }
}