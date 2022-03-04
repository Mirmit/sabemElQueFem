<?php

namespace App\Admin;

use App\Entity\Project;
use App\Entity\User;
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
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class TimeRegisterAdmin extends AbstractAdmin
{
    private TokenStorageInterface $tokenStorage;

    /**
     * Methods.
     */
    public function __construct($code, $class ,$baseControllerName, TokenStorageInterface $tokenStorage)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->tokenStorage = $tokenStorage;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_ORDER] = 'DESC';
        $sortValues[DatagridInterface::SORT_BY] = 'date';
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('Informació general', ['class' => 'col-md-4'])
            ->add(
                'user',
                EntityType::class,
                [
                    'class' => User::class,
                    'data' => $this->tokenStorage->getToken()->getUser()
                ]
            )
            ->add(
                'project',
                EntityType::class,
                ['class' => Project::class]
            )
            ->add(
                'comments',
                TextareaType::class,
                [
                    'required' => false,
                    'attr' => [
                        'style' => 'resize: vertical',
                        'rows' => 3,
                    ]
                ]
            )
            ->add(
                'invoiceable',
                CheckboxType::class,
                [
                    'required' => false
                ]
            )
            ->end()
            ->with('Temps', ['class' => 'col-md-4'])
            ->add(
                'date',
                DateType::class,
                [
                    'label' => 'Data',
                    'widget' => 'single_text',
                    'required' => true,
                ]
            )
            ->add(
                'start',
                TimeType::class,
                [
                    'label' => 'Inici',
                    'input'  => 'datetime',
                    'widget' => 'single_text',
                    'required' => true,
                ]
            )
            ->add(
                'finish',
                TimeType::class,
                [
                    'label' => 'Fi',
                    'input'  => 'datetime',
                    'widget' => 'single_text',
                    'required' => false,
                ]
            )
            ->add(
                'totalHours',
                NumberType::class,
                [
                    'label' => 'Hores totals',
                    'required' => true,
                ]
            )
            ->end()
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
            ->add('user')
            ->add('project')
            ->add(
                'date',
                'date',
                [
                    'format' => 'd/m/Y'
                ]
            )
            ->add(
                'start',
                'time',
                [
                    'format' => 'H:i'
                ]
            )
            ->add(
                'finish',
                'time',
                [
                    'format' => 'H:i'
                ]
            )
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
