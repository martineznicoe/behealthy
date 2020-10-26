<?php
require_once 'Usuario.php';
require_once 'Registro.php';
require_once 'RepositorioUsuario.php';
require_once 'RepositorioRegistro.php';

class ControladorSesion
{
    protected $usuario = null;

    public function login($nombre_usuario, $clave)
    {
        $repo = new RepositorioUsuario();
        $usuario = $repo->login($nombre_usuario, $clave);
        //Si falló el login:
        if ($usuario === false) {
            return [false, "Error de credenciales"];
        }
        else {
            session_start();
            $_SESSION['usuario'] = serialize($usuario);
            return [true, "Usuario autenticado correctamente"];
        }
    }
    
    /* Se crea un nuevo usuario llamando a la función save
       del repositoUsuario */
    public function create($nombre_usuario, $clave, $nombre, $apellido, $genero, $nacimiento, $estatura, $pesodeseado)
    {
        $repo = new RepositorioUsuario();
        $usuario = new Usuario($nombre_usuario, $nombre, $apellido, $genero, $nacimiento, $estatura, $pesodeseado);
        $id = $repo->save($usuario, $clave);
        if ($id === false) {
            return [ false, "Error al crear el usuario"];
        }
        else {
            $usuario->setId($id);
            session_start();
            $_SESSION['usuario'] = serialize($usuario);
            return [ true, "Usuario creado correctamente" ];
        }
    }

    /* Se actualizan los datos del perfil del usuario llamando a la función actualizarUsuario
       del repositoUsuario */
    public function actualizar($nombre_usuario, $clave, $nombre, $apellido, $genero, $nacimiento, $estatura, $pesodeseado, $id)
    {
        $repo = new RepositorioUsuario();
        $usuario = new Usuario($nombre_usuario, $nombre, $apellido, $genero, $nacimiento, $estatura, $pesodeseado, $id);
        $a = $repo->actualizarUsuario($usuario, $clave);
        if ($a === false) {
            return [ false, "Error al actualizar los datos"];
        }
        else {
            return [ true, "Datos actualizados correctamente"];
        }
    }

    /* Se registra un peso nuevo llamando a la función nuevoRegistro
       del repositoRegistro */
    public function registrar($fecha, $peso, $idpersona)
    {
        $repo = new RepositorioRegistro();
        $registro = new Registro($fecha, $peso, $idpersona);
        $idregistro = $repo->nuevoRegistro($registro);
        if ($idregistro === false) {
            return [ false, "Error al crear el registro"];
        }
        else {
            $registro->setId($idregistro);
            
            return [ true, "Registro creado correctamente" ];
        }
    }

    /* Se trae la lista de registros de peso y fecha del usuario llamando a la función consultaRegistros
       del repositorioRegistros */
    public function getRegistros($idpersona)
    {
        $repo = new RepositorioRegistro();
        $listaRegistros = $repo->consultaRegistros($idpersona);
        if ($listaRegistros === false) {
            return [ false, "Error al cargar registros."];
        }
        else {
            return $listaRegistros;
        }
    }

    public function eliminarRegistro($idRegistro)
    {
        $repo = new RepositorioRegistro();
        $respuesta = $repo->delRegistro($idRegistro);
        if ($respuesta === false) {
            return [ false, "Error al eliminar el registro."];
        }
        else {
            return $respuesta;
        }
    }

}
