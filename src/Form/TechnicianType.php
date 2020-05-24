<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Technician;
use App\Entity\Department;
use App\Entity\Unit;
use App\Entity\Ward;
use App\Entity\Hospital;
use App\Repository\UnitRepository;
use App\Repository\DepartmentRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;


class TechnicianType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $label="Create";
        if ($options['edit_mode']==true )
        {
            $label="Update";
        }
        $builder
            ->add('tNIC', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC of Technician')))
            ->add('tFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Firstname of Technician')))
            ->add('tLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Lastname of Technician')))
            ->add('tAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Technician')))
            ->add('tGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('tDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('tPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('tRole', ChoiceType::class, array('choices' => [ 'Main Technician' =>  'Main Technician', 'Assistant Technician' => 'Assistant Technician'],'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Hospital', EntityType::class, array('class' => Hospital::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Ward', EntityType::class, array('class' => Ward::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('department', EntityType::class, array(
                'required' => true,
                'label' => false,
                'attr' => array('class' => 'form-control'),
                'placeholder' => 'Select a Department...',
                'class' => Department::class,
                //'mapped' => false,
                //'multiple' => false,
                //'choice_label' => 'DepartmentName',
                //'query_builder' => function(DepartmentRepository $repository) {
                //    return $repository->createQueryBuilder('s')
                //           ->GroupBy('s.DepartmentName')
                //           ->orderBy('s.DepartmentName','DESC');
                //}
                
            ))
        ;

        $builder->get('department')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event)
            {
                $form = $event->getForm();
                
                $form->getParent()
                ->add('unit', EntityType::class, [
                    'class' => Unit::class,
                    'attr' => array('class' => 'form-control'),
                    'placeholder' => 'Please select a unit',
                    'choices' => $form->getData()->getUnits()
                ]);
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event)
            {
                $form = $event->getForm();
                $data = $event->getData();
                $unit = $data->getUnit();
                if($unit)
                {
                    $form->get('department')->setData($unit->getDepartment());
                    $form->add('unit', EntityType::class, [
                        'class' => Unit::class,
                        'attr' => array('class' => 'form-control'),
                        'label' => false,
                        'placeholder' => 'Please select a unit',
                        'choices' => $unit->getDepartment()->getUnits()
                    ]);
                } else {
                    $form->add('unit', EntityType::class, [
                        'class' => Unit::class,
                        'attr' => array('class' => 'form-control'),
                        'label' => false,
                        'placeholder' => 'Please select a unit',
                        'choices' => []
                    ]);
                }
            }
        ); 

        $builder
            ->add('tStatus', ChoiceType::class, array('choices' => [ 'Active' => 'Active', 'Deactive' => 'Deactive'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Status')))
            ->add('photo', FileType::class, array('required' => false, 'mapped' => false, 'label' => false, 'constraints' => array(
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/tiff',
                            'image/bmp',
                            'image/other',
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
        ; 
    }
                

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Technician::class,'edit_mode' => false,
        ));

        $resolver->setAllowedTypes('edit_mode', 'bool');
    }

}