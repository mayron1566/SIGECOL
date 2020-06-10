<h1>Registro-Logs &raquo; Listado del sistema <em><?=$usuario?></em></h1>
<?php
$f = new \sowerphp\general\View_Helper_Form();
echo $f->begin([
    'onsubmit'=>'Form.check()'
]);
echo $f->input([
    'name'=>'usuario',
    'label'=>'Usuario',
    'attr'=>'maxlength="50"',
    'check'=>'integer',
]);
echo $f->end('Buscar registro');
foreach($registrologs as &$registrolog) {
    $registrolog['id'] = $registrolog['id'];
    $registrolog['fecha'] = $registrolog['fecha'];
    $registrolog['entidad_asoc'] = $registrolog['entidad_asoc'];
    $registrolog['id_actor'] = $registrolog['id_actor'];
    $registrolog['nota'] = $registrolog['nota'];
    $registrolog['id_asoc'] = $registrolog['id_asoc'];
    unset($registrolog['id']);
}
array_unshift($registrologs, array('Fecha', 'Entidad Asociada', 'Id del actor', 'Nota', 'Id asociada'));
new \sowerphp\general\View_Helper_Table($registrologs);

