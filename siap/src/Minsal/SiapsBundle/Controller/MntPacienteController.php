<?php

namespace Minsal\SiapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Minsal\Metodos\Funciones;
use Doctrine\DBAL as DBAL;

class MntPacienteController extends Controller {
    /*
     * DESCRIPCIÓN: Método que devuelve la vista para la busqueda local 
     * del paciente
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/buscar/paciente", name="buscar_paciente", options={"expose"=true})
     */
    public function buscarPacienteAction() {
        $em = $this->getDoctrine()->getManager();
        $establecimiento = $em->getRepository("MinsalSiapsBundle:CtlEstablecimiento")->obtenerEstablecimientoConfigurado();
        if ($establecimiento->getIdTipoEstablecimiento()->getId() == 1)
            return $this->render('MinsalSiapsBundle:MntPacienteAdmin:resultado_busqueda_hospital.html.twig', array('tipo_busqueda' => 'l'));
        else
            return $this->render('MinsalSiapsBundle:MntPacienteAdmin:resultado_busqueda.html.twig', array('tipo_busqueda' => 'l'));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve la vista para la busqueda global 
     * del paciente
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/buscar/paciente/global", name="buscar_paciente_global", options={"expose"=true})
     */
    public function buscarPacienteGlobalAction() {

        return $this->render('MinsalSiapsBundle:MntPacienteAdmin:resultado_busqueda.html.twig', array('tipo_busqueda' => 'g'));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve un JSON de la busqueda de los pacientes
     * según los parámetros enviados. Dicha consulta se realiza con el gestor
     * POSTGRESQL por el tipo de consulta que se realiza
     * ANALISTA PROGRAMADOR: Karen Peñate - Victoria López
     */

    /**
     * @Route("/cargar/paciente", name="cargar_paciente", options={"expose"=true})
     */
    public function cargarBusquedaJSON() {
        //OBTENIENDO PARÁMETROS DE BUSQUEDA
        $request = $this->getRequest();
        $primerNombre = chop(ltrim($request->get('primer_nombre')));
        $segundoNombre = chop(ltrim($request->get('segundo_nombre')));
        $tercerNombre = chop(ltrim($request->get('tercer_nombre')));
        $primerApellido = chop(ltrim($request->get('primer_apellido')));
        $segundoApellido = chop(ltrim($request->get('segundo_apellido')));
        $nombreMadre = chop(ltrim($request->get('nombre_madre')));
        $fechaNacimiento = $request->get('fecha_nacimiento');
        $conocidoPor = chop(ltrim($request->get('conocido_por')));
        $nec = chop(ltrim($request->get('nec')));
        $dui = $request->get('dui');
        $tipo_busqueda = $request->get('tipo_busqueda');
        $procedencia = $request->get('procedencia');
        //INICIALIZANDO VARIABLE DOCTRINE
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        //CONSTANTES
        if (strcmp($tipo_busqueda, 'l') == 0)
            $sql = "SELECT A.*,C.nombre,coalesce(B.numero,'EM') numero,
                E.nombre_ambiente ambiente,
                D.diagnostico,D.fecha,D.hora
                FROM mnt_paciente A 
                      LEFT JOIN ctl_documento_identidad C ON C.id=A.id_doc_ide_paciente
                      LEFT JOIN mnt_expediente B ON B.id_paciente=A.id
                      LEFT JOIN sec_ingreso D ON (D.id_expediente=B.id AND D.id = (SELECT id FROM sec_ingreso WHERE fecha=(SELECT max(fecha) FROM sec_ingreso WHERE id_expediente=B.id) AND id_expediente=B.id))
                      LEFT JOIN mnt_aten_area_mod_estab E ON D.id_ambiente_ingreso=E.id
                WHERE (B.habilitado= TRUE OR (SELECT COUNT(id) FROM sec_emergencia WHERE id_paciente=A.id)>0) 
                ";
        else
            $sql = "SELECT A.*,C.nombre 
               FROM mnt_paciente A LEFT JOIN ctl_documento_identidad C ON C.id=A.id_doc_ide_paciente
                WHERE ";


        if ($primerNombre != '')
            if (strcmp($tipo_busqueda, 'l') == 0)
                $primerNombre = "  AND A.primer_nombre::text ~* '$primerNombre'";
            else
                $primerNombre = "A.primer_nombre::text ~* '$primerNombre'";
        if ($primerApellido != '')
            $primerApellido = " AND A.primer_apellido::text ~* '$primerApellido'";
        if ($segundoNombre != '')
            $segundoNombre = " AND A.segundo_nombre::text ~* '$segundoNombre'";
        if ($tercerNombre != '')
            $tercerNombre = " AND A.tercer_nombre::text ~* '$tercerNombre'";
        if ($segundoApellido != '')
            $segundoApellido = " AND A.segundo_apellido::text ~* '$segundoApellido'";
        if ($nombreMadre != '')
            $nombreMadre = " AND A.nombre_madre::text ~* '$nombreMadre'";
        if ($conocidoPor != '')
            $conocidoPor = " OR A.conocido_por::text ~* '$conocidoPor'";
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
        if ($dui != '')
            $dui = " AND A.numero_doc_ide_paciente::text ~*'$dui'";
        $order_by = " ORDER BY A.primer_apellido,A.primer_nombre, A.fecha_nacimiento";
        $sql.=$primerNombre . $primerApellido . $segundoNombre . $tercerNombre . $segundoApellido . $nombreMadre . $conocidoPor . $fechaNacimiento . $nec . $dui . $order_by;
        if (strcmp($tipo_busqueda, 'l') == 0)
            $query = $conn->query($sql);
        else {
            $establecimientoPN = $this->container->get('security.context')->getToken()->getUser()->getIdEstablecimiento();
            $regional = $establecimientoPN->getIdEstablecimientoPadre()->getIdEstablecimientoPadre();
            $conexion = $em->getRepository('MinsalSiapsBundle:MntConexion')->findOneBy(array('idEstablecimiento' => $regional));
            $conn = $em->getRepository('MinsalSiapsBundle:MntConexion')->getConexionGenerica($conexion);
            $query = $conn->query($sql);
        }

        $establecimiento = $em->getRepository("MinsalSiapsBundle:CtlEstablecimiento")->obtenerEstablecimientoConfigurado();
        $numfilas = count($query->rowCount());
        $i = 0;
        $rows = array();
        if ($numfilas > 0) {
            if ($establecimiento->getIdTipoEstablecimiento()->getId() == 1) {
                foreach ($query->fetchAll() as $aux) {
                    $espacio = '<a href="' . $this->generateUrl('admin_minsal_siaps_mntpaciente_edit', array('id' => $aux['id'], 'procedencia' => $procedencia)) . '" class="btn btn-info">
    <span class="glyphicon glyphicon-folder-open"></span> Detalle
</a>';
                    if (strcmp($tipo_busqueda, 'l') == 0) {
                        $numero = $aux['numero'];
                        $id = $aux['id'];
                    } else {
                        $numero = '';
                        $id = $aux['id'];
                    }
                    $rows[$i]['id'] = $id;
                    if (!is_null($aux['fecha']))
                        $fechaIngreso = date('d-m-Y', strtotime($aux['fecha'])) . " " . date('H:i', strtotime($aux['hora']));
                    else
                        $fechaIngreso = null;
                    $rows[$i]['cell'] = array($id,
                        $espacio, $numero,
                        $aux['primer_apellido'] . ' ' . $aux['segundo_apellido'] . ' ' . $aux['apellido_casada'],
                        $aux['primer_nombre'] . ' ' . $aux['segundo_nombre'] . ' ' . $aux['tercer_nombre'],
                        date('d-m-Y', strtotime($aux['fecha_nacimiento'])),
                        substr($aux['nombre'], 0, 4) . ":" . $aux['numero_doc_ide_paciente'],
                        $aux['nombre_madre'],
                        $aux['conocido_por'],
                        $aux['ambiente'],
                        $aux['diagnostico'],
                        $fechaIngreso
                    );
                    $i++;
                }
            } else {
                foreach ($query->fetchAll() as $aux) {
                    $espacio = '<a href="' . $this->generateUrl('admin_minsal_siaps_mntpaciente_edit', array('id' => $aux['id'], 'procedencia' => 'c')) . '" class="btn btn-info">
    <span class="glyphicon glyphicon-folder-open"></span> Detalle
</a>';
                    if (strcmp($tipo_busqueda, 'l') == 0) {
                        $numero = $aux['numero'];
                        $id = $aux['id'];
                    } else {
                        $numero = '';
                        $id = $aux['id'];
                    }
                    $rows[$i]['id'] = $id;
                    $rows[$i]['cell'] = array($id,
                        $espacio, $numero,
                        $aux['primer_apellido'] . ' ' . $aux['segundo_apellido'] . ' ' . $aux['apellido_casada'],
                        $aux['primer_nombre'] . ' ' . $aux['segundo_nombre'] . ' ' . $aux['tercer_nombre'],
                        date('d-m-Y', strtotime($aux['fecha_nacimiento'])),
                        substr($aux['nombre'], 0, 4) . ":" . $aux['numero_doc_ide_paciente'],
                        $aux['nombre_madre'],
                        $aux['conocido_por']
                    );
                    $i++;
                }
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
     * DESCRIPCIÓN: Método que se devuelve en un JSON la edad de un determinado
     * paciente.
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/paciente/edad}", name="edad_paciente", options={"expose"=true})
     * @Method("GET")
     */
    public function edad_paciente() {
        $request = $this->getRequest();
        $fecha_nacimiento = $request->get('fecha_nacimiento');
        $hora_nacimiento = $request->get('hora_nacimiento');
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $calcular = new Funciones();

        $datos['edad'] = $calcular->calcularEdad($conn, $fecha_nacimiento,$hora_nacimiento);

        return new Response(json_encode($datos));
    }

}
