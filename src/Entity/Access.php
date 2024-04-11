<?php

namespace App\Entity;

use App\Repository\AccessRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessRepository::class)]
class Access
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

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

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'accessid')]
    private Collection $accessid;

    public function __construct()
    {
        $this->accessid = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Reservation>
     */
    public function getAccessid(): Collection
    {
        return $this->accessid;
    }

    public function addAccessid(Reservation $accessid): static
    {
        if (!$this->accessid->contains($accessid)) {
            $this->accessid->add($accessid);
            $accessid->setAccessid($this);
        }

        return $this;
    }

    public function removeAccessid(Reservation $accessid): static
    {
        if ($this->accessid->removeElement($accessid)) {
            // set the owning side to null (unless already changed)
            if ($accessid->getAccessid() === $this) {
                $accessid->setAccessid(null);
            }
        }

        return $this;
    }
}
