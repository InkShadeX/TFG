<?php 
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tarjeta;
use App\Entity\Usuario;
use App\Entity\Producto;
use App\Entity\Categoria;
use App\Entity\Orden;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ControladorLoginRegistro extends AbstractController {

    #[Route('/registro', name:'registro')]
    public function registro(){
        return $this->render('pagina_registro.html.twig');
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = "";

        if ($authenticationUtils->getLastAuthenticationError()) {
            $error = "Contrasena invalida";
        }
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('pagina_login.html.twig');
    }

    #[Route('/procesar_registro', name: 'procesar_registro', methods: ['POST'])]
    public function registrarUsuario(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Recoger datos del formulario
        $nombre = $request->request->get('usuario');
        $apellidos = $request->request->get('apellidos');
        $correo = $request->request->get('correo');
        $contrasena = $request->request->get('contrasena');
        $direccion = $request->request->get('direccion');
    
        // Comprobar si ya existe un usuario con el mismo correo
        $existingUser = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $correo]);
        if ($existingUser) {
            return $this->render('anuncio.html.twig', ["mensaje" => "El correo ya está registrado."]);
        }
    
        // Crear una nueva instancia de Usuario
        $usuario = new Usuario();
        $usuario->setNombreUsuario($nombre);
        $usuario->setApellidoUsuario($apellidos);
        $usuario->setEmail($correo);
        $usuario->setDireccion($direccion);
        $usuario->setRol(0);
    
        // Codificar la contraseña
        $hashedPassword = $passwordHasher->hashPassword($usuario, $contrasena);
        $usuario->setPassword($hashedPassword);
    
        // Guardar en la base de datos
        $entityManager->persist($usuario);
        $entityManager->flush();
    
        // Redirigir o mostrar un mensaje de éxito
        return $this->render('anuncio.html.twig', ["mensaje" => "Usuario registrado con éxito."]);
    }
    
    #[Route('/prueba', name:'prueba')]
    public function prueba(Request $request, EntityManagerInterface $entityManager): Response {    
        $usuario_prueba = $entityManager->getRepository(Usuario::class)->find(1)->getNombreUsuario();
        if ($usuario_prueba === null) {
            return $this->render('anuncio.html.twig', ["mensaje" => "El usuario no ha sido encontrado."]);
        }
        return $this->render('anuncio.html.twig', ["mensaje" => "Usuario: " . $usuario_prueba]);
    }
}

?>