<h1><?php 
if(isset($_Auth) and $_Auth->logged()){
//echo "Profesor: ".$nombre; cambiado por experimentacion
echo "Listado de Resultado de evaluaciones"; ?></h1>
<script type="text/javascript">
$(function() {
    var url = document.location.toString();
    if (url.match('#')) {
        console.log($('.panel-title a[href=#'+url.split('#')[1]+']'));
        $('#'+url.split('#')[1]).collapse('show');
    }
});
</script>
<p>Seleccione una prueba para ver resultados:</p>
<div class="panel-group" id="categorias" role="tablist" aria-multiselectable="true">
<?php
$aux=0;
$aux2=0;
$aux3=0;
$auxtext=0;
$sumador=0;
$contador=0;
$compara='0';
$comparanombre='0';
$comparatexto='0';
$comparante='0';
$puntajeTotal=0;
$nombreaperllido=array();
$total_prueba=0;
$datos = array(array());
$puntosportexto=array();
$context=array();
$media= array();
$mediana=array();
$moda= array();
$desviacion=array();

// mostrar cada categoria y buscar sus pruebas

    // id para la categoría
    $id = \sowerphp\core\Utility_String::normalize('resultados-prueba'.'-'.$pruebaid);
	    echo '<div style= "overflow: scroll; border: silver 10px solid; border-image-slice: 21; padding: 10px; height: auto; max-height: 900px; width:1024px;">';
//se guarda el id de la primera pregunta y se incrementa aux hasta que se vuelva a repetir el id de la primera pregunta7
    echo '<table id = "tabla_excel" class="table">',"\n";
    echo '<thead><tr><th>Alumno</th><th>Colegio</th><th>Fecha</th>';
    $k=0;
    foreach($porpregunta as &$a){ 
	if ($compara=='0'){ 
		$comparatexto=$a['id_texto'];
		$compara=$a['id'];
		++$aux;
		++$auxtext;
		echo '<th>Texto '.$auxtext.' - Pregunta '.$aux.'</th>';
		}
	else if ($compara==$a['id']){
		echo '<th>Puntaje total texto '.$auxtext.'</th>';
		$media[$k]=0;
		$k++;
		break;
		}
	else if ($comparatexto==$a['id_texto']){
		++$aux;
		echo '<th>Texto '.$auxtext.' - Pregunta '.$aux.'</th>';
		}

	else  {
		echo '<th>Puntaje total texto '.$auxtext.'</th>';
		++$auxtext;
		$aux=1;
		$comparatexto=$a['id_texto'];
		echo '<th>Texto '.$auxtext.' - Pregunta '.$aux.'</th>';
		}
	$aux2++;

	}
	$k=0;
//calcula puntaje por texto
	$comparatexto='0';
	$firsttext='';
	foreach($porpregunta as &$a){
	if ($comparatexto=='0'){ 
		$contador+=1;
		$comparatexto=$a['id_texto'];
		$firsttext=$a['id_texto'];
		$comparante=$comparatexto;
		$sumador+=$a['puntos'];
		}
	else if ($comparatexto==$a['id_texto']){
		$contador+=1;
		$comparante=$comparatexto;
		$sumador+=$a['puntos'];
		}
	
	else  {
		$context[$k]=$contador;
		$puntosportexto[$k]=$sumador;
		$sumador=0;
		$contador=0;
		$k++;
		$comparante='0';
		$contador+=1;
		$sumador+=$a['puntos'];
		$comparatexto=$a['id_texto'];
		}

	}
    $context[$k]=$contador;
    $puntosportexto[$k]=$sumador;
    $contador=0;
    $k=0;
    $i=0;
    $j=0;

//guarda datos en matriz
     foreach($porpregunta as &$resultados) {
	$datos[$i][$j]= $resultados['puntos'];
	$j++;
	if ($i == $aux2) $i++;
	}


    echo '<th>Puntaje total</th><th>Porcentaje de logro</th></tr></th></thead><tbody>',"\n";
    $i=0;
    $j=0;
    $w=0;
    $x=0;
    $nom='';
    $ape= '';
    $contaddor_posicion=0; 
    foreach($porpregunta as &$resultados) {
	if ($i==0){
		$nombreapellido = explode(' ', $resultados['nombre']);
		$nom=$nombreapellido[0];
		for ($x=1; $x<count($nombreapellido); $x++){
			$ape.=$nombreapellido[$x];
		}
		echo '<tr id="',$resultados['nombre'],'">',"\n"; 
        	echo '<td>',$nom,'</td>',"\n";
		echo '<td>',$ape,'</td>',"\n";
		echo '<td>',$resultados['fecha_resolucion'],'</td>',"\n";
		$ape='';
		$nom='';
		}
        echo '<td>',$resultados['puntos'],'</td>',"\n";
	$puntajeTotal += $resultados['puntos'];
	$datos[$j][$w]=$resultados['puntos']; //guarda los resultados por pregunta y por textos en una matriz para ser usados para el calculo estadistico
	$media[$w]=0;	
	$contador+=1;
	$i++;
	++$w;
	if ($context[$k] == $contador){
		echo '<td>',$puntosportexto[$k],'</td>',"\n";
		$datos[$j][$w]=$puntosportexto[$k];
		$media[$w]=0;
		$contador=0;
		$w++;
		++$k;
		}
	if ($resultados['reordenar']=='true') {
		$total_prueba+=8;
		}
	else{ 
		$total_prueba+=2;
		}
	if ($i == $aux2){
		echo '<td>',$puntajeTotal,'</td>',"\n";
		$media[$w]=0;
		$datos[$j][$w]=$puntajeTotal;
		++$w;
		echo '<td>',(int)(($puntajeTotal*100)/$total_prueba),'%</td>',"\n";
		$datos[$j][$w]=(int)(($puntajeTotal*100)/$total_prueba);
		$media[$w]=0;
		++$w;
		$aux3=$w;	
		$i=0;
		$w=0;
		$j++;	
		$puntajeTotal=0;
		$total_prueba=0;
		}
	}
	$k=0;
	//caluclo de la media
	echo '<tr id="media',$resultados['nombre'],'">',"\n"; 
	echo '<th></th>';
	echo '<th></th>';
	echo '<th>Media</th>';
	for ($x=0; $x<$aux3; $x++){
		for($i=0; $i<$j; $i++){
			$media[$k]+=$datos[$i][$x];
			}
		echo '<th>'.$media[$k]/$j.'</th>';
		$k++;		
		}

	$k=0;
	//calculo de la moda
	echo '<tr id="moda',$resultados['nombre'],'">',"\n"; 
	echo '<th></th>';
	echo '<th></th>';
	echo '<th>Moda</th>';
	for ($x=0; $x<$aux3; $x++){
		for($i=0; $i<$j; $i++){
			array_push($moda, $datos[$i][$x]);
			}
			$mod=array_count_values($moda);
			arsort($mod);
			echo '<th>'.key($mod).'</th>';
			$moda=array();
		
		}

	$k=0;
	//calculo de la mediana
	echo '<tr id="mediana',$resultados['nombre'],'">',"\n"; 
	echo '<th></th>';
	echo '<th></th>';
	echo '<th>Mediana</th>';
	for ($x=0; $x<$aux3; $x++){
		for($i=0; $i<$j; $i++){
			array_push($mediana, $datos[$i][$x]);
			}
		sort($mediana);
		$con = count($mediana);
		$middleval = floor(($con-1)/2);
		if($con % 2) {
			$median = $mediana[$middleval];
		} else {
			$low = $mediana[$middleval];
			$high = $mediana[$middleval+1];
			$median = (($low+$high)/2);
		}
		echo '<th>'.$median.'</th>';	
		$mediana=array();
		}

	$k=0;
	//calculo desviacion estandar
	echo '<tr id="desviacion',$resultados['nombre'],'">',"\n"; 
	echo '<th></th>';
	echo '<th></th>';
	echo '<th>Desviacion Estandar</th>';
	for ($x=0; $x<$aux3; $x++){
		for($i=0; $i<$j; $i++){
			array_push($desviacion, $datos[$i][$x]);
			}
		$sum=0;
		for($i=0;$i<count($desviacion);$i++){
			$sum+=$desviacion[$i];
			}
		$media2 = $sum/count($desviacion);
		$sum2=0;
		for($i=0;$i<count($desviacion);$i++){
			$sum2+=($desviacion[$i]-$media2)*($desviacion[$i]-$media2);
		}
		
		$vari = $sum2/count($desviacion);
		$sq = sqrt($vari);
		echo '<th>'.number_format ( $sq , $decimals = 4).'</th>';	
		$desviacion=array();
		}
	}
        echo '</td>',"\n";
        echo '</tr>',"\n\n";
        echo '</tbody></table>',"\n";
	$aux2++;
echo '</div>';
?>
