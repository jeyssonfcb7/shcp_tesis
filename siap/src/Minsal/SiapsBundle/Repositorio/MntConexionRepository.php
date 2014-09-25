<?php

namespace Minsal\SiapsBundle\Repositorio;

use Doctrine\ORM\EntityRepository;
use Minsal\SiapsBundle\Entity\MntConexion;
use Doctrine\DBAL as DBAL;
use Minsal\Metodos\Funciones;

/**
 * MntConexionRepository
 *
 */
class MntConexionRepository extends EntityRepository {

    public function getConexionGenerica(MntConexion $conexion) {
        $encripta = new Funciones();

        // Construir el Conector genérico
        $config = new DBAL\Configuration();

        $connectionParams = array(
            'dbname' => $conexion->getBaseDeDatos(),
            'user' => $conexion->getUsuario(),
            'password' => $encripta->desencriptarClave(trim($conexion->getContrasenia())),
            'host' => $conexion->getHost(),
            'driver' => $conexion->getGestorBase(),
            'port' => $conexion->getPuerto()
        );
        try {
            $conn = DBAL\DriverManager::getConnection($connectionParams, $config);
        } catch (\Exception $e) {
            throw new \PDOException($e->getMessage());
            echo $e->getMessage();
        }
        return $conn;
    }

}

?>