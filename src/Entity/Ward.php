<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WardRepository")
 */
class Ward
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
    private $WardName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nurse", mappedBy="Ward")
     */
    private $nurses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Doctor", mappedBy="Ward")
     */
    private $doctors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Consultant", mappedBy="Ward")
     */
    private $consultants;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Technician", mappedBy="Ward")
     */
    private $technicians;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="wards")
     */
    private $Department;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unit", inversedBy="wards")
     */
    private $Unit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hospital", inversedBy="wards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Hospital;

    public function __construct()
    {
        $this->nurses = new ArrayCollection();
        $this->doctors = new ArrayCollection();
        $this->consultants = new ArrayCollection();
        $this->technicians = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWardName(): ?string
    {
        return $this->WardName;
    }

    public function setWardName(string $WardName): self
    {
        $this->WardName = $WardName;

        return $this;
    }

    /**
     * @return Collection|Nurse[]
     */
    public function getNurses(): Collection
    {
        return $this->nurses;
    }

    public function addNurse(Nurse $nurse): self
    {
        if (!$this->nurses->contains($nurse)) {
            $this->nurses[] = $nurse;
            $nurse->setWard($this);
        }

        return $this;
    }

    public function removeNurse(Nurse $nurse): self
    {
        if ($this->nurses->contains($nurse)) {
            $this->nurses->removeElement($nurse);
            // set the owning side to null (unless already changed)
            if ($nurse->getWard() === $this) {
                $nurse->setWard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Doctor[]
     */
    public function getDoctors(): Collection
    {
        return $this->doctors;
    }

    public function addDoctor(Doctor $doctor): self
    {
        if (!$this->doctors->contains($doctor)) {
            $this->doctors[] = $doctor;
            $doctor->setWard($this);
        }

        return $this;
    }

    public function removeDoctor(Doctor $doctor): self
    {
        if ($this->doctors->contains($doctor)) {
            $this->doctors->removeElement($doctor);
            // set the owning side to null (unless already changed)
            if ($doctor->getWard() === $this) {
                $doctor->setWard(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->WardName;
    }

    /**
     * @return Collection|Consultant[]
     */
    public function getConsultants(): Collection
    {
        return $this->consultants;
    }

    public function addConsultant(Consultant $consultant): self
    {
        if (!$this->consultants->contains($consultant)) {
            $this->consultants[] = $consultant;
            $consultant->setWard($this);
        }

        return $this;
    }

    public function removeConsultant(Consultant $consultant): self
    {
        if ($this->consultants->contains($consultant)) {
            $this->consultants->removeElement($consultant);
            // set the owning side to null (unless already changed)
            if ($consultant->getWard() === $this) {
                $consultant->setWard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Technician[]
     */
    public function getTechnicians(): Collection
    {
        return $this->technicians;
    }

    public function addTechnician(Technician $technician): self
    {
        if (!$this->technicians->contains($technician)) {
            $this->technicians[] = $technician;
            $technician->setWard($this);
        }

        return $this;
    }

    public function removeTechnician(Technician $technician): self
    {
        if ($this->technicians->contains($technician)) {
            $this->technicians->removeElement($technician);
            // set the owning side to null (unless already changed)
            if ($technician->getWard() === $this) {
                $technician->setWard(null);
            }
        }

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

    public function getHospital(): ?Hospital
    {
        return $this->Hospital;
    }

    public function setHospital(?Hospital $Hospital): self
    {
        $this->Hospital = $Hospital;

        return $this;
    }

}
