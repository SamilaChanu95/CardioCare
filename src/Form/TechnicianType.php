<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Technician;
use App\Entity\Department;
use App\Entity\Unit;
use App\Entity\Ward;
use App\Repository\UnitRepository;
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

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $unit = new Unit();

        $builder
            ->add('tNIC', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC of Technician')))
            ->add('tFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Firstname of Technician')))
            ->add('tLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Lastname of Technician')))
            ->add('tAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Technician')))
            ->add('tGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('tDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('tPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('tRole', ChoiceType::class, array('choices' => [ 'Main Technician' =>  'Main Technician', 'Assistant Technician' => 'Assistant Technician'],'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('department', EntityType::class, array(
                'required' => true,
                'label' => false,
                'attr' => array('class' => 'form-control'),
                'placeholder' => 'Select a Department...',
                'class' => Department::class,
                'multiple' => false,
                
            ))
            ->add('unit', EntityType::class, array(
                'required' => true,
                'label' => false,
                'attr' => array('class' => 'form-control'),
                'placeholder' => 'Select a department first ...',
                'class' => Unit::class,
                'multiple' => false,
                'query_builder' => function(EntityRepository $er) {
                    $query_builder = $er->createQueryBuilder('p');
                    $query_builder
                        ->select('p')
                        ->leftJoin(Department::class, 'd', 'WITH', 'd.id = p.id')
                        ->leftJoin(Unit::class, 'u', 'WITH', 'u.Department = p.id')
                        ->where('d.id = u.Department');
                        

                    return $query_builder;
                },         
            ))
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
            ->add('save', SubmitType::class, array('label'=> 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')));
        
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Technician::class
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_technician';
    }

}