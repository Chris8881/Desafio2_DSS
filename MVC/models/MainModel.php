<?php
require_once "beans/PersonaBean.php";
require_once "beans/OcupacionBean.php";

class MainModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function listaPersonas()
    {
        $query = "SELECT * FROM persona a INNER JOIN ocupaciones o ON a.id_ocupacion = o.id_ocupacion";
        $conexion = $this->con->conectar();
        $resultado = $conexion->prepare($query);
        $resultado->execute();

        $array = array();
        while ($row = $resultado->fetch()) {
            $persona = new PersonaBean();
            $ocupacion = new OcupacionBean();

            $persona->setIdPersona($row['id_persona']);
            $persona->setNombre($row['nombre_persona']);
            $persona->setEdad($row['edad_persona']);
            $persona->setTelefono($row['telefono_persona']);
            $persona->setSexo($row['sexo_persona']);
            $persona->setFecha($row['fecha_nac']);

            $ocupacion->setOcupacion($row['ocupacion']);
            $ocupacion->setIdOcupacion($row['id_ocupacion']);

            $persona->setOcupacion($ocupacion);
            $array[] = $persona;
        }
        $this->con->desconectar($conexion);
        return $array;
    }

    function agregarPersona($nombre, $edad, $telefono, $sexo, $ocupacion, $fecha)
    {
        $query = "INSERT INTO persona (nombre_persona, edad_persona, telefono_persona, sexo_persona, id_ocupacion, fecha_nac) 
                  VALUES (:nombre, :edad, :telefono, :sexo, :ocupacion, :fecha)";

        $conexion = $this->con->conectar();
        $stmt = $conexion->prepare($query);
        $success = $stmt->execute([
            ':nombre' => $nombre,
            ':edad' => $edad,
            ':telefono' => $telefono,
            ':sexo' => $sexo,
            ':ocupacion' => $ocupacion,
            ':fecha' => $fecha
        ]);
        $this->con->desconectar($conexion);
        return $success;
    }

    function modificarPersona($id, $nombre, $edad, $telefono, $sexo, $ocupacion, $fecha)
    {
        $query = "UPDATE persona SET nombre_persona = :nombre, edad_persona = :edad, 
                  telefono_persona = :telefono, sexo_persona = :sexo, id_ocupacion = :ocupacion, 
                  fecha_nac = :fecha WHERE id_persona = :id";
        $conexion = $this->con->conectar();
        $stmt = $conexion->prepare($query);
        $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':edad' => $edad,
            ':telefono' => $telefono,
            ':sexo' => $sexo,
            ':ocupacion' => $ocupacion,
            ':fecha' => $fecha
        ]);
        $this->con->desconectar($conexion);
    }

    function eliminarPersona($id)
    {
        $query = "DELETE FROM persona WHERE id_persona = :id";
        $conexion = $this->con->conectar();
        $stmt = $conexion->prepare($query);
        $stmt->execute([':id' => $id]);
        $this->con->desconectar($conexion);
    }


    function obtenerPersona($id = null)
    {
        // Si no hay ID, buscamos el primero para evitar errores en la vista
        $query = ($id) ? "SELECT * FROM persona WHERE id_persona = :valor" : "SELECT * FROM persona LIMIT 1";

        $conexion = $this->con->conectar();
        $stmt = $conexion->prepare($query);
        if ($id) $stmt->bindParam(':valor', $id);

        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $persona = new PersonaBean();
            $persona->setIdPersona($row['id_persona']);
            $persona->setNombre($row['nombre_persona']);
            $persona->setEdad($row['edad_persona']);
            $persona->setTelefono($row['telefono_persona']);
            $persona->setSexo($row['sexo_persona']);
            $persona->setFecha($row['fecha_nac']);

            $ocupacion = new OcupacionBean();
            $ocupacion->setIdOcupacion($row['id_ocupacion']);
            $persona->setOcupacion($ocupacion);
            $this->con->desconectar($conexion);
            return $persona;
        }
        $this->con->desconectar($conexion);
        return null;
    }

    function listaOcupaciones()
    {
        $query = "SELECT * FROM ocupaciones";
        $conexion = $this->con->conectar();
        $resultado = $conexion->prepare($query);
        $resultado->execute();
        $array = array();
        while ($row = $resultado->fetch()) {
            $ocupacion = new OcupacionBean();
            $ocupacion->setOcupacion($row['ocupacion']);
            $ocupacion->setIdOcupacion($row['id_ocupacion']);
            $array[] = $ocupacion;
        }
        $this->con->desconectar($conexion);
        return $array;
    }
}
