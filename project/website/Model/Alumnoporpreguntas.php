<?php

// namespace del modelo
namespace website;

/**
 * Clase para mapear la tabla alumnoporpregunta de la base de datos
 * Comentario de la tabla: Tabla para generar estadísticas. Almacena datos de una pregunta que respondió un alumno.
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla alumnoporpregunta
 */
class Model_Alumnoporpreguntas extends \Model_Plural_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'alumnoporpregunta'; ///< Tabla del modelo

}
