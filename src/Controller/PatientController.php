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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
            ->add('pNIC', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC of Patient')))
            ->add('pFirstName', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Patient')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Patient')))
            ->add('pAddress', TextareaType::class, array('required' => true, 'label' => false , 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Patient')))
            ->add('pGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Height (cm)')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Weight (kg)')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Visiting Number')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Emergency Contact Details')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Medical Histroy')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Allergic Histroy')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Surgical Histroy')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Drug Histroy')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Social Histroy')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Examination Details')))
            ->add('PatientType', EntityType::class, array('class' => PatientType::class, 'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Type')))
            //->add('pSurgeryInfo', CheckboxType::class, array('required' => true,'label' => 'Surgery Complete', 'attr' => array('class' => 'col-md-1 mb-2')))
            ->add('pCurrentLocation', ChoiceType::class, array('choices' => [ 'In Patient' => [ 'ICU' => 'ICU', 'Ward' => 'Ward', 'Operating Theater' => 'Operating Theater'], 'Out Patient' => ['Clinic' => 'Clinic']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control')))
            ->add('pStatus', ChoiceType::class, array('choices' => ['Status' => [ 'Active' => 'Active', 'Deactive' => 'Deactive']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control')))
            ->add('brochureFilename', FileType::class, array('required' => false, 'mapped' => false, 'label' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/tiff',
                            'image/bmp',
                            'image/other',
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/zip',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                            'application/vnd.ms-word.document.macroEnabled.12',
                            'application/vnd.ms-word.template.macroEnabled.12',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel.sheet.macroEnabled.12',
                            'application/vnd.ms-powerpoint',
                            'text/plain',
                            'text/csv',    
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file.',
                    ])
                ],
            ))
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

            $file = $form->get('brochureFilename')->getData();

            if($file)
            {
                $pdfs_directory = $this->getParameter('pdfs_directory');
                $filename = md5(uniqid()) .'.'. $file->guessExtension();

                try {
                    $file->move(
                        $pdfs_directory,
                        $filename
                    );
                } catch (FileException $e) {

                }

                $patient->setBrochureFilename($filename);
            }

            //echo "<pre>";
            //var_dump($request); die;
            //var_dump($file); die;

            //$patient = $form->getData();
             
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
            ->add('pNIC', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC number')))
            ->add('pFirstName', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Patient')))
            ->add('pLastName', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Patient')))
            ->add('pAddress', TextareaType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Patient')))
            ->add('pGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('pDOB', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('pHeight', NumberType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Height')))
            ->add('pWeight', NumberType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Weight')))
            ->add('pPhoneNumber', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Visiting Number')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Emergency Contact Details')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Medical Histroy')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Allergic Histroy')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Surgical Histroy')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Drug Histroy')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Social Histroy')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Examination Details')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "In Patient");
                }, 
                'required' => true,
                'label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Type')))
            //->add('pSurgeryInfo', CheckboxType::class, array('required' => true,'label' => 'Surgery Complete', 'attr' => array('class' => 'col-md-1 mb-2')))
            ->add('pCurrentLocation', ChoiceType::class, array('choices' => [ 'ICU' => 'ICU', 'Ward' => 'Ward', 'Operating Theater' => 'Operating Theater', 'Clinic' => 'Clinic'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Current Location')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'Active', 'Deactive' => 'Deactive'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Status')))
            ->add('brochureFilename', FileType::class, array('required' => false, 'mapped' => false, 'label' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/tiff',
                            'image/bmp',
                            'image/other',
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/zip',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                            'application/vnd.ms-word.document.macroEnabled.12',
                            'application/vnd.ms-word.template.macroEnabled.12',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel.sheet.macroEnabled.12',
                            'application/vnd.ms-powerpoint',
                            'text/plain',
                            'text/csv',  
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file.',
                    ])
                ],
            ))
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
            $file = $form->get('brochureFilename')->getData();

            if($file)
            {
                $pdfs_directory = $this->getParameter('pdfs_directory');
                $filename = md5(uniqid()) .'.'. $file->guessExtension();

                try {
                    $file->move(
                        $pdfs_directory,
                        $filename
                    );
                } catch (FileException $e) {

                }

                $patient->setBrochureFilename($filename);
            }
   
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
            ->add('pNIC', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC number')))
            ->add('pFirstName', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Patient')))
            ->add('pLastName', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Patient')))
            ->add('pAddress', TextareaType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Patient')))
            ->add('pGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('pDOB', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('pHeight', NumberType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Height (cm)')))
            ->add('pWeight', NumberType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Weight (kg)')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control','placeholder' => 'Phone Number')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true, 'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Visiting Number')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Emergency Contact Details')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Medical Histroy')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Allergic Histroy')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Surgical Histroy')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Drug Histroy')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Social Histroy')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Examination Details')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "In Patient");
                }, 
                'required' => true,
                'label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Type')))
            //->add('pSurgeryInfo', CheckboxType::class, array('required' => true,'label' => 'Surgery Complete', 'attr' => array('class' => 'col-md-1 mb-2')))
            ->add('pCurrentLocation', ChoiceType::class, array('choices' => [ 'ICU' => 'ICU', 'Ward' => 'Ward', 'Operating Theater' => 'Operating Theater', 'Clinic' => 'Clinic'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Current Location')))    
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'Active', 'Deactive' => 'Deactive'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Status')))
            ->add('brochureFilename', FileType::class, array('required' => false, 'mapped' => false, 'label' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/tiff',
                            'image/bmp',
                            'image/other',
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/zip',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                            'application/vnd.ms-word.document.macroEnabled.12',
                            'application/vnd.ms-word.template.macroEnabled.12',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel.sheet.macroEnabled.12',
                            'application/vnd.ms-powerpoint',
                            'text/plain',
                            'text/csv', 
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file.',
                    ])
                ],
            ))
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
            $file = $form->get('brochureFilename')->getData();

            if($file)
            {
                $pdfs_directory = $this->getParameter('pdfs_directory');
                $filename = md5(uniqid()) .'.'. $file->guessExtension();

                try {
                    $file->move(
                        $pdfs_directory,
                        $filename
                    );
                } catch (FileException $e) {

                }

                $patient->setBrochureFilename($filename);
            }
             
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
            ->add('pNIC', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'NIC number')))
            ->add('pFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Patient')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Patient')))
            ->add('pAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Patient')))
            ->add('pGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Height (cm)')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Weight (kg)')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Visiting Number')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Emergency Contact Details')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Medical Histroy')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Allergic Histroy')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Surgical Histroy')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Drug Histroy')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Social Histroy')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Examination Details')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "Out Patient");
                }, 
                'required' => true,
                'label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Type')))
            ->add('pCurrentLocation', ChoiceType::class, array('choices' => [ 'Out Patient' => ['Clinic' => 'Clinic']], 'required' => true, 'label' => false, 'attr' => array('class' => 'form-control')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'Active', 'Deactive' => 'Deactive'], 'required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Status')))
            ->add('brochureFilename', FileType::class, array('required' => false, 'mapped' => false, 'label' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/tiff',
                            'image/bmp',
                            'image/other',
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/zip',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                            'application/vnd.ms-word.document.macroEnabled.12',
                            'application/vnd.ms-word.template.macroEnabled.12',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel.sheet.macroEnabled.12',
                            'application/vnd.ms-powerpoint',
                            'text/plain',
                            'text/csv', 
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file.',
                    ])
                ],
            ))
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

            $file = $form->get('brochureFilename')->getData();

            if($file)
            {
                $pdfs_directory = $this->getParameter('pdfs_directory');
                $filename = md5(uniqid()) .'.'. $file->guessExtension();

                try  {
                    $file->move(
                        $pdfs_directory,
                        $filename
                    );
                } catch (FileException $e) {

                }

                $patient->setBrochureFilename($filename);             

            }

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
            ->add('pNIC', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC number')))
            ->add('pFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Patient')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Patient')))
            ->add('pAddress', TextareaType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Patient')))
            ->add('pGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Height (cm)')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Weight (kg)')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Visiting Number')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' =>'Phone Number')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'EmergencyContactDetails')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Medical Histroy')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Allergic Histroy')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Surgical Histroy')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Drug Histroy')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Social Histroy')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Examination Details')))
            ->add('PatientType', EntityType::class, array('class' => PatientType::class, 'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Type')))
            //->add('pSurgeryInfo', CheckboxType::class, array('required' => true,'label' => 'Surgery Complete', 'attr' => array('class' => 'col-md-1 mb-2')))
            ->add('pCurrentLocation', ChoiceType::class, array('choices' => [ 'ICU' => 'ICU', 'Ward' => 'Ward', 'Operating Theater' => 'Operating Theater'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Current Location')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'Active', 'Deactive' => 'Deactive'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Status')))
            ->add('brochureFilename', FileType::class, array('required' => false, 'mapped' => false, 'label' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/tiff',
                            'image/bmp',
                            'image/other',
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/zip',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                            'application/vnd.ms-word.document.macroEnabled.12',
                            'application/vnd.ms-word.template.macroEnabled.12',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel.sheet.macroEnabled.12',
                            'application/vnd.ms-powerpoint',
                            'text/plain',
                            'text/csv', 
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file.',
                    ])
                ],
            ))
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
            $file = $form->get('brochureFilename')->getData();

            if($file)
            {
                $pdfs_directory = $this->getParameter('pdfs_directory');
                $filename = md5(uniqid()) .'.'. $file->guessExtension();

                try  {
                    $file->move(
                        $pdfs_directory,
                        $filename
                    );
                } catch (FileException $e) {

                }

                $patient->setBrochureFilename($filename);             

            }
            
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
            ->add('pNIC', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC number')))
            ->add('pFirstName', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Patient')))
            ->add('pLastName', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Patient')))
            ->add('pAddress', TextareaType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Patient')))
            ->add('pGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('pDOB', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('pHeight', NumberType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Height')))
            ->add('pWeight', NumberType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Weight')))
            ->add('pPhoneNumber', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Visiting Number')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Emergency Contact Details')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Medical Histroy')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Allergic Histroy')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Surgical Histroy')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Drug Histroy')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Social Histroy')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control','placeholder' => 'Examination Details')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "In Patient");
                }, 
                'required' => true,
                'label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Type')))
            //->add('pSurgeryInfo', CheckboxType::class, array('required' => true,'label' => 'Surgery Complete', 'attr' => array('class' => 'col-md-1 mb-2')))    
            ->add('pCurrentLocation', ChoiceType::class, array('choices' => [ 'ICU' => 'ICU', 'Ward' => 'Ward', 'Operating Theater' => 'Operating Theater'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Current Location')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'Active', 'Deactive' => 'Deactive'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Status')))
            ->add('brochureFilename', FileType::class, array('required' => false, 'mapped' => false, 'label' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/tiff',
                            'image/bmp',
                            'image/other',
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/zip',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                            'application/vnd.ms-word.document.macroEnabled.12',
                            'application/vnd.ms-word.template.macroEnabled.12',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel.sheet.macroEnabled.12',
                            'application/vnd.ms-powerpoint',
                            'text/plain',
                            'text/csv', 
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file.',
                    ])
                ],
            ))
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
            $file = $form->get('brochureFilename')->getData();

            if($file)
            {
                $pdfs_directory = $this->getParameter('pdfs_directory');
                $filename = md5(uniqid()) .'.'. $file->guessExtension();

                try  {
                    $file->move(
                        $pdfs_directory,
                        $filename
                    );
                } catch (FileException $e) {

                }

                $patient->setBrochureFilename($filename);             

            }

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
            ->add('pNIC', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC number')))
            ->add('pFirstName', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Patient')))
            ->add('pLastName', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Patient')))
            ->add('pAddress', TextareaType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Patient')))
            ->add('pGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('pDOB', TextType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('pHeight', NumberType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Height (cm)')))
            ->add('pWeight', NumberType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Weight (kg)')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control','placeholder' => 'Phone Number')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true, 'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Visiting Number')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Emergency Contact Details')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Medical Histroy')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Allergic Histroy')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Surgical Histroy')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Drug Histroy')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Social Histroy')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true, 'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Examination Details')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "In Patient");
                }, 
                'required' => true,
                'label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Type')))
            //->add('pSurgeryInfo', CheckboxType::class, array('required' => true,'label' => 'Surgery Complete', 'attr' => array('class' => 'col-md-1 mb-2')))
            ->add('pCurrentLocation', ChoiceType::class, array('choices' => [ 'ICU' => 'ICU', 'Ward' => 'Ward', 'Operating Theater' => 'Operating Theater'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Current Location')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'Active', 'Deactive' => 'Deactive'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Status')))
            ->add('brochureFilename', FileType::class, array('required' => false, 'mapped' => false, 'label' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/tiff',
                            'image/bmp',
                            'image/other',
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/zip',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                            'application/vnd.ms-word.document.macroEnabled.12',
                            'application/vnd.ms-word.template.macroEnabled.12',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel.sheet.macroEnabled.12',
                            'application/vnd.ms-powerpoint',
                            'text/plain',
                            'text/csv', 
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file.',
                    ])
                ],
            ))
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
            $file = $form->get('brochureFilename')->getData();

            if($file)
            {
                $pdfs_directory = $this->getParameter('pdfs_directory');
                $filename = md5(uniqid()) .'.'. $file->guessExtension();

                try  {
                    $file->move(
                        $pdfs_directory,
                        $filename
                    );
                } catch (FileException $e) {

                }

                $patient->setBrochureFilename($filename);             

            }
            
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
            ->add('pNIC', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'NIC number')))
            ->add('pFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Patient')))
            ->add('pLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Patient')))
            ->add('pAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Patient')))
            ->add('pGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('pDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('pHeight', NumberType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Height (cm)')))
            ->add('pWeight', NumberType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Weight (kg)')))
            ->add('pPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('pVisitingNumber', IntegerType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Visiting Number')))
            ->add('pEmergencyContactDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Emergency Contact Details')))
            ->add('pMedicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Medical Histroy')))
            ->add('pAllergicHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Allergic Histroy')))
            ->add('pSurgicalHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Surgical Histroy')))
            ->add('pDrugHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Drug Histroy')))
            ->add('pSocialHistroy', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Social Histroy')))
            ->add('pExaminationDetails', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Examination Details')))
            ->add('PatientType', EntityType::class, array(
                'class' => PatientType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.Type = :val')
                        ->setParameter('val', "Out Patient");
                }, 
                'required' => true,
                'label' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Type')))
            ->add('pStatus', ChoiceType::class, array('choices' => [ 'Active' => 'Active', 'Deactive' => 'Deactive'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Status')))
            ->add('brochureFilename', FileType::class, array('required' => false, 'mapped' => false, 'label' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/tiff',
                            'image/bmp',
                            'image/other',
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/zip',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                            'application/vnd.ms-word.document.macroEnabled.12',
                            'application/vnd.ms-word.template.macroEnabled.12',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel.sheet.macroEnabled.12',
                            'application/vnd.ms-powerpoint',
                            'text/plain',
                            'text/csv', 
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file.',
                    ])
                ],
            ))
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
            $file = $form->get('brochureFilename')->getData();

            if($file)
            {
                $pdfs_directory = $this->getParameter('pdfs_directory');
                $filename = md5(uniqid()) .'.'. $file->guessExtension();

                try  {
                    $file->move(
                        $pdfs_directory,
                        $filename
                    );
                } catch (FileException $e) {

                }

                $patient->setBrochureFilename($filename);             

            }
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('clinics_list');
        }

        return $this->render('clinic/patient_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
