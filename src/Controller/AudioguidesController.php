<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AudioguidesController extends AbstractController
{
    #[Route('/audioguides', name: 'audioguides')]
    public function list() : Response
    {

        return $this->render('audioguides/list.html.twig');
    }
}