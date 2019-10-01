<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Member", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkIdMember;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $access;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkIdMember(): ?Member
    {
        return $this->fkIdMember;
    }

    public function setFkIdMember(Member $fkIdMember): self
    {
        $this->fkIdMember = $fkIdMember;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAccess(): ?string
    {
        return $this->access;
    }

    public function setAccess(string $access): self
    {
        $this->access = $access;

        return $this;
    }
}
