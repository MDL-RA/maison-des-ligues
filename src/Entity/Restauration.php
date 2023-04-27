<?php

namespace App\Entity;

use App\Repository\RestaurationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurationRepository::class)]
class Restauration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateRestauration = null;

    #[ORM\Column(length: 255)]
    private ?string $typeRepas = null;

    #[ORM\ManyToOne( cascade: ['persist'], inversedBy: 'restaurations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inscription $inscription = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRestauration(): ?\DateTimeInterface
    {
        return $this->dateRestauration;
    }

    public function setDateRestauration(\DateTimeInterface $dateRestauration): self
    {
        $this->dateRestauration = $dateRestauration;

        return $this;
    }

    public function getTypeRepas(): ?string
    {
        return $this->typeRepas;
    }

    public function setTypeRepas(string $typeRepas): self
    {
        $this->typeRepas = $typeRepas;

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
}
