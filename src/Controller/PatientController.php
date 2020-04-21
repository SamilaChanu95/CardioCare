<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\PatientType;
use App\Entity\ICU;
use App\Repository\PatientTypeRepository;
use Doctrine\ORM\EntityRepository;
use App\Entity\Surgery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;

class PatientController extends AbstractController
{
    /**
     * @Route("/patient", name="patients_list")
     */
    public function displayPatient()
    {
        $patients = $this->getDoctrine()->getRepository(Patient::class)->findAll();

        return $this->render('patient/patient.html.twig', [
            'patients' => $patients
        ]);
    }

    /**
     * @Route("/surgery", name="surgeries_list")
     */
    public function displaySurgery()
    {
        $surgeries = $this->getDoctrine()->getRepository(Surgery::class)->findAll();
        $patients = $this->getDoctrine()->getRepository(Patient::class)->findAll();

        return $this->render('surgery/surgery.html.twig', [
            'surgeries' => $surgeries,
            'patients' => $patients
        ]);
    }

    /**
     * @Route("/icu", name="icu_reports_list")
     */
    public function displayICU()
    {

        $icureports = $this->getDoctrine()->getRepository(ICU::class)->findAll();
        $patients = $this->getDoctrine()->getRepository(Patient::class)->findAll();

        return $this->render('icu/icureport.html.twig', [
            'icureports' => $icureports,
            'patients' => $patients
        ]);
    }


    /**
     * @Route("/clinic", name="clinics_list")
     */
    public function displayClinic()
    {
        $patients = $this->getDoctrine()->getRepository(Patient::class)->findAll();

        return $this->render('clinic/clinic.html.twig', [
            'patients' => $patients
        ]);
    }


    /**
     * @Route("/patient/add", name="patient_add")
     */
    public function createPatient(Request $request)
    {
        $patient = new Patient();

        $form = $this->createFormBuilder($patient)
            ->add('pNIC', TextType::class, array('required' => true,'label' => 'NIC number of Patient','attr' => array('class' => 'form-control')))
            ->add('pFirstName', TextType::class, array('required' => true,'label' => 'First Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => 'Last Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pAddress', TextareaType::class, array('required' => true,'label' => 'Address of Patient','attr' => array('class' => 'form-control')))
            ->add('pGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => 'Height (cm)','attr' => array('class' => 'form-control')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => 'Weight (kg)','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => 'Visiting Number','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => 'Emergency Contact Details', 'attr' => array('class' => 'form-control')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => 'Medical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => 'Allergic Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => 'Surgical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => 'Drug Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => 'Social Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => 'Examination Details', 'attr' => array('class' => 'form-control')))
            ->add('PatientType', EntityType::class, array('class' => PatientType::class, 'required' => true,'label' => 'Patient Type','attr' => array('class' => 'form-control')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'active_user', 'Deactive' => 'deactive_user'],'required' => true,'label' => 'Status', 'attr' => array('class' => 'form-control')))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('save', SubmitType::class, array('label'=> 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $patient = $form->getData();
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush(); 

            return $this->redirectToRoute('patients_list');
        }

        return $this->render('patient/patient_add.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/surgery/patient/add", name="patient_surgery_add")
     */
    public function createSurgeryPatient(Request $request)
    {
        $patient = new Patient();

        $form = $this->createFormBuilder($patient)
            ->add('pNIC', TextType::class, array('required' => true,'label' => 'NIC number of Patient','attr' => array('class' => 'form-control')))
            ->add('pFirstName', TextType::class, array('required' => true,'label' => 'First Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => 'Last Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pAddress', TextareaType::class, array('required' => true,'label' => 'Address of Patient','attr' => array('class' => 'form-control')))
            ->add('pGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => 'Height (cm)','attr' => array('class' => 'form-control')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => 'Weight (kg)','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => 'Visiting Number','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => 'Emergency Contact Details', 'attr' => array('class' => 'form-control')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => 'Medical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => 'Allergic Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => 'Surgical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => 'Drug Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => 'Social Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => 'Examination Details', 'attr' => array('class' => 'form-control')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "Surgical Patient");
                }, 
                'required' => true,
                'label' => 'Patient Type',
                'attr' => array('class' => 'form-control')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'active_user', 'Deactive' => 'deactive_user'],'required' => true,'label' => 'Status', 'attr' => array('class' => 'form-control')))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('save', SubmitType::class, array('label'=> 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $patient = $form->getData();
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush(); 

            return $this->redirectToRoute('surgeries_list');
        }

        return $this->render('surgery/patient_add.html.twig', [
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/icu/patient/add", name="patient_icu_add")
     */
    public function createICUPatient(Request $request)
    {
        $patient = new Patient();

        $form = $this->createFormBuilder($patient)
            ->add('pNIC', TextType::class, array('required' => true,'label' => 'NIC number of Patient','attr' => array('class' => 'form-control')))
            ->add('pFirstName', TextType::class, array('required' => true,'label' => 'First Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => 'Last Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pAddress', TextareaType::class, array('required' => true,'label' => 'Address of Patient','attr' => array('class' => 'form-control')))
            ->add('pGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => 'Height (cm)','attr' => array('class' => 'form-control')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => 'Weight (kg)','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => 'Visiting Number','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => 'Emergency Contact Details', 'attr' => array('class' => 'form-control')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => 'Medical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => 'Allergic Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => 'Surgical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => 'Drug Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => 'Social Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => 'Examination Details', 'attr' => array('class' => 'form-control')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "ICU Patient");
                }, 
                'required' => true,
                'label' => 'Patient Type',
                'attr' => array('class' => 'form-control')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'active_user', 'Deactive' => 'deactive_user'],'required' => true,'label' => 'Status', 'attr' => array('class' => 'form-control')))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('save', SubmitType::class, array('label'=> 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $patient = $form->getData();
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush(); 

            return $this->redirectToRoute('icu_reports_list');
        }

        return $this->render('icu/patient_add.html.twig', [
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/clinic/patient/add", name="patient_clinic_add")
     */
    public function createClinicPatient(Request $request)
    {
        $patient = new Patient();

        $form = $this->createFormBuilder($patient)
            ->add('pNIC', TextType::class, array('required' => true,'label' => 'NIC number of Patient','attr' => array('class' => 'form-control')))
            ->add('pFirstName', TextType::class, array('required' => true,'label' => 'First Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => 'Last Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pAddress', TextareaType::class, array('required' => true,'label' => 'Address of Patient','attr' => array('class' => 'form-control')))
            ->add('pGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => 'Height (cm)','attr' => array('class' => 'form-control')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => 'Weight (kg)','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => 'Visiting Number','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => 'Emergency Contact Details', 'attr' => array('class' => 'form-control')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => 'Medical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => 'Allergic Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => 'Surgical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => 'Drug Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => 'Social Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => 'Examination Details', 'attr' => array('class' => 'form-control')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "Clinical Patient");
                }, 
                'required' => true,
                'label' => 'Patient Type',
                'attr' => array('class' => 'form-control')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'active_user', 'Deactive' => 'deactive_user'],'required' => true,'label' => 'Status', 'attr' => array('class' => 'form-control')))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('save', SubmitType::class, array('label'=> 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $patient = $form->getData();
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush(); 

            return $this->redirectToRoute('clinics_list');
        }

        return $this->render('clinic/patient_add.html.twig', [
            'form' => $form->createView()
        ]);

    }



    /**
     * @Route("/patient/edit/{id}", name="patient_edit")
     */
    public function editPatient(Request $request,$id)
    {

        $patient = new Patient();

        $patient = $this->getDoctrine()->getRepository(Patient::class)->find($id);

        $form = $this->createFormBuilder($patient)
            ->add('pNIC', TextType::class, array('required' => true,'label' => 'NIC number of Patient','attr' => array('class' => 'form-control')))
            ->add('pFirstName', TextType::class, array('required' => true,'label' => 'First Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => 'Last Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pAddress', TextareaType::class, array('required' => true,'label' => 'Address of Patient','attr' => array('class' => 'form-control')))
            ->add('pGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => 'Height (cm)','attr' => array('class' => 'form-control')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => 'Weight (kg)','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => 'Visiting Number','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => 'EmergencyContactDetails', 'attr' => array('class' => 'form-control')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => 'Medical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => 'Allergic Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => 'Surgical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => 'Drug Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => 'Social Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => 'Examination Details', 'attr' => array('class' => 'form-control')))
            ->add('PatientType', EntityType::class, array('class' => PatientType::class, 'required' => true,'label' => 'Patient Type','attr' => array('class' => 'form-control')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'active_user', 'Deactive' => 'deactive_user'],'required' => true,'label' => 'Status', 'attr' => array('class' => 'form-control')))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('save', SubmitType::class, array('label'=> 'Update', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('patients_list');
        }

        return $this->render('patient/patient_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/surgery/patient/edit/{id}", name="surgery_patient_edit")
     */
    public function editSurgeryPatient(Request $request,$id)
    {

        $patient = new Patient();

        $patient = $this->getDoctrine()->getRepository(Patient::class)->find($id);

        $form = $this->createFormBuilder($patient)
            ->add('pNIC', TextType::class, array('required' => true,'label' => 'NIC number of Patient','attr' => array('class' => 'form-control')))
            ->add('pFirstName', TextType::class, array('required' => true,'label' => 'First Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => 'Last Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pAddress', TextareaType::class, array('required' => true,'label' => 'Address of Patient','attr' => array('class' => 'form-control')))
            ->add('pGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => 'Height (cm)','attr' => array('class' => 'form-control')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => 'Weight (kg)','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => 'Visiting Number','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => 'EmergencyContactDetails', 'attr' => array('class' => 'form-control')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => 'Medical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => 'Allergic Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => 'Surgical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => 'Drug Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => 'Social Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => 'Examination Details', 'attr' => array('class' => 'form-control')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "Surgical Patient");
                }, 
                'required' => true,
                'label' => 'Patient Type',
                'attr' => array('class' => 'form-control')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'active_user', 'Deactive' => 'deactive_user'],'required' => true,'label' => 'Status', 'attr' => array('class' => 'form-control')))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('save', SubmitType::class, array('label'=> 'Update', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('surgeries_list');
        }

        return $this->render('surgery/patient_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/icu/patient/edit/{id}", name="icu_patient_edit")
     */
    public function editICUPatient(Request $request,$id)
    {

        $patient = new Patient();

        $patient = $this->getDoctrine()->getRepository(Patient::class)->find($id);

        $form = $this->createFormBuilder($patient)
            ->add('pNIC', TextType::class, array('required' => true,'label' => 'NIC number of Patient','attr' => array('class' => 'form-control')))
            ->add('pFirstName', TextType::class, array('required' => true,'label' => 'First Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => 'Last Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pAddress', TextareaType::class, array('required' => true,'label' => 'Address of Patient','attr' => array('class' => 'form-control')))
            ->add('pGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => 'Height (cm)','attr' => array('class' => 'form-control')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => 'Weight (kg)','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => 'Visiting Number','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => 'EmergencyContactDetails', 'attr' => array('class' => 'form-control')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => 'Medical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => 'Allergic Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => 'Surgical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => 'Drug Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => 'Social Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => 'Examination Details', 'attr' => array('class' => 'form-control')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "ICU Patient");
                }, 
                'required' => true,
                'label' => 'Patient Type',
                'attr' => array('class' => 'form-control')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'active_user', 'Deactive' => 'deactive_user'],'required' => true,'label' => 'Status', 'attr' => array('class' => 'form-control')))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('save', SubmitType::class, array('label'=> 'Update', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('icu_reports_list');
        }

        return $this->render('icu/patient_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/clinic/patient/edit/{id}", name="clinic_patient_edit")
     */
    public function editClinicPatient(Request $request,$id)
    {

        $patient = new Patient();

        $patient = $this->getDoctrine()->getRepository(Patient::class)->find($id);

        $form = $this->createFormBuilder($patient)
            ->add('pNIC', TextType::class, array('required' => true,'label' => 'NIC number of Patient','attr' => array('class' => 'form-control')))
            ->add('pFirstName', TextType::class, array('required' => true,'label' => 'First Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => 'Last Name of Patient','attr' => array('class' => 'form-control')))
            ->add('pAddress', TextareaType::class, array('required' => true,'label' => 'Address of Patient','attr' => array('class' => 'form-control')))
            ->add('pGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => 'Height (cm)','attr' => array('class' => 'form-control')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => 'Weight (kg)','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => 'Visiting Number','attr' => array('class' => 'form-control')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => 'EmergencyContactDetails', 'attr' => array('class' => 'form-control')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => 'Medical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => 'Allergic Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => 'Surgical Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => 'Drug Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => 'Social Histroy', 'attr' => array('class' => 'form-control')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => 'Examination Details', 'attr' => array('class' => 'form-control')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "Clinical Patient");
                }, 
                'required' => true,
                'label' => 'Patient Type',
                'attr' => array('class' => 'form-control')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'active_user', 'Deactive' => 'deactive_user'],'required' => true,'label' => 'Status', 'attr' => array('class' => 'form-control')))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('save', SubmitType::class, array('label'=> 'Update', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('clinics_list');
        }

        return $this->render('clinic/patient_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
