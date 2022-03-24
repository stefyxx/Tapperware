<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $Ville;

    #[ORM\Column(type: 'string', length: 255)]
    private $Rue;

    #[ORM\Column(type: 'string', length: 255)]
    private $Numero;

    #[ORM\Column(type: 'string', length: 255)]
    private $Zip;

    #[ORM\Column(type: 'string', length: 255)]
    private $Numero_TVA;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Site_Web;

    #[ORM\Column(type: 'boolean')]
    private $isActive;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'restaurants')]
    private $User;

    #[ORM\OneToMany(mappedBy: 'Restaurant', targetEntity: Panier::class)]
    private $paniers;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Image;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->Rue;
    }

    public function setRue(string $Rue): self
    {
        $this->Rue = $Rue;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->Numero;
    }

    public function setNumero(string $Numero): self
    {
        $this->Numero = $Numero;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->Zip;
    }

    public function setZip(string $Zip): self
    {
        $this->Zip = $Zip;

        return $this;
    }

    public function getNumeroTVA(): ?string
    {
        return $this->Numero_TVA;
    }

    public function setNumeroTVA(string $Numero_TVA): self
    {
        $this->Numero_TVA = $Numero_TVA;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->Site_Web;
    }

    public function setSiteWeb(?string $Site_Web): self
    {
        $this->Site_Web = $Site_Web;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): ?Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers[] = $panier;
            $panier->setRestaurant($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getRestaurant() === $this) {
                $panier->setRestaurant(null);
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
