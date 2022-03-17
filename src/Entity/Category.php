<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Label;

    #[ORM\OneToMany(mappedBy: 'Category', targetEntity: PrototypeProduit::class)]
    private $prototypeProduits;

    public function __construct()
    {
        $this->prototypeProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->Label;
    }

    public function setLabel(string $Label): self
    {
        $this->Label = $Label;

        return $this;
    }

    /**
     * @return Collection<int, PrototypeProduit>
     */
    public function getPrototypeProduits(): Collection
    {
        return $this->prototypeProduits;
    }

    public function addPrototypeProduit(PrototypeProduit $prototypeProduit): self
    {
        if (!$this->prototypeProduits->contains($prototypeProduit)) {
            $this->prototypeProduits[] = $prototypeProduit;
            $prototypeProduit->setCategory($this);
        }

        return $this;
    }

    public function removePrototypeProduit(PrototypeProduit $prototypeProduit): self
    {
        if ($this->prototypeProduits->removeElement($prototypeProduit)) {
            // set the owning side to null (unless already changed)
            if ($prototypeProduit->getCategory() === $this) {
                $prototypeProduit->setCategory(null);
            }
        }

        return $this;
    }
}
