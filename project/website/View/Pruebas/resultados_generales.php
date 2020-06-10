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
// mostrar cada categoria y buscar sus pruebas
foreach($pruebass as &$prueb) {
    // id para la categoría
    $id = \sowerphp\core\Utility_String::normalize($prueb['prueba'].'-'.$prueb['id']);
    // mostrar categoría
    echo '<div class="panel panel-default">',"\n";
    echo '<div class="panel-heading" role="tab" id="heading_',$id,'">';
    echo '<h4 class="panel-title">';
    echo '<a class="collapsed" data-toggle="collapse in" data-parent="#pruebass" href="#',$id,' aria-expanded="true" aria-controls="',$id,'">';
    echo $prueb['prueba'];
    echo '</a>            </h4></div>',"\n";
    // mostrar pruebas para la categoría
    echo '<div id="',$id,'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_',$id,'"><div class="panel-body">',"\n";
    echo '<table class="table">',"\n";
    echo '<thead><tr><th>Promedio puntaje total</th><th>Promedio porcentaje logrado</th><th style="width:120px">Desglose de resultados</th></tr></thead><tbody>',"\n";
        $id = \sowerphp\core\Utility_String::normalize($prueb['prueba'].'-'.$prueb['id']);
        echo '<tr id="',$id,'">',"\n";
        echo '<td>',$notas[$aux],'</td>',"\n";
        echo '<td>',$porprueba[$aux],'</td>',"\n";
        echo '<td>',"\n";
        echo '<a href="/pruebas/resultados_ppregunta/',$prueb['id'],'" title="Resultados generales">Ver resultados generales</a>',"\n";
	echo "<br>";
	echo "-------------";
	echo "<br>";
        echo '<a href="',$_base,'/r/',$prueb['id'],'" title="Resolver en línea">Filtrar resultados</a>',"\n";
        echo '</td>',"\n";
        echo '</tr>',"\n\n";
    echo '</tbody></table>',"\n";
    echo '</div></div>',"\n";
    echo '</div>',"\n";
	$aux++;
}
}
echo '</div>';
?>
