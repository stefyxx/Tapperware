<?php

namespace App\Entity;

use App\Repository\DetailProduitRetourRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailProduitRetourRepository::class)]
class DetailProduitRetour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $DateRetour;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Quantite_total_a_Rendre;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $QuantiteRendue;

    #[ORM\Column(type: 'float', nullable: true)]
    private $MontantRendue;

    #[ORM\ManyToOne(targetEntity: Panier::class, inversedBy: 'detailProduitRetours')]
    private $Panier;

    #[ORM\ManyToOne(targetEntity: PrototypeProduit::class, inversedBy: 'detailProduitRetours')]
    private $PrototypeProduit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->DateRetour;
    }

    public function setDateRetour(?\DateTimeInterface $DateRetour): self
    {
        $this->DateRetour = $DateRetour;

        return $this;
    }

    public function getQuantiteTotalARendre(): ?int
    {
        return $this->Quantite_total_a_Rendre;
    }

    public function setQuantiteTotalARendre(?int $Quantite_total_a_Rendre): self
    {
        $this->Quantite_total_a_Rendre = $Quantite_total_a_Rendre;

        return $this;
    }

    public function getQuantiteRendue(): ?int
    {
        return $this->QuantiteRendue;
    }

    public function setQuantiteRendue(?int $QuantiteRendue): self
    {
        $this->QuantiteRendue = $QuantiteRendue;

        return $this;
    }

    public function getMontantRendue(): ?float
    {
        return $this->MontantRendue;
    }

    public function setMontantRendue(?float $MontantRendue): self
    {
        $this->MontantRendue = $MontantRendue;

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
