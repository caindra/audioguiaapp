<?php

namespace App\Controller;

use App\Repository\AudioguideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AudioguidesController extends AbstractController
{
    #[Route('/audioguides', name: 'audioguides')]
    public function list(
        EntityManagerInterface $entityManager,
        AudioguideRepository $audioguideRepository) : Response
    {
        $audioguides = $audioguideRepository->findAll();
        return $this->render('audioguides/list.html.twig', [
            'audios' => $audioguides
        ]);
    }

}