<?php

// namespace del modelo
namespace website;

/**
 * Clase para mapear la tabla respuesta de la base de datos
 * Comentario de la tabla: Tabla para respuestas de las preguntas
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla respuesta
 */
class Model_Respuestas extends \Model_Plural_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'respuesta'; ///< Tabla del modelo

}
