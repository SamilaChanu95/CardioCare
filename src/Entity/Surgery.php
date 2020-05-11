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
    private $DoctorMain;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Doctor", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=true)
     */
    private $DoctorFAssistant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Doctor", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=true)
     */
    private $DoctorSAssistant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Doctor", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=true)
     */
    private $DoctorAnesthetist;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Nurse", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $NurseMain;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Nurse", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=true)
     */
    private $NurseFAssistant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Nurse", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=true)
     */
    private $NurseSAssistant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Nurse", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=true)
     */
    private $NurseTAssistant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Consultant", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ConsultantMain;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Consultant", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=true)
     */
    private $ConsultantAssistant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Technician", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $TechnicianMain;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Technician", inversedBy="surgeries")
     * @ORM\JoinColumn(nullable=true)
     */
    private $TechnicianAssistant;

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

    public function getDoctorMain(): ?Doctor
    {
        return $this->DoctorMain;
    }

    public function setDoctorMain(?Doctor $DoctorMain): self
    {
        $this->DoctorMain = $DoctorMain;

        return $this;
    }

    public function getDoctorFAssistant(): ?Doctor
    {
        return $this->DoctorFAssistant;
    }

    public function setDoctorFAssistant(?Doctor $DoctorFAssistant): self
    {
        $this->DoctorFAssistant = $DoctorFAssistant;

        return $this;
    }

    public function getDoctorSAssistant(): ?Doctor
    {
        return $this->DoctorSAssistant;
    }

    public function setDoctorSAssistant(?Doctor $DoctorSAssistant): self
    {
        $this->DoctorSAssistant = $DoctorSAssistant;

        return $this;
    }

    public function getDoctorAnesthetist(): ?Doctor
    {
        return $this->DoctorAnesthetist;
    }

    public function setDoctorAnesthetist(?Doctor $DoctorAnesthetist): self
    {
        $this->DoctorAnesthetist = $DoctorAnesthetist;

        return $this;
    }

    public function getNurseMain(): ?Nurse
    {
        return $this->NurseMain;
    }

    public function setNurseMain(?Nurse $NurseMain): self
    {
        $this->NurseMain = $NurseMain;

        return $this;
    }

    public function getNurseFAssistant(): ?Nurse
    {
        return $this->NurseFAssistant;
    }

    public function setNurseFAssistant(?Nurse $NurseFAssistant): self
    {
        $this->NurseFAssistant = $NurseFAssistant;

        return $this;
    }

    public function getNurseSAssistant(): ?Nurse
    {
        return $this->NurseSAssistant;
    }

    public function setNurseSAssistant(?Nurse $NurseSAssistant): self
    {
        $this->NurseSAssistant = $NurseSAssistant;

        return $this;
    }

    public function getNurseTAssistant(): ?Nurse
    {
        return $this->NurseTAssistant;
    }

    public function setNurseTAssistant(?Nurse $NurseTAssistant): self
    {
        $this->NurseTAssistant = $NurseTAssistant;

        return $this;
    }

    public function getConsultantMain(): ?Consultant
    {
        return $this->ConsultantMain;
    }

    public function setConsultantMain(?Consultant $ConsultantMain): self
    {
        $this->ConsultantMain = $ConsultantMain;

        return $this;
    }

    public function getConsultantAssistant(): ?Consultant
    {
        return $this->ConsultantAssistant;
    }

    public function setConsultantAssistant(?Consultant $ConsultantAssistant): self
    {
        $this->ConsultantAssistant = $ConsultantAssistant;

        return $this;
    }

    public function getTechnicianMain(): ?Technician
    {
        return $this->TechnicianMain;
    }

    public function setTechnicianMain(?Technician $TechnicianMain): self
    {
        $this->TechnicianMain = $TechnicianMain;

        return $this;
    }

    public function getTechnicianAssistant(): ?Technician
    {
        return $this->TechnicianAssistant;
    }

    public function setTechnicianAssistant(?Technician $TechnicianAssistant): self
    {
        $this->TechnicianAssistant = $TechnicianAssistant;

        return $this;
    }

}
