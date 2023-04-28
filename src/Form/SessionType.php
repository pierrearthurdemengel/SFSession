<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateFin', DateType::class,[
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('nombrePlaces', IntegerType::class, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('Intitule', TextType::class, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('stagiaire', EntityType::class, [
                'attr' => ['class' => 'form-control'],
                'class' => Stagiaire::class
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class
        ]);
    }
}