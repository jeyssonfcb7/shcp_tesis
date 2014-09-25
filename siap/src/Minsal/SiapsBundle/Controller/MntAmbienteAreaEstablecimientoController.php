<?php

namespace Minsal\SiapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
//use Doctrine\DBAL as DBAL;
use Minsal\SiapsBundle\Entity\MntAreaModEstab;

class MntAmbienteAreaEstablecimientoController extends Controller {

    /**
     * @Route("/areas/modalidades/get", name="get_areas_modalidades", options={"expose"=true})
     * @Method("GET")
     */
    public function getAreaModalidadAction() {

        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT A.id as id,(
                        CASE WHEN F.nombre IS NOT NULL THEN CONCAT(D.nombre, '-',B.nombre,'-',F.nombre) 
                                ELSE CONCAT(D.nombre, '-',B.nombre) 
                        END)  as nombre
                FROM MinsalSiapsBundle:MntAreaModEstab A
                JOIN A.idAreaAtencion B
                JOIN A.idModalidadEstab C
                JOIN C.idModalidad D
                LEFT JOIN A.idServicioExternoEstab E
                LEFT JOIN E.idServicioExterno F
                WHERE B.id = 3";
        $areas['areas'] = $em->createQuery($dql)
                ->getArrayResult();

        return new Response(json_encode($areas));
    }

     /**
     * @Route("/especialidades/hospitalizacion/get", name="get_especialidades_hospitalizacion", options={"expose"=true})
     * @Method("GET")
     */
    public function getEspecialidadesHospitalizacionAction() {
        $request = $this->getRequest();
        $idAreaModEstab = $request->get('idAreaModEstab');
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT A.id as id,C.nombre as nombre
                FROM MinsalSiapsBundle:MntAtenAreaModEstab A
                JOIN A.idAreaModEstab B
                JOIN A.idAtencion C
                WHERE B.id = $idAreaModEstab 
                        AND C.idTipoAtencion = 1
                        AND A.nombreAmbiente IS NULL";
        $especialidades['especialidades']  = $em->createQuery($dql)
                ->getArrayResult();
 
        return new Response(json_encode($especialidades));
    }

    /**
     * @Route("/servicios/get", name="get_servicios", options={"expose"=true})
     * @Method("GET")
     */
    public function getServiciosHospitalariosAction() {
        $request = $this->getRequest();
        $idAreaModEstab = $request->get('idAreaModEstab');
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT A.id as id,C.nombre as nombre
                FROM MinsalSiapsBundle:MntAtenAreaModEstab A
                JOIN A.idAreaModEstab B
                JOIN A.idAtencion C
                WHERE A.idAreaModEstab = :idAreaModEstab 
                        AND C.idTipoAtencion = 1";
        $especialidades['especialidades'] = $em->createQuery($dql)
                ->setParameter('idAreaModEstab', $idAreaModEstab)
                ->getArrayResult();

        return new Response(json_encode($especialidades));
    }

    /**
     * @Route("/servicios/hospitalarios/generar", name="generar_servicios_hospitalarios", options={"expose"=true})
     * @Method("GET")
     */
    public function generarServiciosHospitalariosAction() {
        $request = $this->getRequest();

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT A.id
              FROM MinsalSiapsBundle:MntAtenAreaModEstab A
              JOIN A.idAreaModEstab B
              JOIN B.idServicioExternoEstab C
              JOIN C.idServicioExterno D
              WHERE A.id= :id";

        try {
            $area = $em->createQuery($dql)
                    ->setParameter('id', $request->get('idAtenAreaModEstab'))
                    ->getSingleResult();
            $dql = "SELECT CONCAT(B.nombre,' ',E.abreviatura) as nombre, A.id as id
                    FROM MinsalSiapsBundle:MntAtenAreaModEstab A
                    JOIN A.idAtencion B
                    JOIN A.idAreaModEstab C
                    JOIN C.idServicioExternoEstab D
                    JOIN D.idServicioExterno E
                    WHERE A.id= :id";
        } catch (\Doctrine\ORM\NoResultException $e) {
            $dql = "SELECT B.nombre as nombre, A.id as id
                    FROM MinsalSiapsBundle:MntAtenAreaModEstab A
                    JOIN A.idAtencion B
                    WHERE A.id= :id";
        }

        try {
            $especialidad = $em->createQuery($dql)
                    ->setParameter('id', $request->get('idAtenAreaModEstab'))
                    ->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            $especialidad = new \Minsal\SiapsBundle\Entity\CtlAtencion();
        }

        if ($request->get('numeroAmbientes') == "")
            $ambientes = 0;
        else
            $ambientes = $request->get('numeroAmbientes');


        return $this->render('MinsalSiapsBundle:MntAmbienteAreaEstablecimiento:generar_servicios.html.twig', array('especialidades' => $especialidad,
                    'porSexo' => $request->get('porSexo'),
                    'numeroAmbientes' => $ambientes
        ));
    }

    /**
     * @Route("/guardar/hospitalizacion/{sexo}/{numero_ambientes}/{id_aten_area_mod_estab}", name="guardar_hopitalizacion", options={"expose"=true})
     * @Method("POST")
     */
    public function guardarHospitalizacionAction($sexo, $numero_ambientes, $id_aten_area_mod_estab) {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $establecimiento = $em->getRepository('MinsalSiapsBundle:CtlEstablecimiento')
                    ->findOneBy(array('configurado' => true));
        
        $area =$em->getRepository('MinsalSiapsBundle:MntAtenAreaModEstab')
                    ->findOneBy(array('id' => $id_aten_area_mod_estab));
        
        if ($numero_ambientes == 0 && $sexo == 'false') {
            $ambiente = new MntAreaModEstab();
            $ambiente->setIdAtencion($area->getIdAtencion());
            $ambiente->setIdAreaAtencion($area->getIdAreaAtencion());
            $ambiente->setIdEstablecimiento($establecimiento);
            $ambiente->setNombre($request->get('nombre'));
            $em->persist($ambiente);
            $em->flush();
        }
        
          return $this->redirect($this->generateUrl('admin_minsal_siaps_mntatenareamodestab_list', array()));
    }

}