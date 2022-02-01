<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_num;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_rue;

    /**
     * @ORM\Column(type="date")
     */
    private $inscription;

    /**
     * @ORM\OneToOne(targetEntity=Prestataire::class, mappedBy="utilisateur", cascade={"persist", "remove"})
     */
    private $prestataire;

    public function __construct()
    {
        $this->inscription = new \DateTime('now');
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_utilisateur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_essais;

    /**
     * @ORM\Column(type="boolean")
     */
    private $banni;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inscript_conf;

    /**
     * @ORM\ManyToOne(targetEntity=Commune::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $commune;

    /**
     * @ORM\ManyToOne(targetEntity=CodePostal::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $codePostal;

    /**
     * @ORM\ManyToOne(targetEntity=Localite::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $localite;

    /**
     * @ORM\OneToOne(targetEntity=Internaute::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $internaute;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAdresseNum(): ?string
    {
        return $this->adresse_num;
    }

    public function setAdresseNum(string $adresse_num): self
    {
        $this->adresse_num = $adresse_num;

        return $this;
    }

    public function getAdresseRue(): ?string
    {
        return $this->adresse_rue;
    }

    public function setAdresseRue(string $adresse_rue): self
    {
        $this->adresse_rue = $adresse_rue;

        return $this;
    }

    public function getInscription(): ?\DateTimeInterface
    {
        return $this->inscription;
    }

    public function setInscription(\DateTimeInterface $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getTypeUtilisateur(): ?string
    {
        return $this->type_utilisateur;
    }

    public function setTypeUtilisateur(string $type_utilisateur): self
    {
        $this->type_utilisateur = $type_utilisateur;

        return $this;
    }

    public function getNbEssais(): ?int
    {
        return $this->nb_essais;
    }

    public function setNbEssais(?int $nb_essais): self
    {
        $this->nb_essais = $nb_essais;

        return $this;
    }

    public function getBanni(): ?bool
    {
        return $this->banni;
    }

    public function setBanni(bool $banni): self
    {
        $this->banni = $banni;

        return $this;
    }

    public function getInscriptConf(): ?bool
    {
        return $this->inscript_conf;
    }

    public function setInscriptConf(bool $inscript_conf): self
    {
        $this->inscript_conf = $inscript_conf;

        return $this;
    }

    public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getCodePostal(): ?CodePostal
    {
        return $this->codePostal;
    }

    public function setCodePostal(?CodePostal $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getLocalite(): ?Localite
    {
        return $this->localite;
    }

    public function setLocalite(?Localite $localite): self
    {
        $this->localite = $localite;

        return $this;
    }

    public function getInternaute(): ?Internaute
    {
        return $this->internaute;
    }

    public function setInternaute(?Internaute $internaute): self
    {
        $this->internaute = $internaute;

        return $this;
    }

    public function getPrestataire(): ?Prestataire
    {
        return $this->prestataire;
    }

    public function setPrestataire(?Prestataire $prestataire): self
    {
        // unset the owning side of the relation if necessary
        if ($prestataire === null && $this->prestataire !== null) {
            $this->prestataire->setUtilisateur(null);
        }

        // set the owning side of the relation if necessary
        if ($prestataire !== null && $prestataire->getUtilisateur() !== $this) {
            $prestataire->setUtilisateur($this);
        }

        $this->prestataire = $prestataire;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
