<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Entity\Access;
use App\Entity\Request;
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
    #[Route(path: '/api/request/{telephone}', name: 'app_request', methods: ['GET'], defaults: [
        '_api_resource_class' => Request::class,
        '_api_operation_name' => '_api_/request/{telephone}',
    ],)]
    #[ApiResource(operations: [
        new Get(
            uriTemplate: '/request/{telephone}',
            requirements: ['telephone' => '\d+'],
            options: ['my_option' => 'my_option_value'],
            name: 'request'
        )],)]
    public function getUserByTelephone(string $telephone, EntityManagerInterface $entityManager): JsonResponse
    {
        $access = $entityManager->getRepository(Access::class)->findAll();
        $reservation = $entityManager->getRepository(Reservation::class)->findAll();
        $user = $entityManager->getRepository(User::class)->findAll();
        $lastname = 0;
        $firstname = 0;
        $date_debut = 0;
        $date_fin = 0;
        $heure = 0;
        $duree = 0;
        $cycle = 0;
        $designation = 0;
        foreach ($user as $users) {
            if ($users->getPhoneNumber() == $telephone) {
                $firstname = $users->getFirstname();
                $lastname = $users->getLastname();
                $userid = $users->getUserid();
                foreach ($reservation as $reservations) {
                    if ($userid == $reservations->getUserid()) {
                        $date_debut = $reservations->getStartDate();
                        $date_fin = $reservations->getEndDate();
                        $heure = $reservations->getStartTime();
                        $duree = ($reservations->getEndTime()) - $heure;
                        $cycle = $reservations->getCycle();
                        foreach ($access as $accesss) {
                            if ($reservations->getAccessid() == $accesss->getAccessid()) {
                                $designation = $accesss->getName();
                            }
                        }
                    }
                }
            }
        }
        $data = [
            'tel' => $telephone,
            'nom' => $lastname,
            'prenom' => $firstname,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'heure' => $heure,
            'duree' => $duree,
            'cycle' => $cycle,
            'designation' => $designation,
        ];

        return new JsonResponse($data);
    }
}

