<?php

namespace App\Entity;

use App\Repository\DemandeCertificatRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: DemandeCertificatRepository::class)]
class DemandeCertificat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Lieu_reception_certificat = null;

    #[ORM\Column(type: 'datetime_immutable', options:['default'=>'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column]
    private ?int $numeroTelephone = null;

    #[ORM\ManyToOne(inversedBy: 'demandeCertificat')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

   

    #[ORM\Column]
    private ?bool $statutDemande = null;

    #[ORM\Column(length: 100)]
    private ?string $statut = null;
   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieuReceptionCertificat(): ?string
    {
        return $this->Lieu_reception_certificat;
    }

    public function setLieuReceptionCertificat(string $Lieu_reception_certificat): static
    {
        $this->Lieu_reception_certificat = $Lieu_reception_certificat;

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

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getNumeroTelephone(): ?int
    {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(int $numeroTelephone): static
    {
        $this->numeroTelephone = $numeroTelephone;

        return $this;
    }
   

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
    
    public function __toString()
    {
        return $this->user ;
    }

   

    public function isStatutDemande(): ?bool
    {
        return $this->statutDemande;
    }

    public function setStatutDemande(bool $statutDemande): static
    {
        $this->statutDemande = $statutDemande;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

   

   
    

}
