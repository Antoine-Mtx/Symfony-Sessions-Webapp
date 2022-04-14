<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Programme
 *
 * @ORM\Table(name="programme", indexes={@ORM\Index(name="IDX_3DDCB9FF3A53B0DC", columns={"module_formation_id"}), @ORM\Index(name="IDX_3DDCB9FF613FECDF", columns={"session_id"})})
 * @ORM\Entity
 */
class Programme
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
     * @var int
     *
     * @ORM\Column(name="nb_jours", type="integer", nullable=false)
     */
    private $nbJours;

    /**
     * @var \ModuleFormation
     *
     * @ORM\ManyToOne(targetEntity="ModuleFormation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="module_formation_id", referencedColumnName="id")
     * })
     */
    private $moduleFormation;

    /**
     * @var \Session
     *
     * @ORM\ManyToOne(targetEntity="Session")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="session_id", referencedColumnName="id")
     * })
     */
    private $session;


}
