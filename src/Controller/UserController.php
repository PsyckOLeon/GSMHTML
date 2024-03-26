<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserControllerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'current_menu' => 'user',
            'user' => $user,
        ]);
    }
    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function update(EntityManagerInterface $entityManager, Request $request,int $id): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                "Pas d'utilisateur avec cette ".$id
            );
        }
        $form = $this->createForm(UserControllerType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', "L'Utilisateur <strong>{$user->getFirstname()}</strong> a bien été modifié");
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/edit.html.twig', [
            'current_menu' => 'user',
            'form' => $form->createView()]);
    }

    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
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
