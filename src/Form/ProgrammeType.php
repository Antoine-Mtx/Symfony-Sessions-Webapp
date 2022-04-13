<?php

namespace App\Form;

use App\Entity\Programme;
use App\Entity\ModuleFormation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbJours', NumberType::class, [
                'label' => 'durée (jours)',
                'attr' => ['min' => '1/2', 'max' => '15']
            ])
            ->add('session', HiddenType::class)
            ->add('moduleFormation', EntityType::class, [
                'label' => 'module',
                'class' => ModuleFormation::class,
                'choice_label' => 'intitule'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
