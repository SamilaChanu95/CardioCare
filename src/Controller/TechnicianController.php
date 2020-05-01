<?php

namespace App\Controller;

use App\Entity\Technician;
use App\Entity\Department;
use App\Entity\Unit;
use App\Entity\Ward;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Symfony\Component\Validator\Constraints\File;

class TechnicianController extends AbstractController
{
    /**
     * @Route("/technician", name="technicians_list")
     */
    public function display()
    {
        $technicians = $this->getDoctrine()->getRepository(Technician::class)->findAll();

        return $this->render('technician/technician.html.twig', [
            'technicians' => $technicians,
        ]);
    }

    /**
     * @Route("/technician/add", name="technician_add")
     */

    public function createTechnician(Request $request)
    {
        $technician = new Technician();

        $form = $this->createFormBuilder($technician)
            ->add('tNIC', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC of Technician')))
            ->add('tFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Firstname of Technician')))
            ->add('tLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Lastname of Technician')))
            ->add('tAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Technician')))
            ->add('tGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('tDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('tPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('tRole', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Unit', EntityType::class, array('class' => Unit::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Department', EntityType::class, array('class' => Department::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Ward', EntityType::class, array('class' => Ward::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('photo', FileType::class, array('required' => false, 'mapped' => false, 'label' => false, 'constraints' => array(
                new File([
                    'maxSize' => '2048k',
                    'mimeTypes' => [
                        'image/jpg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => "Please upload valid photo.",   
                    ])
                ),
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

        if($form->isSubmitted())
        {
            $file = $form->get('photo')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $fileName); 
            $technician->setPhoto($fileName);  
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($technician);
            $entityManager->flush(); 

            return $this->redirectToRoute('technicians_list');
        }

        return $this->render('technician/technician_add.html.twig',array('form' => $form->createView()));    
    }

    /**
     * @Route("/technician/edit/{id}", name="technician_edit")
     */
    public function edit(Request $request,$id)
    {
        $technician = new Technician();

        $technician = $this->getDoctrine()->getRepository(Technician::class)->find($id);

        $form = $this->createFormBuilder($technician)
            ->add('tNIC', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC of Technician')))
            ->add('tFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Firstname of Technician')))
            ->add('tLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Lastname of Technician')))
            ->add('tAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Technician')))
            ->add('tGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('tDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('tPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('tRole', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Unit', EntityType::class, array('class' => Unit::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Department', EntityType::class, array('class' => Department::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Ward', EntityType::class, array('class' => Ward::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('photo', FileType::class, array('required' => false, 'mapped' => false, 'label' => false, 'constraints' => array(
                new File([
                    'maxSize' => '2048k',
                    'mimeTypes' => [
                        'image/jpg',
                        'image/png',
                    ],
                    'mimeTypesMessage' =>  "Please upload valid photo.",    
                    ])
                ),
            )) 
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ]
            ))
            ->add('save', SubmitType::class, array('label'=> 'Update', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('technicians_list');
        }

        return $this->render('technician/technician_edit.html.twig', ['form' => $form->createView()]);    
    }

}






