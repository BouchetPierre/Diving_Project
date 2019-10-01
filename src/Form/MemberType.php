<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('firstName')
            ->add('userName')
            ->add('sex')
            ->add('levelDive')
            ->add('instructor')
            ->add('birthdayDate')
            ->add('mail')
            ->add('adress')
            ->add('cp')
            ->add('city')
            ->add('phone1')
            ->add('phone2')
            ->add('numLicense')
            ->add('boatLicense')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
