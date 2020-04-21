<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Doctor;
use App\Entity\Consultant;
use App\Entity\Nurse;
use App\Entity\Technician;
use App\Entity\Surgery;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;

class SurgeryController extends AbstractController
{
    /**
     * @Route("/surgery", name="surgeries_list")
     */
    public function display()
    {
        $surgeries = $this->getDoctrine()->getRepository(Surgery::class)->findAll();
        $patients = $this->getDoctrine()->getRepository(Patient::class)->findAll();

        return $this->render('surgery/surgery.html.twig', [
            'surgeries' => $surgeries,
            'patients' => $patients
        ]);
    }

    /**
     * @Route("/surgery/add", name="surgery_add")
     */
    public function createSurgery(Request $request)
    {
        $surgery = new Surgery();

        $form = $this->createFormBuilder($surgery)
            ->add('SurgeryName', TextType::class, array('required' => true,'label' => 'Name of Surgery','attr' => array('class' => 'form-control')))    
            ->add('priority', IntegerType::class, array('required' => true,'label' => 'Priority of the Surgery','attr' => array('class' => 'form-control')))
            ->add('Patient', EntityType::class, array('class' => Patient::class, 'required' => true,'label' => 'Patient Name','attr' => array('class' => 'form-control')))
            ->add('Doctor', EntityType::class, array('class' => Doctor::class, 'required' => true,'label' => 'Doctor Name','attr' => array('class' => 'form-control')))
            ->add('Nurse', EntityType::class, array('class' => Nurse::class, 'required' => true,'label' => 'Nurse Name','attr' => array('class' => 'form-control')))
            ->add('Consultant', EntityType::class, array('class' => Consultant::class, 'required' => true,'label' => 'Consultant Name','attr' => array('class' => 'form-control')))
            ->add('Technician', EntityType::class, array('class' => Technician::class, 'required' => true,'label' => 'Technician Name','attr' => array('class' => 'form-control')))
            ->add('time', TimeType::class, array('required' => true, 'html5' => false, 'label' => 'Surgery time'))
            ->add('date', DateType::class, array('required' => true, 'html5' => false, 'label' => 'Surgery Date'))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('submit', SubmitType::class, array('label' => 'Create','attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $surgery = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($surgery);
            $entityManager->flush(); 

            return $this->redirectToRoute('surgeries_list');
        }

        return $this->render('surgery/surgery_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/surgery/edit/{id}", name="surgery_edit")
     */
    public function edit(Request $request,$id)
    {
        $surgery = new Surgery();

        $surgery = $this->getDoctrine()->getRepository(Surgery::class)->find($id);

        $form = $this->createFormBuilder($surgery)
            ->add('SurgeryName', TextType::class, array('required' => true,'label' => 'Name of Surgery','attr' => array('class' => 'form-control')))    
            ->add('priority', IntegerType::class, array('required' => true,'label' => 'Priority of the Surgery','attr' => array('class' => 'form-control')))
            ->add('Patient', EntityType::class, array('class' => Patient::class, 'required' => true,'label' => 'Patient Name','attr' => array('class' => 'form-control')))
            ->add('Doctor', EntityType::class, array('class' => Doctor::class, 'required' => true,'label' => 'Doctor Name','attr' => array('class' => 'form-control')))
            ->add('Nurse', EntityType::class, array('class' => Nurse::class, 'required' => true,'label' => 'Nurse Name','attr' => array('class' => 'form-control')))
            ->add('Consultant', EntityType::class, array('class' => Consultant::class, 'required' => true,'label' => 'Consultant Name','attr' => array('class' => 'form-control')))
            ->add('Technician', EntityType::class, array('class' => Technician::class, 'required' => true,'label' => 'Technician Name','attr' => array('class' => 'form-control')))
            ->add('time', TimeType::class, array('required' => true, 'html5' => false, 'label' => 'Surgery time'))
            ->add('date', DateType::class, array('required' => true, 'html5' => false, 'label' => 'Surgery Date'))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('submit', SubmitType::class, array('label' => 'Update','attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush(); 

            return $this->redirectToRoute('surgeries_list');
        }

        return $this->render('surgery/surgery_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
