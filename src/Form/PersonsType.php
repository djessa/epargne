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
            ->add('name')
            ->add('nationality')
            ->add('identity')
            ->add('cin_recto_file', FileType::class)
            ->add('cin_verso_file', FileType::class)
            ->add('address')
            ->add('certificat_file', FileType::class)
            ->add('tel', TelType::class)
            ->add('email', EmailType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Persons::class,
        ]);
    }
}
