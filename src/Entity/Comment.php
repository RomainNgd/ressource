<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\AcceptCommentController;
use App\Controller\CommentCreateController;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ApiResource(
    operations: [
        new Patch(
            uriTemplate: '/comments/accept/{id}',
            controller: AcceptCommentController::class,
            openapiContext: [
                'summary' => 'Accept a comment by a moderator',
                'requestBody' => [
                    'content' => [
                        'application/merge-patch+json' => []
                    ]
                ]
            ],
            description: 'Accept a comment by a moderator (must have role moderator)',
            normalizationContext: ['groups' => ['comment:accept']],
            name: 'comment accept'
        ),
    ],
    normalizationContext: ['read:comment:collection','read:comment:item'],
    denormalizationContext: ["create:comment:item"]
)]
#[GetCollection(denormalizationContext: ['read:comment:collection'])]
#[Get(normalizationContext: ['read:comment:collection','read:comment:item'])]
#[Post(
    controller: CommentCreateController::class,
    openapiContext: [
        'summary' => 'Create Ressource',
        'requestBody' => [
            'content' => [
                'json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'ressourceType' => [
                                'type' => 'string',
                                'example' => '/api/ressource_types/{id}' ,
                            ],
                            'content' => [
                                'type' => 'string',
                                'example' => 'Lorem ipsum dolor set amet',
                            ],
                        ],
                    ]
                ]
            ]
        ]
    ],
    normalizationContext: [ 'read:comment:collection','read:comment:item'],
    denormalizationContext: ["create:comment:item"]
)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:ressource:item", 'create:comment:item'])]
    #[Assert\NotBlank(message: 'Le contenue est obligatoire')]
    #[Assert\Length(min: 1, max: 255, minMessage: 'Le contenue doit faire au minimum {{ limit }} caractère', maxMessage: 'Le titre doit faire au maximum {{ limit }} caractère')]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['create:comment:item'])]
    private Ressource $ressource;

    #[ORM\Column]
    #[Groups(["comment:accept"])]
    private bool $accepted = false;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[Groups(["read:ressource:item", 'read:comment:collection'])]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $deletedAt = null;

    public function __construct(
        #[ORM\Column]
        #[Groups(["read:ressource:item", 'read:comment:item'])]
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

    public function getRessource(): Ressource
    {
        return $this->ressource;
    }

    public function setRessource(Ressource $ressource): static
    {
        $this->ressource = $ressource;

        return $this;
    }

    public function isAccepted(): bool
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
