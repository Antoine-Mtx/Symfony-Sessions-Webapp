<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleFormation
 *
 * @ORM\Table(name="module_formation", indexes={@ORM\Index(name="IDX_1A213E77BCF5E72D", columns={"categorie_id"})})
 * @ORM\Entity
 */
class ModuleFormation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=75, nullable=false)
     */
    private $intitule;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=false)
     */
    private $description;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
     * })
     */
    private $categorie;


}
