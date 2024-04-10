<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\AcceptRessourceController;
use App\Controller\ShareByMeController;
use App\Controller\ShareToMeController;
use App\dto\ShareDto;
use App\Processor\ShareProcessor;
use App\Repository\ShareRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShareRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/shares/to-me',
            controller: ShareToMeController::class,
            description: 'Get User personnal share top him',
            read: true,

        ),
        new GetCollection(
            uriTemplate: '/shares/by-me',
            controller: ShareByMeController::class,
            description: 'Get User personnal share by him',
            read: true,
        ),
    ],
)]
#[Post(
    openapiContext: [
        'summary' => 'Create Share',
        'requestBody' => [
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'ressource' => [
                                'type' => 'string',
                                'example' => '/api/ressources/{id}' ,
                            ],
                            'email' => [
                                'type' => 'string',
                                'example' => 'test@test.fr',
                            ],
                        ],
                    ]
                ]
            ]
        ]
    ],
    input: ShareDto::class,
    processor: ShareProcessor::class,
)]
#[Get(
    output: false,
    read: false
)]
#[GetCollection(
    output: false,
    read: false
)]
class Share
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'shares')]
    #[ORM\JoinColumn(nullable: false)]
    private User $sender;

    #[ORM\ManyToOne(inversedBy: 'shares')]
    #[ORM\JoinColumn(nullable: false)]
    private User $recipient;

    #[ORM\ManyToOne(inversedBy: 'shares')]
    private Ressource $ressource;


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

    public function setId(int $id): void
    {
        $this->id = $id;
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

    public function getSender(): User
    {
        return $this->sender;
    }

    public function setSender(User $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): User
    {
        return $this->recipient;
    }

    public function setRecipient(User $recipient): static
    {
        $this->recipient = $recipient;

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
}
