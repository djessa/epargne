<?php

namespace App\Form;

use App\Entity\Persons;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nom et prénom', 'attr' => ['placeholder' => 'Entrer le nom et le prénom']])
            ->add('nationality', null, ['label' => "Nationalité", 'attr' => ['placeholder' => 'Entrer la nationalité']])
            ->add('identity', null, ['label' => 'Numéro d\'identité', 'attr' => ['placeholder' => 'Entrer le numéro d\'identité']])
            ->add('cin_recto_file', FileType::class, ['label' => 'CIN recto'])
            ->add('cin_verso_file', FileType::class, ['label' => 'CIN verso'])
            ->add('address', null, ['label' => 'Adresse exacte', 'attr' => ['placeholder' => 'Entrer l\'adresse exacte']])
            ->add('certificat_file', FileType::class, ['label' => 'Certificat'])
            ->add('tel', TelType::class, ['label' => 'Téléphone', 'attr' => ['placeholder' => 'Entrer le numéro téléphone']])
            ->add('email', EmailType::class, ['label' => 'Email', 'attr' => ['placeholder' => 'Entrer l\'adresse email']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Persons::class,
        ]);
    }
}
