<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $intitule;

    /**
     * @ORM\OneToMany(targetEntity=ModuleFormation::class, mappedBy="categorie")
     */
    private $ModuleFormation;

    public function __construct()
    {
        $this->ModuleFormation = new ArrayCollection();
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

    /**
     * @return Collection<int, ModuleFormation>
     */
    public function getModuleFormation(): Collection
    {
        return $this->ModuleFormation;
    }

    public function addModuleFormation(ModuleFormation $moduleFormation): self
    {
        if (!$this->ModuleFormation->contains($moduleFormation)) {
            $this->ModuleFormation[] = $moduleFormation;
            $moduleFormation->setCategorie($this);
        }

        return $this;
    }

    public function removeModuleFormation(ModuleFormation $moduleFormation): self
    {
        if ($this->ModuleFormation->removeElement($moduleFormation)) {
            // set the owning side to null (unless already changed)
            if ($moduleFormation->getCategorie() === $this) {
                $moduleFormation->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return ucfirst($this->intitule);
    }
}
