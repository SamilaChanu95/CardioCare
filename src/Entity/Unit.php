<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnitRepository")
 */
class Unit
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
    private $UnitName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nurse", mappedBy="Unit")
     */
    private $nurses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Doctor", mappedBy="Unit")
     */
    private $doctors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Technician", mappedBy="Unit")
     */
    private $technicians;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Consultant", mappedBy="Unit")
     */
    private $consultants;

    public function __construct()
    {
        $this->nurses = new ArrayCollection();
        $this->doctors = new ArrayCollection();
        $this->technicians = new ArrayCollection();
        $this->consultants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnitName(): ?string
    {
        return $this->UnitName;
    }

    public function setUnitName(string $UnitName): self
    {
        $this->UnitName = $UnitName;

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
            $nurse->setUnit($this);
        }

        return $this;
    }

    public function removeNurse(Nurse $nurse): self
    {
        if ($this->nurses->contains($nurse)) {
            $this->nurses->removeElement($nurse);
            // set the owning side to null (unless already changed)
            if ($nurse->getUnit() === $this) {
                $nurse->setUnit(null);
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
            $doctor->setUnit($this);
        }

        return $this;
    }

    public function removeDoctor(Doctor $doctor): self
    {
        if ($this->doctors->contains($doctor)) {
            $this->doctors->removeElement($doctor);
            // set the owning side to null (unless already changed)
            if ($doctor->getUnit() === $this) {
                $doctor->setUnit(null);
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
            $technician->setUnit($this);
        }

        return $this;
    }

    public function removeTechnician(Technician $technician): self
    {
        if ($this->technicians->contains($technician)) {
            $this->technicians->removeElement($technician);
            // set the owning side to null (unless already changed)
            if ($technician->getUnit() === $this) {
                $technician->setUnit(null);
            }
        }

        return $this;
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
            $consultant->setUnit($this);
        }

        return $this;
    }

    public function removeConsultant(Consultant $consultant): self
    {
        if ($this->consultants->contains($consultant)) {
            $this->consultants->removeElement($consultant);
            // set the owning side to null (unless already changed)
            if ($consultant->getUnit() === $this) {
                $consultant->setUnit(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->UnitName;
    }
}
