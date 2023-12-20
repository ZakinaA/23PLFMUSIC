<?php

namespace App\Form;

use App\Entity\Eleve;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;

class EleveModifierType extends AbstractType
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
            ->add('responsables', EntityType::class, [
                'class' => 'App\Entity\Responsable',
                'choice_label' => function ($responsable) {
                    return $responsable->getNom() . ' ' . $responsable->getPrenom();
                },
                "attr" => ["class" => "form-select"],
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.prenom', 'ASC');
                },
                'constraints' => [
                    new Count(['max' => 2, 'maxMessage' => 'Vous ne pouvez sélectionner que deux responsables.'])
                ]
            ]);
        $builder->add('enregistrer',SubmitType::class, array('label' => 'Nouveau Cours', "attr" => ["class" => "btn btn-primary"]));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
