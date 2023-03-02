<?php

namespace App\Entity;

use App\Repository\NuiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NuiteRepository::class)]
class Nuite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateNuitee = null;

    #[ORM\ManyToOne(inversedBy: 'nuites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inscription $inscription = null;

    #[ORM\ManyToOne(inversedBy: 'nuites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hotel $hotel = null;

    #[ORM\ManyToOne(inversedBy: 'nuites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieChambre $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNuitee(): ?\DateTimeInterface
    {
        return $this->dateNuitee;
    }

    public function setDateNuitee(\DateTimeInterface $dateNuitee): self
    {
        $this->dateNuitee = $dateNuitee;

        return $this;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getCategorie(): ?CategorieChambre
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieChambre $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
