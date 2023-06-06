<?php 

/**
 * Función para crear un formulario con unos campos determinados
 */
function generarFormulario($method, $fields=[]) {
    $form = '<form method="GET">';
    $form .= '<input type="hidden" name="metodo" value="'. $method .'">';
    foreach ($fields as $name => $type) {
        $form .= '<label for="' . $name . '">' . ucfirst($name) . ':</label>';
        if ($type == 'decimal') {
            $form .= '<input required type="number" step="0.01" name="' . $name . '" id="' . $name . '"><br>';
        } elseif ($type == 'int'){
            $form .= '<input required type="number" required name="' . $name . '" id="' . $name . '"><br>';
        } else {
            $form .= '<input required type="' . $type . '" name="' . $name . '" id="' . $name . '"><br>';
        }
    }
    $form .= '<input type="submit" value="Enviar">';
    $form .= '</form>';
    return $form;
}

/**
 * Devuelve una <table> HTMl con los datos obtenidos de la api.
 */
function creaTabla($campos, $data){
    $table = "<table>";
    $table .= "<tr>";
    foreach ($campos as $campo){
        $table .= "<th>" . $campo . "</th>";
    }
    $table .= "</tr>";
    foreach ($data as $item){
        $table .= "<tr>";
        foreach ($campos as $campo){
            $table .= "<td>" . $item->$campo . "";
        }
        $table .= "</tr>";
    }
    $table .= "</table>";
    return $table;
}

/**
 * Devuelve los datos de la api tipo JSON
 * 
 * @param string $url Es la URL de la api.php donde se realiza la petición.
 * @return object $respuesta Devuelve un objeto JSON.
 */
function getData($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($curl);
    curl_close($curl);

    return $respuesta;
}

/**
 * Ejecuta la acción determinada por el método
 * 
 * @param string $method == 'POST' introduce datos.
 *               $method == 'PUT' actualiza los datos por el id del objeto.
 *               $method == 'DELETE' Elimina el objeto identificado por el id.
 * 
 * @param string $url Es la URL de la api donde se realiza la petición.
 * @param string $datos cadena tipo url de consulta.
 * 
 * @return object $respuesta Objeto JSON de éxito o error. 
 */
function setData($method, $url, $datos) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $datos);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $respuesta = curl_exec($curl);
    curl_close($curl);

    return $respuesta;
}