<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FormCreate extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options)
		{
			$builder
				->add('name', TextType::class)
				->add('year', TextType::class)
				->add('author', TextType::class)
			;
		}
}
?>