<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TechnicianRepository")
 */
class Technician
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
    private $tNIC;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $tFirstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $tLastName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $tGender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tAddress;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $tDOB;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $tPhoneNumber;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $tRole;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="technicians")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Department;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unit", inversedBy="technicians")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Unit;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Surgery", mappedBy="Technician")
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

    public function getTNIC(): ?string
    {
        return $this->tNIC;
    }

    public function setTNIC(string $tNIC): self
    {
        $this->tNIC = $tNIC;

        return $this;
    }

    public function getTFirstName(): ?string
    {
        return $this->tFirstName;
    }

    public function setTFirstName(string $tFirstName): self
    {
        $this->tFirstName = $tFirstName;

        return $this;
    }

    public function getTLastName(): ?string
    {
        return $this->tLastName;
    }

    public function setTLastName(string $tLastName): self
    {
        $this->tLastName = $tLastName;

        return $this;
    }

    public function getTGender(): ?string
    {
        return $this->tGender;
    }

    public function setTGender(string $tGender): self
    {
        $this->tGender = $tGender;

        return $this;
    }

    public function getTAddress(): ?string
    {
        return $this->tAddress;
    }

    public function setTAddress(string $tAddress): self
    {
        $this->tAddress = $tAddress;

        return $this;
    }

    public function getTDOB(): ?string
    {
        return $this->tDOB;
    }

    public function setTDOB(string $tDOB): self
    {
        $this->tDOB = $tDOB;

        return $this;
    }

    public function getTPhoneNumber(): ?string
    {
        return $this->tPhoneNumber;
    }

    public function setTPhoneNumber(string $tPhoneNumber): self
    {
        $this->tPhoneNumber = $tPhoneNumber;

        return $this;
    }

    public function getTRole(): ?string
    {
        return $this->tRole;
    }

    public function setTRole(string $tRole): self
    {
        $this->tRole = $tRole;

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
            $surgery->setTechnician($this);
        }

        return $this;
    }

    public function removeSurgery(Surgery $surgery): self
    {
        if ($this->surgeries->contains($surgery)) {
            $this->surgeries->removeElement($surgery);
            // set the owning side to null (unless already changed)
            if ($surgery->getTechnician() === $this) {
                $surgery->setTechnician(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->tFirstName;
    }

}
