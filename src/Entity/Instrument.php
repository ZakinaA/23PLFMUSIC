<?php

namespace App\Entity;

use App\Repository\InstrumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstrumentRepository::class)]
class Instrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numSerie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateAchat = null;

    #[ORM\Column]
    private ?float $prixAchat = null;

    #[ORM\Column(length: 255)]
    private ?string $utilisation = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $cheminImage = null;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: Marque::class)]
    private Collection $marque;

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?Accessoire $accessoire = null;

    #[ORM\ManyToMany(targetEntity: Couleur::class, inversedBy: 'instruments')]
    private Collection $couleur;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: TypeInstrument::class)]
    private Collection $typeinstrument;

    public function __construct()
    {
        $this->marque = new ArrayCollection();
        $this->couleur = new ArrayCollection();
        $this->typeinstrument = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSerie(): ?int
    {
        return $this->numSerie;
    }

    public function setNumSerie(int $numSerie): static
    {
        $this->numSerie = $numSerie;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->dateAchat;
    }

    public function setDateAchat(\DateTimeInterface $dateAchat): static
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(float $prixAchat): static
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    public function getUtilisation(): ?string
    {
        return $this->utilisation;
    }

    public function setUtilisation(string $utilisation): static
    {
        $this->utilisation = $utilisation;

        return $this;
    }

    public function getCheminImage(): ?string
    {
        return $this->cheminImage;
    }

    public function setCheminImage(?string $cheminImage): static
    {
        $this->cheminImage = $cheminImage;

        return $this;
    }

    /**
     * @return Collection<int, Marque>
     */
    public function getMarque(): Collection
    {
        return $this->marque;
    }

    public function addMarque(Marque $marque): static
    {
        if (!$this->marque->contains($marque)) {
            $this->marque->add($marque);
            $marque->setInstrument($this);
        }

        return $this;
    }

    public function removeMarque(Marque $marque): static
    {
        if ($this->marque->removeElement($marque)) {
            // set the owning side to null (unless already changed)
            if ($marque->getInstrument() === $this) {
                $marque->setInstrument(null);
            }
        }

        return $this;
    }

    public function getAccessoire(): ?Accessoire
    {
        return $this->accessoire;
    }

    public function setAccessoire(?Accessoire $accessoire): static
    {
        $this->accessoire = $accessoire;

        return $this;
    }

    /**
     * @return Collection<int, Couleur>
     */
    public function getCouleur(): Collection
    {
        return $this->couleur;
    }

    public function addCouleur(Couleur $couleur): static
    {
        if (!$this->couleur->contains($couleur)) {
            $this->couleur->add($couleur);
        }

        return $this;
    }

    public function removeCouleur(Couleur $couleur): static
    {
        $this->couleur->removeElement($couleur);

        return $this;
    }

    /**
     * @return Collection<int, TypeInstrument>
     */
    public function getTypeinstrument(): Collection
    {
        return $this->typeinstrument;
    }

    public function addTypeinstrument(TypeInstrument $typeinstrument): static
    {
        if (!$this->typeinstrument->contains($typeinstrument)) {
            $this->typeinstrument->add($typeinstrument);
            $typeinstrument->setInstrument($this);
        }

        return $this;
    }

    public function removeTypeinstrument(TypeInstrument $typeinstrument): static
    {
        if ($this->typeinstrument->removeElement($typeinstrument)) {
            // set the owning side to null (unless already changed)
            if ($typeinstrument->getInstrument() === $this) {
                $typeinstrument->setInstrument(null);
            }
        }

        return $this;
    }
}
