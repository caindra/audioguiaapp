<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NewUserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'users')]
    final public function listUsers(
        UserRepository $userRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $query = $userRepository->findAll();
        $pagination = $paginator->paginate(
            $query, // query, NOT result
            $request->query->getInt('page', 1), // page number
            15 // limit per page
        );
        return $this->render('users/list.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/users/create', name: 'user_create')]
    final public function createUser(
        UserRepository $userRepository,
        Request $request,
    ): Response
    {
        $user = new User();
        $userRepository->add($user);
        $form = $this->createForm(NewUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $userRepository->add($user);
                $userRepository->save();
                $this->addFlash('success', 'Se ha creado con éxito');
                return $this->redirectToRoute('users');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido crear. Error: ' . $e->getMessage());
            }
        }

        return $this->render('users/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/users/modify/{id}', name: 'user_edit')]
    public function modifyUser(
        Request $request,
        User $user,
        UserRepository $userRepository,
    ): Response {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $userRepository->save();
                $this->addFlash('success', 'La modificación se ha realizado correctamente');
                return $this->redirectToRoute('users');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido aplicar las modificaciones. Error: ' . $e->getMessage());
            }
        }
        return $this->render('users/modify.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/users/delete/{id}', name: 'user_delete')]
    final public function deleteUser(
        User $user,
        UserRepository $userRepository,
        Request $request
    ): Response
    {
        if ($request->request->has('confirmar')) {
            try {
                $userRepository->remove($user);
                $userRepository->save();
                $this->addFlash('success', 'El usuario ha sido eliminada con éxito');
                return $this->redirectToRoute('users');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar al usuario. Error: ' . $e->getMessage());
            }
        }

        return $this->render('users/delete.html.twig', [
            'user' => $user
        ]);
    }
}

