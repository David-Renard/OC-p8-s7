<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Adresse email',
                    'attr'  => ['class' => 'form-control'],
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type'            => PasswordType::class,
                    'attr'            => ['autocomplete' => 'new-password',],
                    'first_options'   => [
                        'label' => 'Mot de passe',
                        'attr'  => ['class' => 'form-control'],
                        ],
                    'second_options'  =>
                        [
                            'label' => 'Tapez à nouveau le mot de passe',
                            'attr'  => ['class' => 'form-control'],
                        ],
                    'invalid_message' => "La confirmation du mot de passe ne correspond pas.",
                ]
            )
            ->add(
                'username',
                TextType::class,
                [
                    'label' => "Nom d'utilisateur",
                    'attr'  => ['class' => 'form-control'],
                ]
            )
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class,]);

    }
}
