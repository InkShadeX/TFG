<?php
// src/Controller/AboutUsController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AboutUsController extends AbstractController
{
    #[Route('/AboutUS', name: 'AboutUS')]
    public function AboutUS(){
        return $this->render('AboutUs.html.twig');
    }

}