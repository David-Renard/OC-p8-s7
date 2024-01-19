<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre',
                    'attr'  => ['class' => 'form-control border border-primary-subtle'],
                    'label_attr' => ['class' => 'mb-2'],
                ]
            )
            ->add(
                'content',
                TextareaType::class,
                [
                    'label'    => 'Description',
                    'attr'     =>
                        [
                            'class' => 'form-control border border-primary-subtle',
                            'rows'   => 4,
                        ],
                    'required' => false,
                    'label_attr' => ['class' => 'mb-2'],
                ]
            )
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Task::class,]);

    }
}
