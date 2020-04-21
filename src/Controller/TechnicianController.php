<?php

namespace App\Controller;

use App\Entity\Technician;
use App\Entity\Department;
use App\Entity\Unit;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('tNIC', TextType::class, array('required' => true,'label' => 'NIC number of Technician','attr' => array('class' => 'form-control')))
            ->add('tFirstName', TextType::class, array('required' => true,'label' => 'First Name of Technician','attr' => array('class' => 'form-control')))
            ->add('tLastName', TextType::class, array('required' => true,'label' => 'Last Name of Technician','attr' => array('class' => 'form-control')))
            ->add('tAddress', TextareaType::class, array('required' => true,'label' => 'Address of Technician','attr' => array('class' => 'form-control')))
            ->add('tGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('tDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('tPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('tRole', TextType::class, array('required' => true,'label' => 'Role','attr' => array('class' => 'form-control')))
            ->add('Unit', EntityType::class, array('class' => Unit::class, 'required' => true,'label' => 'Unit','attr' => array('class' => 'form-control')))
            ->add('Department', EntityType::class, array('class' => Department::class, 'required' => true,'label' => 'Department','attr' => array('class' => 'form-control')))
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
            $technician = $form->getData();
             
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
            ->add('tNIC', TextType::class, array('required' => true,'label' => 'NIC number of Technician','attr' => array('class' => 'form-control')))
            ->add('tFirstName', TextType::class, array('required' => true,'label' => 'First Name of Technician','attr' => array('class' => 'form-control')))
            ->add('tLastName', TextType::class, array('required' => true,'label' => 'Last Name of Technician','attr' => array('class' => 'form-control')))
            ->add('tAddress', TextareaType::class, array('required' => true,'label' => 'Address of Technician','attr' => array('class' => 'form-control')))
            ->add('tGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('tDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('tPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('tRole', TextType::class, array('required' => true,'label' => 'Role','attr' => array('class' => 'form-control')))
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

        if($form->isSubmitted() && $form->isValid())
        {
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('technicians_list');
        }

        return $this->render('technician/technician_edit.html.twig', ['form' => $form->createView()]);    
    }

}






