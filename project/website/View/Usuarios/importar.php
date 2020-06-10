<h1>Importar &raquo; Listado de alumnos</h1>
<?php
$f = new \sowerphp\general\View_Helper_Form();
echo $f->begin([
    'action'=>$_base.'/usuarios/usuariosimportar',
 //   'onsubmit'=>'validarxls()'
]);
echo $f->input([
    'name'=>'file',
    'label'=>'Seleccionar excel a importar',
    'attr'=>'maxlength="50"',
    'type'=>'file'
]);
echo $f->end('Importar alumnos');
echo '<h2>En esta sección podrás importar tus alumnos desde un archivo excel</h2>';
echo 'El formato es el siguiente: </br>';
echo '<center><img src="'.$_base.'/img/screenshots/web/excel.png"/></center></br></br>';
echo "<center><table border=1><tr><td>En la primera columna debe decir 'Nombre', con los respectivos nombres de los alumnos.</td>";
echo "<td>En la segunda columna debe decir 'Apellido', con los respectivos apellidos de los alumnos.</td>";
echo "<td>En la tercera columna debe decir 'Rut', con los respectivos rut de los alumnos, los cuales serán el usuario con el cual los alumnos ingresarán a la plataforma, el debe NO debe contener NI puntos NI guiones, y DEBE contener el número verificador.</td>";
echo "<td>En la cuarta columna debe decir 'Email', con los respectivos E-mails de los alumnos a los cuales se les enviará la contraseña de su identificación.</td></tr></table></center>";
