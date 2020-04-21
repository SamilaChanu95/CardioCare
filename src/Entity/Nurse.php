<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NurseRepository")
 */
class Nurse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nNIC;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nFirstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nLastName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nGender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nAddress;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nDOB;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nPhoneNumber;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nRole;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="nurses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Department;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unit", inversedBy="nurses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Unit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ward", inversedBy="nurses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Ward;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Surgery", mappedBy="Nurse")
     */
    private $surgeries;

    protected $captchaCode;
    
    public function getCaptchaCode()
    {
      return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
      $this->captchaCode = $captchaCode;
    }


    public function __construct()
    {
        $this->surgeries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNNIC(): ?string
    {
        return $this->nNIC;
    }

    public function setNNIC(string $nNIC): self
    {
        $this->nNIC = $nNIC;

        return $this;
    }

    public function getNFirstName(): ?string
    {
        return $this->nFirstName;
    }

    public function setNFirstName(string $nFirstName): self
    {
        $this->nFirstName = $nFirstName;

        return $this;
    }

    public function getNLastName(): ?string
    {
        return $this->nLastName;
    }

    public function setNLastName(string $nLastName): self
    {
        $this->nLastName = $nLastName;

        return $this;
    }

    public function getNGender(): ?string
    {
        return $this->nGender;
    }

    public function setNGender(string $nGender): self
    {
        $this->nGender = $nGender;

        return $this;
    }

    public function getNAddress(): ?string
    {
        return $this->nAddress;
    }

    public function setNAddress(string $nAddress): self
    {
        $this->nAddress = $nAddress;

        return $this;
    }

    public function getNDOB(): ?string
    {
        return $this->nDOB;
    }

    public function setNDOB(string $nDOB): self
    {
        $this->nDOB = $nDOB;

        return $this;
    }

    public function getNPhoneNumber(): ?string
    {
        return $this->nPhoneNumber;
    }

    public function setNPhoneNumber(string $nPhoneNumber): self
    {
        $this->nPhoneNumber = $nPhoneNumber;

        return $this;
    }

    public function getNRole(): ?string
    {
        return $this->nRole;
    }

    public function setNRole(string $nRole): self
    {
        $this->nRole = $nRole;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->Department;
    }

    public function setDepartment(?Department $Department): self
    {
        $this->Department = $Department;

        return $this;
    }

    public function getUnit(): ?Unit
    {
        return $this->Unit;
    }

    public function setUnit(?Unit $Unit): self
    {
        $this->Unit = $Unit;

        return $this;
    }

    public function getWard(): ?Ward
    {
        return $this->Ward;
    }

    public function setWard(?Ward $Ward): self
    {
        $this->Ward = $Ward;

        return $this;
    }

    /**
     * @return Collection|Surgery[]
     */
    public function getSurgeries(): Collection
    {
        return $this->surgeries;
    }

    public function addSurgery(Surgery $surgery): self
    {
        if (!$this->surgeries->contains($surgery)) {
            $this->surgeries[] = $surgery;
            $surgery->setNurse($this);
        }

        return $this;
    }

    public function removeSurgery(Surgery $surgery): self
    {
        if ($this->surgeries->contains($surgery)) {
            $this->surgeries->removeElement($surgery);
            // set the owning side to null (unless already changed)
            if ($surgery->getNurse() === $this) {
                $surgery->setNurse(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nFirstName;
    }

}
