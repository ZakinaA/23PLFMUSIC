<?php
// src/Form/EleveType.php
namespace App\Form;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Repository\DepartementRepository;
use App\Repository\TypeInstrumentRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EleveType extends AbstractType
{
    private $typeInstrumentRepository;

    public function __construct(TypeInstrumentRepository $typeInstrumentRepository)
    {
        $this->typeInstrumentRepository = $typeInstrumentRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('numRue')
            ->add('copos')
            ->add('ville')
            ->add('tel')
            ->add('mail')
            ->add('rue')
            ->add('responsables', EntityType::class, [
                'class' => 'App\Entity\Responsable',
                'choice_label' => function ($responsable) {
                    return $responsable->getNom() . ' ' . $responsable->getPrenom();
                },
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.prenom', 'ASC');
                },
                'constraints' => [
                    new Count(['max' => 2, 'maxMessage' => 'Vous ne pouvez sélectionner que deux responsables.'])
                ]
            ]);
        /*
        ->add('typeInstrument', EntityType::class, [
            'class' => 'App\Entity\TypeInstrument',
            'choice_label' => 'libelle',
            'required' => false,
            'placeholder' => 'Choisir un instrument',
            'mapped' => false,
            'query_builder' => fn (TypeInstrumentRepository $typeInstrumentRepository) =>
            $typeInstrumentRepository->findByOrderedByLibelleQueryBuilder()
        ]);

    $formModifier = function (FormInterface $form, Cours $cours = null) {
        $typeinstrument = $cours === null ? [] : $this->CoursRepository->findByInstrumentOrderedByNom($cours);
        $form->add('Cours', EntityType::class, [
            'class' => Cours::class,
            'choice_label' => 'libelle',
            'required' => false,
            'disabled' => $cours === null,
            'placeholder' => 'Choisir un cours',
            'choices' => $typeinstrument
        ]);
    };

    $builder->addEventListener(
        FormEvents::PRE_SET_DATA,
        function (FormEvent $event) use ($formModifier) {
            $data = $event->getData();

            $formModifier($event->getForm(), $data->getTypeInstrument());
        }
    );

    $builder->get('typeInstrument')->addEventListener(
        FormEvents::POST_SUBMIT,
        function (FormEvent $event) use ($formModifier) {
            $typeinstrument = $event->getForm()->getData();

            $formModifier($event->getForm()->getParent(), $typeinstrument);
        }

    );
*/
    $builder->add('enregistrer', SubmitType::class, ['label' => 'Nouveau Eleve']);
}



        function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Eleve::class,
            ]);
        }

}
