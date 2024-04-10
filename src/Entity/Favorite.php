<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\DeleteFavoriteController;
use App\Controller\FavoriteController;
use App\Controller\MyFavoriteController;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/my-favorites',
            controller: MyFavoriteController::class,
            openapiContext: [
                'summary' => 'Retrive user favorite ressource',
            ],
            description: 'Retrive user favorite ressource',
            normalizationContext: ['groups' => ['read:favorite:collection']],
            read: false,
        ),
    ],
)]
#[Post(
    controller: FavoriteController::class,
    normalizationContext: ['groups' => ['read:favorite:collection']],
    denormalizationContext: ['groups' => ['create:favorite:item']],
)]
#[Delete(
    controller: DeleteFavoriteController::class,
)]
#[Get]
#[GetCollection]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['create:favorite:item', 'read:favorite:collection'])]
    private ?Ressource $ressource = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    public function __construct(
        #[ORM\Column]
        private ?\DateTimeImmutable $createdAt = new \DateTimeImmutable()
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRessource(): ?Ressource
    {
        return $this->ressource;
    }

    public function setRessource(?Ressource $Ressource): static
    {
        $this->ressource = $Ressource;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }
}
