<?php
require_once '.env.php';
require_once 'Registro.php';

class RepositorioRegistro
{
    private static $conexion = null;

    public function __construct()
    {
        if (is_null(self::$conexion)) {
            $credenciales = credenciales();
            self::$conexion = new mysqli(   $credenciales['servidor'],
                                            $credenciales['usuario'],
                                            $credenciales['clave'],
                                            $credenciales['base_de_datos']);
            if(self::$conexion->connect_error) {
                $error = 'Error de conexión: '.self::$conexion->connect_error;
                self::$conexion = null;
                die($error);
            }
            self::$conexion->set_charset('utf8'); 
        }
    }

    public function nuevoRegistro($r)
    {   
        /* Se guardan los resultados de los geters en variables para luego ser utilizados en blind_param,
        en vez de ejecutar los geters directamente en blind_param.
        De esta manera se soluciona el error "Only variables should be passed by reference" */
        $fecha = $r->getFecha();
        $peso = $r->getPeso();
        $idpersona = $r->getIdpersona();

        $q = "INSERT INTO registros (fecha, peso, idpersona)"; 
        $q.= "VALUES (?, ?, ?)";
        $query = self::$conexion->prepare($q);
        $query->bind_param("sdi", $fecha, $peso, $idpersona);

        if ( $query->execute() ) {
            // Retornamos el id del usuario recién insertado.
            return self::$conexion->insert_id;
        }
        else {
            return false;
        }
    }

    /* Consulta a BBDD el historico de registros de peso del usuario en la tabla registros y devuelve resultado*/
    public function consultaRegistros($idUsuario)
    {
        $q = "SELECT * FROM registros ";
        $q.= "WHERE idpersona = ? ORDER BY fecha DESC";
        $query = self::$conexion->prepare($q);
        $query->bind_param("i", $idUsuario);
        if ( $query->execute() ) {
            $resultado = $query->get_result();
            $resultado = $resultado->fetch_all();
            return $resultado;
        }
        else {
            return false;
        }
    }
}