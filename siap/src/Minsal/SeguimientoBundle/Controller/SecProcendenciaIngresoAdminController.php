<?php

namespace Minsal\SeguimientoBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Minsal\Metodos\Funciones;

class SecProcendenciaIngresoAdminController extends Controller {
    /*
     * DESCRIPCIÓN: Función llamada por Sonata para la acción list
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    public function listAction() {
        if (false === $this->admin->isGranted('LIST')) {
            return $this->render('MinsalSiapsBundle::Accesso_denegado.html.twig', array('admin_pool' => $this->container->get('sonata.admin.pool'),
                        'layout' => $this->container->get('sonata.admin.pool')->getTemplate('layout')
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $establecimiento = $em->getRepository("MinsalSiapsBundle:MntAtenAreaModEstab")->obtenerEstablecimientoConfigurado();

        return $this->render($this->admin->getTemplate('list'), array(
                    'action' => 'list',
                    'establecimiento' => $establecimiento
        ));
    }

}

?>
