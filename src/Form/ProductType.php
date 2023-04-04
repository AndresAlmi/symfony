<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use  Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder->add('name', TextType::class, [
            'attr'=>[
                'class' => 'form-control'
            ]
        ]);

        $builder->add('code', TextType::class, []);

        $builder->add('category', ProductCategoryType::class,[]);

        if($options['categorys'] != false){
            $builder->add('category', EntityType::class,[
                'class' => \App\Entity\ProductCategory::class
            ]);
        }
        $builder->add('guardar', SubmitType::class, [
            
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'categorys' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'product';
    }
}
