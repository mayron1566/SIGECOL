<?php

/** ESTE ARCHIVO SE DEBE CONFIGURAR Y RENOMBRAR A core.php */

/**
 * @file core.php
 * Configuración propia de cada página o aplicación
 */

// Tema de la página (diseño)
\sowerphp\core\Configure::write('page.layout', 'mitest');

// logo ASCII
$logo = <<< EOF
  __  __ _ _____    ____  _
 #####  ###  #####  #######  #####  ####### #       
#     #  #  #     # #       #     # #     # #       
#        #  #       #       #       #     # #       
 #####   #  #  #### #####   #       #     # #       
      #  #  #     # #       #       #     # #       
#     #  #  #     # #       #     # #     # #       
 #####  ###  #####  #######  #####  ####### #######

EOF;

// Textos de la página
\sowerphp\core\Configure::write('page.header.title', 'Sigecol');
\sowerphp\core\Configure::write('page.body.title', 'Sigecol');
\sowerphp\core\Configure::write('page.footer', '');

// Menú principal del sitio web
\sowerphp\core\Configure::write('nav.website', array(
    '/usuarios' => array('name'=>'Usuarios', 'desc'=>'Listado de usuarios'),
    '/descargas' => array('name'=>'Descargas', 'desc'=>'Descargas de software para ejecutar las pruebas'),
    '/contacto' => array('name'=>'Contacto', 'desc'=>'Página de contacto con desarrollador del proyecto'),
));

// Menú principal de la aplicación
\sowerphp\core\Configure::write('nav.app', array(
    '/pruebas' => array('name'=>'Pruebas', 'desc'=>'Acceso a gestión de pruebas'),
    '/estadisticas' => array('name'=>'Estadísticas', 'desc'=>'Acceso área de estadísticas'),
    '/sistema' => array('name'=>'Sistema', 'desc'=>'Acceso área de administración'),
));

// Base de datos
\sowerphp\core\Configure::write('database.default', array(
    'type' => 'PostgreSQL',
    'name' => 'postgres',
    'user' => 'postgres',
    'pass' => '79671183',
    'host' => 'localhost'
));

// Formato por defecto de las pruebas que se descargan
\sowerphp\core\Configure::write('test.format', 'json'); // mt, xml o json

// Agregar mimetype para archivos mt
\sowerphp\core\Network_Response::setMimetype('mt', 'text/plain');

// Configuración para el correo electrónico
\sowerphp\core\Configure::write('email.default', [
    'type' => 'smtp',
    'host' => 'ssl://smtp.gmail.com',
    'port' => 465,
    'user' => 'soporte.sigecol@gmail.com',
    'pass' => '79671183',
    'to' => '',
]);

// Configuración para reCAPTCHA
/*\sowerphp\core\Configure::write('recaptcha', [
    'public_key' => '',
    'private_key' => '',
]);*/

// Configuración para auto registro de usuarios
\sowerphp\core\Configure::write('app.self_register', [
    'groups' => ['usuarios']
]);

// Configuración para Telegram
\sowerphp\core\Configure::write('telegram.default', [
    'bot' => 'MiTeStBot',
    'token' => '',
]);

// Configuración para Debug
\sowerphp\core\Configure::write('debug', true);

// Configuración para Debug
\sowerphp\core\Configure::write('error.level', E_ALL);
