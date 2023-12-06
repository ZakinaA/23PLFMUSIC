<?php

namespace App\Form;

use App\Entity\ContratPret;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratPretModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut')
            ->add('dateFin')
            ->add('attestationAssurance')
            ->add('etatDetailleDebut')
            ->add('etatDetailleRetour')
            ->add('instrument',EntityType::class, [
        'class' => 'App\Entity\Instrument',
        'choice_label' => function ($instrument) {
            return $instrument->getNumSerie();   }
    ])
            ->add('eleve',EntityType::class, [
        'class' => 'App\Entity\Eleve',
        'choice_label' => function ($eleve) {
            return $eleve->getNom();   }
    ])
            ->add('enregistrer', SubmitType::class, array('label' => 'enregistrer les modifications'));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContratPret::class,
        ]);
    }
}
