<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['uuid'], message: 'Il existe déja un compte avec ce numero')]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $uuid = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DemandeCertificat::class)]
    private Collection $demandeCertificat;

    public function __construct()
    {
        $this->demandeCertificat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->uuid;
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

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * //@see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, DemandeCertificat>
     */
    public function getDemandeCertificat(): Collection
    {
        return $this->demandeCertificat;
    }

    public function addDemandeCertificat(DemandeCertificat $demandeCertificat): static
    {
        if (!$this->demandeCertificat->contains($demandeCertificat)) {
            $this->demandeCertificat->add($demandeCertificat);
            $demandeCertificat->setUser($this);
        }

        return $this;
    }

    public function removeDemandeCertificat(DemandeCertificat $demandeCertificat): static
    {
        if ($this->demandeCertificat->removeElement($demandeCertificat)) {
            // set the owning side to null (unless already changed)
            if ($demandeCertificat->getUser() === $this) {
                $demandeCertificat->setUser(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->uuid ;
    }

}
