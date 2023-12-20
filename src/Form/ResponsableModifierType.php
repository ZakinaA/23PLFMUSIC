<?php

namespace App\Form;

use App\Entity\Responsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class , ["attr" => ["class" => "form-control"]])
            ->add('prenom', TextType::class , ["attr" => ["class" => "form-control"]])
            ->add('numRue', NumberType::class , ["attr" => ["class" => "form-control"]])
            ->add('rue', TextType::class , ["attr" => ["class" => "form-control"]])
            ->add('copos', NumberType::class , ["attr" => ["class" => "form-control"]])
            ->add('ville', TextType::class , ["attr" => ["class" => "form-control"]])
            ->add('tel', TextType::class , ["attr" => ["class" => "form-control"]])
            ->add('mail', TextType::class , ["attr" => ["class" => "form-control"]])
            // ->add('eleves')

            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier Responsable', "attr" => ["class" => "btn btn-primary"]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Responsable::class,
        ]);
    }
}
