<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HospitalRepository")
 */
class Hospital
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Department", mappedBy="hospital")
     */
    private $departments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Unit", mappedBy="hospital")
     */
    private $units;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ward", mappedBy="Hospital")
     */
    private $wards;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
        $this->units = new ArrayCollection();
        $this->wards = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->Name;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection|Department[]
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): self
    {
        if (!$this->departments->contains($department)) {
            $this->departments[] = $department;
            $department->setHospital($this);
        }

        return $this;
    }

    public function removeDepartment(Department $department): self
    {
        if ($this->departments->contains($department)) {
            $this->departments->removeElement($department);
            // set the owning side to null (unless already changed)
            if ($department->getHospital() === $this) {
                $department->setHospital(null);
            }
        }

        return $this;
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
            $unit->setHospital($this);
        }

        return $this;
    }

    public function removeUnit(Unit $unit): self
    {
        if ($this->units->contains($unit)) {
            $this->units->removeElement($unit);
            // set the owning side to null (unless already changed)
            if ($unit->getHospital() === $this) {
                $unit->setHospital(null);
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
            $ward->setHospital($this);
        }

        return $this;
    }

    public function removeWard(Ward $ward): self
    {
        if ($this->wards->contains($ward)) {
            $this->wards->removeElement($ward);
            // set the owning side to null (unless already changed)
            if ($ward->getHospital() === $this) {
                $ward->setHospital(null);
            }
        }

        return $this;
    }
}
