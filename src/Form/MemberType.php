<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

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
            ->add('sex', ChoiceType::class, [
                                            'choices' => [
                                                'Homme' => 'Homme',
                                                'Femme' => 'Femme'
                                            ],  'expanded' => true,
                                                'multiple' => false])

            ->add('levelDive',ChoiceType::class, [
                                            'choices' => [
                                                'Debutant'=> 'Debutant',
                                                'N1' => 'N1',
                                                'N2' => 'N2',
                                                'N3' => 'N3',
                                                'N4' => 'N4'
                                            ],  'expanded' => true,
                                                'multiple' => false])

            ->add('instructor',ChoiceType::class, [
                                            'choices' => [
                                                'E1' => 'E1',
                                                'E2' => 'E2',
                                                'MF1' => 'MF1',
                                                'MF2' => 'MF2',
                                                'DP' => 'DP'
                                            ],  'expanded' => true,
                                                'multiple' => false,
                                                'required'   => false,
                                                'placeholder' => false
                                                ])

            ->add('birthdayDate', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
                            ])
            ->add('mail',TextType::class, $this->getConfig(" ", "Adresse E-mail"))
            ->add('address', TextType::class, $this->getConfig(" ", "Adresse postale"))
            ->add('cp')
            ->add('city',TextType::class, $this->getConfig(" ", "Ville"))
            ->add('phone1',TextType::class, $this->getConfig(" ", "N° de téléphone"))
            ->add('phone2',TextType::class, $this->getConfig(" ", "N° de téléphone URGENCE"))
            ->add('numLicense')
            ->add('boatLicense',CheckboxType::class, [
                'label'    => 'Permis bateau',
                'required' => false])
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
