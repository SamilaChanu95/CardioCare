<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatientRepository")
 */
class Patient
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
    private $pNIC;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $pFirstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $pLastName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $pGender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pAddress;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $pDOB;

    /**
     * @ORM\Column(type="float")
     */
    private $pHeight;

    /**
     * @ORM\Column(type="float")
     */
    private $pWeight;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $pPhoneNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $pVisitingNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pEmergencyContactDetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pMedicalHistroy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pAllergicHistroy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pSurgicalHistroy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $pDrugHistroy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $pSocialHistroy;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pExaminationDetails;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pStatus;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Surgery", mappedBy="Patient")
     */
    private $surgeries;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PatientType", inversedBy="patients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $PatientType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Patient", mappedBy="PatientType")
     */
    private $patients;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ICU", mappedBy="Patient")
     */
    private $iCUs;

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
        $this->patients = new ArrayCollection();
        $this->iCUs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPNIC(): ?string
    {
        return $this->pNIC;
    }

    public function setPNIC(string $pNIC): self
    {
        $this->pNIC = $pNIC;

        return $this;
    }

    public function getPFirstName(): ?string
    {
        return $this->pFirstName;
    }

    public function setPFirstName(string $pFirstName): self
    {
        $this->pFirstName = $pFirstName;

        return $this;
    }

    public function getPLastName(): ?string
    {
        return $this->pLastName;
    }

    public function setPLastName(string $pLastName): self
    {
        $this->pLastName = $pLastName;

        return $this;
    }

    public function getPGender(): ?string
    {
        return $this->pGender;
    }

    public function setPGender(string $pGender): self
    {
        $this->pGender = $pGender;

        return $this;
    }

    public function getPAddress(): ?string
    {
        return $this->pAddress;
    }

    public function setPAddress(string $pAddress): self
    {
        $this->pAddress = $pAddress;

        return $this;
    }

    public function getPDOB(): ?string
    {
        return $this->pDOB;
    }

    public function setPDOB(string $pDOB): self
    {
        $this->pDOB = $pDOB;

        return $this;
    }

    public function getPHeight(): ?float
    {
        return $this->pHeight;
    }

    public function setPHeight(float $pHeight): self
    {
        $this->pHeight = $pHeight;

        return $this;
    }

    public function getPWeight(): ?float
    {
        return $this->pWeight;
    }

    public function setPWeight(float $pWeight): self
    {
        $this->pWeight = $pWeight;

        return $this;
    }

    public function getPPhoneNumber(): ?string
    {
        return $this->pPhoneNumber;
    }

    public function setPPhoneNumber(string $pPhoneNumber): self
    {
        $this->pPhoneNumber = $pPhoneNumber;

        return $this;
    }

    public function getPVisitingNumber(): ?int
    {
        return $this->pVisitingNumber;
    }

    public function setPVisitingNumber(int $pVisitingNumber): self
    {
        $this->pVisitingNumber = $pVisitingNumber;

        return $this;
    }

    public function getPEmergencyContactDetails(): ?string
    {
        return $this->pEmergencyContactDetails;
    }

    public function setPEmergencyContactDetails(string $pEmergencyContactDetails): self
    {
        $this->pEmergencyContactDetails = $pEmergencyContactDetails;

        return $this;
    }

    public function getPMedicalHistroy(): ?string
    {
        return $this->pMedicalHistroy;
    }

    public function setPMedicalHistroy(?string $pMedicalHistroy): self
    {
        $this->pMedicalHistroy = $pMedicalHistroy;

        return $this;
    }

    public function getPAllergicHistroy(): ?string
    {
        return $this->pAllergicHistroy;
    }

    public function setPAllergicHistroy(?string $pAllergicHistroy): self
    {
        $this->pAllergicHistroy = $pAllergicHistroy;

        return $this;
    }

    public function getPSurgicalHistroy(): ?string
    {
        return $this->pSurgicalHistroy;
    }

    public function setPSurgicalHistroy(string $pSurgicalHistroy): self
    {
        $this->pSurgicalHistroy = $pSurgicalHistroy;

        return $this;
    }

    public function getPDrugHistroy(): ?string
    {
        return $this->pDrugHistroy;
    }

    public function setPDrugHistroy(string $pDrugHistroy): self
    {
        $this->pDrugHistroy = $pDrugHistroy;

        return $this;
    }

    public function getPSocialHistroy(): ?string
    {
        return $this->pSocialHistroy;
    }

    public function setPSocialHistroy(string $pSocialHistroy): self
    {
        $this->pSocialHistroy = $pSocialHistroy;

        return $this;
    }

    public function getPExaminationDetails(): ?string
    {
        return $this->pExaminationDetails;
    }

    public function setPExaminationDetails(string $pExaminationDetails): self
    {
        $this->pExaminationDetails = $pExaminationDetails;

        return $this;
    }

    public function getPStatus(): ?string
    {
        return $this->pStatus;
    }

    public function setPStatus(string $pStatus): self
    {
        $this->pStatus = $pStatus;

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
            $surgery->setPatient($this);
        }

        return $this;
    }

    public function removeSurgery(Surgery $surgery): self
    {
        if ($this->surgeries->contains($surgery)) {
            $this->surgeries->removeElement($surgery);
            // set the owning side to null (unless already changed)
            if ($surgery->getPatient() === $this) {
                $surgery->setPatient(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->pFirstName;
    }

    public function getPatientType(): ?PatientType
    {
        return $this->PatientType;
    }

    public function setPatientType(?PatientType $PatientType): self
    {
        $this->PatientType = $PatientType;

        return $this;
    }

    public function removePatient(self $patient): self
    {
        if ($this->patients->contains($patient)) {
            $this->patients->removeElement($patient);
            // set the owning side to null (unless already changed)
            if ($patient->getPatientType() === $this) {
                $patient->setPatientType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ICU[]
     */
    public function getICUs(): Collection
    {
        return $this->iCUs;
    }

    public function addICUs(ICU $iCUs): self
    {
        if (!$this->iCUs->contains($iCUs)) {
            $this->iCUs[] = $iCUs;
            $iCUs->setPatient($this);
        }

        return $this;
    }

    public function removeICUs(ICU $iCUs): self
    {
        if ($this->iCUs->contains($iCUs)) {
            $this->iCUs->removeElement($iCUs);
            // set the owning side to null (unless already changed)
            if ($iCUs->getPatient() === $this) {
                $iCUs->setPatient(null);
            }
        }

        return $this;
    }

}
