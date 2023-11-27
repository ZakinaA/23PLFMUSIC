<?php

namespace App\Entity;

use App\Entity\Marque;
use App\Entity\TypeInstrument;
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






    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?Marque $marque = null;

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?TypeInstrument $typeInstrument = null;

    #[ORM\OneToMany(mappedBy: 'Instrument', targetEntity: InstrumentCouleur::class)]
    private Collection $instrumentCouleurs;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: Accessoire::class)]
    private Collection $accessoire;



    //#[ORM\onetomany(targetEntity: Couleur::class, inversedBy: 'instruments')]
    //private ?Couleur $couleurs = null;



    public function __construct()
    {

        $this->couleurs = new ArrayCollection();

        $this->instrumentCouleurs = new ArrayCollection();
        $this->accessoire = new ArrayCollection();
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






    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getCouleurs(): ?Couleurs
    {
        return $this->couleurs;
    }

    public function setCouleurs(?Couleurs $couleurs): static
    {
        $this->couleurs = $couleurs;

        return $this;
    }

    public function getTypeInstrument(): ?TypeInstrument
    {
        return $this->typeInstrument;
    }

    public function setTypeInstrument(?TypeInstrument $typeInstrument): static
    {
        $this->typeInstrument = $typeInstrument;

        return $this;
    }

    /**
     * @return Collection<int, Couleur>
     */
    public function getCouleur(): Collection
    {
        return $this->couleurs;
    }

    public function addCouleur(Couleur $couleur): static
    {
        if (!$this->couleurs->contains($couleur)) {
            $this->couleurs->add($couleur);
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
            $instrumentCouleur->setInstrument($this);
        }

        return $this;
    }

    public function removeInstrumentCouleur(InstrumentCouleur $instrumentCouleur): static
    {
        if ($this->instrumentCouleurs->removeElement($instrumentCouleur)) {
            // set the owning side to null (unless already changed)
            if ($instrumentCouleur->getInstrument() === $this) {
                $instrumentCouleur->setInstrument(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Accessoire>
     */
    public function getAccessoire(): Collection
    {
        return $this->accessoire;
    }

    public function addAccessoire(Accessoire $accessoire): static
    {
        if (!$this->accessoire->contains($accessoire)) {
            $this->accessoire->add($accessoire);
            $accessoire->setInstrument($this);
        }

        return $this;
    }

    public function removeAccessoire(Accessoire $accessoire): static
    {
        if ($this->accessoire->removeElement($accessoire)) {
            // set the owning side to null (unless already changed)
            if ($accessoire->getInstrument() === $this) {
                $accessoire->setInstrument(null);
            }
        }

        return $this;
    }


}
