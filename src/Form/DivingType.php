<?php

namespace App\Form;

use App\Entity\Diving;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DivingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location')
            ->add('date',DateType::class, [
                                    'widget' => 'single_text',
                                    'format' => 'yyyy-MM-dd'
                                ])
            ->add('description')
            ->add('places')
            ->add('levelMin',ChoiceType::class, [
                            'choices' => [
                                'Debutant'=> 'Debutant',
                                'N1' => 'N1',
                                'N2' => 'N2',
                                'N3' => 'N3',
                                'N4' => 'N4'
                            ],  'expanded' => true,
                            'multiple' => false]);                           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Diving::class,
        ]);
    }
}
