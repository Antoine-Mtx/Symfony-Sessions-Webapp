<?php

namespace App\Entity;

use DateTime;
use App\Entity\Session;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="formation", orphanRemoval=true)
     */
    private $session;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $intitule;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function __construct()
    {
        $this->session = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSession(): Collection
    {
        return $this->session;
    }

    public function addSession(Session $session): self
    {
        if (!$this->session->contains($session)) {
            $this->session[] = $session;
            $session->setFormation($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->session->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getFormation() === $this) {
                $session->setFormation(null);
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

    public function __toString()
    {
        return ucfirst($this->intitule);
    }

    // retourne un tableau associatif des sessions en fonction de leur statut ("passé/en cours/à venir")

    public function getSessionsStatut() {
        $now = new DateTime();
        $sessionsStatut = [
            "passées" => [],
            "en cours" => [],
            "à venir" => [],
        ];
        foreach ($this->session as $session) {
            if ($session->getDateDebut() > $now) {
                $sessionsStatut["à venir"] []= $session;
            } else if ($session->getDateFin() < $now) {
                $sessionsStatut["passées"] []= $session;
            } else {
                $sessionsStatut["en cours"] []= $session;
            }
        }
        return $sessionsStatut;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

}
