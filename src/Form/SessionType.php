<?php

namespace App\Form;

use App\Entity\Module;


use App\Entity\Session;
use App\Entity\Categorie;
use App\Entity\Formateur;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', TextType::class, [
                'attr' => ['class' => 'form-control']
                ])
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
            ->add('formateur', EntityType::class, [
                'class' => Formateur::class,
                'attr' => ['class' => 'form-control']
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'attr' => ['class' => 'form-control'],
                
                // ????? //
                'mapped' => false
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'form-control']
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