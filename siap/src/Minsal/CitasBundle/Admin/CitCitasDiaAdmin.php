<?php

namespace Minsal\CitasBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Route\RouteCollection;
Use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class CitCitasDiaAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
    }

    protected function configureListFields(ListMapper $listMapper) {
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection->remove('delete');
        $collection->remove('batch');
        $collection->remove('export');
    }
}
