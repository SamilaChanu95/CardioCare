<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\ICU;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;

class ICUType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $label="Create";
        if ($options['edit_mode']==true )
        {
            $label="Update";
        }
        $builder
        ->add('Patient', EntityType::class, array(
            'class' => Patient::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->Where('u.pStatus = :val1') 
                    ->andWhere('u.pCurrentLocation != :val2')
                    ->setParameters(array('val1' => "Active" , 'val2' => "Clinic"));   
            }, 
            'required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Patient Name')))
        ->add('AdmitDate', DateType::class, array('required' => true, 'html5' => false, 'label' => false))
        ->add('Room', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => "Patient's Room")))
        ->add('Code', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => "ICU Report's Code")))
        ->add('Diagnosis', TextareaType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => "Patient's Diagnosies")))
        ->add('Neuro', TextareaType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Neuro')))
        ->add('Cardiac', TextareaType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Cardiac')))
        ->add('Respiratory', TextareaType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Respiratory')))
        ->add('Ventilator', TextareaType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Ventilator')))
        ->add('GI', TextareaType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'GI Information')))
        ->add('GU', TextareaType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'GU Information')))
        ->add('Skin', TextareaType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Skin')))
        ->add('Drains', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Drains')))
        ->add('Labs', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Labs')))
        ->add('Meds', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Meds')))
        ->add('Hemodynamics', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Hemodynamics')))
        ->add('ToDo', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Todo List')))
        ->add('CoreMeasures', TextareaType::class, array('required' => false,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'CoreMeasures')))
        ->add('captchaCode', CaptchaType::class, array(
            'captchaConfig' => 'ExampleCaptchaUserRegistration',
            'label' => 'Retype the characters from the picture',
            'constraints' => [
                new ValidCaptcha ([
                    'message' => 'Invalid captcha, please try again',
                ]),
            ],
        ))
        ->add('submit', SubmitType::class, array('label'=> $label, 'attr' => array('class' => 'btn btn-primary mt-3')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ICU::class,'edit_mode' => false,
        ]);

        $resolver->setAllowedTypes('edit_mode', 'bool');
    }
}