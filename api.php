<?php 
include('clases/Database.php');
// * clase Database

include('src/api_functions.php');
// * insert($campos, $tabla)
// * update ($campos, $tabla)
// * delete ($campos, $tabla)
// * getInput()

include('src/sql_functions.php');
// * getTypeCampo($db, $tabla)
// * getCampos($tipos)

include ('src/variables.php');
// variable $nombreDB;
// variable $tabla;

$db = new Database($nombreDB);

$metodo = $_SERVER['REQUEST_METHOD'];

$cabecera = header('content-type: application/json');

$tipos = getTypeCampo($db, $nombreDB, $tabla); // consulta la tabla y devuele los campos con su tipo de datos.
$campos = getCampos($tipos); //almacena una lista con el nombre de los campos de la tabla.
$id_auto = isAutoIncrement($db,$nombreDB);


switch ($metodo) {
    case 'GET':
        $getData = $db->listar($tabla);
        
        $cabecera;
        echo json_encode($getData);
        break;

    case 'POST':
        $data = getInput(); // datos extraidos en formato URL
        $postQuery = insert($campos, $tabla, $id_auto); // genera la consulta SQL
        $status = $db->query($postQuery, $data);
        $cabecera; //prepara el header para datos JSON
        echo json_encode(['status' => $status]);
        break;
    
    case 'PUT':
        $data = getInput(); // datos extraidos en formato URL 
        $id = array_shift($data);
        array_push($data, $id);
        $updateQuery = update($campos, $tabla); // genera la consulta SQL
        $status = $db->query($updateQuery, $data);
        $cabecera; //prepara el header para datos JSON
        echo json_encode(['status' => $status]);
        break;

    case 'DELETE':
        $data = getInput(); // datos extraidos en formato URL
        $deleteQuery = delete($campos, $tabla); // genera la consulta SQL
        $status = $db->query($deleteQuery, $data);
        $cabecera; //prepara el header para datos JSON
        echo json_encode(['status' => $status]);
        break;

}