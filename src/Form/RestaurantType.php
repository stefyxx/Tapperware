<?php

namespace App\Form;

use App\Entity\Restaurant;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Ville')
            ->add('Rue')
            ->add('Numero')
            ->add('Zip')
            ->add('Numero_TVA')
            ->add('Site_Web')
            ->add('isActive')
            ->add('Image')
            //User lo aggungo nel controller
            /*->add('User', EntityType::class,
            [
                'class' => User::class,
                'choice_label' => 'Nom'
            ])*/

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
