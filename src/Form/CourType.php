<?php

namespace App\Form;

use App\Entity\Cour;
use App\Entity\Professeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('fichier',FileType::class, array('data_class' => null,'required' => false))
            ->add('description')
            ->add('content')
            ->add('cours',EntityType::class,['class'=>Professeur::class,
                'choice_label'=>'fullname',
                'label'=>'Professeurs'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cour::class,
        ]);
    }
}
