<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\PrototypeProduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrototypeProduitType extends AbstractType
{
    //NBBB: per inserire AUTOMATICAMENTE il select delle Category, 
    //vedere ->add('Category'... P.S: importare ref di EntityType
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom_produit')
            ->add('PrixLocationUnitaire')
            ->add('Taille_Capacite')
            ->add('Description')
            ->add('Stock')
            ->add('Image')
            ->add('Category',EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => 'Label'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PrototypeProduit::class,
        ]);
    }
}
