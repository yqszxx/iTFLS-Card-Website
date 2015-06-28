<?php

namespace iTFLS\Card\ApiBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'money')
            ->add('card_sn', 'text')
            ->add('endpoint_sn', 'money');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'iTFLS\Card\ApiBundle\Entity\Transaction'
        ));
    }

    public function getName()
    {
        return 'transaction';
    }
}