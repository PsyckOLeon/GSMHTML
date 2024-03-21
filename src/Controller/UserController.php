<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
