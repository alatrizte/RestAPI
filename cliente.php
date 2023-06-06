<?php 
include ('clases/Database.php');
// * Clase Database

include ('src/sql_functions.php');
// * getTypeCampo($db, $tabla)
// * getCampos($tipos)

include ('src/client_functions.php');
// * generarFormulario($method, $fields=[])
// * creaTabla($campos, $data)
// * getData($url)
// * setData($method, $url, $datos)

include ('src/variables.php');
// variable $nombreDB;

$db = new Database($nombreDB);

//// IMPORTANTE!!!! ESTA URL APUNTA A LA DIRECCION DE LA API ////
$url_api = 'http://localhost/unidad_08/RestAPI/api.php';

$tipos = getTypeCampo($db, $nombreDB, $tabla);
$campos = getCampos($tipos);
$id_auto = isAutoIncrement($db, $nombreDB);

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $queryString = $_SERVER['QUERY_STRING']; // cadena donde se muestran las consulas.
    // Eliminamos la primera variable metodo=['metodo']
    $cadenaDatos = substr(strstr($queryString, '&'), 1);

    if (isset ($_GET['metodo'])){
        switch ($_GET['metodo']){

            case 'get':
                $data = json_decode(getData($url_api));
                $table = creaTabla($campos, $data);
                break;

            case 'post':
                $data = json_decode(setData('POST', $url_api, $cadenaDatos));
                if ($data->status == true){
                    echo "INSERT realizado con éxito";
                } else {
                    echo "Acción INSERT sin respuesta positiva";
                }
                break;

            case 'put':
                $data = json_decode(setData('PUT', $url_api, $cadenaDatos));
                if ($data->status == true){
                    echo "UPDATE realizado con éxito";
                } else {
                    echo "Acción UPDATE sin respuesta positiva";
                }
                break;

            case 'delete':
                $data = json_decode(setData('DELETE', $url_api, $cadenaDatos));
                if ($data->status == true){
                    echo "DELETE realizado con éxito";
                } else {
                    echo "Acción DELETE sin respuesta positiva";
                } 
                break;
        }
    }
}

echo "<div id='listadoForm'>";
echo "<h1>LISTADO</h1>";
echo isset($table) ? $table : '';
echo generarFormulario('get');
echo "</div>";

echo "<div id='updateForm'>";
echo "<h1>UPDATE</h1>";
echo generarFormulario('put', $tipos);
echo "</div>";

echo "<div id='insertForm'>";
echo "<h1>INSERT</h1>";
$insertFieds = $id_auto ? array_slice($tipos, 1) : $tipos; // Si el ID es auto_increment no lo necesitamos en el formulario.
echo generarFormulario('post', $insertFieds);
echo "</div>";

echo "<div id='deleteForm'>";
echo "<h1>DELETE</h1>";
$idFiled = array_slice($tipos, 0,1);
echo generarFormulario('delete', $idFiled);
echo "</div>";

?>

