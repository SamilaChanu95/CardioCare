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
use Doctrine\ORM\EntityRepository;

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
            ->add('SurgeryName', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control')))    
            ->add('priority', IntegerType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Patient', EntityType::class, array(
                'class' => Patient::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.pStatus = :val1') 
                        ->andWhere('u.pCurrentLocation != :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Clinic")); 
                },
                'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('DoctorMain', EntityType::class, array(
                'class' => Doctor::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.dStatus = :val1') 
                        ->andWhere('u.dRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Main Doctor"));
                }, 
                'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('DoctorFAssistant', EntityType::class, array(
                'class' => Doctor::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.dStatus = :val1') 
                        ->andWhere('u.dRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Assistant Doctor"));
                }, 
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('DoctorSAssistant', EntityType::class, array(
                'class' => Doctor::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.dStatus = :val1') 
                        ->andWhere('u.dRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Doctor Anaesthetist"));
                },
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('NurseMain', EntityType::class, array(
                'class' => Nurse::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.nStatus = :val1') 
                        ->andWhere('u.nRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Main Nurse"));
                },
                'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('NurseFAssistant', EntityType::class, array(
                'class' => Nurse::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.nStatus = :val1') 
                        ->andWhere('u.nRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Assistant Nurse"));
                },
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('NurseSAssistant', EntityType::class, array(
                'class' => Nurse::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.nStatus = :val1') 
                        ->andWhere('u.nRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Assistant Nurse"));
                },
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('NurseTAssistant', EntityType::class, array(
                'class' => Nurse::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.nStatus = :val1') 
                        ->andWhere('u.nRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Nurse Anaesthetist"));
                },
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('ConsultantMain', EntityType::class, array(
                'class' => Consultant::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.cStatus = :val1') 
                        ->andWhere('u.cRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Main Consultant"));
                }, 
                'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('ConsultantAssistant', EntityType::class, array(
                'class' => Consultant::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.cStatus = :val1') 
                        ->andWhere('u.cRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Assistant Consultant"));
                }, 
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('TechnicianMain', EntityType::class, array(
                'class' => Technician::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.tStatus = :val1') 
                        ->andWhere('u.tRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Main Technician"));
                }, 
                'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('TechnicianAssistant', EntityType::class, array(
                'class' => Technician::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.tStatus = :val1') 
                        ->andWhere('u.tRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Assistant Technician"));
                }, 
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('time', TimeType::class, array('required' => true, 'html5' => false, 'label' => false))
            ->add('date', DateType::class, array('required' => true, 'html5' => false, 'label' => false))
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
            ->add('SurgeryName', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control')))    
            ->add('priority', IntegerType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Patient', EntityType::class, array(
                'class' => Patient::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.pStatus = :val')
                        ->setParameter('val', "Active");
                }, 
                'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('DoctorMain', EntityType::class, array(
                'class' => Doctor::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.dStatus = :val1') 
                        ->andWhere('u.dRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Main Doctor"));
                }, 
                'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('DoctorFAssistant', EntityType::class, array(
                'class' => Doctor::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.dStatus = :val1') 
                        ->andWhere('u.dRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Assistant Doctor"));
                }, 
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('DoctorSAssistant', EntityType::class, array(
                'class' => Doctor::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.dStatus = :val1') 
                        ->andWhere('u.dRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Doctor Anaesthetist"));
                },
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('NurseMain', EntityType::class, array(
                'class' => Nurse::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.nStatus = :val1') 
                        ->andWhere('u.nRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Main Nurse"));
                },
                'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('NurseFAssistant', EntityType::class, array(
                'class' => Nurse::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.nStatus = :val1') 
                        ->andWhere('u.nRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Assistant Nurse"));
                },
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('NurseSAssistant', EntityType::class, array(
                'class' => Nurse::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.nStatus = :val1') 
                        ->andWhere('u.nRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Assistant Nurse"));
                },
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('NurseTAssistant', EntityType::class, array(
                'class' => Nurse::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.nStatus = :val1') 
                        ->andWhere('u.nRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Nurse Anaesthetist"));
                },
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('ConsultantMain', EntityType::class, array(
                'class' => Consultant::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.cStatus = :val1') 
                        ->andWhere('u.cRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Main Consultant"));
                }, 
                'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('ConsultantAssistant', EntityType::class, array(
                'class' => Consultant::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.cStatus = :val1') 
                        ->andWhere('u.cRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Assistant Consultant"));
                }, 
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('TechnicianMain', EntityType::class, array(
                'class' => Technician::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.tStatus = :val1') 
                        ->andWhere('u.tRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Main Technician"));
                }, 
                'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('TechnicianAssistant', EntityType::class, array(
                'class' => Technician::class, 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.tStatus = :val1') 
                        ->andWhere('u.tRole = :val2')
                        ->setParameters(array('val1' => "Active" , 'val2' => "Assistant Technician"));
                }, 
                'required' => false,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('time', TimeType::class, array('required' => true, 'html5' => false, 'label' => false))
            ->add('date', DateType::class, array('required' => true, 'html5' => false, 'label' => false))
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
