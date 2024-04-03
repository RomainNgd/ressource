<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Patch;
use App\Controller\AcceptCommentController;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ApiResource(
    new Patch(
        uriTemplate: '/comment/accept/{id}',
        controller: AcceptCommentController::class,
        openapiContext: [
            'summary' => 'Accept a comment by a moderator',
            'requestBody' => [
                'content' => [
                    'application/merge-patch+json' => []
                ]
            ]
        ],
        description: 'Accept a ressource by a moderator (must have role moderator)',
        normalizationContext: ['groups' => ['ressource:accept']],
        read: false,
        name: 'accept'
    ),
)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:ressource:item"])]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ressource $ressource = null;

    #[ORM\Column]
    private ?bool $accepted = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[Groups(["read:ressource:item"])]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $deletedAt = null;

    public function __construct(
        #[ORM\Column]
        #[Groups(["read:ressource:item"])]
        private \DateTime $createdAt = new \DateTime()
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    public function isAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(bool $accepted): static
    {
        $this->accepted = $accepted;

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

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTime $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
