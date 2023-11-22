<?php

namespace App\Entity;

use App\Repository\TypeInstrumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeInstrumentRepository::class)]
class TypeInstrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;


    #[ORM\ManyToOne(inversedBy: 'typeinstrument')]
    private ?Instrument $instrument = null;

    #[ORM\OneToMany(mappedBy: 'typeInstrument', targetEntity: ClasseInstrument::class)]
    private Collection $classeintrument;

    public function __construct()
    {
        $this->classeintrument = new ArrayCollection();

    #[ORM\OneToMany(mappedBy: 'typeInstrument', targetEntity: Cours::class)]
    private Collection $cours;

    public function __construct()
    {
        $this->cours = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

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
     * @return Collection<int, ClasseInstrument>
     */
    public function getClasseintrument(): Collection
    {
        return $this->classeintrument;
    }

    public function addClasseintrument(ClasseInstrument $classeintrument): static
    {
        if (!$this->classeintrument->contains($classeintrument)) {
            $this->classeintrument->add($classeintrument);
            $classeintrument->setTypeInstrument($this);

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): static
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setTypeInstrument($this);

        }

        return $this;
    }


  public function removeClasseintrument(ClasseInstrument $classeintrument): static
    {
        if ($this->classeintrument->removeElement($classeintrument)) {
            // set the owning side to null (unless already changed)
            if ($classeintrument->getTypeInstrument() === $this) {
                $classeintrument->setTypeInstrument(null);
            }
        }

        return $this;
    }

    public function removeCour(Cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getTypeInstrument() === $this) {
                $cour->setTypeInstrument(null);

            }
        }

        return $this;
    }
}
