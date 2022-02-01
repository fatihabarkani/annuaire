<?php

namespace App\Entity;

use App\Repository\PrestataireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrestataireRepository::class)
 */
class Prestataire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siteInternet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numTel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numTva;

    /**
     * @ORM\ManyToMany(targetEntity=CategorieService::class, inversedBy="prestataires")
     */
    private $categorieServices;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="prestataire")
     */
    private $images;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $utilisateur;

    /**
     * @ORM\ManyToMany(targetEntity=Internaute::class, inversedBy="prestataires")
     */
    private $internaute;

    /**
     * @ORM\OneToMany(targetEntity=Promotion::class, mappedBy="prestataire")
     */
    private $promotion;



    public function __construct()
    {
        $this->categorieServices = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->internaute = new ArrayCollection();
        $this->promotion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSiteInternet(): ?string
    {
        return $this->siteInternet;
    }

    public function setSiteInternet(string $siteInternet): self
    {
        $this->siteInternet = $siteInternet;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getNumTva(): ?string
    {
        return $this->numTva;
    }

    public function setNumTva(string $numTva): self
    {
        $this->numTva = $numTva;

        return $this;
    }

    /**
     * @return Collection|CategorieService[]
     */
    public function getCategorieServices(): Collection
    {
        return $this->categorieServices;
    }

    public function addCategorieService(CategorieService $categorieService): self
    {
        if (!$this->categorieServices->contains($categorieService)) {
            $this->categorieServices[] = $categorieService;
        }

        return $this;
    }

    public function removeCategorieService(CategorieService $categorieService): self
    {
        $this->categorieServices->removeElement($categorieService);

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPrestataire($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPrestataire() === $this) {
                $image->setPrestataire(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    

    /**
     * @return Collection|Internaute[]
     */
    public function getInternaute(): Collection
    {
        return $this->internaute;
    }

    public function addInternaute(Internaute $internaute): self
    {
        if (!$this->internaute->contains($internaute)) {
            $this->internaute[] = $internaute;
        }

        return $this;
    }

    public function removeInternaute(Internaute $internaute): self
    {
        $this->internaute->removeElement($internaute);

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    /**
     * @return Collection|Promotion[]
     */
    public function getPromotion(): Collection
    {
        return $this->promotion;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotion->contains($promotion)) {
            $this->promotion[] = $promotion;
            $promotion->setPrestataire($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotion->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getPrestataire() === $this) {
                $promotion->setPrestataire(null);
            }
        }

        return $this;
    }

 

   

}
