<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('regulator',CheckboxType::class, [
                'label'    => "J'ai besoin d'un détendeur ",
                'required' => false])
            ->add('wetSuit',CheckboxType::class, [
                'label'    => "J'ai besoin d'une combinaison ",
                'required' => false])
            ->add('sizeSuit',ChoiceType::class, [
                'choices' => [
                    'S' => 'S',
                    'M' => 'M',
                    'L' => 'L',
                    'XL' => 'XL',
                    'XXL' => 'XXL',
                ],  'expanded' => true,
                'multiple' => false,
                'required'   => false,
                'placeholder' => false,
                'label_attr'=>[
                    'class'=>'radio-inline'
                ] ])
            ->add('needCar',CheckboxType::class, [
                'label'    => "J'ai besoin d'un transport",
                'required' => false])
            ->add('driverCar',CheckboxType::class, [
                'label'    => "Je peux emmener des personnes",
                'required' => false])
            ->add('placeCar',ChoiceType::class, [
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                ],  'expanded' => true,
                'multiple' => false,
                'required'   => false,
                'placeholder' => false,
                'label_attr'=>[
                    'class'=>'radio-inline'
                ] ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
