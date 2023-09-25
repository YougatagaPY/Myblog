<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['pseudo'], message: 'There is already an account with this pseudo')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Article::class)]
    private Collection $lesarticles;

    public function __construct()
    {
        $this->lesarticles = new ArrayCollection();
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->mail;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __ToString()
    {
        return $this->pseudo;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $mdp): static
    {
        $this->password = $mdp;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getLesarticles(): Collection
    {
        return $this->lesarticles;
    }

    public function addLesarticle(Article $lesarticle): static
    {
        if (!$this->lesarticles->contains($lesarticle)) {
            $this->lesarticles->add($lesarticle);
            $lesarticle->setUser($this);
        }

        return $this;
    }
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }





    public function removeLesarticle(Article $lesarticle): static
    {
        if ($this->lesarticles->removeElement($lesarticle)) {
            // set the owning side to null (unless already changed)
            if ($lesarticle->getUser() === $this) {
                $lesarticle->setUser(null);
            }
        }

        return $this;
    }
    
}
