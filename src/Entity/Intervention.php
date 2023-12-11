<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Intervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptif = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prix = null;

    #[ORM\ManyToOne(inversedBy: 'interventions')]
    private ?Professionnel $professionnel = null;

    #[ORM\ManyToOne(inversedBy: 'interventions')]
    private ?Instrument $instrument = null;

    #[ORM\OneToMany(mappedBy: 'intervention', targetEntity: InterPret::class)]
    private Collection $interPrets;

    public function __construct()
    {
        $this->interPrets = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): static
    {
        $this->descriptif = $descriptif;

        return $this;
    }


    public function getPrix(): ?string

    {
        return $this->prix;
    }

    public function setPrix(string $prix): static

    {
        $this->prix = $prix;

        return $this;
    }


    public function getProfessionnel(): ?Professionnel
    {
        return $this->professionnel;
    }

    public function setProfessionnel(?Professionnel $professionnel): static
    {
        $this->professionnel = $professionnel;

        return $this;
    }

    public function getInstrument(): ?Instrument
    {
        return $this->instrument;
    }

    public function setInstrument(?Instrument $instrument): static
    {
        $this->instrument = $instrument;

        return $this;
    }

    /**
     * @return Collection<int, InterPret>
     */
    public function getInterPrets(): Collection
    {
        return $this->interPrets;
    }

    public function addInterPret(InterPret $interPret): static
    {
        if (!$this->interPrets->contains($interPret)) {
            $this->interPrets->add($interPret);
            $interPret->setIntervention($this);
        }

        return $this;
    }

    public function removeInterPret(InterPret $interPret): static
    {
        if ($this->interPrets->removeElement($interPret)) {
            // set the owning side to null (unless already changed)
            if ($interPret->getIntervention() === $this) {
                $interPret->setIntervention(null);
            }
        }

        return $this;
    }

}
