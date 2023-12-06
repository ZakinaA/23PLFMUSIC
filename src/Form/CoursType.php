<?php

namespace App\Form;

use App\Entity\Cours;
use Doctrine\DBAL\Types\TimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('ageMini')
            ->add('heureDebut')
            ->add('heureFin')
            ->add('nbPlaces')
            ->add('ageMaxi')
            ->add('jour',EntityType::class, array('class' => 'App\Entity\Jour','choice_label'=>'libelle'))
            ->add('typeCours',EntityType::class, array('class' => 'App\Entity\TypeCours','choice_label'=>'libelle'))
            ->add('typeInstrument',EntityType::class, array('class' => 'App\Entity\TypeInstrument','choice_label'=>'libelle'))
            ->add('professeur',EntityType::class, array('class' => 'App\Entity\Professeur','choice_label'=>'prenom'))

            ->add('enregistrer', SubmitType::class, array('label' => 'Nouveau Cours'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
