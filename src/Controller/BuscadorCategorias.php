<?php
// src/Controller/CategoriaController.php
namespace App\Controller;

use App\Entity\Categoria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BuscadorCategorias extends AbstractController
{
    public function buscarCategorias(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $query = $request->query->get('q', '');
        
        // Buscar las categorías que coincidan con el texto ingresado
        $categorias = $em->getRepository(Categoria::class)->createQueryBuilder('c')
            ->where('c.nombre LIKE :nombre')
            ->setParameter('nombre', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        // Convertir el resultado en un formato JSON
        $resultados = [];
        foreach ($categorias as $categoria) {
            $resultados[] = ['nombre' => $categoria->getNombre()];
        }

        return new JsonResponse($resultados);
    }
}
