<h1><?php 
if(isset($_Auth) and $_Auth->logged()){
//echo "Profesor: ".$nombre; cambiado por experimentacion
echo "SIGECOL"; ?></h1>
<script type="text/javascript">
$(function() {
    var url = document.location.toString();
    if (url.match('#')) {
        console.log($('.panel-title a[href=#'+url.split('#')[1]+']'));
        $('#'+url.split('#')[1]).collapse('show');
    }
});
</script>
<p>Seleccione una de las pruebas para resolverla:</p>
<div class="panel-group" id="categorias" role="tablist" aria-multiselectable="true">
<?php
// mostrar cada categoria y buscar sus pruebas
foreach($categorias as &$categoria) {
    // id para la categoría
    $id = \sowerphp\core\Utility_String::normalize($categoria['categoria'].'-'.$categoria['id']);
    // mostrar categoría
    echo '<div class="panel panel-default">',"\n";
    echo '<div class="panel-heading" role="tab" id="heading_',$id,'">';
    echo '<h4 class="panel-title">';
    echo '<a class="collapsed" data-toggle="collapse in" data-parent="#categorias" aria-expanded="true" aria-controls="',$id,'">';
    echo "Listado de evaluaciones";
    echo '</a>            </h4></div>',"\n";
    // mostrar pruebas para la categoría
    echo '<div id="',$id,'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_',$id,'"><div class="panel-body">',"\n";
    echo '<table class="table">',"\n";
    echo '<thead><tr><th>Prueba</th><th>Descripción</th></tr></thead><tbody>',"\n";
    foreach($categoria['pruebas'] as &$prueba) {
        $id = \sowerphp\core\Utility_String::normalize($prueba['prueba'].'-'.$prueba['id']);
        echo '<tr id="',$id,'">',"\n";
        echo '<td><a href="',$_base,'/r/',$prueba['id'],'" title="Ir a la página de la prueba">',$prueba['prueba'],'</a></td>',"\n";
        echo '<td>',$prueba['descripcion'],'</td>',"\n";
        echo '<td>',"\n";
        //echo '<a href="',$_base,'/p/',$prueba['id'],'" title="Ir a la página de la prueba"><img src="',$_base,'/img/icons/16x16/actions/next.png" alt="" /></a>',"\n";
        //echo '<a href="',$_base,'/r/',$prueba['id'],'" title="Resolver en línea"><img src="',$_base,'/img/icons/16x16/actions/resolver.png" alt="" /></a>',"\n";
        //echo '<a href="https://telegram.me/MiTeStBot?start=r:',$prueba['id'],'" title="Resolver en Telegram"><img src="',$_base,'/img/icons/16x16/actions/telegram.png" alt="" /></a>',"\n";
        //echo '<a href="',$_base,'/d/',$prueba['id'],'" title="Descargar"><img src="',$_base,'/img/icons/16x16/actions/download.png" alt="" /></a>',"\n";
        if($_Auth->User->auth('BOTONES')){
	  echo '<a href="',$_base,'/estadisticas/EstPorPrueba/',$prueba['id'],'" title="Ir a la página de estadísticas de la prueba"><img src="',$_base,'/img/icons/16x16/actions/forum_stats.png" alt="" /></a>',"\n";
	  echo '<a href="',$_base,'/estadisticas/VerNotas/',$prueba['id'],'" title="Ver las notas obtenidas con esta evaluación"><img src="',$_base,'/img/icons/16x16/actions/notas.png" alt="" /></a>',"\n";
	}
        echo '</td>',"\n";
        echo '</tr>',"\n\n";
    }
    echo '</tbody></table>',"\n";
    echo '</div></div>',"\n";
    echo '</div>',"\n";
}
}
echo '</div>';
?>
