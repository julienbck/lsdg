<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;



class ArticleEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
      {
        $builder
        ->add('title',        TextType::class)
        ->add('author',       TextType::class)
        ->add('content',  CKEditorType::class)
        ->add('published',    CheckboxType::class, array('required' => false))
        ->add('save',         SubmitType::class)
        ->add('categories', EntityType::class, array(
          'class'        =>'FrontBundle:Category',
          'choice_label' => 'name',
          'multiple'     => true,
          'expanded'     => true,
      ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontBundle\Entity\Article'
        ));
    }


}
