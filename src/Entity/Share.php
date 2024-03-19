<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ShareRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShareRepository::class)]
#[ApiResource]
class Share
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'shares')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $sender = null;

    #[ORM\ManyToOne(inversedBy: 'shares')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $recipient = null;

    #[ORM\ManyToOne(inversedBy: 'shares')]
    private ?Ressource $ressource = null;


    public function __construct(
        #[ORM\Column]
        private \DateTime $sharedAt = new \DateTime()
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSharedAt(): \DateTime
    {
        return $this->sharedAt;
    }

    public function setSharedAt(\DateTime $sharedAt): static
    {
        $this->sharedAt = $sharedAt;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?User
    {
        return $this->recipient;
    }

    public function setRecipient(?User $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getRessource(): ?Ressource
    {
        return $this->ressource;
    }

    public function setRessource(?Ressource $ressource): static
    {
        $this->ressource = $ressource;

        return $this;
    }
}
