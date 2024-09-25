<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuario;
use App\Entity\Tarjeta;
use App\Entity\Orden;
use App\Entity\Producto;
use App\Entity\Categoria;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ControladorUsuario extends AbstractController
{
    #[Route('/perfil_usuario', name: 'perfil_usuario')]
    public function perfilUsuario(Request $request, EntityManagerInterface $entityManager)
    {
        if ($this->getUser() == null) {
            return $this->render("anuncio.html.twig", [
                "mensaje" => "Si no estás logeado, no puedes acceder :("
            ]);
        }
        else {
            //Obtener el usuario actual
            $usuario_identifier = $this->getUser()->getUserIdentifier();

            //Obtener el id del usuario a través del usuario_identifier y posteriormente todas las órdenes relacionadas con ese id
            $id_usuario = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $usuario_identifier])->getIdUsuario();
            $productos_comprados = $entityManager->getRepository(Orden::class)->findBy(['usuario' => $id_usuario, 'estado' => "Efectuado"]);
            $tarjetas_usuario = $entityManager->getRepository(Tarjeta::class)->findBy(['usuario' => $id_usuario]);

            //Obtener el total de productos
            $total_productos = count($productos_comprados);

            return $this->render("pagina_usuario.html.twig", [
                "total_productos" => $total_productos,
                "pedidos" => $productos_comprados,
                "tarjetas" => $tarjetas_usuario
            ]);
        }
    }

    #[Route('/procesar_editar_usuario', name: 'procesar_editar_usuario')]
    public function procesar_editar_usuario(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        // Recoger datos del formulario tras la verificación del usuario
        $nombre = $request->request->get('nombre');
        $apellidos = $request->request->get('apellidos');
        $correo = $request->request->get('email');
        $direccion = $request->request->get('direccion');
        $contrasena = $request->request->get('contrasena');
        $confirmar_contrasena = $request->request->get('confirmar_contrasena');

        //Recoger el usuario que queremos modificar (el propio que está logeado, claramente)
        $usuario_identifier = $this->getUser()->getUserIdentifier();
        $usuario = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $usuario_identifier]);
        
        if ($this->getUser() == null) {
            return $this->render("anuncio.html.twig", [
                "titulo_mensaje" => "Vaya...",
                "mensaje" => "Lo sentimos... si no estás logeado, no puedes acceder :("
            ]);
        }
        else {
            // Aquí empieza la fase para verificar qué campos están vacíos y cuáles no, en caso de estarlo, se entiende que el usuario no quiere modificar nada.
            if ($nombre != "") {
                $usuario->setNombreUsuario($nombre);
            }
            if ($apellidos != "") {
                $usuario->setApellidoUsuario($apellidos);
            }
            if ($correo != "") {
                $usuario_repetido = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $correo]);
                if ($usuario_repetido) {
                    return $this->render("anuncio.html.twig", [
                        "titulo_mensaje" => "Vaya...",
                        "mensaje" => "Lo sentimos... pero este email ya está escogido"
                    ]);
                }
                $usuario->setEmail($correo);
            }
            if ($direccion != "") {
                $usuario->setDireccion($direccion);
            }
            if ($contrasena != "") {
                $hashedPassword = $passwordHasher->hashPassword($usuario, $contrasena);
                $usuario->setPassword($hashedPassword);
            }

            $entityManager->persist($usuario);
            $entityManager->flush();

            return $this->render("anuncio.html.twig", [
                "titulo_mensaje" => "¡Listo!",
                "mensaje" => "Hemos terminado de editar tus datos, puedes volver a tu usuario o de vuelta a la tienda a través de la barra superior ;D"
            ]);
        }
    }

    #[Route('/procesar_cancelacion', name: 'procesar_cancelacion')]
    public function procesarCancelacion(Request $request, EntityManagerInterface $entityManager)
    {
        $id_orden = $request->request->get('id_orden');
        $orden = $entityManager->getRepository(Orden::class)->findOneBy(['id_orden' => $id_orden]);

        if ($this->getUser() == null) {
            return $this->render("anuncio.html.twig", [
                "mensaje" => "Si no estás logeado, no puedes acceder :("
            ]);
        }
        else {
            
            $orden->setEstado("Cancelado");
            $entityManager->persist($orden);
            $entityManager->flush();

            return $this->render("anuncio.html.twig", [
                "titulo_mensaje" => "¡Listo!",
                "mensaje" => "Hemos cancelado el pedido con éxito ;D"
            ]);
        }
    }

    #[Route('/procesar_eliminacion_tarjeta', name: 'procesar_eliminacion_tarjeta')]
    public function procesar_eliminacion_tarjeta(Request $request, EntityManagerInterface $entityManager)
    {
        $id_tarjeta = $request->request->get('id_tarjeta');
        $tarjeta = $entityManager->getRepository(Tarjeta::class)->findOneBy(['idTarjeta' => $id_tarjeta]);

        if ($this->getUser() == null) {
            return $this->render("anuncio.html.twig", [
                "mensaje" => "Si no estás logeado, no puedes acceder :("
            ]);
        }
        else {
            
            $entityManager->remove($tarjeta);
            $entityManager->flush();

            return $this->render("anuncio.html.twig", [
                "titulo_mensaje" => "¡Listo!",
                "mensaje" => "Hemos eliminado esta tarjeta ;D"
            ]);
        }
    }

    #[Route('/procesar_anadir_tarjeta', name: 'procesar_anadir_tarjeta')]
    public function procesar_anadir_tarjeta(Request $request, EntityManagerInterface $entityManager)
    {   
        $usuario_identifier = $this->getUser()->getUserIdentifier();
        $id_usuario = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $usuario_identifier]);
        $titular_tarjeta = $request->request->get('titular');
        $numero_tarjeta = $request->request->get('numero_tarjeta');
        $ccv = $request->request->get('ccv');
        $fecha_expiracion = $request->request->get('fecha_expiracion');

        if ($this->getUser() == null) {
            return $this->render("anuncio.html.twig", [
                "mensaje" => "Si no estás logeado, no puedes acceder :("
            ]);
        }
        else {
            $tarjeta = new Tarjeta();
            $tarjeta->setNombreTitular($titular_tarjeta);
            $tarjeta->setUsuario($id_usuario);
            $tarjeta->setNumeroTarjeta($numero_tarjeta);
            $tarjeta->setCcv($ccv);
            $tarjeta->setFechaExpiracion($fecha_expiracion);
            $entityManager->persist($tarjeta);
            $entityManager->flush();

            return $this->render("anuncio.html.twig", [
                "titulo_mensaje" => "¡Listo!",
                "mensaje" => "Hemos añadido esta tarjeta a tu cuenta ;D"
            ]);
        }
  
    }
}
        