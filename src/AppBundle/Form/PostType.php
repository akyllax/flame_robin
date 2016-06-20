<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\CallbackTransformer;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('postImages', FileType::class, array('label' => 'Post Image', 'multiple' => true, 'data_class' => 'Doctrine\Common\Collections\ArrayCollection', 'required' => false))

        ;
        // $builder->get('postImages')
        //     ->addModelTransformer(new CallbackTransformer(
        //         function ($postImagesAsArray){
        //           return implode(',', $postImagesAsArray);
        //         },
        //         function ($postImagesAsString){
        //           var_dump($postImagesAsString);die;
        //         }
        //     ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }
}
