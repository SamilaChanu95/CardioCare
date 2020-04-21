<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ICURepository")
 */
class ICU
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Patient", inversedBy="iCUs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Patient;

    /**
     * @ORM\Column(type="date")
     */
    private $AdmitDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Room;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Diagnosis;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Neuro;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Cardiac;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Respiratory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Ventilator;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $GI;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $GU;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Skin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Drains;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Labs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Meds;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Hemodynamics;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ToDo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CoreMeasures;

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

    public function getPatient(): ?Patient
    {
        return $this->Patient;
    }

    public function setPatient(?Patient $Patient): self
    {
        $this->Patient = $Patient;

        return $this;
    }

    public function getAdmitDate(): ?\DateTimeInterface
    {
        return $this->AdmitDate;
    }

    public function setAdmitDate(\DateTimeInterface $AdmitDate): self
    {
        $this->AdmitDate = $AdmitDate;

        return $this;
    }

    public function getRoom(): ?string
    {
        return $this->Room;
    }

    public function setRoom(string $Room): self
    {
        $this->Room = $Room;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(string $Code): self
    {
        $this->Code = $Code;

        return $this;
    }

    public function getDiagnosis(): ?string
    {
        return $this->Diagnosis;
    }

    public function setDiagnosis(string $Diagnosis): self
    {
        $this->Diagnosis = $Diagnosis;

        return $this;
    }

    public function getNeuro(): ?string
    {
        return $this->Neuro;
    }

    public function setNeuro(?string $Neuro): self
    {
        $this->Neuro = $Neuro;

        return $this;
    }

    public function getCardiac(): ?string
    {
        return $this->Cardiac;
    }

    public function setCardiac(?string $Cardiac): self
    {
        $this->Cardiac = $Cardiac;

        return $this;
    }

    public function getRespiratory(): ?string
    {
        return $this->Respiratory;
    }

    public function setRespiratory(?string $Respiratory): self
    {
        $this->Respiratory = $Respiratory;

        return $this;
    }

    public function getVentilator(): ?string
    {
        return $this->Ventilator;
    }

    public function setVentilator(?string $Ventilator): self
    {
        $this->Ventilator = $Ventilator;

        return $this;
    }

    public function getGI(): ?string
    {
        return $this->GI;
    }

    public function setGI(?string $GI): self
    {
        $this->GI = $GI;

        return $this;
    }

    public function getGU(): ?string
    {
        return $this->GU;
    }

    public function setGU(?string $GU): self
    {
        $this->GU = $GU;

        return $this;
    }

    public function getSkin(): ?string
    {
        return $this->Skin;
    }

    public function setSkin(?string $Skin): self
    {
        $this->Skin = $Skin;

        return $this;
    }

    public function getDrains(): ?string
    {
        return $this->Drains;
    }

    public function setDrains(?string $Drains): self
    {
        $this->Drains = $Drains;

        return $this;
    }

    public function getLabs(): ?string
    {
        return $this->Labs;
    }

    public function setLabs(?string $Labs): self
    {
        $this->Labs = $Labs;

        return $this;
    }

    public function getMeds(): ?string
    {
        return $this->Meds;
    }

    public function setMeds(?string $Meds): self
    {
        $this->Meds = $Meds;

        return $this;
    }

    public function getHemodynamics(): ?string
    {
        return $this->Hemodynamics;
    }

    public function setHemodynamics(?string $Hemodynamics): self
    {
        $this->Hemodynamics = $Hemodynamics;

        return $this;
    }

    public function getToDo(): ?string
    {
        return $this->ToDo;
    }

    public function setToDo(?string $ToDo): self
    {
        $this->ToDo = $ToDo;

        return $this;
    }

    public function getCoreMeasures(): ?string
    {
        return $this->CoreMeasures;
    }

    public function setCoreMeasures(?string $CoreMeasures): self
    {
        $this->CoreMeasures = $CoreMeasures;

        return $this;
    }
}
