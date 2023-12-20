<?php

namespace App\Form;

use App\Entity\Couleur;
use App\Entity\Instrument;
use App\Entity\Marque;
use App\Entity\TypeInstrument;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class InstrumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NumSerie', TextType::class , ["attr" => ["class" => "form-control"]])
            ->add('Nom', TextType::class , ["attr" => ["class" => "form-control"]])
            ->add('dateAchat', DateType::class, [
                'widget' => 'single_text',
                "attr" => ["class" => "form-control"],
                'format' => 'yyyy-MM-dd',
                'constraints' => [new Assert\LessThanOrEqual('today'),]])

            ->add('prixAchat', TextType::class , ["attr" => ["class" => "form-control"]])

            ->add('typeInstrument', EntityType::class, [
                'class' => TypeInstrument::class,
                "attr" => ["class" => "form-select"],
                'choice_label' => 'libelle'

            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                "attr" => ["class" => "form-select"],
                'choice_label' => 'libelle'
            ])

            ->add('Utilisation', TextType::class , ["attr" => ["class" => "form-control"]])

            ->add('couleur', EntityType::class, [
                'class' => Couleur::class,
                "attr" => ["class" => "form-select"],
                'choice_label' => 'nom',
                'multiple' => true,
            ])
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouvel Instrument', "attr" => ["class" => "btn btn-primary"]))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}
