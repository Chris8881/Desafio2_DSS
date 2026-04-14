<?php 
require_once 'conexion.php';

class Model { 

    public $con;

    function __construct() { 
        // Instanciamos la clase conexión para que cada vez que accedamos a 
        // este constructor invoquemos una conexión diferente
        $this->con = new Database(); 
    } 

}

?>