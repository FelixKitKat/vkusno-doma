<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class, [
                'label' => 'Ваше имя',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Ваш отзыв',
            ])
            ->add('rating', ChoiceType::class, [
                'label' => 'Оценка',
                'choices' => [
                    '5 — Отлично' => 5,
                    '4 — Хорошо' => 4,
                    '3 — Нормально' => 3,
                    '2 — Плохо' => 2,
                    '1 — Очень плохо' => 1,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}