<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AccessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessRepository::class)]
#[ApiResource]
class Access
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $fingerprint = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?int $port1 = null;

    #[ORM\Column]
    private ?int $port2 = null;

    #[ORM\Column]
    private ?int $port3 = null;

    #[ORM\Column]
    private ?int $port4 = null;

    #[ORM\Column]
    private ?int $port5 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFingerprint(): ?string
    {
        return $this->fingerprint;
    }

    public function setFingerprint(string $fingerprint): static
    {
        $this->fingerprint = $fingerprint;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPort1(): ?int
    {
        return $this->port1;
    }

    public function setPort1(int $port1): static
    {
        $this->port1 = $port1;

        return $this;
    }

    public function getPort2(): ?int
    {
        return $this->port2;
    }

    public function setPort2(int $port2): static
    {
        $this->port2 = $port2;

        return $this;
    }

    public function getPort3(): ?int
    {
        return $this->port3;
    }

    public function setPort3(int $port3): static
    {
        $this->port3 = $port3;

        return $this;
    }

    public function getPort4(): ?int
    {
        return $this->port4;
    }

    public function setPort4(int $port4): static
    {
        $this->port4 = $port4;

        return $this;
    }

    public function getPort5(): ?int
    {
        return $this->port5;
    }

    public function setPort5(int $port5): static
    {
        $this->port5 = $port5;

        return $this;
    }
}
