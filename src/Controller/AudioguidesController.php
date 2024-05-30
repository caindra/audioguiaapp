<?php

namespace App\Controller;

use App\Entity\Audioguide;
use App\Repository\AudioguideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class AudioguidesController extends AbstractController
{
    #[Route('/audioguides', name: 'audioguides')]
    public function list(
        Request $request,
        AudioGuideRepository $audioGuideRepository,
        SessionInterface $session
    ): Response {
        // Obtener el idioma de la sesión, por defecto 'es'
        $language = $session->get('language', 'es');

        // Si hay una solicitud de cambio de idioma, actualizar la sesión
        if ($request->query->has('lang')) {
            $language = $request->query->get('lang');
            $session->set('language', $language);
        }

        // Establecer el idioma para la internacionalización
        $request->setLocale($language);

        // Obtener los audios de la base de datos
        $audios = $audioGuideRepository->findAll();

        // Renderizar la plantilla con los datos necesarios
        return $this->render('audioguides/list.html.twig', [
            'audios' => $audios,
            'language' => $language,
        ]);
    }

    #[Route('/audio/image/{id}', name: 'audio_image')]
    public function getLayoutAction(Audioguide $audioguide): Response
    {
        $callback = function () use ($audioguide) {
            echo stream_get_contents($audioguide->getImage());
        };

        $response = new StreamedResponse($callback);
        $response->headers->set('Content-Type', 'image/png');
        return $response;
    }

    #[Route('/audioguides/create', name: 'create_audioguide')]
    final public function createTemplate(
        AudioguideRepository $audioguideRepository,
        Request $request,
    ): Response
    {
        $audioguide = new Audioguide();
        $audioguideRepository->add($audioguide);
        $form = $this->createForm(NewAudioguideType::class, $audioguide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $layoutFile = $form->get('layout')->getData();

            if ($layoutFile) {
                $layoutStream = fopen($layoutFile->getRealPath(), 'rb');
                $audioguide->setImage(stream_get_contents($layoutStream));
                fclose($layoutStream);
            }

            try {
                $audioguideRepository->add($audioguide);
                $audioguideRepository->save();
                $this->addFlash('success', 'Se ha creado la audioguía con éxito');
                return $this->redirectToRoute('audioguides');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido crear la audioguía. Error: ' . $e->getMessage());
            }
        }

        return $this->render('audioguides/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/templates/modify/{id}', name: 'modify_audioguide')]
    public function modifyTemplate(
        Request $request,
        AudioguideRepository $audioguideRepository,
        Audioguide $audioguide
    ): Response {
        $form = $this->createForm(AudioguideType::class, $audioguide);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $layoutFile = $form->get('layout')->getData();
            if ($layoutFile) {
                $layoutStream = fopen($layoutFile->getRealPath(), 'rb');
                $audioguide->setImage(stream_get_contents($layoutStream));
                fclose($layoutStream);
            }
            try {
                $audioguideRepository->save();
                $this->addFlash('success', 'La modificación se ha realizado correctamente');
                return $this->redirectToRoute('audioguides');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido aplicar las modificaciones. Error: ' . $e->getMessage());
            }
        }
        return $this->render('audioguides/modify.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/templates/delete/{id}', name: 'delete_audioguide')]
    final public function deleteTemplate(
        AudioguideRepository $audioguideRepository,
        Audioguide $audioguide,
        Request $request
    ): Response
    {
        if ($request->request->has('confirmar')) {
            try{
                $audioguideRepository->remove($audioguide);
                $audioguideRepository->save();
                $this->addFlash('success', 'La audioguía ha sido eliminada con éxito');
                return $this->redirectToRoute('audioguides');
            }catch (\Exception $e){
                $this->addFlash('error', 'No se ha podido eliminar la audioguía. Error: ' . $e);
            }
        }

        return $this->render('audioguides/delete.html.twig', [
            'user' => $audioguide
        ]);
    }

}