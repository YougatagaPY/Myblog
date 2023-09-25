<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Article::class)]
    private Collection $LesCategorie;

    public function __construct()
    {
        $this->LesCategorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getLesCategorie(): Collection
    {
        return $this->LesCategorie;
    }

    public function addLesCategorie(Article $lesCategorie): static
    {
        if (!$this->LesCategorie->contains($lesCategorie)) {
            $this->LesCategorie->add($lesCategorie);
            $lesCategorie->setCategorie($this);
        }

        return $this;
    }

    public function removeLesCategorie(Article $lesCategorie): static
    {
        if ($this->LesCategorie->removeElement($lesCategorie)) {
            // set the owning side to null (unless already changed)
            if ($lesCategorie->getCategorie() === $this) {
                $lesCategorie->setCategorie(null);
            }
        }

        return $this;
    }
    public function __ToString()
    {
        return $this->libelle;
    }

}
