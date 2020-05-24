<?php

namespace App\Form;

use App\Entity\Department;
use App\Entity\Hospital;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DepartmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $label="Create";
        if ($options['edit_mode']==true )
        {
            $label="Update";
        }
        $builder
            ->add('DepartmentName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Name of Department')))
            ->add('hospital', EntityType::class, array('class' => Hospital::class ,'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Name of Hospital')))
            ->add('save', SubmitType::class, array('label'=> $label, 'attr' => array('class' => 'btn btn-primary mt-3')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Department::class,'edit_mode' => false,
        ]);

        $resolver->setAllowedTypes('edit_mode', 'bool');
    }
}
