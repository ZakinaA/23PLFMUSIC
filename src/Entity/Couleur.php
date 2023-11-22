<?php

namespace App\Entity;

use App\Repository\CouleurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouleurRepository::class)]
class Couleur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Instrument::class, mappedBy: 'couleur')]
    private Collection $instruments;

    #[ORM\OneToMany(mappedBy: 'Couleur', targetEntity: InstrumentCouleur::class)]
    private Collection $instrumentCouleurs;

    public function __construct()
    {
        $this->instruments = new ArrayCollection();
        $this->instrumentCouleurs = new ArrayCollection();
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

    /**
     * @return Collection<int, Instrument>
     */
    public function getInstruments(): Collection
    {
        return $this->instruments;
    }

    public function addInstrument(Instrument $instrument): static
    {
        if (!$this->instruments->contains($instrument)) {
            $this->instruments->add($instrument);
            $instrument->addCouleur($this);
        }

        return $this;
    }

    public function removeInstrument(Instrument $instrument): static
    {
        if ($this->instruments->removeElement($instrument)) {
            $instrument->removeCouleur($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, InstrumentCouleur>
     */
    public function getInstrumentCouleurs(): Collection
    {
        return $this->instrumentCouleurs;
    }

    public function addInstrumentCouleur(InstrumentCouleur $instrumentCouleur): static
    {
        if (!$this->instrumentCouleurs->contains($instrumentCouleur)) {
            $this->instrumentCouleurs->add($instrumentCouleur);
            $instrumentCouleur->setCouleur($this);
        }

        return $this;
    }

    public function removeInstrumentCouleur(InstrumentCouleur $instrumentCouleur): static
    {
        if ($this->instrumentCouleurs->removeElement($instrumentCouleur)) {
            // set the owning side to null (unless already changed)
            if ($instrumentCouleur->getCouleur() === $this) {
                $instrumentCouleur->setCouleur(null);
            }
        }

        return $this;
    }
}
