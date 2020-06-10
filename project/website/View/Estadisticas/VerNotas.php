<h1>Notas &raquo; Prueba: <em><?=$Prueba?></em></h1>
<?php
foreach($notas as &$nota) {
    unset($nota['id']);
    unset($nota['id_alumno']);
    unset($nota['id_prueba_relacionada']);
}
array_unshift($notas, array('Nota', 'Fecha de resolución', 'Respuestas', 'Nombre', 'Usuario', 'Email'));
new \sowerphp\general\View_Helper_Table($notas);
