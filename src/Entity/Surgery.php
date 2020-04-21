<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SurgeryRepository")
 */
class Surgery
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
    private $SurgeryName;

    /**
     * @ORM\Column(type="integer")
     */
    private $priority;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Patient", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Patient;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Doctor", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Doctor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Nurse", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Nurse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Consultant", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Consultant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Technician", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Technician;

    protected $captchaCode;
    
    public function getCaptchaCode()
    {
      return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
      $this->captchaCode = $captchaCode;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurgeryName(): ?string
    {
        return $this->SurgeryName;
    }

    public function setSurgeryName(string $SurgeryName): self
    {
        $this->SurgeryName = $SurgeryName;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->Patient;
    }

    public function setPatient(?Patient $Patient): self
    {
        $this->Patient = $Patient;

        return $this;
    }
    
    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->Doctor;
    }

    public function setDoctor(?Doctor $Doctor): self
    {
        $this->Doctor = $Doctor;

        return $this;
    }

    public function getNurse(): ?Nurse
    {
        return $this->Nurse;
    }

    public function setNurse(?Nurse $Nurse): self
    {
        $this->Nurse = $Nurse;

        return $this;
    }

    public function getConsultant(): ?Consultant
    {
        return $this->Consultant;
    }

    public function setConsultant(?Consultant $Consultant): self
    {
        $this->Consultant = $Consultant;

        return $this;
    }

    public function getTechnician(): ?Technician
    {
        return $this->Technician;
    }

    public function setTechnician(?Technician $Technician): self
    {
        $this->Technician = $Technician;

        return $this;
    }

}
