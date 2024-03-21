<?php

namespace App\Controller;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(EntityManagerInterface $em): Response
    {
        $reservation = $em->getRepository(Reservation::class)->findAll();
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'current_menu' => 'reservation',
            'reservation' => $reservation,
        ]);
    }
}
