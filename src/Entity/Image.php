<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ordre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image; // changer en string pour stocker le nom de l'image

    /**
     * @ORM\ManyToOne(targetEntity=Prestataire::class, inversedBy="images")
     */
    private $prestataire;

    /**
     * @ORM\OneToOne(targetEntity=CategorieService::class, mappedBy="images", cascade={"persist", "remove"})
     */
    private $categorieService;

    /**
     * @ORM\OneToOne(targetEntity=Internaute::class, mappedBy="image", cascade={"persist", "remove"})
     */
    private $internaute;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrestataire(): ?Prestataire
    {
        return $this->prestataire;
    }

    public function setPrestataire(?Prestataire $prestataire): self
    {
        $this->prestataire = $prestataire;

        return $this;
    }

    public function getCategorieService(): ?CategorieService
    {
        return $this->categorieService;
    }

    public function setCategorieService(?CategorieService $categorieService): self
    {
        // unset the owning side of the relation if necessary
        if ($categorieService === null && $this->categorieService !== null) {
            $this->categorieService->setImages(null);
        }

        // set the owning side of the relation if necessary
        if ($categorieService !== null && $categorieService->getImages() !== $this) {
            $categorieService->setImages($this);
        }

        $this->categorieService = $categorieService;

        return $this;
    }

    public function __toString()
    {
        return $this->image;
    }

    public function getInternaute(): ?Internaute
    {
        return $this->internaute;
    }

    public function setInternaute(?Internaute $internaute): self
    {
        // unset the owning side of the relation if necessary
        if ($internaute === null && $this->internaute !== null) {
            $this->internaute->setImage(null);
        }

        // set the owning side of the relation if necessary
        if ($internaute !== null && $internaute->getImage() !== $this) {
            $internaute->setImage($this);
        }

        $this->internaute = $internaute;

        return $this;
    }
}
