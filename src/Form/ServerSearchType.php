<?php

namespace App\Form;

use App\Entity\Server;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ServerSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('mem')
/*
            ->add('mem', RangeType::class, [
                'empty_data' => 0,
                'attr' => [
                        'min' => 0,
                        'max' => 32,
                        'step' => 1
                         ]
            ])
*/
            ->add('os_id', null, [
                'required'   => false,
                    'empty_data' => null,
                    'placeholder' => 'Только данная ОС',
                    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Server::class,
        ]);
    }
}
