<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index() : Response
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('main/index.html.twig');
    }

}