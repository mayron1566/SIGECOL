<?php

/**
 * @file routes.php
 * Archivo de rutas "cortas" de la página web
 */

\sowerphp\core\Routing_Router::connect(
    '/u/*', ['controller' => 'usuarios', 'action' => 'mostrar']
);
\sowerphp\core\Routing_Router::connect(
    '/p/*', ['controller' => 'pruebas', 'action' => 'mostrar']
);
\sowerphp\core\Routing_Router::connect(
    '/r/*', ['controller' => 'pruebas', 'action' => 'resolver']
);
\sowerphp\core\Routing_Router::connect(
    '/d/*', ['controller' => 'pruebas', 'action' => 'descargar']
);
