<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Technician;
use App\Entity\Department;
use App\Entity\Unit;
use App\Entity\Ward;
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
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


class TechnicianType extends AbstractType
{

    private $em;
    private $departmentRepository;
    
    /**
     * The Type requires the EntityManager as argument in the constructor. It is autowired
     * in Symfony 3.
     * 
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, DepartmentRepository $departmentRepository)
    {
        $this->em = $em;
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tNIC', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'NIC of Technician')))
            ->add('tFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Firstname of Technician')))
            ->add('tLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Lastname of Technician')))
            ->add('tAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Technician')))
            ->add('tGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('tDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('tPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('tRole', ChoiceType::class, array('choices' => [ 'Main Technician' =>  'Main Technician', 'Assistant Technician' => 'Assistant Technician'],'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
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
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));    
        
    }

    protected function addElements(FormInterface $form, Department $department = null) {
       
        $form->add('department', EntityType::class, array(
            'required' => true,
            'label' => false,
            'attr' => array('class' => 'form-control'),
            'data' => $department,
            'placeholder' => 'Select a Department...',
            'class' => Department::class
        ));
        
        // Neighborhoods empty, unless there is a selected City (Edit View)
        $units = array();
        //$wards = array();
        
        // If there is a city stored in the Person entity, load the neighborhoods of it
        if ($department) {
            // Fetch Neighborhoods of the City if there's a selected city
            $repoUnit = $this->em->getRepository(Unit::class);
            
            $units = $repoUnit->departmentRepository->findOneBySomeField($department);
        }
        
        // Add the Neighborhoods field with the properly data
        $form->add('unit', EntityType::class, array(
            'required' => true,
            'label' => false,
            'attr' => array('class' => 'form-control'),
            'placeholder' => 'Select a department first ...',
            'class' => Unit::class,
            'choices' => $units
        ));

    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        
        // Search for selected City and convert it into an Entity
        $department = $this->em->getRepository(Department::class)->find($data['department']);
        
        $this->addElements($form, $department);
    }

    function onPreSetData(FormEvent $event) {
        $technician = $event->getData();
        $form = $event->getForm();

        // When you create a new person, the City is always empty
        $department = $technician->getDepartment() ? $technician->getDepartment() : null;
        
        $this->addElements($form, $department);
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