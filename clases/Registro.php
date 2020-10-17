<?php
class Registro
{
    protected $idregistro;
    protected $fecha;
    protected $peso;
    protected $idpersona;
    
    public function __construct($fecha, $peso, $idpersona=null, $idregistro=null)
    {
        $this->idregistro = $idregistro;
        $this->fecha = $fecha;
        $this->peso = $peso;
        $this->idpersona = $idpersona;
    }

    public function getId() { return $this->idregistro;}
    public function setId($idregistro) { $this->idregistro = $idregistro;}
    public function getFecha() {return $this->fecha;}
    public function getPeso() {return $this->peso;}
    public function getIdPersona() { return $this->idpersona;}
}

