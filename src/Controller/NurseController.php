<?php

namespace App\Controller;

use App\Entity\Nurse;
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

class NurseController extends AbstractController
{
    /**
     * @Route("/nurse", name="nurses_list")
     */
    public function display()
    {

        $nurses = $this->getDoctrine()->getRepository(Nurse::class)->findAll();

        return $this->render('nurse/nurse.html.twig', [
            'nurses' => $nurses,
        ]);
    }

    /**
     * @Route("/nurse/add", name="nurse_add")
     */
    public function createNurse(Request $request)
    {
        $nurse = new Nurse();

        $form = $this->createFormBuilder($nurse)
            ->add('nNIC', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC of Nurse')))
            ->add('nFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Nurse')))
            ->add('nLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Nurse')))
            ->add('nAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Nurse')))
            ->add('nGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('nDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('nPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('nRole', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control')))
            ->add('Department', EntityType::class, array('class' => Department::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Unit', EntityType::class, array('class' => Unit::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
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
            $nurse = $form->getData();
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nurse);
            $entityManager->flush(); 

            return $this->redirectToRoute('nurses_list');
        }

        return $this->render('nurse/nurse_add.html.twig',array('form' => $form->createView()));    
    }


    /**
     * @Route("/nurse/edit/{id}", name="nurse_edit")
     */
    public function edit(Request $request,$id)
    {
        $nurse = new Nurse();

        $nurse = $this->getDoctrine()->getRepository(Nurse::class)->find($id);

        $form = $this->createFormBuilder($nurse)
            ->add('nNIC', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC of Nurse')))
            ->add('nFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Nurse')))
            ->add('nLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Nurse')))
            ->add('nAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Nurse')))
            ->add('nGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('nDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('nPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('nRole', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control')))
            ->add('Department', EntityType::class, array('class' => Department::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Unit', EntityType::class, array('class' => Unit::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
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

            return $this->redirectToRoute('nurses_list');
        }
        
        return $this->render('nurse/nurse_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
