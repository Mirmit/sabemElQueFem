<?php

namespace App\Admin;

use App\Entity\Project;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class FeeAdmin extends AbstractAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_ORDER] = 'DESC';
        $sortValues[DatagridInterface::SORT_BY] = 'endDate';
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add(
                'project',
                EntityType::class,
                ['class' => Project::class]
            )
            ->add(
                'name',
                TextareaType::class,
                [
                    'required' => false,
                    'attr' => [
                        'style' => 'resize: vertical',
                        'rows' => 2,
                    ]
                ]
            )
            ->add(
                'renewalPeriod',
                TextareaType::class,
                [
                    'required' => false,
                    'attr' => [
                        'style' => 'resize: vertical',
                        'rows' => 2,
                    ]
                ]
            )
            ->add(
                'amount',
                NumberType::class,
                [
                    'label' => 'Import',
                    'required' => true,
                ]
            )
            ->add(
                'endDate',
                DateType::class,
                [
                    'label' => 'Data fi',
                    'widget' => 'single_text',
                    'required' => true,
                ]
            )
            ->add(
                'invoiced',
                CheckboxType::class,
                [
                    'required' => false
                ]
            )
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('project')
            ->add('name')
            ->add('renewalPeriod')
            ->add('amount')
            ->add('endDate')
            ->add('invoiced')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('project')
            ->addIdentifier('name')
            ->add('renewalPeriod')
            ->add('amount')
            ->add(
                'endDate',
                'date',
                [
                    'format' => 'd/m/Y'
                ]
            )
            ->add('invoiced')
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
