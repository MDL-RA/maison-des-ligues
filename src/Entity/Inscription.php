<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: Restauration::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $restaurations;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: Nuite::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $nuites;

    #[ORM\ManyToMany(targetEntity: Atelier::class, inversedBy: 'inscriptions',)]
    private Collection $ateliers;

    #[ORM\OneToOne(mappedBy: 'inscription', cascade: ['persist', 'remove'])]
    private ?Compte $compte = null;

    public function __construct()
    {
        $this->restaurations = new ArrayCollection();
        $this->nuites = new ArrayCollection();
        $this->ateliers = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }


    public function getRestaurations(): ?Restauration
    {
        return $this->restaurations;
    }

    public function setRestaurations(?Restauration $restaurations): self
    {
        $this->restaurations = $restaurations;

        return $this;
    }

    public function addRestauration(Restauration $restauration): self
    {
        if (!$this->restaurations->contains($restauration)) {
            $this->restaurations->add($restauration);
            $restauration->setInscription($this);
        }

        return $this;
    }

    public function removeRestauration(Restauration $restauration): self
    {
        if ($this->restaurations->removeElement($restauration)) {
            // set the owning side to null (unless already changed)
            if ($restauration->getInscription() === $this) {
                $restauration->setInscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Nuite>
     */
    public function getNuites(): Collection
    {
        return $this->nuites;
    }

    public function addNuite(Nuite $nuite): self
    {
        if (!$this->nuites->contains($nuite)) {
            $this->nuites->add($nuite);
            $nuite->setInscription($this);
        }

        return $this;
    }

    public function removeNuite(Nuite $nuite): self
    {
        if ($this->nuites->removeElement($nuite)) {
            // set the owning side to null (unless already changed)
            if ($nuite->getInscription() === $this) {
                $nuite->setInscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Atelier>
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    public function addAtelier(Atelier $atelier): self
    {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers->add($atelier);
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): self
    {
        $this->ateliers->removeElement($atelier);

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        // unset the owning side of the relation if necessary
        if ($compte === null && $this->compte !== null) {
            $this->compte->setInscription(null);
        }

        // set the owning side of the relation if necessary
        if ($compte !== null && $compte->getInscription() !== $this) {
            $compte->setInscription($this);
        }

        $this->compte = $compte;

        return $this;
    }
}
