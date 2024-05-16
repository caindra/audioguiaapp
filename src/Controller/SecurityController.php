<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/entrar', name: 'app_login_es')]
    public function login(AuthenticationUtils $authenticationUtils) : Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastEmail = $authenticationUtils->getLastUsername();
        return $this->render('spanish/login.html.twig', [
            'last_email' => $lastEmail,
            'error' => $error
        ]);
    }
    #[Route(path: '/salir', name: 'app_logout_es')]
    public function logout(): void
    {
        throw new \LogicException('Este mensaje no debería de aparecer');
    }

    #[Route('/login', name: 'app_login_en')]
    public function loginEn(AuthenticationUtils $authenticationUtils) : Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastEmail = $authenticationUtils->getLastUsername();
        return $this->render('english/login.html.twig', [
            'last_email' => $lastEmail,
            'error' => $error
        ]);
    }
    #[Route(path: '/logout', name: 'app_logout_en')]
    public function logoutEn(): void
    {
        throw new \LogicException('This message should not be appearing before you');
    }
}