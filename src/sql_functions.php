<?php 

// Función que devuelve un array con los tipos de variables de cada campo.
function getTypeCampo($db, $nombre, $tabla){
    $consulta = $db->queryData("SELECT COLUMN_NAME, DATA_TYPE FROM Information_Schema.COLUMNS WHERE table_schema = ? AND table_name = ? order by ORDINAL_POSITION", [$nombre, $tabla]);
    $listado = [];
    foreach ($consulta as $valor){
        $listado[$valor->COLUMN_NAME] = $valor->DATA_TYPE === 'varchar' ? 'text' : $valor->DATA_TYPE;
    }
    return $listado;
}

//Funcion que devuelve un array con el nombre de todos los campos de la tabla.
function getCampos($tipos){
    $campos = [];
    foreach ($tipos as $key=>$valor){
        $campos[] = $key;
    }
    return $campos;
}

// Función que devuelve TRUE o FALSE si el campo del primary Key es auto-increment.
function isAutoIncrement ($db, $nombre) {
    $consulta = $db->query("SELECT column_name FROM Information_schema.COLUMNS WHERE table_schema = ? AND extra='auto_increment'", [$nombre]);
    return $consulta;
}