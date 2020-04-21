<?php

namespace App\Controller;


use App\Entity\Consultant;
use App\Entity\Department;
use App\Entity\Unit;
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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;


class ConsultantController extends AbstractController
{

    /**
     * @Route("/consultant/add", name="consultant_add")
     */
    public function createConsultant(Request $request)
    {
        $consultant = new Consultant();

        $form = $this->createFormBuilder($consultant)
            ->add('cNIC', TextType::class, array('required' => true,'label' => 'NIC number of Technician','attr' => array('class' => 'form-control')))
            ->add('cFirstName', TextType::class, array('required' => true,'label' => 'First Name of Technician','attr' => array('class' => 'form-control')))
            ->add('cLastName', TextType::class, array('required' => true,'label' => 'Last Name of Technician','attr' => array('class' => 'form-control')))
            ->add('cAddress', TextareaType::class, array('required' => true,'label' => 'Address of Technician','attr' => array('class' => 'form-control')))
            ->add('cGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('cDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('cPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('cRole', TextType::class, array('required' => true,'label' => 'Role','attr' => array('class' => 'form-control')))
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
            $consultant = $form->getData();
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consultant);
            $entityManager->flush(); 

            return $this->redirectToRoute('consultants_list');
            
        }

        return $this->render('consultant/consultant_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/consultant", name="consultants_list")
     */
    public function display()
    {

        $consultants = $this->getDoctrine()->getRepository(Consultant::class)->findAll();

        return $this->render('consultant/consultant.html.twig', [
            'consultants' => $consultants,
        ]);
    }

    /**
     * @Route("/consultant/edit/{id}", name="consultant_edit")
     */
    public function edit(Request $request,$id)
    {
        $consultant = new Consultant();

        $consultant = $this->getDoctrine()->getRepository(Consultant::class)->find($id);

        $form = $this->createFormBuilder($consultant)
            ->add('cNIC', TextType::class, array('required' => true,'label' => 'NIC number of Technician','attr' => array('class' => 'form-control')))
            ->add('cFirstName', TextType::class, array('required' => true,'label' => 'First Name of Technician','attr' => array('class' => 'form-control')))
            ->add('cLastName', TextType::class, array('required' => true,'label' => 'Last Name of Technician','attr' => array('class' => 'form-control')))
            ->add('cAddress', TextareaType::class, array('required' => true,'label' => 'Address of Technician','attr' => array('class' => 'form-control')))
            ->add('cGender', TextType::class, array('required' => true,'label' => 'Male/Female','attr' => array('class' => 'form-control')))
            ->add('cDOB', TextType::class, array('required' => true,'label' => 'Date of Birth','attr' => array('class' => 'form-control')))
            ->add('cPhoneNumber', TextType::class, array('required' => true,'label' => 'Phone Number','attr' => array('class' => 'form-control')))
            ->add('cRole', TextType::class, array('required' => true,'label' => 'Role','attr' => array('class' => 'form-control')))
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

            return $this->redirectToRoute('consultants_list');
        }
        return $this->render('consultant/consultant_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}



