<?php 

// Función que devuelve un string SQL preparado para insertar en la BBDD
function insert($campos, $tabla, $autoIncrement){
    if ($autoIncrement){
        array_shift($campos); // Si el campo del id es auto_increment no lo necesitamos en el insert.
    }
    $lista = implode(", ", $campos);
    $interrogantes = array_fill(0, count($campos), "?");
    $marks = implode(", ", $interrogantes);
    $string = "INSERT INTO $tabla ($lista) VALUES ($marks)";
    return $string;
}

// Función que devuelve un string SQL preparado para la actualización de un elemento seleccionado por su 'clave_unica' de la BBDD.
function update ($campos, $tabla){
    $id = array_shift($campos);
    $lista = implode(" = ? , ", $campos);
    $lista = $lista . " = ?";

    $string = "UPDATE $tabla SET $lista WHERE $id = ?";
    return $string;
}

// Función que devuelve un string SQL preparado para eliminar un elemento seleccionado por su 'clave_unica' de la BBDD.
function delete ($campos, $tabla){
    $id = array_shift($campos);
    $string = "DELETE FROM $tabla WHERE $id = ?";

    return $string;
}

// Devuelve un array con los valores de los campos extraidos de un string formateado en forma de URL.
function getInput() {
    parse_str(file_get_contents('php://input'), $data);
    //return $data;
    $inputs = [];
    foreach ($data as $valor){
        $inputs[] = $valor;
    }
    return $inputs;
}