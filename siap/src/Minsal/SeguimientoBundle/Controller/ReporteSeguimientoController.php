<?php

namespace Minsal\SeguimientoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Minsal\SeguimientoBundle\Entity\SecEmergencia;

class ReporteSeguimientoController extends Controller {
    /*
     * DESCRIPCIÓN: Método que genera la hoja de ingreso y egresos
     * ANALISTA PROGRAMADOR: Karen Peñate
     * PARAMETROS ENTRADA:
     *          paciente        =>  Id del paciente
     *          ingreso         =>  Id del Ingreso
     *          report_name     =>  Nombre del reporte
     *          report_format   =>  Formato del reporte
     */

    /**
     * @Route("/hoja/ingreso/egreso/{report_name}/{report_format}", name="hoja_ingreso_egreso", options={"expose"=true})
     */
    public function hojaIngresoEgresoAction($report_name, $report_format) {
        $request = $this->getRequest();
        $id_paciente = $request->get('paciente');
        $id_ingreso = $request->get('ingreso');

        $jasperReport = $this->container->get('jasper.build.reports');
        $jasperReport->setReportName($report_name);
        $jasperReport->setReportFormat($report_format);
        $jasperReport->setReportPath("/reports/siaps/seguimiento/");
        $jasperReport->setReportParams(array(
            'id_paciente' => $id_paciente,
            'id_ingreso' => $id_ingreso
        ));
        return $jasperReport->buildReport();
    }

    /*
     * DESCRIPCIÓN: Método que genera la hoja de ingreso y egresos
     * ANALISTA PROGRAMADOR: Karen Peñate
     * PARAMETROS ENTRADA:
     *          fecha_inicio    =>  Fecha de inicio del reporte
     *          fecha_fin       =>  Fecha fin del reporte
     *          id_servicio     =>  Id del ambiento o servicio 
     *          report_name     =>  Nombre del reporte
     *          report_format   =>  Formato del reporte
     */

    /**
     * @Route("/total/ingresos/{report_name}/{report_format}/{fecha_inicio}/{fecha_fin}/{id_servicio}", name="total_ingresos", options={"expose"=true})
     */
    public function totalIngresosAction($report_name, $report_format, $fecha_inicio, $fecha_fin, $id_servicio = 0) {

        $jasperReport = $this->container->get('jasper.build.reports');
        $jasperReport->setReportName($report_name);
        $jasperReport->setReportFormat($report_format);
        $jasperReport->setReportPath("/reports/siaps/seguimiento/");
        $jasperReport->setReportParams(array(
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'id_servicio' => $id_servicio
        ));
        return $jasperReport->buildReport();
    }

    /*
     * DESCRIPCIÓN: Método que generar la hoja de urgencia y crearle la hoja si
     * no la tuviese
     * ANALISTA PROGRAMADOR: Karen Peñate
     * PARAMETROS ENTRADA:
     *          id_paciente     =>  Id del paciente a generar la hoja 
     *          report_name     =>  Nombre del reporte
     *          report_format   =>  Formato del reporte
     */

    /**
     * @Route("/report/seguimiento/paciente/{report_name}/{report_format}", name="_report_seguimiento_paciente", options={"expose"=true})
     */
    public function pacienteAction($report_name, $report_format) {
        $em = $this->getDoctrine()->getManager();
        $id_paciente=$this->get('request')->get('paciente');
        $id_emergencia=0;
        $emergencia = $em->getRepository("MinsalSeguimientoBundle:SecEmergencia")->findBy(array('idPaciente' => $id_paciente));
        $paciente = $em->getRepository("MinsalSiapsBundle:MntPaciente")->find($id_paciente);
	if (is_null($this->get('request')->get('id_emergencia'))) {
	      if (count($emergencia) == 0) {
		  $emergencia = new SecEmergencia();
		  $anio = date("Y");
		  $emergencia->setAnioEmergencia($anio);
		  $sql = "SELECT COALESCE(MAX(CAST(numero_emergencia AS integer))+1,1) AS numero FROM sec_emergencia WHERE anio_emergencia=" . $anio;
		  $con = $em->getConnection();
		  $query = $con->query($sql);
		  $query = $query->fetch();
		  $emergencia->setNumeroEmergencia($query['numero']);
		  $emergencia->setIdPaciente($paciente);
		  $emergencia->setIdUsuarioRegistra($this->container->get('security.context')->getToken()->getUser());
		  $emergencia->setFechaRegistra(new \DateTime());
		  $em->persist($emergencia);
		  $em->flush();
		  $id_emergencia=$emergencia->getId();
	      }else{
		  $dql = "SELECT max(u),u entidad
			  FROM MinsalSeguimientoBundle:SecEmergencia u
                               JOIN u.idPaciente p
			  WHERE p.id = ".$id_paciente.
			  " GROUP BY u.id";
                  
		  $emergencia= $em->createQuery($dql)->getResult();
                  $emergencia=end($emergencia);
		  $emergencia=$emergencia['entidad'];
		  $fechaActual = new \DateTime();
		  list($hora, $minutos) = explode(":", $emergencia->getFechaRegistra()->format('H:i'));
		  if($emergencia->getFechaRegistra()->diff($fechaActual)->d == 0 && $emergencia->getFechaRegistra()->diff($fechaActual)->m == 0 && $emergencia->getFechaRegistra()->diff($fechaActual)->y == 0){
		    if ($fechaActual->format('H') > ($hora+5)){
			$emergencia = new SecEmergencia();
			$anio = date("Y");
			$emergencia->setAnioEmergencia($anio);
			$sql = "SELECT COALESCE(MAX(CAST(numero_emergencia AS integer))+1,1) AS numero FROM sec_emergencia WHERE anio_emergencia=" . $anio;
			$con = $em->getConnection();
			$query = $con->query($sql);
			$query = $query->fetch();
			$emergencia->setNumeroEmergencia($query['numero']);
			$emergencia->setIdPaciente($paciente);
			$emergencia->setIdUsuarioRegistra($this->container->get('security.context')->getToken()->getUser());
			$emergencia->setFechaRegistra(new \DateTime());
			$em->persist($emergencia);
			$em->flush();
			$id_emergencia=$emergencia->getId();
		    }else{//FIN DEL IF DE LA HORA EL MISMO DIA
		      $id_emergencia=$emergencia->getId();
		    }
		  }else{
		    $emergencia = new SecEmergencia();
		    $anio = date("Y");
		    $emergencia->setAnioEmergencia($anio);
		    $sql = "SELECT COALESCE(MAX(CAST(numero_emergencia AS integer))+1,1) AS numero FROM sec_emergencia WHERE anio_emergencia=" . $anio;
		    $con = $em->getConnection();
		    $query = $con->query($sql);
		    $query = $query->fetch();
		    $emergencia->setNumeroEmergencia($query['numero']);
		    $emergencia->setIdPaciente($paciente);
		    $emergencia->setIdUsuarioRegistra($this->container->get('security.context')->getToken()->getUser());
		    $emergencia->setFechaRegistra(new \DateTime());
		    $em->persist($emergencia);
		    $em->flush();
		    $id_emergencia=$emergencia->getId();
		  }
	      }
        }else{
	    $id_emergencia=$this->get('request')->get('id_emergencia');
	}

        $jasperReport = $this->container->get('jasper.build.reports');
        $jasperReport->setReportName($report_name);
        $jasperReport->setReportFormat($report_format);
        $jasperReport->setReportPath("/reports/siaps/seguimiento/");
        
        $jasperReport->setReportParams(array('id_paciente' => (int)$id_paciente,'id_emergencia'=> (int)$id_emergencia));

        return $jasperReport->buildReport();
    }
    
     /*
     * DESCRIPCIÓN: Método que genera la hoja de resumen de emergencia en un rango de fechas
     * ANALISTA PROGRAMADOR: Karen Peñate
     * PARAMETROS ENTRADA:
     *          fecha_inicio    =>  Fecha de inicio del reporte
     *          fecha_fin       =>  Fecha fin del reporte
     *          report_name     =>  Nombre del reporte
     *          report_format   =>  Formato del reporte
     */

    /**
     * @Route("/total/emergencias/{report_name}/{report_format}/{fecha_inicio}/{fecha_fin}", name="total_emergencias", options={"expose"=true})
     */
    public function totalEmergenciasAction($report_name, $report_format, $fecha_inicio, $fecha_fin) {

        $jasperReport = $this->container->get('jasper.build.reports');
        $jasperReport->setReportName($report_name);
        $jasperReport->setReportFormat($report_format);
        $jasperReport->setReportPath("/reports/siaps/seguimiento/");
        $jasperReport->setReportParams(array(
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        ));
        return $jasperReport->buildReport();
    }

}

?>
