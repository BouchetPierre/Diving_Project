<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\DivingRepository")
 * @UniqueEntity(
 *     fields={"date"},
 *     message="il y a déjà une plongée de programmée à cette date !!!"
 * )
 */
class Diving
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $places;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $levelMin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="fkIdDiving", cascade={"persist", "remove"})
     */
    private $fkIdResa;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $placeResa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getLevelMin(): ?string
    {
        return $this->levelMin;
    }

    public function setLevelMin(string $levelMin): self
    {
        $this->levelMin = $levelMin;

        return $this;
    }

    public function getFkIdResa(): ?Reservation
    {
        return $this->fkIdResa;
    }

    public function setFkIdResa(Reservation $fkIdResa): self
    {
        $this->fkIdResa = $fkIdResa;

        // set the owning side of the relation if necessary
        if ($this !== $fkIdResa->getFkIdDiving()) {
            $fkIdResa->setFkIdDiving($this);
        }

        return $this;
    }

    public function getPlaceResa(): ?int
    {
        return $this->placeResa;
    }

    public function setPlaceResa(?int $placeResa): self
    {
        $this->placeResa = $placeResa;

        return $this;
    }
}
