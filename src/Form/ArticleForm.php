<?php 

namespace App\Form;

use App\Document\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artName', TextType::class,[
                'label'=> 'Article Name',
                'attr' => ['class' => 'form-control','placeholder'=> 'Enter Article Name',
                            'minlength' => 3],
            ])
            
            ->add('artDescription', TextareaType::class,[
                'label'=> 'Article Description',
                'attr' => ['class' => 'form-control','placeholder'=> 'Enter description',
                            'minlength' => 10],
                
            ])
            ->add('artImage', FileType::class, 
                // array('data_class' => null),
                [
                'label'=> 'Add Image',
                'mapped' => false,
                // 'data' => $Article->getArtImage(),
                'required' => false,
               
            ])
            ->add('publish', ChoiceType::class,[
                'choices'  => [
                    'select' => null,
                    'Yes' => 'Yes',
                    'No' => 'No',
                ],
                'attr' => ['class' => 'form-control'],
                
            ])
            ->add('createdBy', TextType::class,[
                'label'=> 'Created_by',
                'attr' => ['class' => 'form-control',
                            'minlength' => 3],
            ])
            ->add('updatedBy', TextType::class,[
                'label'=> 'Updated_by',
                'attr' => ['class' => 'form-control',
                            'minlength' => 3],
            ])

            ->add('submit', SubmitType::class,[
                'attr' => ['class' => 'btn btn-md btn-success']
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}