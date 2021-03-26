<?php 

namespace App\Form;

use App\Document\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('authorname', TextType::class,[
                'label'=> 'Author Name',
                'attr' => ['class' => 'form-control','placeholder'=> 'Enter your First Name',
                            'minlength' => 3],
            ])
            
            ->add('comment', TextType::class,[
                'label'=> 'Comment',
                'attr' => ['class' => 'form-control','placeholder'=> 'Enter your Last Name',
                            'minlength' => 3],
                
            ])
            // ->add('articleid',TextType::class,[
            //     // 'label'=> 'articleid',
            //     'attr' => ['class' => 'form-control','value' =>''],
            //     'attr' => array('style'=>'display:none;'),
            // ])
            
            ->add('submit', SubmitType::class,[
                'attr' => ['class' => 'btn btn-md btn-primary']
            ]);
            
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}