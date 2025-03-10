<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fase', ChoiceType::class, [
                'choices' => [
                    'First Bachelor' => 1,
                    'Second Bachelor' => 2,
                    'Third Bachelor' => 3,
                ],
            ])
            ->add('email', EmailType::class)
            ->add('next', SubmitType::class, ['label' => 'Next...']);
    }
}

//public function buildForm(FormBuilderInterface $builder, array $options): void
//{
//    $builder
//        ->add('fase', ChoiceType::class, [
//            'label' => 'Fase:',
//            'choices' => [
//                'First Bachelor' => 1,
//                'Second Bachelor' => 2,
//                'Third Bachelor' => 3,
//            ],
//            'expanded' => false, // Dropdown
//            'multiple' => false
//        ])
//        ->add('email', EmailType::class, [
//            'label' => 'Email:',
//            'required' => true,
//        ])
//        ->add('books', EntityType::class, [
//            'class' => Book::class, // Assuming you have a Book entity
//            'choice_label' => 'title', // Show the title in checkboxes
//            'multiple' => true,
//            'expanded' => true, // Display as checkboxes
//        ])
//        ->add('submit', SubmitType::class, [
//            'label' => 'Next...',
//        ]);
//}
//
//public function configureOptions(OptionsResolver $resolver): void
//{
//    $resolver->setDefaults([
//        'data_class' => null, // No specific entity, using form data array
//    ]);
//}