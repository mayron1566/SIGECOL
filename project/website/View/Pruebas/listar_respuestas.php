<h1>Edicion de respuestas de evaluaciones</h1>
<?php
foreach($pruebas as &$prueba) {
    $prueba[] =
        '<a href="editar_respuestas/'.$prueba['id'].'" title="Editar respuestas"><img src="'.$_base.'/img/icons/16x16/actions/edit.png" alt="" /></a> '
    ;
    unset($prueba['id']);
}
array_unshift($pruebas, array('Categoría', 'Prueba', 'Descripcion'));
new \sowerphp\general\View_Helper_Table($pruebas);
