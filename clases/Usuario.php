<?php
class Usuario
{
    protected $id;
    protected $usuario;
    protected $nombre;
    protected $apellido;
    protected $genero;
    protected $nacimiento;
    protected $estatura;
    protected $pesodeseado;

    public function __construct($usuario, $nombre, $apellido, $genero, $nacimiento, $estatura, $pesodeseado, $id = null)
    {
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->genero = $genero;
        $this->nacimiento = $nacimiento;
        $this->estatura = $estatura;
        $this->pesodeseado = $pesodeseado;
        $this->id = $id;
       
    }

    public function getId() { return $this->id;}
    public function setId($id) { $this->id = $id;}
    public function getUsuario() {return $this->usuario;}
    public function setUsuario($usuario) {$this->usuario = $usuario;}
    public function getNombre() {return $this->nombre;}
    public function setNombre($nombre) { $this->nombre = $nombre;}
    public function getApellido() {return $this->apellido;}
    public function setApellido($apellido) {$this->apellido = $apellido;}
    public function getNombreApellido() {return "$this->nombre $this->apellido";}
    public function getGenero() {return $this->genero;}
    public function setGenero($genero) {$this->genero = $genero;}
    public function getNacimiento() {return $this->nacimiento;}
    public function setNacimiento($nacimiento) {$this->nacimiento = $nacimiento;}
    public function getEstatura() {return $this->estatura;}
    public function setEstatura($estatura) {$this->estatura = $estatura;}
    public function getPesoDeseado() {return $this->pesodeseado;}
    public function setPesoDeseado($pesoDeseado) {$this->pesodeseado = $pesoDeseado;}
    public function __toString() {return "Usuario: $this->usuario 
                                          Nombre: $this->nombre 
                                          Apellido: $this->apellido 
                                          Genero: $this->genero 
                                          Nacimiento: $this->nacimiento 
                                          Estatura: $this->estatura 
                                          Peso Deseado: $this->pesodeseado 
                                          ID: $this->id";}
}





