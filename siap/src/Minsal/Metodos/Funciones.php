<?php
namespace Minsal\Metodos;

/**
 * Calcular es una clase que contendrá todos aquellos métodos que necesiten 
 * hacer un calculo y devolver dicho valor a la clase de la que fue llamada.
 *
 * @author Equipo SIAPS
 */
class Funciones {
    
    /*
     * calcularEdad => Método que calcula mediante postgres la edad
     *                  de una persona comparandola con la fecha actual
     *                  luego cambia a español el resultado para que 
     *                  aparesca Años, meses y días
     * 
     * $conn => Es la conexión para poder realizar la consulta
     * $fechaNacimiento => Es la fecha de nacimiento de la persona
     * $fechaHoraNacimiento => Es la horaNacimiento de la persona
     * @return string
     * 
     */
    public function calcularEdad($conn, $fechaNacimiento,$horaNacimiento=null) {
        $fecha_actual = getdate();
        $fecha_actual = $fecha_actual['mday'] . '-' . $fecha_actual['mon'] . '-' . $fecha_actual['year'];
        $sql = "SELECT age('$fecha_actual','$fechaNacimiento')";
        $query = $conn->query($sql);
        if ($query->rowCount() > 0) {
            $edad = $query->fetch();
            $edad = $edad['age'];
            $edad = ereg_replace('years', 'años,', $edad);
            $edad = ereg_replace('year', 'año,', $edad);
            $edad = ereg_replace('mons', 'meses,', $edad);
            $edad = ereg_replace('mon', 'mes,', $edad);
            $edad = ereg_replace('days', 'días,', $edad);
            $edad = ereg_replace('day', 'día,', $edad);
            $edad = ereg_replace('[,]$', '', $edad);
        }
        /*AGREGAR LO DE SI ES = 000000 COLOCAR LA FECHA*/
        if(strcmp($edad,'00:00:00')==0){
	  if (is_null($horaNacimiento)){
	    $edad='0 días';
	  }else{
	    $sql = "SELECT concat_ws(' ',regexp_replace(to_char((now()::TIME - '$horaNacimiento'),'HH24:MI'),':',' Horas '),'Minutos') AS age";
	    $query = $conn->query($sql);
	    $edad = $query->fetch();
	    $edad = $edad['age'];
          }
        }
        return $edad;
    }
    
    /*
     * encriptarClave => Encripta la cadena que se envía como parámetro
     * 
     * $cadena => Cadena a encriptar
     * 
     * @return string
     * 
     */
    
    public function encriptarClave($cadena) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $key = md5('m1ns4l-s14ps');

        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $cadena, MCRYPT_MODE_ECB, $iv);        
        return base64_encode($crypttext);
    }
    
    /*
     * desencriptarClave( => Desencripta la cadena que se envía como parámetro
     * 
     * $cadena => Cadena a desencriptar
     * 
     * @return string
     * 
     */
    public function desencriptarClave($cadena) {
        $cadena = base64_decode($cadena);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $key = md5('m1ns4l-s14ps');

        $texto = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $cadena, MCRYPT_MODE_ECB, $iv);        
        return $texto;
    }

}

?>
