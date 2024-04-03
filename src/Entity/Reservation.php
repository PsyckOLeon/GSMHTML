<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Controller\RequestController;
use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource
(
    operations: [
        new Get(
            uriTemplate: '/request/{telephone}',
            controller: RequestController::class,
            openapiContext: [
                'summary' => 'Get user reservations by telephone',
                'parameters' => [
                    [
                        'name' => 'telephone',
                        'in' => 'path',
                        'required' => true,
                        'description' => 'User telephone number',
                        'schema' => [
                            'type' => 'string',
                        ],
                    ],
                    [
                        'name' => 'id',
                        'in' => 'path',
                        'required' => false,
                        'description' => 'Ignored',
                        'schema' => [
                            'type' => 'string',
                            'default' => 'ignored',
                        ],
                    ],
                ],
            ],
            output: false,
            read: false,
        ),
    ]
)
]
#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column]
    private ?int $start_time = null;

    #[ORM\Column]
    private ?int $end_time = null;

    #[ORM\Column]
    private ?int $cycle = null;

    #[ORM\ManyToOne(inversedBy: 'userid')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userid = null;

    #[ORM\ManyToOne(inversedBy: 'accessid')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Access $accessid = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getStartTime(): ?int
    {
        return $this->start_time;
    }

    public function setStartTime(int $start_time): static
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?int
    {
        return $this->end_time;
    }

    public function setEndTime(int $end_time): static
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getCycle(): ?int
    {
        return $this->cycle;
    }

    public function setCycle(int $cycle): static
    {
        $this->cycle = $cycle;

        return $this;
    }

    public function getUserid(): ?User
    {
        return $this->userid;
    }

    public function setUserid(?User $userid): static
    {
        $this->userid = $userid;

        return $this;
    }

    public function getAccessid(): ?Access
    {
        return $this->accessid;
    }

    public function setAccessid(?Access $accessid): static
    {
        $this->accessid = $accessid;

        return $this;
    }
}
