<?php
// CODIGO DATATABLE DINAMICO ACTUALIZADO
// V1.3
error_reporting(E_ALL & ~E_WARNING);
date_default_timezone_set('America/Caracas');

if (isset($_POST['key']) && $_POST['key'] == 'unLock') {
    include "./config.php";

    $localhost = HOST_MYSQL;
    $username = USER_MYSQL;
    $password = PASS_MYSQL;

    $conn3 = mysqli_connect($localhost, $username, $password, DB_MYSQL) or die("Connection failed: " . mysqli_connect_error());


    if (!function_exists('dataTable_funcionMaster')) {
        function dataTable_funcionMaster($conn3, $params = [
            "select" => "campoObtener",
            "tabla" => "tabla",
            "campo" => "campoFiltrar",
            "value" => "valorFiltrar"
        ])
        {
            $query = mysqli_query($conn3, "SELECT {$params['select']} FROM {$params['tabla']} WHERE 
            {$params['campo']} = '{$params['value']}' ORDER BY {$params['campo']} LIMIT 1");
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    return $row[$params['select']];
                }
            } else {
                return $params['value'];
            }
        }
    }
    
    function Desencriptar($valor)
    {
        $Sc = base64_decode("keyMaster");
        $Texto = openssl_decrypt(urldecode($valor), "AES-256-CBC", $Sc);
        return $Texto;
    }

    // VARIABLES GLOBALES
    $consulta = (isset($_POST['option']['consulta']) ? json_decode(Desencriptar($_POST['option']['consulta']), true) : []);
    $funcionMaster = (isset($_POST['option']['funcionMaster']) ? json_decode(Desencriptar($_POST['option']['funcionMaster']), true) : []);
    $columnas = (isset($_POST['option']['columnas']) ? json_decode(Desencriptar($_POST['option']['columnas']), true) : []);

    $exceptionArea = [];
    foreach ($columnas as $key => $value) {
        // OBTENEMOS LAS COLUMNAS QUE NO DEBEN SER USADAS EN EL SEARCH
        if (preg_match("/:ns/", $value) == 1) {
            $columnas[$key] = str_replace(":ns", "", $value);
            $exceptionArea['ns'][] = $columnas[$key];
        }
    }

    // OBTENEMOS LAS COLUMNAS QUE CONTINEN LOS NOMBRES DE LOS CAMPOS
    $columnsData = [];
    foreach ($_POST['option']['columnasData'] as $key => $indice) {
        foreach ($indice as $clave => $value) {
            if (!empty($value) && $value != "undefined") {
                $columnsData[] = $value;
            }
        }
    }

    // REINICIAMOS EL CAMPO QUE SE USARA PARA ORDENAR SI SE SOBRE PASA DE LA CANTIDAD QUE EXISTE
    $_POST['order'][0]['column'] = ($_POST['order'][0]['column'] <= (count($columnsData) - 1) ? $_POST['order'][0]['column'] : 0);

    // REMPLAZAMOS EL {order} POR EL CAMPO QUE DEBE USAR PARA ORDENAR Y AGREGAMOS ASC O DESC
    $columnaOrdenar = $columnas[array_search($columnsData[$_POST['order'][0]['column']], $columnsData)];
    $consulta['order'] = str_replace("{order}", "{$columnaOrdenar} {$_POST['order'][0]['dir']}", $consulta['order']);

    // REMPLAZAMOS $0..9 POR LAS COLUMNAS A LAS QUE PERTENECE
    // foreach ($columnas as $key => $value) {
    // code..
    // }

    $busquedaPorCampo = array();
    foreach ($_POST['columns'] as $key => $value) {
        $_POST['columns'][$key]['search']['value'] = preg_replace("/[(|)]/", '', $_POST['columns'][$key]['search']['value']);
        if (!empty($_POST['columns'][$key]['search']['value'])) {
            $busquedaPorCampo[$_POST['columns'][$key]['data']] = $_POST['columns'][$key]['search']['value'];
        }
    }

    // ORDENAMOS LA BUSQUEDA
    $search = '';
    if (count($busquedaPorCampo) > 0) { // SI SE USA BUSCADORES PARA CADA CAMPO
        $search = (!empty($consulta['where']) ? 'AND ' : 'WHERE ') . "(";
        $indice = 0;
        foreach ($busquedaPorCampo as $key => $value) {
            $search .= "{$key} LIKE '%" . str_replace(" ", "%", $value) . "%'" . (($indice < (count($busquedaPorCampo) - 1)) ? " OR " : ")");
            $indice++;
        }
    } else if (!empty($_POST['search']['value'])) { // SI SE USA BUSCADOR GENERAL
        $search = implode(", ", array_filter($columnas, function ($value) use ($exceptionArea) {
            return !in_array($value, $exceptionArea['ns'] ?? []);
        }));
        $search = (!empty($consulta['where']) ? 'AND ' : 'WHERE ') . "CONCAT({$search}) LIKE '%" . str_replace(" ", "%", $_POST['search']['value']) . "%'";
    }

    // CONSULTAMOS LOS DATOS Y OBTENEMOS LA CANTIDAD DE REGISTROS EN TOTAL QUE OBTIENE LA BUSQUEDA
    $datos = mysqli_query($conn3, "SELECT {$consulta['from']} FROM {$consulta['tabla']} {$consulta['where']} {$search} {$consulta['order']} LIMIT {$_POST['start']}, {$_POST['length']}");
    $cuentaDatos = mysqli_query($conn3, "SELECT count(*) as cuentaRegistro FROM {$consulta['tabla']} {$consulta['where']} {$search} {$consulta['order']}");

    // echo "<pre>";
    // var_dump("SELECT {$consulta['from']} FROM {$consulta['tabla']} {$consulta['where']} {$search} {$consulta['order']} LIMIT {$_POST['start']}, {$_POST['length']}");
    // var_dump("SELECT count(*) as cuentaRegistro FROM {$consulta['tabla']} {$consulta['where']} {$search} {$consulta['order']}");
    // echo "</pre>";
    // exit();

    // NUMERO DE REGISTROS OBTENIDOS EN TOTAL POR LA CUENTA DE BUSQUEDA
    $rowCuentaDatos = mysqli_num_rows($cuentaDatos);
    // NUMERO DE REGISTROS OBTENIDOS EN TOTAL POR LA CONSULTA DE BUSQUEDA
    $rowCuentaData = mysqli_fetch_assoc($cuentaDatos);
    // NUMERO DE REGISTROS OBTENIDOS EN TOTAL POR LA CONSULTA
    $rowDatos = mysqli_num_rows($datos);

    // OBTENEMOS LOS DATOS DE LOS REGISTROS Y LOS PREPARAMOS
    $data = array();
    while ($rowData = mysqli_fetch_assoc($datos)) {
        $datosArray = [];

        if (count($funcionMaster) > 0) { // EN CASO DE TENEL FILTROS PARA FUNCIONMASTER
            $original = []; // GUARDAREMOS LOS VALORES ORIGINALES
            foreach ($funcionMaster as $campo => $filtros) { // RECORREMOS LOS CAMPOS CON FILTRO
                // SI EL CAMPO NO ESTA EN LOS VALORES ORIGINALES
                if (!in_array($campo, $original)) $original[$campo] = $rowData[$campo];

                foreach ($filtros as $indices => $filtro) { // RECORREMOS LOS FILTROS
                    // LISTAMOS LAS VARIABLES SEGUN LA POSICION DEL ARRAY
                    list($valorFiltrar, $campoFiltrar, $selectObtener, $tablaFiltrar, $separador) = $filtro;

                    if (preg_match("/\{.*\}/", $valorFiltrar)) { // SI EL VALOR A FILTRAR CONTIENE UN PATRON {XAMPLE}
                        $valorFiltrar = $original[preg_replace("/\{|\}/", "", $valorFiltrar)]; // BUSCAMOS EL VALOR ORIGINAL
                    } else { // SI EL VALOR A FILTRAR NO CONTIENE UN PATRON {XAMPLE}
                        $valorFiltrar = $rowData[$valorFiltrar]; // BUSCAMOS EL VALOR ALTERADO
                    }

                    $datoObtenido = dataTable_funcionMaster($conn3, [ // REALIZAMOS LA CONSULTA
                        "select" => $selectObtener, // CAMPO A OBTENER
                        "tabla" => $tablaFiltrar, // TABLA A FILTRAR
                        "campo" => $campoFiltrar, // CAMPO A FILTRAR
                        "value" => $valorFiltrar // VALOR A FILTRAR
                    ]);

                    // SI $separador NO ESTA VACIO, SE AGREGA EL SEPARADOR CONCATENANDO SU CONTENIDO
                    // SI $separador ESTA VACIO, SOLO SE GUARDA EL NUEVO VALOR
                    $rowData[$campo] = (!empty($separador) ? "{$rowData[$campo]}{$separador}{$datoObtenido}" : $datoObtenido);
                }
            }
        }

        foreach ($columnas as $key => $value) {
            $value = explode(".", $value);
            $value = $value[count($value) - 1];
            $datosArray[$value] = ($_POST['option']['caracter'] == "true" ? utf8_encode($rowData[$value]) : $rowData[$value]);
        }
        $data[] = $datosArray;
    }

    // PREPARAMOS TODOS LOS DATOS NECESIARIOS
    $json_data = array(
        // "prueba"          => "SELECT {$consulta['from']} FROM {$consulta['tabla']} {$consulta['where']} {$search} {$consulta['order']} LIMIT {$_POST['start']}, {$_POST['length']}",
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval(($rowCuentaDatos == 1 ? $rowCuentaData['cuentaRegistro'] : $rowCuentaDatos)),
        "recordsFiltered" => intval(($rowCuentaDatos == 1 ? $rowCuentaData['cuentaRegistro'] : $rowCuentaDatos)),
        "data"            => (count($data) == 0 ? array() : $data)
    );

    // ENVIAMOS TODOS LOS DATOS NECESIARIOS
    echo json_encode($json_data);
    exit();
}
