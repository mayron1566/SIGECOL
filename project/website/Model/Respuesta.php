<?php

// namespace del modelo
namespace website;

/**
 * Clase para mapear la tabla respuesta de la base de datos
 * Comentario de la tabla: Tabla para respuestas de las preguntas
 * Esta clase permite trabajar sobre un registro de la tabla respuesta
 */
class Model_Respuesta extends \Model_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'respuesta'; ///< Tabla del modelo

    // Atributos de la clase (columnas en la base de datos)
    public $id; ///< Identificador de la respuesta: integer(32) NOT NULL DEFAULT 'nextval('respuesta_id_seq'::regclass)' AUTO PK 
    public $respuesta; ///< Posible respuesta a la pregunta: text() NOT NULL DEFAULT '' 
    public $pregunta; ///< Pregunta a la que pertenece la respuesta: integer(32) NOT NULL DEFAULT '' FK:pregunta.id
    public $correcta; ///< Indica si la respuesta es correcta: boolean() NOT NULL DEFAULT 'false'
    public $pos; ///< Indica la posicion de la pregunta, utilizado en mapa conceptual o preguntas que requieran de un orden especifico
    public $possel; ///< Posicion de respuesta seleccionada por estudiante
    public $media_correcta; ///< Puntaje medio
    public $nula; ///< puntaje nulo
    public $puntaje;///<Puntaje de respuesta
    public $n_buenasc;///<Numero de respuestas correctas para puntaje completo
    public $n_buenasm;///<Numero de respuestas buenas para puntaje medio

    // Información de las columnas de la tabla en la base de datos
    public static $columnsInfo = array(
        'id' => array(
            'name'      => 'Id',
            'comment'   => 'Identificador de la respuesta',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => false,
            'default'   => 'nextval(\'respuesta_id_seq\'::regclass)',
            'auto'      => true,
            'pk'        => true,
            'fk'        => null
        ),
        'respuesta' => array(
            'name'      => 'Respuesta',
            'comment'   => 'Posible respuesta a la pregunta',
            'type'      => 'text',
            'length'    => null,
            'null'      => false,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'pregunta' => array(
            'name'      => 'Pregunta',
            'comment'   => 'Pregunta a la que pertenece la respuesta',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => false,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'pregunta', 'column' => 'id')
        ),
        'correcta' => array(
            'name'      => 'Correcta',
            'comment'   => 'Indica si la respuesta es correcta',
            'type'      => 'boolean',
            'length'    => null,
            'null'      => false,
            'default'   => 'false',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
	'pos' => array(
            'name'      => 'Pos',
            'comment'   => 'Indica la posicion de la pregunta, utilizado en mapa conceptual o preguntas que requieran de un orden especifico',
            'type'      => 'integer',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
	'possel' => array(
            'name'      => 'Possel',
            'comment'   => 'Posicion de respuesta seleccionada por estudiante ',
            'type'      => 'integer',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
	'media_correcta' => array(
            'name'      => 'Media_Correcta',
            'comment'   => 'Puntaje medio',
            'type'      => 'boolean',
            'length'    => null,
            'null'      => false,
            'default'   => 'false',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
	'nula' => array(
            'name'      => 'Nula',
            'comment'   => 'Puntaje nulo',
            'type'      => 'boolean',
            'length'    => null,
            'null'      => false,
            'default'   => 'false',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
	'puntaje' => array(
            'name'      => 'Puntaje',
            'comment'   => 'Puntaje de respuesta',
            'type'      => 'integer',
            'length'    => null,
            'null'      => true,
            'default'   => 'false',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
	'n_buenasc' => array(
            'name'      => 'N_buenasC',
            'comment'   => 'Numero de respuestas correctas para puntaje completo',
            'type'      => 'integer',
            'length'    => null,
            'null'      => true,
            'default'   => 'false',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
	'n_buenasm' => array(
            'name'      => 'N_buenasM',
            'comment'   => 'Numero de respuestas buenas para puntaje medio',
            'type'      => 'integer',
            'length'    => null,
            'null'      => true,
            'default'   => 'false',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),

    );

    // Comentario de la tabla en la base de datos
    public static $tableComment = 'Tabla para respuestas de las preguntas';

    public static $fkNamespace = array(
        'Model_Pregunta' => 'website'
    ); ///< Namespaces que utiliza esta clase

}
