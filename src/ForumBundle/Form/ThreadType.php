<?php

namespace ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ForumBundle\Entity\Post;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class ThreadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('title',      TextType::class)
          ->add(
                'post',
                CollectionType::class,
                [
                    'entry_type'     => PostType::class,
                    'allow_add'      => true,
                    'error_bubbling' => true,
                    'prototype' => true,
                ])
          ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ForumBundle\Entity\Thread'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'forumbundle_thread';
    }


}
