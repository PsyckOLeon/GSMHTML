<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Entity\Access;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Reservation;

#[AsController]
class RequestController extends AbstractController
{
    #[Route(path: '/api/request/{telephone}', name: 'app_request', methods: ['GET'])]
    public function getUserByTelephone(string $telephone, EntityManagerInterface $entityManager): JsonResponse
    {
        $userRepository = $entityManager->getRepository(User::class);
        $reservationRepository = $entityManager->getRepository(Reservation::class);
        $accessRepository = $entityManager->getRepository(Access::class);

        $user = $userRepository->findOneBy(['phone_number' => $telephone]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found for telephone number: ' . $telephone], JsonResponse::HTTP_NOT_FOUND);
        }

        $reservations = $reservationRepository->findBy(['userid' => $user->getId()]);

        if (empty($reservations)) {
            return new JsonResponse(['error' => 'No reservations found for user with telephone number: ' . $telephone], JsonResponse::HTTP_NOT_FOUND);
        }

        $reservationData = [];
        foreach ($reservations as $reservation) {
            $access = $accessRepository->findOneBy(['id' => $reservation->getAccessId()]);
            $reservationData[] = [
                'startDate' => $reservation->getStartDate(),
                'endDate' => $reservation->getEndDate(),
                'startTime' => $reservation->getStartTime(),
                'endTime' => $reservation->getEndTime(),
                'cycle' => $reservation->getCycle(),
                'designation' => $access['name'],
            ];
        }

        $userData = [
            'tel' => $telephone,
            'nom' => $user->getLastname(),
            'prenom' => $user->getFirstname(),
            'reservations' => $reservationData,
        ];

        return new JsonResponse($userData);
    }
}

