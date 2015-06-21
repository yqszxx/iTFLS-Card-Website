<?php
/**
 * This file (CardAdmin.php) is belong to project "iTFLS".
 * Author: yqszxx
 * Created At: 15-6-19-下午9:13
 */

namespace iTFLS\Card\ApiBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CardAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('cardSN', 'text', array('label' => 'Card Hex SN'))
            ->add('isActive', 'checkbox')
            ->add('balance', 'number')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('isActive')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('cardSN')
            ->add('isActive')
            ->add('balance')
        ;
    }
}