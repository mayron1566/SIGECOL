#!/usr/bin/php -q
<?php

/**
 * @file shell.php
 * Dispatcher para la shell
 */

// Directorio de instalación de SowerPHP, En caso de una instalación compartida
// se debe modificar esta definición indicando el directorio donde está
// instalado el framework, ejemplo: /usr/share/sowerphp
define ('DIR_FRAMEWORK', '/var/www/html/segene');

// Directorio que contiene el proyecto (directorio project) ¡no modificar!
define ('DIR_PROJECT', dirname(dirname(dirname(__FILE__))));

// Extensiones que se utilizarán. Deberá ser vendor/extensión dentro de
// DIR_FRAMEWORK/extensions o bien dentro de DIR_PROJECT/extensions, ejemplo:
// $_EXTENSIONS = array('sowerphp/dev', 'sowerphp/general');
$_EXTENSIONS = array('sowerphp/app', 'sowerphp/general');

// Iniciar bootstrap (proceso que prepara e inicia el proyecto)
if (!@include(DIR_FRAMEWORK.'/lib/sowerphp/core/bootstrap.php')) {
    echo 'Bootstrap no ha podido ser ejecutado, verificar DIR_FRAMEWORK ',
        'en ',DIR_PROJECT,'/website/Shell/shell.php',"\n"
    ;
    exit(1);
}

// Despachar/ejecutar la shell
exit(\sowerphp\core\Shell_Exec::run($argv));
