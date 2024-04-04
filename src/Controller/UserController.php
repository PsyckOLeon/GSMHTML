<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
        $adduser = new User();

        $form = $this->createForm(UserType::class, $adduser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adduser = $form->getData();
            $entityManager->persist($adduser);
            $entityManager->flush();
            $this->addFlash('success', "L'utilisateur <strong>{$adduser->getname()}</strong> a bien été enregistré");

            return $this->redirectToRoute('app_access');
        }

        $user = $entityManager->getRepository(User::class)->findAll();
        $formEdit = [];
        foreach ($user as $users) {
            $formEdit[$users->getId()] = $this->createForm(UserType::class, $users)->createView();
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'current_menu' => 'user',
            'user' => $user,
            'form' => $form->createView(),
            'formedit' => $formEdit,
        ]);
    }

    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $user = $entityManager->getRepository(Access::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                "Pas d'access avec cette " . $id
            );
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', "L'User <strong>{$user->getName()}</strong> a bien été modifié");
            return $this->redirectToRoute('app_user');
        }

        return $this->redirectToRoute('app_user', [
        ]);
    }
    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): RedirectResponse
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                "Pas d'utilisateur avec cette ".$id
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('success', "L'Utilisateur <strong>{$user->getFirstname()} {$user->getLastname()} {$user->getPhoneNumber()}</strong> a bien été supprimé");

        return $this->redirectToRoute('app_user', [
        ]);
    }
}
