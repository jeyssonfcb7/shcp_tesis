<?php

namespace Minsal\SiapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL as DBAL;

class MntExpedienteController extends Controller {
    /*
     * DESCRIPCIÓN: Método que devuelve la vista para mostrar el resultado de 
     * los expedientes creados en un determinado rango de fechas.
     * ANALISTA PROGRAMADOR: Victoria López
     */

    /**
     * @Route("/expedientes/creados", name="expedientes_creados", options={"expose"=true})
     */
    public function expedientesCreados() {
        //OBTENIENDO PARÁMETROS DE BUSQUEDA
        $datos = array();
        $request = $this->getRequest();
        parse_str($request->get('datos'), $datos);
        if (!array_key_exists('usuario', $datos))
            return $this->render('MinsalSiapsBundle:MntExpedienteAdmin:expedientes_creados.html.twig', array(
                        'fecha_inicio' => $datos['fecha_inicio'], 'fecha_fin' => $datos['fecha_fin']));
        else
            return $this->render('MinsalSiapsBundle:MntExpedienteAdmin:expedientes_creados_usuario.html.twig', array(
                        'fecha_inicio' => $datos['fecha_inicio'], 'fecha_fin' => $datos['fecha_fin']));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve el JSON de los expedientes creados
     * para el JQGRID
     * ANALISTA PROGRAMADOR: Victoria López
     */

    /**
     * @Route("/expedientes/creados/listado", name="expedientes_creados_listado", options={"expose"=true})
     */
    public function expedientesCreadosListado() {
        //OBTENIENDO PARÁMETROS DE BUSQUEDA
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');
        $establecimiento=$em->getRepository('MinsalSiapsBundle:CtlEstablecimiento')->findOneBy(array('configurado' => true));
        $restriccion = "";
        if ($request->get('usuario') != '')
            $restriccion = " AND B.id_user=" . $request->get('usuario') . " ";


        $sql = "SELECT initcap(
B.primer_apellido||coalesce(' '||B.segundo_apellido,'')||coalesce(' '||B.apellido_casada,'')||', '||
B.primer_nombre||coalesce(' '||B.segundo_nombre,'')||coalesce(' '||B.tercer_nombre,'')) as nombre_paciente,
to_char(B.fecha_nacimiento,'DD-MM-YYYY') as fecha_nacimiento,
A.numero,
A.id as id_expediente,
to_char(A.fecha_creacion,'DD-MM-YYYY') as fecha_creacion,
C.nombre as sexo,
E.firstname||' '||E.lastname as tomo_datos
FROM mnt_expediente A
INNER JOIN mnt_paciente B on (A.id_paciente=B.id)
INNER JOIN ctl_establecimiento D on (A.id_establecimiento=D.id AND configurado=true)
INNER JOIN ctl_sexo C on (B.id_sexo=C.id)
LEFT JOIN fos_user_user E on (B.id_user=E.id)
WHERE date(A.fecha_creacion)>=to_date('$fechaInicio','DD-MM-YYYY') 
      AND date(A.fecha_creacion)<=to_date('$fechaFin','DD-MM-YYYY')
	$restriccion";
	
	$ordenamiento="";
        if($establecimiento->getTipoExpediente() == 'G')
	    $ordenamiento =" ORDER BY fecha_creacion ASC,cast (split_part(numero,'-',2) as integer) DESC,cast (split_part(numero,'-',1) as integer) ASC";
	else
	    $ordenamiento =" ORDER BY cast (numero as integer) ASC";
        $expedientes = $conn->query($sql.$ordenamiento);
        $numfilas = count($expedientes);

        $i = 0;
        $rows = array();
        /* 'Número Expediente', 'Fecha de Creación', 'Nombre Paciente', 'Sexo', 'Fecha de Nacimiento' */
        foreach ($expedientes as $aux) {
            $rows[$i]['id'] = $aux['id_expediente'];
            $rows[$i]['cell'] = array($aux['numero'],
                $aux['fecha_creacion'],
                $aux['nombre_paciente'],
                $aux['sexo'],
                $aux['fecha_nacimiento'],
                $aux['tomo_datos']
            );
            $i++;
        }


        $datos = json_encode($rows);
        $pages = floor($numfilas / 20) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';

        return new Response($jsonresponse);
    }

}
