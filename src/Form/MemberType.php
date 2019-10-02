<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    private function getConfig($label, $placeholder){
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, $this->getConfig(" ", "Prénom"))
            ->add('firstName',TextType::class, $this->getConfig(" ", "Nom"))
            ->add('pseudo',TextType::class, $this->getConfig(" ", "Pseudo"))
            ->add('sex')
            ->add('levelDive')
            ->add('instructor')
            ->add('birthdayDate')
            ->add('mail')
            ->add('address')
            ->add('cp')
            ->add('city')
            ->add('phone1')
            ->add('phone2')
            ->add('numLicense')
            ->add('boatLicense')
            ->add('password')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
