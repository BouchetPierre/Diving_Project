<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sex;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $levelDive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instructor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthdayDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer")
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone2;

    /**
     * @ORM\Column(type="integer")
     */
    private $numLicense;

    /**
     * @ORM\Column(type="boolean")
     */
    private $boatLicense;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="fkIdMember", cascade={"persist", "remove"})
     */
    private $kfIdResa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getLevelDive(): ?string
    {
        return $this->levelDive;
    }

    public function setLevelDive(string $levelDive): self
    {
        $this->levelDive = $levelDive;

        return $this;
    }

    public function getInstructor(): ?string
    {
        return $this->instructor;
    }

    public function setInstructor(?string $instructor): self
    {
        $this->instructor = $instructor;

        return $this;
    }

    public function getBirthdayDate(): ?\DateTimeInterface
    {
        return $this->birthdayDate;
    }

    public function setBirthdayDate(\DateTimeInterface $birthdayDate): self
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone1(): ?string
    {
        return $this->phone1;
    }

    public function setPhone1(string $phone1): self
    {
        $this->phone1 = $phone1;

        return $this;
    }

    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    public function setPhone2(string $phone2): self
    {
        $this->phone2 = $phone2;

        return $this;
    }

    public function getNumLicense(): ?int
    {
        return $this->numLicense;
    }

    public function setNumLicense(int $numLicense): self
    {
        $this->numLicense = $numLicense;

        return $this;
    }

    public function getBoatLicense(): ?bool
    {
        return $this->boatLicense;
    }

    public function setBoatLicense(bool $boatLicense): self
    {
        $this->boatLicense = $boatLicense;

        return $this;
    }

    public function getKfIdResa(): ?Reservation
    {
        return $this->kfIdResa;
    }

    public function setKfIdResa(?Reservation $kfIdResa): self
    {
        $this->kfIdResa = $kfIdResa;

        // set (or unset) the owning side of the relation if necessary
        $newFkIdMember = $kfIdResa === null ? null : $this;
        if ($newFkIdMember !== $kfIdResa->getFkIdMember()) {
            $kfIdResa->setFkIdMember($newFkIdMember);
        }

        return $this;
    }

    /**
     * (PHP 5 &gt;=5.5.0)<br/>
     * Returns the difference between two DateTime objects
     * @link https://secure.php.net/manual/en/datetime.diff.php
     * @param DateTimeInterface $datetime2 <p>The date to compare to.</p>
     * @param bool $absolute <p>Should the interval be forced to be positive?</p>
     * @return DateInterval
     * The https://secure.php.net/manual/en/class.dateinterval.php DateInterval} object representing the
     * difference between the two dates or <b>FALSE</b> on failure.
     *
     */
    public function diff($datetime2, $absolute = false)
    {
        // TODO: Implement diff() method.
    }

    /**
     * (PHP 5 &gt;=5.5.0)<br/>
     * Returns date formatted according to given format
     * @link https://secure.php.net/manual/en/datetime.format.php
     * @param string $format <p>
     * Format accepted by  {@link https://secure.php.net/manual/en/function.date.php date()}.
     * </p>
     * @return string
     * Returns the formatted date string on success or <b>FALSE</b> on failure.
     *
     */
    public function format($format)
    {
        // TODO: Implement format() method.
    }

    /**
     * (PHP 5 &gt;=5.5.0)<br/>
     * Returns the timezone offset
     * @return int
     * Returns the timezone offset in seconds from UTC on success
     * or <b>FALSE</b> on failure.
     *
     */
    public function getOffset()
    {
        // TODO: Implement getOffset() method.
    }

    /**
     * (PHP 5 &gt;=5.5.0)<br/>
     * Gets the Unix timestamp
     * @return int
     * Returns the Unix timestamp representing the date.
     */
    public function getTimestamp()
    {
        // TODO: Implement getTimestamp() method.
    }

    /**
     * (PHP 5 &gt;=5.5.0)<br/>
     * Return time zone relative to given DateTime
     * @link https://secure.php.net/manual/en/datetime.gettimezone.php
     * @return DateTimeZone
     * Returns a {@link https://secure.php.net/manual/en/class.datetimezone.php DateTimeZone} object on success
     * or <b>FALSE</b> on failure.
     */
    public function getTimezone()
    {
        // TODO: Implement getTimezone() method.
    }

    /**
     * (PHP 5 &gt;=5.5.0)<br/>
     * The __wakeup handler
     * @link https://secure.php.net/manual/en/datetime.wakeup.php
     * @return void Initializes a DateTime object.
     */
    public function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }
}
