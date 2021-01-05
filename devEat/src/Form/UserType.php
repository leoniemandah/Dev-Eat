<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password', PasswordType::class)
            ->add('FirstName')
            ->add('Confirm_password',PasswordType::class)
            ->add('LastName')
            ->add('solde')
            ->add('Address')
            ->add('roles',ChoiceType::class,
            array('choices' => array(
                    'Utilisateur' => 'ROLE_USER',
                    'Restaurateur' => 'ROLE_RESTAURANT',
                    'admin' => 'ROLE_ADMIN'),
                    'multiple'=>true,
                    'expanded'=>true,
                    'label' => 'Qui êtes vous ?'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
