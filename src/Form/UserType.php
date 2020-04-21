<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username' , TextType::class, array('required' => true, 'trim' => true, 'label' => false , 'attr' => array('class' => 'form-control input-group mb-3', 'placeholder' => "Enter username")))
            ->add('email', EmailType::class, array('required' => true, 'label' => false ,'attr' => array('class' => 'form-control input-group mb-3', 'placeholder' => "Enter email")))
            ->add('plainPassword', RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [ 'placeholder' => "Enter password", 'class' => 'form-control input-group mb-3'],'label' => false,
                ],
                'second_options' => [
                    'attr' => [ 'placeholder' => "Enter password again", 'class' => 'form-control input-group mb-3'],'label' => false,
                ] 
                ], array('required' => true,'attr' => array('class' => 'form-control input-group mb-3')))
            ->add('termsAccepted', CheckboxType::class, array(
                'mapped' => false,
                'constraints' => new IsTrue(),
                'attr' => [
                    'class' => 'col-sm-1'
                ]
            ))
            ->add('register', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'appbunble_member';
    }
}
