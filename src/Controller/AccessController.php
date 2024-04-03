<?php

namespace App\Controller;

use App\Entity\Access;
use App\Form\AccessType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccessController extends AbstractController
{
    #[Route('/access', name: 'app_access')]
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {

        $addaccess = new Access();

        $form = $this->createForm(AccessType::class, $addaccess);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addaccess = $form->getData();
            $entityManager->persist($addaccess);
            $entityManager->flush();
            $this->addFlash('success', "L'Access <strong>{$addaccess->getname()}</strong> a bien été enregistré");

            return $this->redirectToRoute('app_access');
        }

        $access = $entityManager->getRepository(Access::class)->findAll();
        $formEdit = [];
        foreach ($access as $accesss) {
            $formEdit[$accesss->getId()] = $this->createForm(AccessType::class, $accesss)->createView();
        }

        return $this->render('access/index.html.twig', [
            'controller_name' => 'AccessController',
            'current_menu' => 'access',
            'access' => $access,
            'form' => $form->createView(),
            'formedit' => $formEdit,
        ]);
    }

    #[Route('/access/edit/{id}', name: 'access_edit')]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $access = $entityManager->getRepository(Access::class)->find($id);

        if (!$access) {
            throw $this->createNotFoundException(
                "Pas d'access avec cette " . $id
            );
        }
        $form = $this->createForm(AccessType::class, $access);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', "L'Access <strong>{$access->getName()}</strong> a bien été modifié");
            return $this->redirectToRoute('app_access');
        }

        return $this->redirectToRoute('app_access', [
        ]);
    }

    #[Route('/access/delete/{id}', name: 'access_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): RedirectResponse
    {
        $access = $entityManager->getRepository(Access::class)->find($id);

        if (!$access) {
            throw $this->createNotFoundException(
                "Pas d'access avec cette " . $id
            );
        }

        $entityManager->remove($access);
        $entityManager->flush();
        $this->addFlash('success', "L'Access <strong>{$access->getName()}</strong> a bien été supprimé");

        return $this->redirectToRoute('app_access', [
        ]);
    }
}
