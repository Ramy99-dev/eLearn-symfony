<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Cours;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options  )
    {
        $category = new Category();
        $builder
            ->add('nom',TextType::class,['data_class' => null,'attr'=>['class'=>'form-control']])
            ->add('categorie',EntityType::class,[
                'class'=>Category::class,
                'label'=>' ',
                'choice_label'=>'categorie',
                'attr'=>['class'=>'form-control']
            ])
            ->add('img',FileType::class, ['required' => false ,'data_class' => null,'attr'=>['class'=>'form-control']])
            ->add('price',NumberType::class, ['required' => false ,'data_class' => null,'attr'=>['class'=>'form-control']])
            ->add('description',TextareaType::class,['required' => false ,'data_class' => null,'attr'=>['class'=>'form-control']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
