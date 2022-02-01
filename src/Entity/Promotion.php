<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $documentPdf;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $debut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fin;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $affichageDe;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $affichageJusque;

    /**
     * @ORM\ManyToOne(targetEntity=Prestataire::class, inversedBy="promotion")
     */
    private $prestataire;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDocumentPdf()
    {
        return $this->documentPdf;
    }

    public function setDocumentPdf($documentPdf): self
    {
        $this->documentPdf = $documentPdf;

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(?\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(?\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function getAffichageDe(): ?\DateTimeInterface
    {
        return $this->affichageDe;
    }

    public function setAffichageDe(?\DateTimeInterface $affichageDe): self
    {
        $this->affichageDe = $affichageDe;

        return $this;
    }

    public function getAffichageJusque(): ?\DateTimeInterface
    {
        return $this->affichageJusque;
    }

    public function setAffichageJusque(?\DateTimeInterface $affichageJusque): self
    {
        $this->affichageJusque = $affichageJusque;

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
}
