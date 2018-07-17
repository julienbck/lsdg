<?php

namespace ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use FOS\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class PostType extends AbstractType
{
  /**
   * @param FormBuilderInterface $builder
   * @param array                $options
   */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('content',  CKEditorType::class,  ['label' => false])
        ->add('save',     SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ForumBundle\Entity\Post'
        ));
    }
    /**
         * @param OptionsResolver $resolver
         */
    public function getBlockPrefix()
    {
        return 'forumbundle_post';
    }


}
