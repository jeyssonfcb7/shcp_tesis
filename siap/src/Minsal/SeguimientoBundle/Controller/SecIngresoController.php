<?php

namespace Minsal\SeguimientoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Minsal\Metodos\Funciones;

class SecIngresoController extends Controller {
    /*
     * DESCRIPCIÓN: Método que devuelve las especialidades de hospitalización
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/obtener/especialidades/ingresos", name="get_especialidad_ingresos", options={"expose"=true})
     */
    public function getEspecialidadesIngresoAction() {

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT A.id as id,
                        (CASE WHEN F.nombre IS NOT NULL THEN CONCAT('Hospitalización ',F.nombre) 
                                ELSE C.nombre
                        END)  as nombre  
                FROM MinsalSiapsBundle:MntAtenAreaModEstab A
                JOIN A.idAreaModEstab B
                JOIN A.idAtencion C
                JOIN B.idAreaAtencion D
                LEFT JOIN B.idServicioExternoEstab E
                LEFT JOIN E.idServicioExterno F
                WHERE C.idTipoAtencion = 1
                      AND A.nombreAmbiente IS NULL
                      AND D.id = 3
                ORDER BY nombre";
        $especialidades['especialidades'] = $em->createQuery($dql)
                ->getArrayResult();

        return new Response(json_encode($especialidades));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve los servicios hospitalarios dependiendo
     * de la especialidad seleccionada
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/obtener/servicios/hospitalarios", name="get_servicios_hospitalarios", options={"expose"=true})
     */
    public function getServiciosHospitalariosAction() {
        $request = $this->getRequest();

        $especialidad = $request->get('idAtenAreaModEstab');
        $em = $this->getDoctrine()->getManager();

        $idAtenAreaModEstab = $em->getRepository('MinsalSiapsBundle:MntAtenAreaModEstab')->find($especialidad);
        $dql = "SELECT A.id as id, A.nombreAmbiente
                FROM MinsalSiapsBundle:MntAtenAreaModEstab A
                WHERE A.idAreaModEstab =:area AND A.idAtencion =:atencion
                      AND A.nombreAmbiente IS NOT NULL";
        $especialidades['especialidades'] = $em->createQuery($dql)
                ->setParameters(array(
                    'area' => $idAtenAreaModEstab->getIdAreaModEstab(),
                    'atencion' => $idAtenAreaModEstab->getIdAtencion()
                ))
                ->getArrayResult();

        return new Response(json_encode($especialidades));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve todos los servicios de hospitalización 
     * restantes.
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/obtener/servicios/hospitalarios/otros", name="get_servicios_hospitalarios_otros", options={"expose"=true})
     */
    public function getServiciosHospitalariosOtrosAction() {
        $request = $this->getRequest();

        $especialidad = $request->get('idAtenAreaModEstab');
        $em = $this->getDoctrine()->getManager();

        $idAtenAreaModEstab = $em->getRepository('MinsalSiapsBundle:MntAtenAreaModEstab')->find($especialidad);
        $dql = "SELECT A.id as id, A.nombreAmbiente
                FROM MinsalSiapsBundle:MntAtenAreaModEstab A
                WHERE A.nombreAmbiente IS NOT NULL AND
                      A.id NOT IN(SELECT B.id
                                  FROM MinsalSiapsBundle:MntAtenAreaModEstab B
                                  WHERE B.idAreaModEstab =:area AND B.idAtencion =:atencion
                                  AND B.nombreAmbiente IS NOT NULL)";
        $especialidades['especialidades'] = $em->createQuery($dql)
                ->setParameters(array(
                    'area' => $idAtenAreaModEstab->getIdAreaModEstab(),
                    'atencion' => $idAtenAreaModEstab->getIdAtencion()
                ))
                ->getArrayResult();

        return new Response(json_encode($especialidades));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve TODOS los servicios de hospitalización
     * registrados.
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/obtener/servicios/hospitalarios/todos", name="get_servicios_hospitalarios_todos", options={"expose"=true})
     */
    public function getServiciosHospitalariosTodosAction() {
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT A.id as id, A.nombreAmbiente nombre
                FROM MinsalSiapsBundle:MntAtenAreaModEstab A
                WHERE A.nombreAmbiente IS NOT NULL
                ORDER BY A.nombreAmbiente";
        $especialidades['especialidades'] = $em->createQuery($dql)
                ->getArrayResult();

        return new Response(json_encode($especialidades));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve la vista para la busqueda de los 
     * ingresos
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/buscar/ingresos", name="buscar_ingresos", options={"expose"=true})
     */
    public function buscarIngresosAction() {

        return $this->render('MinsalSeguimientoBundle:SecIngreso:resultado_busqueda.html.twig', array());
    }

    /*
     * DESCRIPCIÓN: Método que devuelve un JSON que contiene los ingresos
     * de acuerdo a los parámetros enviados.
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/cargar/ingresos", name="cargar_ingresos", options={"expose"=true})
     */
    public function cargarIngresosAction() {
        //OBTENIENDO PARÁMETROS DE BUSQUEDA
        $request = $this->getRequest();
        $primerNombre = chop(ltrim($request->get('primer_nombre')));
        $segundoNombre = chop(ltrim($request->get('segundo_nombre')));
        $tercerNombre = chop(ltrim($request->get('tercer_nombre')));
        $primerApellido = chop(ltrim($request->get('primer_apellido')));
        $segundoApellido = chop(ltrim($request->get('segundo_apellido')));
        $apellidoCasada = chop(ltrim($request->get('apellido_casada')));
        $fechaNacimiento = $request->get('fecha_nacimiento');
        $nec = chop(ltrim($request->get('nec')));
        $servicio = $request->get('servicio_ingreso');

        //INICIALIZANDO VARIABLE DOCTRINE
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        //CONSTANTES

        $sql = "SELECT A.*,E.id id_ingreso,C.nombre,B.numero,D.nombre_ambiente ambiente,E.diagnostico,E.fecha,E.hora,
                    concat(coalesce(cast(E.tarjetas_entregadas as text)||' Tarjetas','0 Tarjetas'),coalesce(' A '||E.responsable_tarjeta,'')) tarjetas
                FROM mnt_paciente A 
                     INNER JOIN mnt_expediente B ON B.id_paciente=A.id
                     LEFT JOIN ctl_documento_identidad C ON C.id=A.id_doc_ide_paciente                     
                     INNER JOIN sec_ingreso E ON E.id_expediente=B.id
                     LEFT JOIN mnt_aten_area_mod_estab D ON E.id_ambiente_ingreso=D.id
                WHERE  B.habilitado= TRUE ";


        if ($primerNombre != '')
            $primerNombre = "  AND A.primer_nombre::text ~* '$primerNombre'";
        if ($primerApellido != '')
            $primerApellido = " AND A.primer_apellido::text ~* '$primerApellido'";
        if ($segundoNombre != '')
            $segundoNombre = " AND A.segundo_nombre::text ~* '$segundoNombre'";
        if ($tercerNombre != '')
            $tercerNombre = " AND A.tercer_nombre::text ~* '$tercerNombre'";
        if ($segundoApellido != '')
            $segundoApellido = " AND A.segundo_apellido::text ~* '$segundoApellido'";
        if ($apellidoCasada != '')
            $apellidoCasada = " AND A.apellido_casada::text ~* '$apellidoCasada'";
        if ($fechaNacimiento != '')
            $fechaNacimiento = " AND A.fecha_nacimiento='$fechaNacimiento'";
       if ($nec != '') {
            $numero = explode('-', $nec);
            $entero = (int) $numero[0];
            $nec = (string) $entero;
            if (count($numero) == 2)
                $nec.='-' . $numero[1];
            $nec = " AND B.numero='$nec'";
        }
        if ($servicio != '')
            $servicio = " AND E.id_ambiente_ingreso=$servicio";
        $fechas = '';
        if ($primerNombre == '' && $primerApellido == '' && $nec == '' && $fechaNacimiento == '' && $servicio == '')
            $fechas = " AND date(E.fecha) = current_date";

        $sql.=$primerNombre . $primerApellido . $segundoNombre . $tercerNombre . $segundoApellido . $apellidoCasada . $fechaNacimiento . $nec . $servicio . $fechas;
        $sql.= " ORDER BY E.fecha DESC, E.hora DESC,A.primer_Apellido ASC";

        $query = $conn->query($sql);
        $numfilas = count($query->rowCount());
        $i = 0;
        $rows = array();
        if ($numfilas > 0) {
            foreach ($query->fetchAll() as $aux) {
                //SE COLOCO AQUI PARA QUE EL GRID NO SE TARDE EN CARGAR-->KEPA
                $espacio = '<a href="'.$this->generateUrl('hoja_ingreso_egreso',array('report_name'=>'hojaIngresoEgreso','report_format'=>'PDF','paciente'=>$aux['id'],'ingreso'=>$aux['id_ingreso'])).'" target="_blank" class="btn btn-info">
                            <span class="glyphicon glyphicon-book"></span> Hoja de Ingreso</a>';
                $espacio .= '<a href="'.$this->generateUrl('admin_minsal_seguimiento_secingreso_edit',array('id'=>$aux['id_ingreso'])).'" class="btn btn-info">
                            <span class="glyphicon glyphicon-pencil"></span> Editar</a>';
                //
                $rows[$i]['id'] = $aux['id_ingreso'];
                $rows[$i]['cell'] = array($aux['id_ingreso'],
                    $espacio,
                    $aux['numero'],
                    $aux['primer_apellido'] . ' ' . $aux['segundo_apellido'] . ' ' . $aux['apellido_casada'],
                    $aux['primer_nombre'] . ' ' . $aux['segundo_nombre'] . ' ' . $aux['tercer_nombre'],
                    date('d-m-Y', strtotime($aux['fecha_nacimiento'])),
                    $aux['tarjetas'],
                    $aux['ambiente'],
                    $aux['diagnostico'],
                    date('d-m-Y', strtotime($aux['fecha'])) . " " . date('H:i', strtotime($aux['hora']))
                );
                $i++;
            }
        }

        $datos = json_encode($rows);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';

        return new Response($jsonresponse);
    }

   
     /*
     * DESCRIPCIÓN: Método que devuelve la vista para la busqueda de los 
     * ingresos por fecha
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/buscar/ingresos/pacientes", name="buscar_ingresos_pacientes", options={"expose"=true})
     */
    public function buscarIngresosPacienteAction() {

        return $this->render('MinsalSeguimientoBundle:SecIngreso:resultado_reporte_list.html.twig', array());
    }
    
     /*
     * DESCRIPCIÓN: Método que devuelve un JSON que contiene los ingresos de 
     * los pacientes en las fechas establecidas.
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/pacientes/ingresado", name="pacientes_ingresados", options={"expose"=true})
     */
    public function cargarReporteIngresoAction() {
        //OBTENIENDO PARÁMETROS DE BUSQUEDA
        $request = $this->getRequest();
        $fecha_inicio= $request->get('fecha_inicio');
        $fecha_fin= $request->get('fecha_fin');
        $servicio = $request->get('servicio_ingreso');

        //INICIALIZANDO VARIABLE DOCTRINE
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        //CONSTANTES

        $sql = "SELECT A.*,E.id id_ingreso,B.numero,D.nombre_ambiente ambiente,E.diagnostico,E.fecha,E.hora
                FROM mnt_paciente A 
                     INNER JOIN mnt_expediente B ON B.id_paciente=A.id
                     INNER JOIN sec_ingreso E ON E.id_expediente=B.id
                     LEFT JOIN mnt_aten_area_mod_estab D ON E.id_ambiente_ingreso=D.id
                WHERE  B.habilitado= TRUE 
                       AND E.fecha>=to_date('$fecha_inicio','DD-MM-YYYY') and E.fecha<=to_date('$fecha_fin','DD-MM-YYYY')";
        if ($servicio != '')
            $sql .= " AND E.id_ambiente_ingreso=$servicio";
        $sql.= " ORDER BY E.fecha DESC, E.hora DESC,A.primer_Apellido ASC";

        $query = $conn->query($sql);

        $numfilas = count($query->rowCount());
        $espacio = "";
        $i = 0;
        $rows = array();
        if ($numfilas > 0) {
            foreach ($query->fetchAll() as $aux) {
                $rows[$i]['id'] = $aux['id_ingreso'];
                $rows[$i]['cell'] = array(
                    $aux['numero'],
                    $aux['primer_apellido'] . ' ' . $aux['segundo_apellido'] . ' ' . $aux['apellido_casada'].$aux['primer_nombre'] . ' ' . $aux['segundo_nombre'] . ' ' . $aux['tercer_nombre'],
                    date('d-m-Y', strtotime($aux['fecha_nacimiento'])),
                    date('d-m-Y', strtotime($aux['fecha'])) . " " . date('H:i', strtotime($aux['hora'])),
                    $aux['ambiente'],
                    $aux['diagnostico']                   
                );
                $i++;
            }
        }

        $datos = json_encode($rows);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';

        return new Response($jsonresponse);
    }

}

?>
