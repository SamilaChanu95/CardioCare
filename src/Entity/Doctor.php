<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DoctorRepository")
 */
class Doctor
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
    private $dNIC;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $dFirstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $dLastName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $dGender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dAddress;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $dDOB;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $dPhoneNumber;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $dRole;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="doctors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Department;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unit", inversedBy="doctors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Unit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ward", inversedBy="doctors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Ward;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Surgery", mappedBy="Doctor")
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

    public function getDNIC(): ?string
    {
        return $this->dNIC;
    }

    public function setDNIC(string $dNIC): self
    {
        $this->dNIC = $dNIC;

        return $this;
    }

    public function getDFirstName(): ?string
    {
        return $this->dFirstName;
    }

    public function setDFirstName(string $dFirstName): self
    {
        $this->dFirstName = $dFirstName;

        return $this;
    }

    public function getDLastName(): ?string
    {
        return $this->dLastName;
    }

    public function setDLastName(string $dLastName): self
    {
        $this->dLastName = $dLastName;

        return $this;
    }

    public function getDGender(): ?string
    {
        return $this->dGender;
    }

    public function setDGender(string $dGender): self
    {
        $this->dGender = $dGender;

        return $this;
    }

    public function getDAddress(): ?string
    {
        return $this->dAddress;
    }

    public function setDAddress(string $dAddress): self
    {
        $this->dAddress = $dAddress;

        return $this;
    }

    public function getDDOB(): ?string
    {
        return $this->dDOB;
    }

    public function setDDOB(string $dDOB): self
    {
        $this->dDOB = $dDOB;

        return $this;
    }

    public function getDPhoneNumber(): ?string
    {
        return $this->dPhoneNumber;
    }

    public function setDPhoneNumber(string $dPhoneNumber): self
    {
        $this->dPhoneNumber = $dPhoneNumber;

        return $this;
    }

    public function getDRole(): ?string
    {
        return $this->dRole;
    }

    public function setDRole(string $dRole): self
    {
        $this->dRole = $dRole;

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
            $surgery->setDoctor($this);
        }

        return $this;
    }

    public function removeSurgery(Surgery $surgery): self
    {
        if ($this->surgeries->contains($surgery)) {
            $this->surgeries->removeElement($surgery);
            // set the owning side to null (unless already changed)
            if ($surgery->getDoctor() === $this) {
                $surgery->setDoctor(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->dFirstName;
    }

    /** 
    *public function getImage()
    *{
    *    return $this->image;
    *}
    *public function setImage($image)
    *{
    *   $this->image = $image;
    *    return $this;
    *}
    */

}
