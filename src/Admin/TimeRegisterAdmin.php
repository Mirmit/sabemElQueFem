<?php

namespace App\Admin;

use App\Entity\Project;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\NumberType;
use Sonata\Form\Type\DatePickerType;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class TimeRegisterAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('project', EntityType::class, ['class' => Project::class])
            ->add('date', DatePickerType::class)
            ->add('start', DateTimePickerType::class)
            ->add('finish', DateTimePickerType::class)
            ->add('totalHours', NumberType::class)
            ->add('comments', TextType::class)
            ->add('invoiceable', CheckboxType::class)
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('project')
            ->add('date')
            ->add('start')
            ->add('finish')
            ->add('totalHours')
            ->add('comments')
            ->add('invoiceable')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('project')
            ->add('date')
            ->add('start')
            ->add('finish')
            ->add('totalHours')
            ->add('comments')
            ->add('invoiceable')
            ->add(
                '_action',
                'actions',
                [
                    'label' => 'Accions',
                    'actions' => [
                        'edit' => []
                    ],
                ]
            )
        ;
    }
}
