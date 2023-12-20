<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]

    private ?string $libelle = null;

    #[ORM\Column]
    #[Assert\Regex(pattern : "/^\d+$/", message:"Veuillez saisir uniquement des chiffres.")]
    #[Assert\Range(
        notInRangeMessage: "l'age ne doit pas être plus petit que 3 ans et plus grand que 99 ans",
        min : 3,
        max : 99
    )]
    #[Assert\Expression('this.getAgeMini() < this.getAgeMaxi()',
    message : "L'age minimun ne peux pas être supérieur à l'age maximum.")]
    private ?int $ageMini = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Expression('this.getHeureDebut() < this.getHeureFin()',
    message : "L'heure de début ne peux pas être supérieur a l'heure de fin.")]
    #[Assert\LessThan('07:00',
    message: "L'heure de début doit être supérieur à 7h")]
    private ?\DateTimeInterface $heureDebut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Expression('this.getHeureDebut() < this.getHeureFin()',
        message : "L'heure de fin ne peux pas être antérieur a l'heure de debut.")]
    #[Assert\LessThan('07:00',
        message: "L'heure de fin doit être supérieur à 7h")]
    private ?\DateTimeInterface $heureFin = null;

    #[ORM\Column]
    #[Assert\Positive(message:"Le nombre de places doit être supérieur à 0")]
    #[Assert\Range(
        notInRangeMessage:"le nombre de place ne peut pas être supérieur à 25 et inférieur à 1",
        min : 1,
        max : 25
    )]
    private ?int $nbPlaces = null;

    #[ORM\Column]
    #[Assert\Regex(pattern : "/^\d+$/", message:"Veuillez saisir uniquement des chiffres.")]
    #[Assert\Range(
        notInRangeMessage: "l'age ne doit pas être plus petit que 3 ans et plus grand que 99 ans",
        min : 3,
        max : 99
    )]
    #[Assert\Expression('this.getAgeMini() < this.getAgeMaxi()',
        message : "L'age minimun ne peux pas être supérieur à l'age maximum.")]
    private ?int $ageMaxi = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Jour $jour = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?TypeCours $typeCours = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?TypeInstrument $typeInstrument = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Professeur $professeur = null;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Inscription::class)]
    private Collection $inscriptions;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
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

    public function getAgeMini(): ?int
    {
        return $this->ageMini;
    }

    public function setAgeMini(int $ageMini): static
    {
        $this->ageMini = $ageMini;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(?\DateTimeInterface $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(?\DateTimeInterface $heureFin): static
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(int $nbPlaces): static
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    public function getAgeMaxi(): ?int
    {
        return $this->ageMaxi;
    }

    public function setAgeMaxi(int $ageMaxi): static
    {
        $this->ageMaxi = $ageMaxi;

        return $this;
    }

    public function getJour(): ?Jour
    {
        return $this->jour;
    }

    public function setJour(?Jour $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

    public function getTypeCours(): ?TypeCours
    {
        return $this->typeCours;
    }

    public function setTypeCours(?TypeCours $typeCours): static
    {
        $this->typeCours = $typeCours;

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

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): static
    {
        $this->professeur = $professeur;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setCours($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getCours() === $this) {
                $inscription->setCours(null);
            }
        }

        return $this;
    }
}
