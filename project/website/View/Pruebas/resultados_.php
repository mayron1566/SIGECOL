<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/js/tableexport.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/js/tableexport.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blob-polyfill/4.0.20190430/Blob.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.6/xls.core.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

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

$(document).ready(function(){
        $("#export_to_excel").click(function(){
                $("#tabla_excel").table2excel({
                        exclude: ".noExl",
                        name: "Developer data",
                        filename: "Resultados",
                        fileext: ".xls",
                        exclude_img: true,
                        exclude_links: true,
                        exclude_inputs: true
                });
        });
});



</script>
<p>Seleccione una prueba para ver resultados:</p>
<div class="panel-group" id="categorias" role="tablist" aria-multiselectable="true">

<?php
$aux=0;
$aux=0;
$aux2=0;
$auxtext=0;
$sumador=0;
$contador=0;
$compara='0';
$comparanombre='0';
$comparatexto='0';
$puntajeTotal=0;
$nombreaperllido=array();
$total_prueba=0;
$datos = array(array());
$puntosportexto=array();
$context=array();
$media=0;
$mediana=0;
$moda=0;
$desviacion=0;

// mostrar cada categoria y buscar sus pruebas

    // id para la categoría
    $id = \sowerphp\core\Utility_String::normalize('resultados-prueba'.'-'.$pruebaid);
    echo '<div style= "overflow: scroll; border: silver 10px solid; border-image-slice: 21; padding: 10px; height: auto; max-height: 900px; width:1024px;">';
//se guarda el id de la primera pregunta y se incrementa aux hasta que se vuelva a repetir el id de la primera pregunta7
echo '<table id = "tabla_excel">',"\n";
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
        break;
        }
else if ($comparatexto==$a['id_texto']){
        ++$aux;
        echo '<th>Texto '.$auxtext.' - Pregunta '.$aux.'</th>';
        }

        else  {
            //echo '<th>Puntaje Texto '.$auxtext.'</th>';
            ++$auxtext;
            $aux=1;
            $comparatexto=$a['id_texto'];
            echo '<th>Texto '.$auxtext.' - Pregunta '.$aux.'</th>';
            }
    $aux2++;

    }
//calcula puntaje por texto
    $comparatexto='0';
    foreach($porpregunta as &$a){
    if ($comparatexto=='0'){
            $contador+=1;
            $comparatexto=$a['id_texto'];
            $sumador+=$a['puntos'];
            }
    else if ($comparatexto==$a['id_texto']){
            $contador+=1;
            $sumador+=$a['puntos'];
    }
    else  {
            $context[$k]=$contador;
            $puntosportexto[$k]=$sumador;
            $sumador=0;
            $contador=0;
            $k++;
            $comparatexto=$a['id_texto'];
            }

        }
        //print_r($puntosportexto);
    $contador=1;
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
        $nom='';
        $ape='';
        foreach($porpregunta as &$resultados) {
            if ($i==0){
                    $nombreapellido = explode(' ', $resultados['nombre']);
                    $nom=$nombreapellido[0];
                    for ($j=1;$j<count($nombreapellido); $j++){
                            $ape.=$nombreapellido[$j]." ";
                            }
                    echo '<tr id="',$resultados['nombre'],'">',"\n";
                    echo '<td>',$nom,'</td>',"\n";
                    echo '<td>',$ape,'</td>',"\n";
                    echo '<td>',$resultados['fecha_resolucion'],'</td>',"\n";
                    $nom='';
                    $ape='';
                    }
            echo '<td>',$resultados['puntos'],'</td>',"\n";
            $puntajeTotal += $resultados['puntos'];
            $contador+=1;
            $i++;
            /*if ($context[$k] == $contador){
                    echo '<td>',$puntosportexto[$k],'</td>',"\n";
                    $contador=0;
                    $k++;
                    }
            */
            if ($resultados['reordenar']=='true') {
                    $total_prueba+=8;
                    }
            else{
                    $total_prueba+=2;
                    }
            if ($i == $aux2){
            $i=0;
            echo '<td>',$puntajeTotal,'</td>',"\n";
            echo '<td>',(int)(($puntajeTotal*100)/$total_prueba),'%</td>',"\n";
            $puntajeTotal=0;
            $total_prueba=0;
            }
            }
            echo '</td>',"\n";
            if ($resultados['reordenar']=='true') {
                $total_prueba+=8;
                }
        else{
                $total_prueba+=2;
                }
        if ($i == $aux2){
        $i=0;
        echo '<td>',$puntajeTotal,'</td>',"\n";
        echo '<td>',(int)(($puntajeTotal*100)/$total_prueba),'%</td>',"\n";
        $puntajeTotal=0;
        $total_prueba=0;
        }
        echo '</td>',"\n";
        echo '</tr>',"\n\n";
    	echo '</tbody></table>',"\n";
        $aux2++;
}
echo '</div>';
$filename="resultados.csv";
echo '<button id="export_to_excel">Exportar a documento Excel</button>';
?>
