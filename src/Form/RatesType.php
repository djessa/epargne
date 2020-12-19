<?php

namespace App\Form;

use App\Entity\Rates;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatesType extends AbstractType
{
    public $month = ['Janvier' =>'January', 'Février' =>'February', 'Mars' =>'March', 'Avril' =>'April', 'Mai' =>'Mey', 'Juin' =>'June', 'Juillet' =>'July', 'Août' =>'August', 'Septembre' =>'September', 'Octobre' =>'October', 'Novembre' =>'November', 'Décembre' =>'December'];
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year', null, ['label' => 'Année'])
            ->add('month', ChoiceType::class, ['label'=>'Mois', 'choices'=>$this->month])
            ->add('value_of_one', null, ['label' => 'Taux pour un an (en %)'])
            ->add('value_of_two', null, ['label' => 'Taux pour deux ans (en %)'])
            ->add('value_of_three', null, ['label' => 'Taux pour trois ans (en %)'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rates::class,
        ]);
    }
}
