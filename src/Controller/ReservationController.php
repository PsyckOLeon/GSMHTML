<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {

        $addreservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $addreservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addreservation = $form->getData();
            $entityManager->persist($addreservation);
            $entityManager->flush();
            $this->addFlash('success', "La réservation <strong>{$addreservation->getLocation()}</strong> a bien été enregistré");

            return $this->redirectToRoute('app_reservation');
        }

        $reservation = $entityManager->getRepository(Reservation::class)->findAll();
        $formEdit = [];
        foreach ($reservation as $reservations) {
            $formEdit[$reservations->getId()] = $this->createForm(ReservationType::class, $reservations)->createView();
        }

        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'current_menu' => 'reservation',
            'reservation' => $reservation,
            'form' => $form->createView(),
            'formedit' => $formEdit,
        ]);
    }

    #[Route('/reservation/edit/{id}', name: 'reservation_edit')]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $reservation = $entityManager->getRepository(Reservation::class)->find($id);

        if (!$reservation) {
            throw $this->createNotFoundException(
                "Pas de reservation avec cette " . $id
            );
        }
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('info', "La réservation <strong>{$reservation->getLocation()}</strong> a bien été modifié");
            return $this->redirectToRoute('app_reservation');
        }

        return $this->redirectToRoute('app_reservation', [
        ]);
    }

    #[Route('/reservation/delete/{id}', name: 'reservation_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): RedirectResponse
    {
        $reservation = $entityManager->getRepository(Reservation::class)->find($id);

        if (!$reservation) {
            throw $this->createNotFoundException(
                "Pas de réservation avec cette " . $id
            );
        }

        $entityManager->remove($reservation);
        $entityManager->flush();
        $this->addFlash('warning', "La réservation <strong>{$reservation->getLocation()}</strong> a bien été supprimé");

        return $this->redirectToRoute('app_reservation', [
        ]);
    }
}
