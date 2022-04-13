<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=75)
     */
    private $intitule;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlaces;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="session")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formateurReferent;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="session")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formation;

    /**
     * @ORM\ManyToMany(targetEntity=Stagiaire::class, mappedBy="session")
     */
    private $stagiaires;

    /**
     * @ORM\OneToMany(targetEntity=Programme::class, mappedBy="session", cascade={"persist"})
     */
    private $programmes;

    public function __construct()
    {
        $this->stagiaires = new ArrayCollection();
        $this->programmes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(int $nbPlaces): self
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
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

    public function getFormateurReferent(): ?Formateur
    {
        return $this->formateurReferent;
    }

    public function setFormateurReferent(?Formateur $formateurReferent): self
    {
        $this->formateurReferent = $formateurReferent;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection<int, Stagiaire>
     */
    public function getStagiaires(): Collection
    {
        return $this->stagiaires;
    }

    public function addStagiaire(Stagiaire $stagiaire): self
    {
        if (!$this->stagiaires->contains($stagiaire)) {
            $this->stagiaires[] = $stagiaire;
            $stagiaire->addSession($this);
        }

        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): self
    {
        if ($this->stagiaires->removeElement($stagiaire)) {
            $stagiaire->removeSession($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): self
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes[] = $programme;
            $programme->setSession($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): self
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getSession() === $this) {
                $programme->setSession(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return ucfirst($this->intitule);
    }

    // public function trieParCategorieProgramme()
    // {
    //     $programmesTries = $this->programmes;
    //     $programmesTries->uasort(function ($a, $b) {
    //         if ($a->categorie == $b->categorie) {
    //             return 0;
    //         }
    //         return ($a->categorie < $b->categorie) ? -1 : 1;
    //     });
    //     return $programmesTries;
    // }

}
