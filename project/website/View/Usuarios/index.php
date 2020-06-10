<?php 
if(!isset($usuario)){
  if(isset($usuarios)){
?><h1>Instrucciones Prueba</h1>
<?php

$contador=0;
$id_prueba;
$descripcion;
$id_profesor;
foreach($usAct as &$prueba) {
    $contador++;
    $id_prueba= $prueba['id'];
    $descripcion= $prueba['descripcion'];
    $id_profesor= $prueba['id_profesor'];
    echo '<br/>';
    unset($prueba['id']);
}

if ($contador==1){ echo $descripcion; echo '<br />'; echo '<a href="',$_base,'/r/',$id_prueba,'" title="Resolver en línea">>>>Resolver evaluacion ahora.</a>',"\n";}
else if ($contador>1){header("location:/u/".$user."");}
     else{
	echo 'Actualmente tu profesor no cuenta con pruebas disponibles. Ponerse en contacto con su profesor correspondiente o de ser un error del sistema escribir al correo soporte.sigecol@gmail.com.';
	}

	}
}

?>
