<?php

namespace App\Form;

use App\Entity\Intervention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut',DateType::class, [
        'widget' => 'single_text',
        'format' => 'yyyy-MM-dd',
        ])
            ->add('dateFin',DateType::class, [
        'widget' => 'single_text',
        'format' => 'yyyy-MM-dd',
    ])
            ->add('descriptif', TextType::class)
            ->add('prix',TextType::class)
            ->add('professionnel',EntityType::class, array('class' => 'App\Entity\professionnel','choice_label' => 'nom' ))
            ->add('instrument',EntityType::class, array('class' => 'App\Entity\instrument','choice_label' => 'numSerie' ))
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouvelle intervention'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
