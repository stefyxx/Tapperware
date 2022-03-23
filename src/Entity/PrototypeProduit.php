<?php

namespace App\Entity;

use App\Repository\PrototypeProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrototypeProduitRepository::class)]
class PrototypeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Nom_produit;

    #[ORM\Column(type: 'float', nullable: true)]
    private $PrixLocationUnitaire;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Taille_Capacite;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Description;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Stock;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'prototypeProduits')]
    private $Category;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Image;
    //forse non serve
    #[ORM\OneToMany(mappedBy: 'PrototypeProduit', targetEntity: DetailProduitLocation::class)]
    private $detailProduitLocations;

    #[ORM\OneToMany(mappedBy: 'PrototypeProduit', targetEntity: DetailProduitRetour::class)]
    private $detailProduitRetours;


    public function __construct()
    {
        $this->detailProduitLocations = new ArrayCollection();
        $this->detailProduitRetours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->Nom_produit;
    }

    public function setNomProduit(string $Nom_produit): self
    {
        $this->Nom_produit = $Nom_produit;

        return $this;
    }

    public function getPrixLocationUnitaire(): ?float
    {
        return $this->PrixLocationUnitaire;
    }

    public function setPrixLocationUnitaire(?float $PrixLocationUnitaire): self
    {
        $this->PrixLocationUnitaire = $PrixLocationUnitaire;

        return $this;
    }

    public function getTailleCapacite(): ?string
    {
        return $this->Taille_Capacite;
    }

    public function setTailleCapacite(?string $Taille_Capacite): self
    {
        $this->Taille_Capacite = $Taille_Capacite;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->Stock;
    }

    public function setStock(?int $Stock): self
    {
        $this->Stock = $Stock;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    /**
     * @return Collection<int, DetailProduitLocation>
     */
    public function getDetailProduitLocations(): Collection
    {
        return $this->detailProduitLocations;
    }

    public function addDetailProduitLocation(DetailProduitLocation $detailProduitLocation): self
    {
        if (!$this->detailProduitLocations->contains($detailProduitLocation)) {
            $this->detailProduitLocations[] = $detailProduitLocation;
            $detailProduitLocation->setPrototypeProduit($this);
        }

        return $this;
    }

    public function removeDetailProduitLocation(DetailProduitLocation $detailProduitLocation): self
    {
        if ($this->detailProduitLocations->removeElement($detailProduitLocation)) {
            // set the owning side to null (unless already changed)
            if ($detailProduitLocation->getPrototypeProduit() === $this) {
                $detailProduitLocation->setPrototypeProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DetailProduitRetour>
     */
    public function getDetailProduitRetours(): Collection
    {
        return $this->detailProduitRetours;
    }

    public function addDetailProduitRetour(DetailProduitRetour $detailProduitRetour): self
    {
        if (!$this->detailProduitRetours->contains($detailProduitRetour)) {
            $this->detailProduitRetours[] = $detailProduitRetour;
            $detailProduitRetour->setPrototypeProduit($this);
        }

        return $this;
    }

    public function removeDetailProduitRetour(DetailProduitRetour $detailProduitRetour): self
    {
        if ($this->detailProduitRetours->removeElement($detailProduitRetour)) {
            // set the owning side to null (unless already changed)
            if ($detailProduitRetour->getPrototypeProduit() === $this) {
                $detailProduitRetour->setPrototypeProduit(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }
}
