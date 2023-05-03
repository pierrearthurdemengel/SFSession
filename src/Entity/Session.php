<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Form\FormTypeInterface;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    private ?int $nombrePlaces = null;

    #[ORM\ManyToMany(targetEntity: Stagiaire::class, inversedBy: 'sessions')]
    private Collection $stagiaire;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Programme::class)]
    private Collection $programme;

    #[ORM\Column(length: 50)]
    private ?string $intitule = null;

    #[ORM\OneToOne(inversedBy: 'session', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formateur $formateur = null;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Categorie::class)]
    private Collection $categorie;

    public function __construct()
    {
        $this->stagiaire = new ArrayCollection();
        $this->programme = new ArrayCollection();
        $this->categorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNombrePlaces(): ?int
    {
        return $this->nombrePlaces;
    }

    public function setNombrePlaces(int $nombrePlaces): self
    {
        $this->nombrePlaces = $nombrePlaces;

        return $this;
    }

    public function __toString()
    {
        return "La session ". $this->id." a lieu du " .$this->dateDebut->format('Y-m-d')." au ".$this->dateFin->format('Y-m-d'). " nombre de places : ".$this->nombrePlaces;
    }

    /**
     * @return Collection<int, Stagiaire>
     */
    public function getStagiaire(): Collection
    {
        return $this->stagiaire;
    }

    public function addStagiaire(Stagiaire $stagiaire): self
    {
        if (!$this->stagiaire->contains($stagiaire)) {
            $this->stagiaire->add($stagiaire);
        }

        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): self
    {
        $this->stagiaire->removeElement($stagiaire);

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgramme(): Collection
    {
        return $this->programme;
    }

    public function addProgramme(Programme $programme): self
    {
        if (!$this->programme->contains($programme)) {
            $this->programme->add($programme);
            $programme->setSession($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): self
    {
        if ($this->programme->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getSession() === $this) {
                $programme->setSession(null);
            }
        }

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie->add($categorie);
            $categorie->setSession($this);
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        if ($this->categorie->removeElement($categorie)) {
            // set the owning side to null (unless already changed)
            if ($categorie->getSession() === $this) {
                $categorie->setSession(null);
            }
        }

        return $this;
    }
}
// session to stagiaire ManyToMany
// Module/Session vers programme OneToMany