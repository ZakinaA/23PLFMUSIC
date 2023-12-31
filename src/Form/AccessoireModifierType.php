<?php

namespace App\Form;

use App\Entity\Accessoire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccessoireModifierType extends AbstractType
{

    public function getParent(){
        return AccessoireType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier accessoire', "attr" => ["class" => "btn btn-primary"]));

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Accessoire::class,
        ]);
    }
}
