<?php

namespace App\Controller;

use App\Entity\Access;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccessController extends AbstractController
{
    #[Route('/access', name: 'app_access')]
    public function index(EntityManagerInterface $em): Response
    {
        $access = $em->getRepository(Access::class)->findAll();
        return $this->render('access/index.html.twig', [
            'controller_name' => 'AccessController',
            'current_menu' => 'access',
            'access' => $access,
        ]);
    }
}
