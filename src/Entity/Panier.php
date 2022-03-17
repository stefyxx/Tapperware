<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $Date_paiment;

    #[ORM\ManyToOne(targetEntity: Restaurant::class, inversedBy: 'paniers')]
    private $Restaurant;

    #[ORM\OneToMany(mappedBy: 'Panier', targetEntity: DetailProduitLocation::class)]
    private $detailProduitLocations;

    #[ORM\OneToMany(mappedBy: 'Panier', targetEntity: DetailProduitRetour::class)]
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

    public function getDatePaiment(): ?\DateTimeInterface
    {
        return $this->Date_paiment;
    }

    public function setDatePaiment(?\DateTimeInterface $Date_paiment): self
    {
        $this->Date_paiment = $Date_paiment;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->Restaurant;
    }

    public function setRestaurant(?Restaurant $Restaurant): self
    {
        $this->Restaurant = $Restaurant;

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
            $detailProduitLocation->setPanier($this);
        }

        return $this;
    }

    public function removeDetailProduitLocation(DetailProduitLocation $detailProduitLocation): self
    {
        if ($this->detailProduitLocations->removeElement($detailProduitLocation)) {
            // set the owning side to null (unless already changed)
            if ($detailProduitLocation->getPanier() === $this) {
                $detailProduitLocation->setPanier(null);
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
            $detailProduitRetour->setPanier($this);
        }

        return $this;
    }

    public function removeDetailProduitRetour(DetailProduitRetour $detailProduitRetour): self
    {
        if ($this->detailProduitRetours->removeElement($detailProduitRetour)) {
            // set the owning side to null (unless already changed)
            if ($detailProduitRetour->getPanier() === $this) {
                $detailProduitRetour->setPanier(null);
            }
        }

        return $this;
    }
}
