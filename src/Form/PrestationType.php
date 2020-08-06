<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Prestation;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
      {
        $builder
            ->add('categorie', EntityType::class, array(
                'class' => Categorie::class,
                'choice_label' => 'name',
                'required' => true,
                'label' => 'Catégorie',
                'attr' => [
                    'class' => 'form-control',
                ],
                'error_bubbling' => true
            ))
            ->add('name', TextType::class, array(
                'required' => true,
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Nom de la Prestation",
                ],
                'error_bubbling' => true
            ))
            ->add('price', TextType::class, array(
                'required' => true,
                'label' => 'Prix',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Prix de la Prestation",
                ],
                'error_bubbling' => true
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prestation::class,
        ]);
    }
}
