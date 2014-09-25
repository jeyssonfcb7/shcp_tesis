<?php

namespace Minsal\SiapsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class MntModalidadEstablecimientoAdmin extends Admin {

    protected $datagridValues = array(
        '_page' => 1, // Display the first page (default = 1)
        '_sort_order' => 'ASC', // Descendant ordering (default = 'ASC')
        '_sort_by' => 'idEstablecimiento' // name of the ordered field (default = the model id field, if any)
    );

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('idEstablecimiento', 'entity', array('label' => $this->getTranslator()->trans('establecimiento'),
                    'read_only' => true,
                    'class' => 'MinsalSiapsBundle:CtlEstablecimiento',
                    'query_builder' => function($repositorio) {
                return $repositorio->obtenerEstabConfigurado();
            }))
                ->add('idModalidad', 'entity', array('label' => $this->getTranslator()->trans('id_modalidad'),
                    'empty_value' => 'Seleccione la modalidad',
                    'class' => 'MinsalSiapsBundle:CtlModalidad',
                    'query_builder' => function($repositorio) {
                $ruta_accion = explode('/', $this->getRequest()->getUri());
                $accion = array_pop($ruta_accion);
                $valor = array_pop($ruta_accion);
                return $repositorio->obtenerModalidades($accion, $valor);
            }))
                ->add('tieneFarmacia', null, array('label' => 'Tiene farmacia habilitada', 'required' => false))
                ->add('repetitiva', null, array('label' => 'Emite recetas repetitivas', 'required' => false));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('idEstablecimiento', null, array('label' => $this->getTranslator()->trans('establecimiento')))
                ->add('idModalidad', null, array('label' => $this->getTranslator()->trans('id_modalidad')))
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('idEstablecimiento.nombre', 'text', array('label' => $this->getTranslator()->trans('establecimiento')))
                ->add('idModalidad.nombre', 'text', array('label' => $this->getTranslator()->trans('id_modalidad')))
                ->add('tieneFarmacia', null, array('label' => 'Tiene farmacia habilitada'))
                ->add('repetitiva', null, array('label' => 'Emite recetas repetitivas'))
                ->add('_action', 'actions', array(
                    'label' => $this->getTranslator()->trans('Action'),
                    'actions' => array(
                        'edit' => array()
                    )
                ))


        ;
    }

    public function getBatchActions() {
        $actions = parent::getBatchActions();
        $actions['delete'] = null;
    }

    public function postPersist($mntModalidadEstablecimiento) {
        if ($mntModalidadEstablecimiento->getIdModalidad()->getId() == 1) {
            $usuario = $this->getModelManager()
                    ->getEntityManager('ApplicationSonataUserBundle:User')
                    ->createQuery("
                    SELECT u
                    FROM ApplicationSonataUserBundle:User u
                    WHERE u.username LIKE 'farmadmin'")
                    ->getSingleResult();
            $usuario->setIdModalidadEstab($mntModalidadEstablecimiento);
            $this->getModelManager()->update($usuario);
        } elseif($mntModalidadEstablecimiento->getIdModalidad()->getId() == 2) {
            $usuario = $this->getModelManager()
                    ->getEntityManager('ApplicationSonataUserBundle:User')
                    ->createQuery("
                    SELECT u
                    FROM ApplicationSonataUserBundle:User u
                    WHERE u.username LIKE 'fosaludadmin'")
                    ->getSingleResult();
            $usuario->setEnabled(true);
            $usuario->setIdModalidadEstab($mntModalidadEstablecimiento);
            $this->getModelManager()->update($usuario);
        }
    }

    public function postUpdate($mntModalidadEstablecimiento) {
        if ($mntModalidadEstablecimiento->getIdModalidad()->getId() == 1) {
            $usuario = $this->getModelManager()
                    ->getEntityManager('ApplicationSonataUserBundle:User')
                    ->createQuery("
                    SELECT u
                    FROM ApplicationSonataUserBundle:User u
                    WHERE u.username LIKE 'farmadmin'")
                    ->getSingleResult();
            $usuario->setIdModalidadEstab($mntModalidadEstablecimiento);
            $this->getModelManager()->update($usuario);
        } elseif($mntModalidadEstablecimiento->getIdModalidad()->getId() == 2) {
            $usuario = $this->getModelManager()
                    ->getEntityManager('ApplicationSonataUserBundle:User')
                    ->createQuery("
                    SELECT u
                    FROM ApplicationSonataUserBundle:User u
                    WHERE u.username LIKE 'fosaludadmin'")
                    ->getSingleResult();
            $usuario->setEnabled(true);
            $usuario->setIdModalidadEstab($mntModalidadEstablecimiento);
            $this->getModelManager()->update($usuario);
        }
    }

}

?>
