<?php

namespace App\Admin;

use App\Enum\UserRolesEnum;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserAdmin extends AbstractAdmin
{
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * Methods.
     */
    public function __construct($code, $class ,$baseControllerName, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->passwordHasher = $passwordHasher;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->remove('batch')
            ->remove('export')
            ->remove('show')
        ;
    }
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('username', TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Contrasenya'),
                'second_options' => array('label' => 'Confirma contrasenya'),
                'required' => false
            ))
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'label' => 'Rols',
                    'choices' => UserRolesEnum::getEnumArray(),
                    'multiple' => true,
                    'expanded' => true,
                ]
            )
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('username');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('username')
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

    public function prePersist($object) : void { // $object is an instance of App\Entity\User as specified in services.yaml
        $this->hashPassword($object);
    }

    public function preUpdate($object) : void { // $object is an instance of App\Entity\User as specified in services.yaml
        $this->hashPassword($object);
    }

    /**
     * @param $object
     * @return void
     */
    private function hashPassword($object): void
    {
        $plainPassword = $object->getPlainPassword();
        if ($plainPassword) {
            $pass = $this->passwordHasher->hashPassword($object, $plainPassword);
            $object->setPassword($pass);
            $object->setPlainPassword(null);
        }
    }
}
