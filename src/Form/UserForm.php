<?php 

namespace App\Form;

use App\Document\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,[
                'label'=> 'First Name',
                'attr' => ['class' => 'form-control','placeholder'=> 'Enter your First Name',
                            'minlength' => 3],
            ])
            
            ->add('lastname', TextType::class,[
                'label'=> 'Last Name',
                'attr' => ['class' => 'form-control','placeholder'=> 'Enter your Last Name',
                            'minlength' => 3],
                
            ])
            ->add('email', EmailType::class,[
                'label'=> 'Email',
                'attr' => ['class' => 'form-control','placeholder'=> 'Enter Email'],

            ])
            // ->add('password', PasswordType::class,[
            //     'label'=> 'Password',
            //     'attr' => ['class' => 'form-control','placeholder'=> 'Enter Password',
            //                 'minlength' => 3],
                
            // ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field','placeholder'=> 'Enter Password','minlength' => 3]],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add('gender', ChoiceType::class, [
                'choices'  => [
                    'select' => null,
                    'male' => 'male',
                    'female' => 'female',
                    'other' => 'other',
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('usertype', ChoiceType::class, [
                'choices'  => [
                    'select' => null,
                    'user' => true,
                    // 'admin' =>'0',    
                ],
                'attr' => ['class' => 'form-control'],
            ])
            
            ->add('register', SubmitType::class,[
                'attr' => ['class' => 'btn btn-md btn-success']
            ]);
            
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}