<?php

namespace App\Form;

use App\Entity\Funds;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FundsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', null, ['label'=>'Montant à deposer'])
            ->add('piece_obtaining_file', FileType::class, ['label'=>'Pièce d\'obtention'])
            ->add('duration', ChoiceType::class, ['label'=>'Durée', 'choices'=>["1 ans " =>1,"2 ans " => 2,"3 ans " =>3]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Funds::class,
        ]);
    }

}
