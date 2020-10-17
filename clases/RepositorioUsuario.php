<?php
require_once '.env.php';
require_once 'Usuario.php';

class RepositorioUsuario
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

    public function login($nombre_usuario, $clave)
    {
        $q = "SELECT idpersona, clave, nombre, apellido, genero, nacimiento, estatura, pesodeseado FROM personas ";
        $q.= "WHERE usuario = ?";
        $query = self::$conexion->prepare($q);
        $query->bind_param("s", $nombre_usuario);
        if ( $query->execute() ) {
            $query->bind_result($id, $clave_encriptada, $nombre, $apellido, $genero, 
                                $nacimiento, $estatura, $pesodeseado);
            if ( $query->fetch() ) {
                if( password_verify($clave, $clave_encriptada) === true) {
                    return new Usuario($nombre_usuario, $nombre, $apellido, $genero, 
                                       $nacimiento, $estatura, $pesodeseado, $id);
                }
            }
        }
        return false;
    }

    public function save($u, $clave)
    {
        $q = "INSERT INTO personas (nombre, apellido, genero, nacimiento, estatura, pesodeseado, usuario, clave) ";
        $q.= "VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $query = self::$conexion->prepare($q);
        $query->bind_param("ssssidss", $u->getNombre(), $u->getApellido(), $u->getGenero(), 
                                       $u->getNacimiento(), $u->getEstatura(), $u->getPesoDeseado(),
                                       $u->getUsuario(), password_hash($clave, PASSWORD_DEFAULT));

        if ( $query->execute() ) {
            // Retornamos el id del usuario recién insertado.
            return self::$conexion->insert_id;
        }
        else {
            return false;
        }
    }

    public function actualizarUsuario($u, $clave)
    {   
        /* Se guardan los resultados de los geters en variables para luego ser utilizados en blind_param,
        en vez de ejecutar los geters directamente en blind_param.
        De esta manera se soluciona el error "Only variables should be passed by reference" */
        $nombre = $u->getNombre();
        $apellido = $u->getApellido();
        $genero = $u->getGenero();
        $nacimiento = $u->getNacimiento();
        $estatura = $u->getEstatura();
        $pesodeseado = $u->getPesoDeseado();
        $nombreUsuario = $u->getUsuario();
        $id = $u->getId();
        $claveNueva = password_hash($clave, PASSWORD_DEFAULT);
        
        $q = "UPDATE personas SET nombre = ?, apellido = ?, genero =?, nacimiento = ?, estatura = ?, pesodeseado = ?, usuario = ?, clave = ? WHERE idpersona = ?";
        $query = self::$conexion->prepare($q);
        $query->bind_param("ssssidssi", $nombre, $apellido, $genero, 
                                        $nacimiento, $estatura, $pesodeseado,
                                        $nombreUsuario, $claveNueva, $id);
        
        if ( $query->execute() ) {
            return true;
        }
        else {
            return false;
        }
    }
}   
?>