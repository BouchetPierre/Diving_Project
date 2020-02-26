<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @Table(name="reservation",uniqueConstraints={@UniqueConstraint(name="resa_idx", columns={"fk_id_member_id", "fk_id_diving_id"})})
 *
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="fkIdResa", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkIdMember;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Diving", inversedBy="fkIdResa", cascade={"persist"})
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

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $needCar;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $driverCar;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $placeCar;

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

    public function getNeedCar(): ?bool
    {
        return $this->needCar;
    }

    public function setNeedCar(?bool $needCar): self
    {
        $this->needCar = $needCar;

        return $this;
    }

    public function getDriverCar(): ?bool
    {
        return $this->driverCar;
    }

    public function setDriverCar(?bool $driverCar): self
    {
        $this->driverCar = $driverCar;

        return $this;
    }

    public function getPlaceCar(): ?int
    {
        return $this->placeCar;
    }

    public function setPlaceCar(?int $placeCar): self
    {
        $this->placeCar = $placeCar;

        return $this;
    }
}
