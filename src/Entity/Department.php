<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 */
class Department
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
    private $DepartmentName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nurse", mappedBy="Department")
     */
    private $nurses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Doctor", mappedBy="Department")
     */
    private $doctors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Technician", mappedBy="Department")
     */
    private $technicians;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Consultant", mappedBy="Department")
     */
    private $consultants;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Unit", mappedBy="Department")
     */
    private $units;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ward", mappedBy="Department")
     */
    private $wards;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hospital", inversedBy="departments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hospital;

    public function __construct()
    {
        $this->nurses = new ArrayCollection();
        $this->doctors = new ArrayCollection();
        $this->technicians = new ArrayCollection();
        $this->consultants = new ArrayCollection();
        $this->units = new ArrayCollection();
        $this->wards = new ArrayCollection();
    }
   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartmentName(): ?string
    {
        return $this->DepartmentName;
    }

    public function setDepartmentName(string $DepartmentName): self
    {
        $this->DepartmentName = $DepartmentName;

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
            $nurse->setDepartment($this);
        }

        return $this;
    }

    public function removeNurse(Nurse $nurse): self
    {
        if ($this->nurses->contains($nurse)) {
            $this->nurses->removeElement($nurse);
            // set the owning side to null (unless already changed)
            if ($nurse->getDepartment() === $this) {
                $nurse->setDepartment(null);
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
            $doctor->setDepartment($this);
        }

        return $this;
    }

    public function removeDoctor(Doctor $doctor): self
    {
        if ($this->doctors->contains($doctor)) {
            $this->doctors->removeElement($doctor);
            // set the owning side to null (unless already changed)
            if ($doctor->getDepartment() === $this) {
                $doctor->setDepartment(null);
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
            $technician->setDepartment($this);
        }

        return $this;
    }

    public function removeTechnician(Technician $technician): self
    {
        if ($this->technicians->contains($technician)) {
            $this->technicians->removeElement($technician);
            // set the owning side to null (unless already changed)
            if ($technician->getDepartment() === $this) {
                $technician->setDepartment(null);
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
            $consultant->setDepartment($this);
        }

        return $this;
    }

    public function removeConsultant(Consultant $consultant): self
    {
        if ($this->consultants->contains($consultant)) {
            $this->consultants->removeElement($consultant);
            // set the owning side to null (unless already changed)
            if ($consultant->getDepartment() === $this) {
                $consultant->setDepartment(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->DepartmentName;
    }

    /**
     * @return Collection|Unit[]
     */
    public function getUnits(): Collection
    {
        return $this->units;
    }

    public function addUnit(Unit $unit): self
    {
        if (!$this->units->contains($unit)) {
            $this->units[] = $unit;
            $unit->setDepartment($this);
        }

        return $this;
    }

    public function removeUnit(Unit $unit): self
    {
        if ($this->units->contains($unit)) {
            $this->units->removeElement($unit);
            // set the owning side to null (unless already changed)
            if ($unit->getDepartment() === $this) {
                $unit->setDepartment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ward[]
     */
    public function getWards(): Collection
    {
        return $this->wards;
    }

    public function addWard(Ward $ward): self
    {
        if (!$this->wards->contains($ward)) {
            $this->wards[] = $ward;
            $ward->setDepartment($this);
        }

        return $this;
    }

    public function removeWard(Ward $ward): self
    {
        if ($this->wards->contains($ward)) {
            $this->wards->removeElement($ward);
            // set the owning side to null (unless already changed)
            if ($ward->getDepartment() === $this) {
                $ward->setDepartment(null);
            }
        }

        return $this;
    }

    public function getHospital(): ?Hospital
    {
        return $this->hospital;
    }

    public function setHospital(?Hospital $hospital): self
    {
        $this->hospital = $hospital;

        return $this;
    }
}
