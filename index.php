<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="node_modules/bootstrap5/src/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="node_modules/font-awesome/css/font-awesome.min.css">
</head>
<body>

    <div class="container">
        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Ciudad</th>
                    <th>Estado</th>
                </tr>
            </thead>
        </table>
    </div>

    <?php
    if (!function_exists('Encriptar')) {
        function Encriptar($valor)
        {
            $Sc = base64_decode("keyMaster");
            $Texto = urlencode(openssl_encrypt($valor, "AES-256-CBC", $Sc));
            return $Texto;
        }
    }

    $datatableDinamico = json_encode([
        "consulta" => Encriptar(json_encode([
            "from" => "ciudad, (SELECT estado FROM estados AS e WHERE e.id_estado = c.id_estado) AS estado",
            "tabla" => "ciudades AS c",
            "where" => "",
            "order" => "ORDER BY {order}"
        ])),
        "funcionMaster" => Encriptar(json_encode([
            // {doctor} => ACCEDE A VALOR ORIGINAL
            // doctor => ACCEDE A VALOR ALTERADO
            // VALORES ALTERADOS SE PROPAGAN DE ARRIBA HACIA ABAJO
            // "doctor" => [
            // [valorfiltrar, campoFiltrar, campoSelect, tablaFiltrar, separador]
            // ['{doctor}', 'ID', 'NOMBRE_USUARIO', 'usuarios', '||']
            // ],
        ])),
        "columnas" => Encriptar(json_encode([
            'ciudad',
            'estado:ns',
        ]))
    ]);
    ?>

    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap5/src/js/bootstrap.bundle.min.js"></script>
    <script src="node_modules/datatables.net/js/dataTables.min.js"></script>
    <script src="node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="node_modules/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="src/js/DTCmpserverSide.js"></script>
    <script type="text/javascript">
        let datatableDinamico = "<?= base64_encode($datatableDinamico) ?>";
    </script>
    <script src="src/js/index.js"></script>
</body>

</html>