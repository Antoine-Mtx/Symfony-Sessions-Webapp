<?php

namespace App\Entity;

use App\Repository\FormateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 */
class Formateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="formateurReferent")
     */
    private $session;

    public function __construct()
    {
        $this->session = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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
            $session->setFormateurReferent($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->session->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getFormateurReferent() === $this) {
                $session->setFormateurReferent(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return ucfirst($this->prenom)." ".strtoupper($this->nom);
    }
}
