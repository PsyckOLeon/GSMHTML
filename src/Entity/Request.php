<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Controller\RequestController;
use App\Repository\RequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestRepository::class)]
#[ApiResource(operations: [
    new Get(
        uriTemplate: '/request/{telephone}',
        requirements: ['telephone' => '\d+'],
        options: ['my_option' => 'my_option_value'],
        controller: RequestController::class,
        name: 'request'
    )],)]
class Request
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
