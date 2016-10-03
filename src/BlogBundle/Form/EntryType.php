<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EntryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                "label" => "Titulo",
                "required"=>"required", 
                "attr" => array("class" => "form-control",)))
            ->add('content', TextAreaType::class, array(
                "label" => "Contenido",
                "required"=>"required", 
                "attr" => array("class" => "form-control",)))
            ->add('status', ChoiceType::class, array(
                "label" => "Estados: ",
                "choices" => array(
                    "public" => "Publico",
                    "private" => "Privado",
                    ),
                "attr" => array("class" => "form-control",))
                )
            ->add('image', FileType::class, array(
                "data_class" => null,
                "label" => "Imagen",
                "required"=>"required", 
                "attr" => array("class" => "form-control",)))
            /*->add('user')*/
            ->add('category', EntityType::class, array(
                "class" => "BlogBundle:Category",
                "label" => "Categoria",
                "required"=>"required", 
                "attr" => array("class" => "form-control",)))
            ->add('tags', TextType::class, array(
                "mapped" => false,
                "label" => "Tags",
                "required"=>"required", 
                "attr" => array("class" => "form-control",)))
            ->add('submit' , SubmitType::class, array("attr" => array("class" => "btn btn-success",)))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Entry'
        ));
    }
}
