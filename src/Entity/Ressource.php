<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use App\Repository\RessourceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: RessourceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['read']],
)]#[Get]
class Ressource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('get')]
    #[Assert\NotBlank(message: 'Le titre est obligatoire')]
    #[Assert\Length(min: 1, max: 255, minMessage: 'Le titre doit faire au minimum {{ limit }} caractère', maxMessage: 'Le titre doit faire au maximum {{ limit }} caractère')]

    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups('get')]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'Ressources')]
    private ?RessourceType $ressourceType = null;

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
}
