<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\SlugController;
use App\Repository\RelationTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: RelationTypeRepository::class)]
#[Get(    normalizationContext: ['read:relationType:collection'],)]
#[GetCollection(    normalizationContext: ['read:relationType:collection'],)]
#[Post(
    controller: SlugController::class,
    openapiContext: [
        'summary' => 'Create relation Type',
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
    normalizationContext: ['read:relationType:collection'],
    denormalizationContext: ["create:relationType"],
)]
#[Patch(
    controller: SlugController::class,
    openapiContext: [
        'summary' => 'Update relationType',
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
    normalizationContext: ['read:relationType:collection'],
    denormalizationContext: ["update:relationType"],
)]
class RelationType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:ressource:collection', 'read:relationType:collection', 'create:relationType', 'update:relationType'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(targetEntity: Ressource::class, mappedBy: 'relationType')]
    private Collection $Ressources;

    public function __construct()
    {
        $this->Ressources = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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
            $ressource->setRelationType($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): static
    {
        if ($this->Ressources->removeElement($ressource)) {
            // set the owning side to null (unless already changed)
            if ($ressource->getRelationType() === $this) {
                $ressource->setRelationType(null);
            }
        }

        return $this;
    }
}
