<?php
ob_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <h1>Reporte de compra</h1>
    <div class="card">
        <div class="card-body">
            <ul style="list-style: none;">
                <li><b>Fecha:</b><?= $data['pdf']['data']['fecha'] ?></li>
                <li><b>Cantidad:</b><?= $data['pdf']['data']['quantity'] ?></li>
                <li><b>Precio del producto:</b><?= $data['pdf']['data']['price'] ?></li>
                <li><b>Total compra:</b><?= $data['pdf']['data']['total'] ?></li>
            </ul>
        </div>
    </div>
</body>

</html>

<?php
$html = ob_get_clean();
// echo $html;

require_once 'Libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new Dompdf();

//Activando las opciones para que se puedan renderizar imagenes en el pdf
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

// $dompdf->setPaper('A4','landscape');
$dompdf->setPaper('letter');

$dompdf->render();

//Recibe como parametros el nombre del archivo y el segundo poarametro si se pasa un valor de falso el pdf se mostrara en el navegador si no se descargara inmediatamente
$dompdf->stream('archivo.pdf', array('Attachment' => false));
