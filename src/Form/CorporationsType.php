<?php

namespace App\Form;

use App\Entity\Corporations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CorporationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('social_reason', null, ['label' => 'Raison sociale', 'attr' => ['placeholder' => 'Entrer le raison sociale ']])
            ->add('address', null, ['label' => 'Adresse exacte', 'attr' => ['placeholder' => 'Entrer l\'adresse exacte']])
            ->add('piece_person_file', FileType::class, ['label' => 'Pièce du personne responsable']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Corporations::class,
        ]);
    }
}
