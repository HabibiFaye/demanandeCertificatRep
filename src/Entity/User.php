<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints as Assert ;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        minMessage: 'le nom doit faire minimum 2 caractères '
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        minMessage: 'le prénom doit faire minimum 2 caractères '
    )]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    
    private ?int $CIN = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Demande::class, orphanRemoval: true)]
    private Collection $demandes;

    #[ORM\Column(length: 255)]
    private ?string $Adresse = null;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->created_at= new \DateTimeImmutable();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCIN(): ?int
    {
        return $this->CIN;
    }

    public function setCIN(?int $CIN): static
    {
        $this->CIN = $CIN;

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): static
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setUser($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): static
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getUser() === $this) {
                $demande->setUser(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->prenom;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): static
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    

}
