<?php
    namespace App\Form\User;

    use App\Entity\User;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
    use Symfony\Component\Form\Extension\Core\Type\PasswordType;
    use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class ChangePasswordType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {

            $builder->add('username', TextType::class, array('required' => true, 'trim' => true, 'label' => false , 'attr' => array('class' => 'form-control input-group mb-3', 'placeholder' => "Enter username")))
                ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class, 'required' => true, 'invalid_message' => 'The password fields must match.',
                'first_options' => array('attr' => [ 'placeholder' => "Enter password", 'class' => 'form-control input-group mb-3'],'label' => false,),
                'second_options' => array('attr' => [ 'placeholder' => "Confirm password", 'class' => 'form-control input-group mb-3'],'label' => false,),
            ));
        }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(array(
                //'data_class' => User::class
            ));
        }
    }