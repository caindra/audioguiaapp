<?php

namespace App\Controller;

use App\Repository\AudioguideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AudioguidesController extends AbstractController
{
    #[Route('/audioguides', name: 'audioguides')]
    public function list(
        Request $request,
        AudioGuideRepository $audioGuideRepository,
        SessionInterface $session) : Response
    {
        // Obtener el idioma de la sesión, por defecto 'es'
        $language = $session->get('language', 'es');

        // Si hay una solicitud de cambio de idioma, actualizar la sesión
        if ($request->query->has('lang')) {
            $language = $request->query->get('lang');
            $session->set('language', $language);
        }

        // Obtener los audios de la base de datos
        $audios = $audioGuideRepository->findAll();

        return $this->render('audioguides/list.html.twig', [
            'audios' => $audios,
            'language' => $language,
        ]);
    }

}