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
        $error = $authenticationUtils->getLastAuthenticationError();
        $mensaje = $error ? "Usuario o Contraseña inválida" : null;

        return $this->render('pagina_login.html.twig', [
            'mensaje' => $mensaje,
        ]);
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
            return $this->render('pagina_login.html.twig', ["mensaje" => "El correo o usuario ya está registrado."]);
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
        return $this->render('pagina_login.html.twig', ["mensaje" => "Usuario registrado con éxito."]);
    }

    #[Route('/pagina_principal', name:'pagina_principal')]
    public function pagina_principal(Request $request, EntityManagerInterface $entityManager): Response {    
        
        if ($this->getUser() == null) {
            return $this->render("anuncio_error.html.twig", [ "mensaje" => "Si no estás logeado, no puedes acceder :(" ]);
        }
        else {
            // Obtiene el usuario autenticado
            $user = $this->getUser(); 

            // Obtener el repositorio de la entidad Categoria
            $categorias = $entityManager->getRepository(Categoria::class)->findAll();

            // Pasar las categorías a la vista
            return $this->render('pagina_principal.html.twig', ['categorias' => $categorias, 'user' => $user]);
        }
    }

    #[Route('/logout', name:'ctrl_logout')]
    public function logout(){    
        return new Response();
    }
}

?>