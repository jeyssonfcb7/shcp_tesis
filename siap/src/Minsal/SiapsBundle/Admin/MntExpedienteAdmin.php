<?php

namespace Minsal\SiapsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class MntExpedienteAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
        $esdomed = $this->getModelManager()
                ->findOneBy('MinsalSiapsBundle:CtlCreacionExpediente', array('id' => 3));

        $ruta_accion = explode('/', $this->getRequest()->getUri());
        $accion = array_pop($ruta_accion);
        $accion=array_pop($ruta_accion);
        $accion=array_pop($ruta_accion);
        if($accion=='admin'){
        $numero = $this->getConfigurationPool()->getContainer()
                ->get('doctrine')
                ->getRepository('MinsalSiapsBundle:MntExpediente')
                ->obtenerExpedienteSugerido();

        $formMapper
                ->add('numero', null, array('required' => true,
                    'label' => $this->getTranslator()->trans('numero'),
                    'attr' => array('value' => $numero)))
                ->add('idCreacionExpediente', null, array('required' => true,
                    'preferred_choices' => array($esdomed),
                    'label' => $this->getTranslator()->trans('idCreacionExpediente')))
        ;
        }else{
            $formMapper
                ->add('numero', null, array('required' => true,
                    'label' => $this->getTranslator()->trans('numero')))
                ->add('idCreacionExpediente', null, array('required' => true,
                    'preferred_choices' => array($esdomed),
                    'label' => $this->getTranslator()->trans('idCreacionExpediente')))
        ;
        }
    }

    public function getTemplate($name) {
        switch ($name) {
            case 'list':
                return 'MinsalSiapsBundle:MntExpedienteAdmin:list.html.twig';
                break;
             case 'listarexpedientes':
                return 'MinsalSiapsBundle:MntExpedienteAdmin:listarexpedientes.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection->remove('delete');
        $collection->add('listarexpedientes');
    }

    public function getBatchActions() {
        $actions = parent::getBatchActions();
        $actions['delete'] = null;
    }

}

?>
