<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="kfIdResa", cascade={"persist", "remove"})
     */
    private $fkIdMember;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Diving", inversedBy="fkIdResa", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkIdDiving;

    /**
     * @ORM\Column(type="boolean")
     */
    private $regulator;

    /**
     * @ORM\Column(type="boolean")
     */
    private $wetSuit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sizeSuit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkIdMember(): ?Member
    {
        return $this->fkIdMember;
    }

    public function setFkIdMember(?Member $fkIdMember): self
    {
        $this->fkIdMember = $fkIdMember;

        return $this;
    }

    public function getFkIdDiving(): ?Diving
    {
        return $this->fkIdDiving;
    }

    public function setFkIdDiving(Diving $fkIdDiving): self
    {
        $this->fkIdDiving = $fkIdDiving;

        return $this;
    }

    public function getRegulator(): ?bool
    {
        return $this->regulator;
    }

    public function setRegulator(bool $regulator): self
    {
        $this->regulator = $regulator;

        return $this;
    }

    public function getWetSuit(): ?bool
    {
        return $this->wetSuit;
    }

    public function setWetSuit(bool $wetSuit): self
    {
        $this->wetSuit = $wetSuit;

        return $this;
    }

    public function getSizeSuit(): ?string
    {
        return $this->sizeSuit;
    }

    public function setSizeSuit(?string $sizeSuit): self
    {
        $this->sizeSuit = $sizeSuit;

        return $this;
    }
}
