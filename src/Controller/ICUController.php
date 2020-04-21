<?php

namespace App\Controller;

use App\Entity\ICU;
use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;

class ICUController extends AbstractController
{
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
     * @Route("/icu/add", name="icu_report_add")
     */
    public function createICUReport(Request $request)
    {
        $icureport = new ICU();

        $form = $this->createFormBuilder($icureport)
            ->add('Patient', EntityType::class, array('class' => Patient::class, 'required' => true,'label' => 'Patient Name','attr' => array('class' => 'form-control')))
            ->add('AdmitDate', DateType::class, array('required' => true, 'html5' => false, 'label' => 'Admit Date'))
            ->add('Room', TextType::class, array('required' => true,'label' => "Patient's Room",'attr' => array('class' => 'form-control')))
            ->add('Code', TextType::class, array('required' => true,'label' => 'Code','attr' => array('class' => 'form-control')))
            ->add('Diagnosis', TextareaType::class, array('required' => true,'label' => 'Diagnosies','attr' => array('class' => 'form-control')))
            ->add('Neuro', TextareaType::class, array('required' => true,'label' => 'Neuro','attr' => array('class' => 'form-control')))
            ->add('Cardiac', TextareaType::class, array('required' => true,'label' => 'Cardiac','attr' => array('class' => 'form-control')))
            ->add('Respiratory', TextareaType::class, array('required' => true,'label' => 'Respiratory','attr' => array('class' => 'form-control')))
            ->add('Ventilator', TextareaType::class, array('required' => true,'label' => 'Ventilator','attr' => array('class' => 'form-control')))
            ->add('GI', TextareaType::class, array('required' => true,'label' => 'GI','attr' => array('class' => 'form-control')))
            ->add('GU', TextareaType::class, array('required' => true,'label' => 'GU','attr' => array('class' => 'form-control')))
            ->add('Skin', TextareaType::class, array('required' => true,'label' => 'Skin','attr' => array('class' => 'form-control')))
            ->add('Drains', TextareaType::class, array('required' => true,'label' => 'Drains', 'attr' => array('class' => 'form-control')))
            ->add('Labs', TextareaType::class, array('required' => false,'label' => 'Labs', 'attr' => array('class' => 'form-control')))
            ->add('Meds', TextareaType::class, array('required' => false,'label' => 'Meds', 'attr' => array('class' => 'form-control')))
            ->add('Hemodynamics', TextareaType::class, array('required' => false,'label' => 'Hemodynamics', 'attr' => array('class' => 'form-control')))
            ->add('ToDo', TextareaType::class, array('required' => false,'label' => 'ToDo', 'attr' => array('class' => 'form-control')))
            ->add('CoreMeasures', TextareaType::class, array('required' => false,'label' => 'CoreMeasures', 'attr' => array('class' => 'form-control')))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('submit', SubmitType::class, array('label'=> 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $icureport = $form->getData();
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($icureport);
            $entityManager->flush(); 

            return $this->redirectToRoute('icu_reports_list');
        }

        return $this->render('icu/icureport_add.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/icu/edit/{id}", name="icu_report_edit")
     */
    public function editICUReport(Request $request,$id)
    {
        $icureport = new ICU();

        $icureport = $this->getDoctrine()->getRepository(ICU::class)->find($id);

        $form = $this->createFormBuilder($icureport)
            ->add('Patient', EntityType::class, array('class' => Patient::class, 'required' => true,'label' => 'Patient Name','attr' => array('class' => 'form-control')))
            ->add('AdmitDate', DateType::class, array('required' => true, 'html5' => false, 'label' => 'Admit Date'))
            ->add('Room', TextType::class, array('required' => true,'label' => "Patient's Room",'attr' => array('class' => 'form-control')))
            ->add('Code', TextType::class, array('required' => true,'label' => 'Code','attr' => array('class' => 'form-control')))
            ->add('Diagnosis', TextareaType::class, array('required' => true,'label' => 'Diagnosies','attr' => array('class' => 'form-control')))
            ->add('Neuro', TextareaType::class, array('required' => true,'label' => 'Neuro','attr' => array('class' => 'form-control')))
            ->add('Cardiac', TextareaType::class, array('required' => true,'label' => 'Cardiac','attr' => array('class' => 'form-control')))
            ->add('Respiratory', TextareaType::class, array('required' => true,'label' => 'Respiratory','attr' => array('class' => 'form-control')))
            ->add('Ventilator', TextareaType::class, array('required' => true,'label' => 'Ventilator','attr' => array('class' => 'form-control')))
            ->add('GI', TextareaType::class, array('required' => true,'label' => 'GI','attr' => array('class' => 'form-control')))
            ->add('GU', TextareaType::class, array('required' => true,'label' => 'GU','attr' => array('class' => 'form-control')))
            ->add('Skin', TextareaType::class, array('required' => true,'label' => 'Skin','attr' => array('class' => 'form-control')))
            ->add('Drains', TextareaType::class, array('required' => true,'label' => 'Drains', 'attr' => array('class' => 'form-control')))
            ->add('Labs', TextareaType::class, array('required' => false,'label' => 'Labs', 'attr' => array('class' => 'form-control')))
            ->add('Meds', TextareaType::class, array('required' => false,'label' => 'Meds', 'attr' => array('class' => 'form-control')))
            ->add('Hemodynamics', TextareaType::class, array('required' => false,'label' => 'Hemodynamics', 'attr' => array('class' => 'form-control')))
            ->add('ToDo', TextareaType::class, array('required' => false,'label' => 'ToDo', 'attr' => array('class' => 'form-control')))
            ->add('CoreMeasures', TextareaType::class, array('required' => false,'label' => 'CoreMeasures', 'attr' => array('class' => 'form-control')))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('submit', SubmitType::class, array('label'=> 'Update', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush(); 

            return $this->redirectToRoute('icu_reports_list');
        }

        return $this->render('icu/icureport_edit.html.twig', [
            'form' => $form->createView()
        ]);

    }


}
