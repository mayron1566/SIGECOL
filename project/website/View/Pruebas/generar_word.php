<?php

// crear objeto para pdf
$pdf = new View_Helper_Prueba('P','mm','Letter');

// generar pruebas
for ($i=0; $i<$pruebas_cantidad; ++$i) {
    $pdf->generar([
        'materia' => $materia,
        'titulo' => $titulo,
        'autor' => $autor,
        'organizacion' => $organizacion,
        'fecha' => $fecha,
        'descuento' => $descuento,
        'preguntas'=> $preguntas,
        'version' => strtoupper(\sowerphp\core\Utility_String::random(6)),
    ], $pdf);
}

// enviar pdf al navegador
$filename = \sowerphp\core\Utility_String::normalize($materia.' '.$titulo).'.pdf';
$content = shell_exec('/usr/local/bin/pdftotext '.$filename.' -');
require_once '../../classes/CreateDocx.inc';

$docx = new CreateDocx();
$textInfo = $content;

$paramsTextInfo = array(
    'val' => 1,
    'i' => 'single',
    'sz' => 8
);

$docx->addText($textInfo, $paramsTextInfo);

$docx->createDocx('report.docx');
exit(0);
