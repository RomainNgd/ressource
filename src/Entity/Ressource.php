<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\AcceptRessourceController;
use App\Controller\RessourceController;
use App\Repository\RessourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\Entity(repositoryClass: RessourceRepository::class)]
#[Uploadable]
#[ApiResource(
    operations: [
        new Patch(
            uriTemplate: '/ressources/accept/{id}',
            controller: AcceptRessourceController::class,
            openapiContext: [
                'summary' => 'Accept a ressource by a moderator',
                'requestBody' => [
                    'content' => [
                        'application/merge-patch+json' => []
                    ]
]
            ],
            description: 'Accept a ressource by a moderator (must have role moderator)',
            normalizationContext: ['groups' => ['ressource:accept']],
            read: false,
            name: 'accept ressource'
        ),
    ],
    normalizationContext: ['groups' => ['read:ressource:collection']],
    denormalizationContext: ['groups' => ['create:ressource:item']],
    paginationClientEnabled: true,
    paginationClientItemsPerPage: 30,
    paginationItemsPerPage: 30,

)]
#[GetCollection(
    normalizationContext : ['groups' => 'read:ressource:collection']
)]
#[Get(
    normalizationContext : ['groups' => ['read:ressource:collection', 'read:ressource:item']]
)]
#[Patch(
    inputFormats: ['multipart' => ['multipart/form-data']],
    controller: RessourceController::class,
    openapiContext: [
        'summary' => 'Create Ressource',
        'requestBody' => [
            'content' => [
                'multipart/form-data' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'file' => [
                                'type' => 'string',
                                'format' => 'binary',
                            ],
                            'title' => [
                                'type' => 'string',
                            ],
                            'description' => [
                                'type' => 'string',
                            ],
                            'content' => [
                                'type' => 'string',
                            ],
                            'ressourceType' => [
                                'type' => 'string',
                                'example' => '/api/ressource_types/{id}' ,
                            ],
                            'relationType' => [
                                'type' => 'string',
                                'example' => '/api/relation_types/{id}'
                            ],
                            'ressourceCategory' => [
                                'type' => 'string',
                                'example' => '/api/ressource_categories/{id}'
                            ],
                            'visible' => [
                                'type' => 'boolean',
                            ],
                        ]
                    ]
                ]
            ]
        ]
    ],
    normalizationContext: ['groups' => ['read:ressource:collection']],
    denormalizationContext: ['groups' => ['update:ressource:item']],
)]
#[Post(
    inputFormats: ['multipart' => ['multipart/form-data']],
    controller: RessourceController::class,
    openapiContext: [
        'summary' => 'Create Ressource',
        'requestBody' => [
            'content' => [
                'multipart/form-data' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'file' => [
                                'type' => 'string',
                                'format' => 'binary',
                            ],
                            'title' => [
                                'type' => 'string',
                            ],
                            'description' => [
                                'type' => 'string',
                            ],
                            'content' => [
                                'type' => 'string',
                            ],
                            'ressourceType' => [
                                'type' => 'string',
                                'example' => '/api/ressource_types/{id}' ,
                            ],
                            'visible' => [
                                'type' => 'boolean',
                            ],
                            'relationType' => [
                                'type' => 'string',
                                'example' => '/api/relation_types/{id}'
                            ],
                            'ressourceCategory' => [
                                'type' => 'string',
                                'example' => '/api/ressource_categories/{id}'
                            ],
                        ]
                    ]
                ]
            ]
        ]
    ],
    normalizationContext: ['groups' => ['read:ressource:collection']],
    denormalizationContext: ['groups' => ['create:ressource:item']],
)]
#[ApiFilter(BooleanFilter::class, properties: ['visible', 'accepted'])]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
#[ApiFilter(SearchFilter::class, properties: ['ressourceType.title' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['updatedAt'], arguments: ['orderParameterName'=>'order'])]
class Ressource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:ressource:collection"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:ressource:collection", 'update:ressource:item','create:ressource:item', 'read:favorite:collection'])]
    #[Assert\NotBlank(message: 'Le titre est obligatoire')]
    #[Assert\Length(min: 1, max: 255, minMessage: 'Le titre doit faire au minimum {{ limit }} caractère', maxMessage: 'Le titre doit faire au maximum {{ limit }} caractère')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["read:ressource:collection",'update:ressource:item', 'create:ressource:item', 'read:favorite:collection'])]
    private string $description = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["read:ressource:item", 'update:ressource:item', 'create:ressource:item'])]
    private string $content = '';

    #[ORM\ManyToOne(inversedBy: 'Ressources')]
    #[Groups(["read:ressource:collection", 'update:ressource:item', 'create:ressource:item'])]
    private ?RessourceType $ressourceType = null;

    #[ORM\Column]
    #[Groups(['update:ressource:item', 'create:ressource:item', 'read:ressource:collection'])]
    private bool $visible = false;

    #[ORM\Column]
    #[Groups(['update:ressource:item', 'ressource:accept'])]
    private bool $accepted = false;

    #[ORM\ManyToOne(inversedBy: 'ressources')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:ressource:collection"])]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'ressource')]
    #[Groups(["read:ressource:item"])]
    private Collection $comments;

    #[ORM\OneToMany(targetEntity: Share::class, mappedBy: 'ressource')]
    private Collection $shares;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filePath = null;

    #[Groups(["read:ressource:collection", 'read:favorite:collection'])]
    public ?string $fileUrl = null;

    #[UploadableField(mapping: 'ressources_image', fileNameProperty: "filePath")]
    #[Groups(['create:ressource:item'])]
    private ?File $file = null;

    #[ORM\ManyToOne(inversedBy: 'Ressources')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:ressource:collection",'update:ressource:item', 'create:ressource:item'])]
    private RessourceCategory $ressourceCategory;

    #[ORM\ManyToOne(inversedBy: 'Ressources')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:ressource:collection",'update:ressource:item', 'create:ressource:item'])]
    private RelationType $relationType;

    #[ORM\OneToMany(targetEntity: Favorite::class, mappedBy: 'Ressource')]
    private Collection $favorites;

    public function __construct(
        #[ORM\Column]
        private \DateTime $createdAt = new \DateTime(),
        #[ORM\Column(nullable: true)]
        #[Groups(["read:ressource:collection"])]
        private \DateTime $updateAt = new \DateTime()
    )
    {
        $this->comments = new ArrayCollection();
        $this->shares = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getRessourceType(): ?RessourceType
    {
        return $this->ressourceType;
    }

    public function setRessourceType(?RessourceType $ressourceType): static
    {
        $this->ressourceType = $ressourceType;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

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

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTime
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTime $updateAt): static
    {
        $this->updateAt = $updateAt;

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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setRessource($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRessource() === $this) {
                $comment->setRessource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Share>
     */
    public function getShares(): Collection
    {
        return $this->shares;
    }

    public function addShare(Share $share): static
    {
        if (!$this->shares->contains($share)) {
            $this->shares->add($share);
            $share->setRessource($this);
        }

        return $this;
    }

    public function removeShare(Share $share): static
    {
        if ($this->shares->removeElement($share)) {
            // set the owning side to null (unless already changed)
            if ($share->getRessource() === $this) {
                $share->setRessource(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    /**
     * @return string|null
     */
    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    /**
     * @param string|null $fileUrl
     */
    public function setFileUrl(?string $fileUrl): void
    {
        $this->fileUrl = $fileUrl;
    }

    public function getRessourceCategory(): RessourceCategory
    {
        return $this->ressourceCategory;
    }

    public function setRessourceCategory(RessourceCategory $ressourceCategory): static
    {
        $this->ressourceCategory = $ressourceCategory;

        return $this;
    }

    public function getRelationType(): RelationType
    {
        return $this->relationType;
    }

    public function setRelationType(RelationType $relationType): static
    {
        $this->relationType = $relationType;

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setRessource($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getRessource() === $this) {
                $favorite->setRessource(null);
            }
        }

        return $this;
    }
}
