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

    #[Route('/user/new', name: 'user_new')]
    public function create(UserRepository $userRepository, Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(NewUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $userRepository->add($user);
                $this->addFlash('success', 'El usuario ha sido creado con éxito.');
                return $this->redirectToRoute('users');
            } catch (\Exception $e) {
                $this->addFlash('error', 'El usuario no pudo ser creado. Error: ' . $e->getMessage());
            }
        }

        return $this->render('users/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function edit(
        User $user,
        UserRepository $userRepository,
        Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $userRepository->save();
                $this->addFlash('success', 'The user has been edited successfully.');
                return $this->redirectToRoute('users');
            } catch (\Exception $e) {
                $this->addFlash('error', 'The modifications could not be applied. Error: ' . $e->getMessage());
            }
        }

        return $this->render('users/modify.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function delete(
        User $user,
        UserRepository $userRepository,
        Request $request): Response
    {
        if ($request->request->has('confirm')) {
            try {
                $userRepository->remove($user);
                $this->addFlash('success', 'The user has been deleted successfully.');
                return $this->redirectToRoute('users');
            } catch (\Exception $e) {
                $this->addFlash('error', 'The user could not be deleted. Error: ' . $e->getMessage());
            }
        }

        return $this->render('users/delete.html.twig', [
            'user' => $user
        ]);
    }
}

