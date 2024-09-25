<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControladorEmail extends AbstractController
{
    #[Route('/email', name: 'email')]
    public function index(Request $request): Response
    {
        $successMessage = '';

        if ($request->isMethod('POST')) {
            // Obtener los datos del formulario
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $message = $request->request->get('message');

            // Procesar los datos
            $successMessage = 'Mensaje enviado con éxito.';

            // Renderizar la vista con el mensaje de éxito
            return $this->render('mensaje.html.twig', [
                'successMessage' => $successMessage,
            ]);
        }

        // Renderizar la vista sin mensaje inicial
        return $this->render('mensaje.html.twig', [
            'successMessage' => '',
        ]);
    }
}
