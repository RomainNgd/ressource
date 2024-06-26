<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\SlugController;
use App\Repository\RessourceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: RessourceTypeRepository::class)]
#[ApiResource(
    paginationClientItemsPerPage: false,
    paginationEnabled: false,
)]
#[GetCollection(
    normalizationContext : ['groups' => 'read:ressourceType:collection']
)]
#[Get(
    normalizationContext : ['groups' => ['read:ressourceType:collection']]
)]
#[Post(
    controller: SlugController::class,
    openapiContext: [
        'summary' => 'Create Ressource Type',
        'requestBody' => [
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'title' => [
                                'type' => 'string',
                                'example' => 'title' ,
                            ],
                        ],
                    ]
                ]
            ]
        ]
    ],
    denormalizationContext: ["create:ressourceType"]
)]
#[Patch(
    controller: SlugController::class,
    openapiContext: [
        'summary' => 'Update ressource Type',
        'requestBody' => [
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'title' => [
                                'type' => 'string',
                                'example' => 'title' ,
                            ],
                        ],
                    ]
                ]
            ]
        ]
    ],
    denormalizationContext: ["update:ressourceType"],
)]
class RessourceType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:ressourceType:collection"])]
    private string $slug = '';

    #[ORM\Column(length: 255)]
    #[Groups(["read:ressource:collection", "read:ressourceType:collection", "update:ressourceType", "create:ressourceType"])]
    private ?string $title = null;

    #[ORM\OneToMany(targetEntity: Ressource::class, mappedBy: 'ressourceType')]
    private Collection $Ressources;

    public function __construct()
    {
        $this->Ressources = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
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

    /**
     * @return Collection<int, Ressource>
     */
    public function getRessources(): Collection
    {
        return $this->Ressources;
    }

    public function addRessource(Ressource $ressource): static
    {
        if (!$this->Ressources->contains($ressource)) {
            $this->Ressources->add($ressource);
            $ressource->setRessourceType($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): static
    {
        if ($this->Ressources->removeElement($ressource)) {
            // set the owning side to null (unless already changed)
            if ($ressource->getRessourceType() === $this) {
                $ressource->setRessourceType(null);
            }
        }

        return $this;
    }
}
