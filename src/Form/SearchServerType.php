<?php

namespace App\Form;

use App\Entity\SearchServer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchServerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('isVm')
            ->add('memMin', null, [
                    'required'   => false,
                    'empty_data' => null,
                    'label' => 'Ram >',
                    ])
            ->add('memMax', null, [
                'required'   => false,
                    'empty_data' => null,
                    ])
            ->add('cpuMin')
            ->add('cpuMax')
            ->add('hddMin')
            ->add('hddMax')
            ->add('onOff')
            ->add('ipAddr')
            ->add('memo')
            ->add('clusterId')
            ->add('osId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchServer::class,
        ]);
    }
}
