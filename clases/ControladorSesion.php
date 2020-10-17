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

    public function actualizar($nombre_usuario, $clave, $nombre, $apellido, $genero, $nacimiento, $estatura, $pesodeseado, $id)
    {
        $repo = new RepositorioUsuario();
        $usuario = new Usuario($nombre_usuario, $nombre, $apellido, $genero, $nacimiento, $estatura, $pesodeseado, $id);
        $a = $repo->actualizarUsuario($usuario);
        if ($a === false) {
            return [ false, "Error al actualizar los datos"];
        }
        else {
            return [ true, "Datos actualizados correctamente"];
        }
    }

    public function registrar($fecha, $peso, $idpersona)
    {
        $repo = new RepositorioRegistro();
        $registro = new Registro($fecha, $peso, $idpersona);
        $id = $repo->nuevoRegistro($registro);
        if ($id === false) {
            return [ false, "Error al crear el registro"];
        }
        else {
            $registro->setId($idregistro);
            return [ true, "Registro creado correctamente" ];
        }
    }
}
