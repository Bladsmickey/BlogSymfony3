<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('name', TextType::class, array("label" => "Nombre", "required" => "required", "attr" => array("class" => "form-control")))
			->add('description', TextAreaType::class, array("label" => "Descripcion", "required" => "required", "attr" => array("class" => "form-control")))
			->add('submit', SubmitType::class, array("attr" => array("class" => "btn btn-success")))
		;
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'BlogBundle\Entity\Tag',
		));
	}
}
