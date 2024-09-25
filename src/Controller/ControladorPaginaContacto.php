<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ControladorPaginaContacto extends AbstractController
{
    #[Route('/Contacto', name: 'Contacto')]
    public function Contacto(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('nombre', TextType::class, ['label' => 'Nombre'])
            ->add('email', EmailType::class, ['label' => 'Correo Electrónico'])
            ->add('mensaje', TextareaType::class, ['label' => 'Mensaje'])
            ->add('enviar', SubmitType::class, ['label' => 'Enviar'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->addFlash('success', 'Mensaje enviado con éxito');

            return $this->redirectToRoute('contacto');
        }

        return $this->render('pagina_contacto.html.twig', ['form' => $form->createView()]);
    }
}

