<?php

namespace App\Form;

use App\Entity\Releves;
// RelevesType.php

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelevesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ... Autres champs ...
            ->add('date', DateType::class, [
                'label' => 'Date du relevé',
            ])
            ->add('lieu_id', EntityType::class, [
                'class' => 'App\Entity\Lieu',
                'choice_label' => 'commune',
                'label' => 'Lieu du relevé',
            ])
            // ... Autres champs ...
            ->add('releve_brut');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Releves::class,
        ]);
    }
}
