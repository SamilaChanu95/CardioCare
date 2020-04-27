<?php

namespace App\Controller;


use App\Entity\Consultant;
use App\Entity\Department;
use App\Entity\Unit;
use App\Entity\Ward;
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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('cNIC', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC of Technician')))
            ->add('cFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Technician')))
            ->add('cLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Technician')))
            ->add('cAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Technician')))
            ->add('cGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('cDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('cPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('cRole', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Unit', EntityType::class, array('class' => Unit::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Department', EntityType::class, array('class' => Department::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Ward', EntityType::class, array('class' => Ward::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
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
            ->add('cNIC', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC of Technician')))
            ->add('cFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Technician')))
            ->add('cLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Technician')))
            ->add('cAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Technician')))
            ->add('cGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('cDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('cPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('cRole', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Unit', EntityType::class, array('class' => Unit::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Department', EntityType::class, array('class' => Department::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Ward', EntityType::class, array('class' => Ward::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
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



