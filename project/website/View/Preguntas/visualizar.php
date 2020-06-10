<h1>Preguntas &raquo; Listado del sistema &raquo; Usuario: <em><?=$usuario?></em></h1>
<?php
foreach($preguntas as &$pregunta) {
    $pregunta[] =
        '<a href="./Estadisticas/'.$pregunta['prueid'].'" title="Ver"><img src="'.$_base.'/img/icons/16x16/actions/forum_stats.png" alt="" /></a> ';
    unset($pregunta['id']);
}
array_unshift($preguntas, array('Id', 'Pregunta', 'Id Prueba', 'Id Tipo', 'Id Categoria', 'Id Usuario Creador' ,'Ver estadística'));
new \sowerphp\general\View_Helper_Table($preguntas);
