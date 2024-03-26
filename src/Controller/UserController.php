<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserControllerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'current_menu' => 'user',
            'user' => $user,
        ]);
    }

    #[Route('/user/add', name: 'user_add')]
    public function add(EntityManagerInterface $entityManager,Request $request)
    {
        $user = new User();
        /*        $form = $this->createFormBuilder($article)
                    ->add('name', TextType::class)
                    ->add('price', TextType::class)
                    ->add('save', SubmitType::class, array('label' => 'Ajouter un article')
                    )->getForm();*/

        $form = $this->createForm(UserControllerType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', "L'Utilisateur <strong>{$user->getFirstname()}</strong> a bien été enregistré");

            return $this->redirectToRoute('app_user');
        }
        return $this->render('user/add.html.twig', [
            'current_menu' => 'user',
            'form' => $form->createView()]);
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
