<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $phone_number = null;

    #[ORM\Column]
    private ?int $permission = null;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'userid')]
    private Collection $userid;

    public function __construct()
    {
        $this->userid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getPermission(): ?int
    {
        return $this->permission;
    }

    public function setPermission(int $permission): static
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getUserid(): Collection
    {
        return $this->userid;
    }

    public function addUserid(Reservation $userid): static
    {
        if (!$this->userid->contains($userid)) {
            $this->userid->add($userid);
            $userid->setUserid($this);
        }

        return $this;
    }

    public function removeUserid(Reservation $userid): static
    {
        if ($this->userid->removeElement($userid)) {
            // set the owning side to null (unless already changed)
            if ($userid->getUserid() === $this) {
                $userid->setUserid(null);
            }
        }

        return $this;
    }
}
