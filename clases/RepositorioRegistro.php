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
        $q = "INSERT INTO registros (fecha, peso, idpersona)"; 
        $q.= "VALUES (?, ?, ?)";
        $query = self::$conexion->prepare($q);
        $query->bind_param("sdi", $r->getFecha(), $r->getPeso(), $r->getIdpersona());

        if ( $query->execute() ) {
            // Retornamos el id del usuario recién insertado.
            return self::$conexion->insert_id;
        }
        else {
            return false;
        }
    }
}