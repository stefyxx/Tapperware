<?php

namespace App\Entity;

use App\Repository\DetailProduitLocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailProduitLocationRepository::class)]
class DetailProduitLocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $Date_debut;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $Date_fin_teorique;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $QuantiteTotal;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $QuantiteResteRendre;

    #[ORM\Column(type: 'float', nullable: true)]
    private $Montant;

    #[ORM\Column(type: 'float', nullable: true)]
    private $Montant_par_unite;

    #[ORM\ManyToOne(targetEntity: Panier::class, inversedBy: 'detailProduitLocations')]
    private $Panier;

    #[ORM\ManyToOne(targetEntity: PrototypeProduit::class, inversedBy: 'detailProduitLocations')]
    private $PrototypeProduit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->Date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $Date_debut): self
    {
        $this->Date_debut = $Date_debut;

        return $this;
    }

    public function getDateFinTeorique(): ?\DateTimeInterface
    {
        return $this->Date_fin_teorique;
    }

    public function setDateFinTeorique(?\DateTimeInterface $Date_fin_teorique): self
    {
        $this->Date_fin_teorique = $Date_fin_teorique;

        return $this;
    }

    public function getQuantiteTotal(): ?int
    {
        return $this->QuantiteTotal;
    }

    public function setQuantiteTotal(?int $QuantiteTotal): self
    {
        $this->QuantiteTotal = $QuantiteTotal;

        return $this;
    }

    public function getQuantiteResteRendre(): ?int
    {
        return $this->QuantiteResteRendre;
    }

    public function setQuantiteResteRendre(?int $QuantiteResteRendre): self
    {
        $this->QuantiteResteRendre = $QuantiteResteRendre;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(?float $Montant): self
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getMontantParUnite(): ?float
    {
        return $this->Montant_par_unite;
    }

    public function setMontantParUnite(?float $Montant_par_unite): self
    {
        $this->Montant_par_unite = $Montant_par_unite;

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->Panier;
    }

    public function setPanier(?Panier $Panier): self
    {
        $this->Panier = $Panier;

        return $this;
    }

    public function getPrototypeProduit(): ?PrototypeProduit
    {
        return $this->PrototypeProduit;
    }

    public function setPrototypeProduit(?PrototypeProduit $PrototypeProduit): self
    {
        $this->PrototypeProduit = $PrototypeProduit;

        return $this;
    }
}
