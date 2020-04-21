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

    public function __construct()
    {
        $this->nurses = new ArrayCollection();
        $this->doctors = new ArrayCollection();
        
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

}
