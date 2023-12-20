<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;


class CoursModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class , ["attr" => ["class" => "form-control"]])
            ->add('ageMini', NumberType::class , ["attr" => ["class" => "form-control"]])
            ->add('heureDebut', TimeType::class , ["attr" => ["class" => "form-select"]] )
            ->add('heureFin' , TimeType::class , ["attr" => ["class" => "form-select"]])
            ->add('nbPlaces', NumberType::class , ["attr" => ["class" => "form-control"]])
            ->add('ageMaxi', NumberType::class , ["attr" => ["class" => "form-control"]])
            ->add('jour',EntityType::class, array('class' => 'App\Entity\Jour','choice_label'=>'libelle', "attr" => ["class" => "form-select"]))
            ->add('typeCours',EntityType::class, array('class' => 'App\Entity\TypeCours','choice_label'=>'libelle', "attr" => ["class" => "form-select"], 'constraints'=>[new Assert\Callback(['callback'=>[$this,'validateNbPlaceAndTypeCours']])]))
            ->add('typeInstrument',EntityType::class, array('class' => 'App\Entity\TypeInstrument','choice_label'=>'libelle', "attr" => ["class" => "form-select"]))
            ->add('professeur',EntityType::class, array('class' => 'App\Entity\Professeur','choice_label'=>'prenom', "attr" => ["class" => "form-select"]))

            ->add('enregistrer', SubmitType::class, array('label' => 'Modification Cours', "attr" => ["class" => "btn btn-primary"]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }

    public function validateNbPlaceAndTypeCours($value, ExecutionContextInterface $context)
    {
        $NbPlaces = $context->getRoot()->get('nbPlaces')->getData();
        $typeCours = $value;

        if ($typeCours !==null){
            if($NbPlaces == 1 && $typeCours->getLibelle() !== 'Cours Individuel'){
                $context->buildViolation('si le nombre  de place est de 1 le type de cours doit être individuel.')
                    ->atPath('typeCours')
                    ->addViolation();
            }
            if ($NbPlaces > 1 && $typeCours->getLibelle() !== 'Cours Colletif'){
                $context->buildViolation('si le nombre de place est supérieur à 1 le type de cours doit être collectif')
                    ->atPath('typeCours')
                    ->addViolation();
            }
        }
    }
}
