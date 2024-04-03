<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use App\State\UserPasswordHasher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
)]
#[Post(
    uriTemplate: '/createAccount',
    openapiContext: [
        'summary' => 'Create Account',
        'requestBody' => [
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'firstname' => 'string',
                            'lastname' => 'string',
                            'email' => 'string',
                            'plainPassword' => 'string',
                        ],
                    ]
                ]
            ]
        ]
    ],
    description: 'Create Account',
    normalizationContext: ['groups' => ['user:create']],
    denormalizationContext: ['groups' => ['read:user:item']],
    validationContext: ['groups' => ['user:create']],
    read: false,
    name: 'Create Account',
    processor: UserPasswordHasher::class,
)]
#[Get(
    normalizationContext : ['groups' => ['read:user:collection', 'read:user:item']],
)]

#[GetCollection(
    normalizationContext : ['groups' => 'read:user:collection']
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:user:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['read:user:item', 'user:create'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['read:user:item'])]
    private array $roles = [];

    #[ORM\Column]
    #[Groups(["read:ressource:collection","read:user:collection", 'user:create'])]
    private string $firstname = '';

    #[ORM\Column]
    #[Groups(["read:ressource:collection","read:user:collection", 'user:create'])]
    private string $lastname = '';

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Groups(['user:create'])]
    private ?string $plainPassword = null;

    #[ORM\OneToMany(targetEntity: LoginAttemps::class, mappedBy: 'user')]
    private Collection $loginAttemps;

    #[ORM\OneToMany(targetEntity: Ressource::class, mappedBy: 'user')]
    private Collection $ressources;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'user')]
    private Collection $comments;

    #[ORM\OneToMany(targetEntity: Share::class, mappedBy: 'sender')]
    private Collection $shares;

    public function __construct()
    {
        $this->loginAttemps = new ArrayCollection();
        $this->ressources = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->shares = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Méthode getUsername qui permet de retourner le champ qui est utilisé pour l'authentification.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, LoginAttemps>
     */
    public function getLoginAttemps(): Collection
    {
        return $this->loginAttemps;
    }

    public function addLoginAttemp(LoginAttemps $loginAttemp): static
    {
        if (!$this->loginAttemps->contains($loginAttemp)) {
            $this->loginAttemps->add($loginAttemp);
            $loginAttemp->setUser($this);
        }

        return $this;
    }

    public function removeLoginAttemp(LoginAttemps $loginAttemp): static
    {
        if ($this->loginAttemps->removeElement($loginAttemp)) {
            // set the owning side to null (unless already changed)
            if ($loginAttemp->getUser() === $this) {
                $loginAttemp->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ressource>
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): static
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources->add($ressource);
            $ressource->setUser($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): static
    {
        if ($this->ressources->removeElement($ressource)) {
            // set the owning side to null (unless already changed)
            if ($ressource->getUser() === $this) {
                $ressource->setUser(null);
            }
        }

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
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
            $share->setSender($this);
        }

        return $this;
    }

    public function removeShare(Share $share): static
    {
        if ($this->shares->removeElement($share)) {
            // set the owning side to null (unless already changed)
            if ($share->getSender() === $this) {
                $share->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }
}
