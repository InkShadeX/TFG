<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Categoria;
use App\Entity\Usuario;
use App\Entity\Orden;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ControladorAdmin extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function adminDashboard(EntityManagerInterface $entityManager): Response
    {
        $productos = $entityManager->getRepository(Producto::class)->findAll();
        $categorias = $entityManager->getRepository(Categoria::class)->findAll();
        $usuarios = $entityManager->getRepository(Usuario::class)->findAll();

        return $this->render('admin.html.twig', [
            'productos' => $productos,
            'categorias' => $categorias,
            'usuarios' => $usuarios,
        ]);
    }


    // Formularios para las redirecciones
    #[Route('/form_editar_usuario/{id}', name: 'form_editar_usuario')]
    public function formEditarUsuario(int $id, EntityManagerInterface $entityManager,): Response
    {

        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        return $this->render('form_editar_usuario.html.twig', ['usuario' => $usuario]);
    }

    #[Route('/form_editar_producto/{id}', name: 'form_editar_producto')]
    public function formEditarProducto(int $id, EntityManagerInterface $entityManager): Response
    {
        // Buscar el producto a editar por ID
        $producto = $entityManager->getRepository(Producto::class)->find($id);

        $categorias = $entityManager->getRepository(Categoria::class)->findAll();

        return $this->render('form_editar_producto.html.twig', [
            'producto' => $producto, 
            'categorias' => $categorias
        ]);
    }

    #[Route('/form_editar_categoria/{id}', name: 'form_editar_categoria')]
    public function formEditarCategoria(int $id, EntityManagerInterface $entityManager): Response
    {
        $categoria = $entityManager->getRepository(Categoria::class)->find($id);

        return $this->render('form_editar_categoria.html.twig', ['categoria' => $categoria]);
    }

    // Funciones para editar registros
    #[Route('/editar_usuario/{id}', name: 'editar_usuario')]
    public function editarUsuario(
        int $id,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $usuario = $entityManager->getRepository(Usuario::class)->find($id);
    
        if (!$usuario) {
            throw $this->createNotFoundException('Usuario no encontrado.');
        }
    
        if ($request->isMethod('POST')) {
            $usuario->setNombreUsuario($request->request->get('nombre_usuario'));
            $usuario->setApellidoUsuario($request->request->get('apellido_usuario'));
            $usuario->setEmail($request->request->get('email'));
            $usuario->setDireccion($request->request->get('direccion'));
    
            // Solo actualizar contraseña si se proporciona
            $password = $request->request->get('password');
            if ($password) {
                $usuario->setPassword($password); // Asegúrate de aplicar hashing si es necesario
            }
    
            $entityManager->persist($usuario);
            $entityManager->flush();
            
            // Redirección final en caso de tener éxito
            $productos = $entityManager->getRepository(Producto::class)->findAll();
            $categorias = $entityManager->getRepository(Categoria::class)->findAll();
            $usuarios = $entityManager->getRepository(Usuario::class)->findAll();

            return $this->render('admin.html.twig', [
                'productos' => $productos,
                'categorias' => $categorias,
                'usuarios' => $usuarios,
            ]);
        }
    
        return $this->render('form_editar_usuario.html.twig', ['usuario' => $usuario]);
    }

    #[Route('/editar_producto/{id}', name: 'editar_producto')]
    public function editarProducto(
        int $id,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $producto = $entityManager->getRepository(Producto::class)->find($id);
        $categorias = $entityManager->getRepository(Categoria::class)->findAll();

        if (!$producto) {
            throw $this->createNotFoundException('Producto no encontrado.');
        }

        if ($request->isMethod('POST')) {
            $producto->setNombre_producto($request->request->get('nombre_producto'));
            $producto->setDescripcion_producto($request->request->get('descripcion'));
            $producto->setPrecio($request->request->get('precio'));

            // Buscar y asignar la categoría seleccionada
            $categoriaId = $request->request->get('categoria');
            $categoria = $entityManager->getRepository(Categoria::class)->find($categoriaId);
            if ($categoria) {
                $producto->setCategoria($categoria);
            }

            $entityManager->persist($producto);
            $entityManager->flush();

            // Redirección final en caso de tener éxito
            $productos = $entityManager->getRepository(Producto::class)->findAll();
            $categorias = $entityManager->getRepository(Categoria::class)->findAll();
            $usuarios = $entityManager->getRepository(Usuario::class)->findAll();

            return $this->render('admin.html.twig', [
                'productos' => $productos,
                'categorias' => $categorias,
                'usuarios' => $usuarios,
            ]);
        }

        return $this->render('form_editar_producto.html.twig', [
            'producto' => $producto,
            'categorias' => $categorias
        ]);
    }

    #[Route('/editar_categoria/{id}', name: 'editar_categoria')]
    public function editarCategoria(
        int $id,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $categoria = $entityManager->getRepository(Categoria::class)->find($id);

        if (!$categoria) {
            throw $this->createNotFoundException('Categoría no encontrada.');
        }

        if ($request->isMethod('POST')) {
            $categoria->setNombreCategoria($request->request->get('nombre_categoria'));
            $categoria->setDescripcionCategoria($request->request->get('descripcion_categoria'));

            $entityManager->persist($categoria);
            $entityManager->flush();

            // Redirección final en caso de tener éxito
            $productos = $entityManager->getRepository(Producto::class)->findAll();
            $categorias = $entityManager->getRepository(Categoria::class)->findAll();
            $usuarios = $entityManager->getRepository(Usuario::class)->findAll();

            return $this->render('admin.html.twig', [
                'productos' => $productos,
                'categorias' => $categorias,
                'usuarios' => $usuarios,
            ]);
        }

        return $this->render('form_editar_categoria.html.twig', ['categoria' => $categoria]);
    }
    

    // Las funciones para eliminar los registros
    #[Route('/admin/usuario/eliminar', name: 'admin_usuario_eliminar')]
    public function eliminarUsuario(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ids = json_decode($request->request->get('ids'), true); // Obtener los IDs

        if (empty($ids)) {
            return new JsonResponse(['success' => false, 'message' => 'No se han seleccionado usuarios.']);
        }

        // Buscar los usuarios a eliminar
        $usuarios = $entityManager->getRepository(Usuario::class)->findBy(['id_usuario' => $ids]);

        foreach ($usuarios as $usuario) {
            // Primero, eliminar las órdenes asociadas al usuario
            $ordenes = $entityManager->getRepository(Orden::class)->findBy(['usuario' => $usuario]);
            
            foreach ($ordenes as $orden) {
                $entityManager->remove($orden);
            }

            // Luego, eliminar el usuario
            $entityManager->remove($usuario);
        }

        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/admin/producto/eliminar', name: 'admin_producto_eliminar')]
    public function eliminarProducto(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ids = json_decode($request->request->get('ids'), true); // Obtener los IDs

        if (empty($ids)) {
            return new JsonResponse(['success' => false, 'message' => 'No se han seleccionado productos.']);
        }

        // Buscar los productos a eliminar
        $productos = $entityManager->getRepository(Producto::class)->findBy(['id_producto' => $ids]);

        foreach ($productos as $producto) {
            // Actualizar las órdenes para que no apunten al producto eliminado
            $ordenes = $entityManager->getRepository(Orden::class)->findBy(['producto' => $producto]);

            foreach ($ordenes as $orden) {
                $orden->setProducto(null); // Desvincular el producto en lugar de eliminar la orden
            }

            // Eliminar el producto
            $entityManager->remove($producto);
        }

        // Persistir los cambios en la base de datos
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/admin/categoria/eliminar', name: 'admin_categoria_eliminar')]
    public function eliminarCategoria(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ids = json_decode($request->request->get('ids'), true); // Obtener los IDs

    if (empty($ids)) {
        return new JsonResponse(['success' => false, 'message' => 'No se han seleccionado categorías.']);
    }

    $categorias = $entityManager->getRepository(Categoria::class)->findBy(['idCategoria' => $ids]);

    foreach ($categorias as $categoria) {
        // Obtener los productos asociados a la categoría
        $productos = $entityManager->getRepository(Producto::class)->findBy(['categoria' => $categoria]);

        foreach ($productos as $producto) {
            // Desvincular las órdenes relacionadas
            $ordenes = $entityManager->getRepository(Orden::class)->findBy(['producto' => $producto]);

            foreach ($ordenes as $orden) {
                $orden->setProducto(null); // Desvincular el producto de la orden
            }

            $entityManager->remove($producto); // Eliminar el producto
        }

        $entityManager->remove($categoria); // Finalmente eliminar la categoría
    }

    $entityManager->flush();

    return new JsonResponse(['success' => true]);

    }


    

    
}
