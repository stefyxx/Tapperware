<?php

namespace App\Form;

use App\Entity\DetailProduitLocation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailProduitLocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date_debut')
            ->add('Date_fin_teorique')
            ->add('QuantiteTotal')
            ->add('QuantiteResteRendre')
            ->add('Montant')
            ->add('Montant_par_unite')
            ->add('Panier')
            ->add('PrototypeProduit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetailProduitLocation::class,
        ]);
    }
}
