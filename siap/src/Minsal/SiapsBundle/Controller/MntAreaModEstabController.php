<?php

namespace Minsal\SiapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class MntAreaModEstabController extends Controller {

    /**
     * @Route("/atenciones/get", name="get_atenciones", options={"expose"=true})
     */
    public function getAtencionesAction() {

        $em = $this->getDoctrine()->getManager();
        $resp = '';

        $atenciones = $em->getRepository('MinsalSiapsBundle:CtlAtencion')->obtenerAtenciones();

        foreach ($atenciones as $k => $atencion) {
            if ($atencion->getIdAtencionPadre() === null) {
                $resp .= '{"title" : "' . $atencion->getNombre() . '", ' .
                        '"key" : "' . $atencion->getId() . '"';
                $hijos = '';
                $hijos = $this->getHijos($atencion->getId(), $atenciones);
                if ($hijos != '')
                    $resp .= ', "children" : [' . $hijos . ']';
                $resp .='},';
            }
        }
        $resp = trim($resp, ',');
        return new Response('[' . $resp . ']');
    }
    
    /**
     * @Route("/especialidades/get", name="get_especialidades", options={"expose"=true})
     */
    public function getEspecialidadesAction() {

        $em = $this->getDoctrine()->getManager();
        $resp = '';

        $atenciones = $em->getRepository('MinsalSiapsBundle:CtlAtencion')
                ->obtenerEspecialidades();

        foreach ($atenciones as $k => $atencion) {
            if ($atencion->getIdAtencionPadre() === null) {
                $resp .= '{"title" : "' . $atencion->getNombre() . '", ' .
                        '"key" : "' . $atencion->getId() . '"';
                $hijos = '';
                $hijos = $this->getHijos($atencion->getId(), $atenciones);
                if ($hijos != '')
                    $resp .= ', "children" : [' . $hijos . ']';
                $resp .='},';
            }
        }
        $resp = trim($resp, ',');
        return new Response('[' . $resp . ']');
    }

    public function getHijos($padre, $arreglo) {
        $hijos = '';
        foreach ($arreglo as $k => $atencion) {
            if ($atencion->getIdAtencionPadre() !== null)
                if ($atencion->getIdAtencionPadre()->getId() == $padre) {
                    $hijos .= '{"title" : "' . $atencion->getNombre() . '", ' .
                            '"key" : "' . $atencion->getId() . '"';
                    $hijos2 = '';
                    $hijos2 = $this->getHijos($atencion->getId(), $arreglo);
                    if ($hijos2 != '')
                        $hijos .= ', "children" : [' . $hijos2 . ']';
                    $hijos .='},';
                }
        }
        $hijos = trim($hijos, ',');
        return $hijos;
    }

}
