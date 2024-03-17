<?php

namespace App\Entity;

use App\Repository\LoginAttempsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoginAttempsRepository::class)]
class LoginAttemps
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $tryAt = null;

    #[ORM\ManyToOne(inversedBy: 'loginAttemps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTryAt(): ?\DateTimeImmutable
    {
        return $this->tryAt;
    }

    public function setTryAt(\DateTimeImmutable $tryAt): static
    {
        $this->tryAt = $tryAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
