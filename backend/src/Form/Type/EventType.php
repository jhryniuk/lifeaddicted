<?php

namespace App\Form\Type;

use App\Entity\Event;
use App\Entity\Participant;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('eventDate', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('owner', EntityType::class,
                [
                    'class' => User::class,
                    'mapped' => false,
                    'multiple' => false
                ])
            ->add('participants', EntityType::class,
                [
                    'class' => Participant::class,
                    'mapped' => false,
                    'multiple' => true,
                ])
            ->add('submit', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'error_bubbling' => false,
        ]);
    }
}