<?php

namespace App\Entity;

use App\Repository\InstrumentCouleurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstrumentCouleurRepository::class)]
class InstrumentCouleur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'instrumentCouleurs')]
    private ?Couleur $Couleur = null;

    #[ORM\ManyToOne(inversedBy: 'instrumentCouleurs')]
    private ?Instrument $Instrument = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCouleur(): ?Couleur
    {
        return $this->Couleur;
    }

    public function setCouleur(?Couleur $Couleur): static
    {
        $this->Couleur = $Couleur;

        return $this;
    }

    public function getInstrument(): ?Instrument
    {
        return $this->Instrument;
    }

    public function setInstrument(?Instrument $Instrument): static
    {
        $this->Instrument = $Instrument;

        return $this;
    }
}
