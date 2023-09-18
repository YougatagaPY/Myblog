<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Article::class)]
    private Collection $lesarticles;

    public function __construct()
    {
        $this->lesarticles = new ArrayCollection();
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

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

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
