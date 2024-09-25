<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categoria;
use Doctrine\ORM\EntityManagerInterface;

class ControladorPaginaInicio extends AbstractController
{

    #[Route('/PaginaInicio', name: 'PaginaInicio')]
    public function PaginaInicio(EntityManagerInterface $entityManager)
    {
        // Obtener el repositorio de la entidad Categoria
        $categorias = $entityManager->getRepository(Categoria::class)->findAll();

        // Pasar las categorías a la vista
        return $this->render('pagina_principal.html.twig', ['categorias' => $categorias,]);
    }
}
