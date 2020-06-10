<?php


// namespace del modelo
namespace website;

/**
 * Clase para mapear la tabla alumnoporprueba de la base de datos
 * Comentario de la tabla: Tabla que servirá para extraer estadísticas. Aloja datos de una prueba realizada por un alumno.
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla alumnoporprueba

 */
class Model_Alumnoporpruebas extends \Model_Plural_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'alumnoporprueba'; ///< Tabla del modelo

}
