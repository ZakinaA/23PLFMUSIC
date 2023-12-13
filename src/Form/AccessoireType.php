<?php

namespace App\Form;

use App\Entity\Instrument;
use App\Entity\Marque;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccessoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Libelle', TextType::class , ["attr" => ["class" => "form-control"]])
            ->add('Instrument', EntityType::class, [
                'class' => Instrument::class,
                "attr" => ["class" => "form-select"],
                'choice_label' => 'nom'
            ])

            ->add('enregistrer', SubmitType::class, array('label' => 'Nouvel accessoire', "attr" => ["class" => "btn btn-primary"]))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
