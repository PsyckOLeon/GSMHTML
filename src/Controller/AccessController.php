<?php

namespace App\Controller;

use App\Entity\Access;
use App\Form\AccessControllerType;
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
        // Ajout
        $addaccess = new Access();
        /*        $form = $this->createFormBuilder($article)
                    ->add('name', TextType::class)
                    ->add('price', TextType::class)
                    ->add('save', SubmitType::class, array('label' => 'Ajouter un article')
                    )->getForm();*/

        $form = $this->createForm(AccessControllerType::class, $addaccess);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addaccess = $form->getData();
            $entityManager->persist($addaccess);
            $entityManager->flush();
            $this->addFlash('success', "L'Access <strong>{$addaccess->getname()}</strong> a bien été enregistré");

            return $this->redirectToRoute('app_access');
        }
        // Fin Ajout
        // Modification
        $access = $entityManager->getRepository(Access::class)->findAll();
        return $this->render('access/index.html.twig', [
            'controller_name' => 'AccessController',
            'current_menu' => 'access',
            'access' => $access,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/access/edit/{id}', name: 'access_edit')]
    public function update(EntityManagerInterface $entityManager, Request $request,int $id): Response
    {
        $access = $entityManager->getRepository(Access::class)->find($id);

        if (!$access) {
            throw $this->createNotFoundException(
                "Pas d'utilisateur avec cette ".$id
            );
        }
        $form = $this->createForm(AccessControllerType::class, $access);

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
                "Pas d'utilisateur avec cette ".$id
            );
        }

        $entityManager->remove($access);
        $entityManager->flush();
        $this->addFlash('success', "L'Access <strong>{$access->getName()}</strong> a bien été supprimé");

        return $this->redirectToRoute('app_access', [
        ]);
    }
}
