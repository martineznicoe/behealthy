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

    public function actualizarUsuario($u)
    {   
        
        $q = "UPDATE personas SET nombre = ?, apellido = ?, genero =?, nacimiento = ?, estatura = ?, pesodeseado = ?, usuario = ?, clave = ? WHERE idpersona = ?";
        $query = self::$conexion->prepare($q);
        $query->bind_param("ssssidssi", $u->getNombre(), $u->getApellido(), $u->getGenero(), 
                                        $u->getNacimiento(), $u->getEstatura(), $u->getPesoDeseado(),
                                        $u->getUsuario(), password_hash($clave, PASSWORD_DEFAULT), $u->getId());
        
        if ( $query->execute() ) {
            return true;
        }
        else {
            return false;
        }
    }
}   
?>