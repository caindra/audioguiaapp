<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'cover')]
    public function cover() : Response
    {
        return $this->render('spanish/cover.html.twig');
    }

    #[Route('/english', name: 'cover_english')]
    public function coverEnglish() : Response
    {
        return $this->render('english/cover.html.twig');
    }
}