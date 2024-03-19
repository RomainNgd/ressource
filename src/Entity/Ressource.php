<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\RessourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: RessourceRepository::class)]
#[ApiResource(
    paginationClientEnabled: true,
    paginationClientItemsPerPage: 30,
    paginationItemsPerPage: 30,
    paginationMaximumItemsPerPage: 50
)]
#[GetCollection(
    normalizationContext : ['groups' => 'read:ressource:collection']
)]
#[Get(
    normalizationContext : ['groups' => ['read:ressource:collection', 'read:ressource:item']]
)]
#[Put(
    denormalizationContext : ['groups' => ['update:ressource:item']]
)]
#[Post(
    denormalizationContext : ['groups' => ['create:ressource:item']]
)]
#[ApiFilter(BooleanFilter::class, properties: ['visible', 'accepted'])]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
class Ressource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:ressource:collection", 'update:ressource:item','create:ressource:item'])]
    #[Assert\NotBlank(message: 'Le titre est obligatoire')]
    #[Assert\Length(min: 1, max: 255, minMessage: 'Le titre doit faire au minimum {{ limit }} caractère', maxMessage: 'Le titre doit faire au maximum {{ limit }} caractère')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["read:ressource:collection",'update:ressource:item', 'create:ressource:item'])]
    private string $description = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["read:ressource:item", 'update:ressource:item', 'create:ressource:item'])]
    private string $content = '';

    #[ORM\ManyToOne(inversedBy: 'Ressources')]
    #[Groups(["read:ressource:collection", 'update:ressource:item', 'create:ressource:item'])]
    private ?RessourceType $ressourceType = null;

    #[ORM\Column]
    #[Groups(['update:ressource:item', 'create:ressource:item'])]
    private bool $visible = false;

    #[ORM\Column]
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
}
