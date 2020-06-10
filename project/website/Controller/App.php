<?php


namespace website;

/**
 * Controlador base de la aplicación
 * Modifica la configuración por defecto del componente Auth
 */
abstract class Controller_App extends \sowerphp\app\Controller_App
{

    public $components = [
        'Auth'=>[
            'redirect' => [
                'login' => '/usuarios',
            ],
        ],
        'Api',
        'Log',
    ]; ///< Componentes usados por el controlador

}
