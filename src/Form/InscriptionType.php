<?php

namespace App\Form;


use App\Entity\Inscription;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateInscription', DateType::class, [ 'widget'=>'single_text','format' => 'yyyy-MM-dd' , "attr" => ["class" => "form-select"] ])
            ->add('eleve', EntityType::class, [
                'class' => 'App\Entity\Eleve',
                'choice_label' => 'nom',
                "attr" => ["class" => "form-select"],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.nom', 'ASC');
                },
            ])
            ->add('cours', EntityType::class, [
                'class' => 'App\Entity\Cours',
                'choice_label' => 'libelle',
                "attr" => ["class" => "form-select"],
                //'multiple' => true,
                /*
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.prenom', 'ASC');
                },
                */
            ])
            ->add('enregistrer', SubmitType::class, ['label' => 'Nouvelle Inscription ', "attr" => ["class" => "btn btn-primary"]]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
