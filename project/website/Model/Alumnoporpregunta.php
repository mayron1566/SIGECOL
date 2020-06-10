<?php


// namespace del modelo
namespace website;

/**
 * Clase para mapear la tabla alumnoporpregunta de la base de datos
 * Comentario de la tabla: Tabla para generar estadísticas. Almacena datos de una pregunta que respondió un alumno.
 * Esta clase permite trabajar sobre un registro de la tabla alumnoporpregunta
 */
class Model_Alumnoporpregunta extends \Model_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'alumnoporpregunta'; ///< Tabla del modelo

    // Atributos de la clase (columnas en la base de datos)
    public $id; ///< Identificador de la tabla alumnoporpregunta: integer(32) NOT NULL DEFAULT 'nextval('alumnoporpregunta_id_seq'::regclass)' AUTO PK 
    public $id_prueba_relacionada; ///< Identificador de la prubea a la que pertenece la pregunta: integer(32) NULL DEFAULT '' FK:prueba.id
    public $fecha_resolucion; ///< Fecha en la que la pregunta fue respondida: timestamp without time zone() NULL DEFAULT 'now()' 
    public $id_alumno; ///< Identificador del alumno que respondió la pregunta: character varying(100) NULL DEFAULT '' 
    public $cantidad_alternativas; ///< Cantidad de alternativas que posee la pregunta: integer(32) NULL DEFAULT '' 
    public $correcta; ///< Atributo booleano que almacena si la pregunta está respondida correctamente o no: integer(32) NULL DEFAULT '' 
    public $tipo; ///< Dificultad de la pregunta: integer(32) NULL DEFAULT '' FK:tipo.id
    public $id_pregunta_relacionada; ///< Pregunta relacionada (que se respondió): integer(32) NULL DEFAULT '' FK:pregunta.id
    public $puntos;///< Puntos obtenidos en la pregunta: integer(32) NULL DEFAULT ''
    public $tiempo;///< Tiempo en contestar las preguntas de un texto: time without time zone() NULL DEFAULT '' 
    public $tiempo_pregunta;///< Tiempo en responder la preguntaa: time without time zone() NULL DEFAULT '' 
    public $respuesta;///< Respuestas seleccionadas en cada pregunta NULL DEFAULT '' 
    // Información de las columnas de la tabla en la base de datos
    public static $columnsInfo = array(
        'id' => array(
            'name'      => 'Id',
            'comment'   => 'Identificador de la tabla alumnoporpregunta',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => false,
            'default'   => 'nextval(\'alumnoporpregunta_id_seq\'::regclass)',
            'auto'      => true,
            'pk'        => true,
            'fk'        => null
        ),
        'id_prueba_relacionada' => array(
            'name'      => 'Id Prueba Relacionada',
            'comment'   => 'Identificador de la prubea a la que pertenece la pregunta',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'prueba', 'column' => 'id')
        ),
        'fecha_resolucion' => array(
            'name'      => 'Fecha Resolucion',
            'comment'   => 'Fecha en la que la pregunta fue respondida',
            'type'      => 'timestamp without time zone',
            'length'    => null,
            'null'      => true,
            'default'   => 'now()',
            'auto'      => false,    
            'pk'        => false,
            'fk'        => null
        ),
        'id_alumno' => array(
            'name'      => 'Id Alumno',
            'comment'   => 'Identificador del alumno que respondió la pregunta',
            'type'      => 'character varying',
            'length'    => 100,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'cantidad_alternativas' => array(
            'name'      => 'Cantidad Alternativas',
            'comment'   => 'Cantidad de alternativas que posee la pregunta',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'correcta' => array(
            'name'      => 'Correcta',
            'comment'   => 'Atributo booleano que almacena si la pregunta está respondida correctamente o no',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'tipo' => array(
            'name'      => 'Tipo',
            'comment'   => 'Dificultad de la pregunta',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'tipo', 'column' => 'id')
        ),
        'id_pregunta_relacionada' => array(
            'name'      => 'Id Pregunta Relacionada',
            'comment'   => 'Pregunta relacionada (que se respondió)',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'pregunta', 'column' => 'id')
        ),
        'puntos' => array(
            'name'      => 'Puntos',
            'comment'   => 'Puntos obtenidos en la pregunta',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'tiempo' => array(
            'name'      => 'Tiempo',
            'comment'   => 'Tiempo en contestar las preguntas de un texto',
            'type'      => 'time without time zone',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'tiempo_pregunta' => array(
            'name'      => 'Tiempo Pregunta',
            'comment'   => 'Tiempo en responder la pregunta',
            'type'      => 'time without time zone',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
	'respuesta' => array(
            'name'      => 'Respuesta',
            'comment'   => 'Respuestas seleccionadas en cada pregunta',
            'type'      => 'text',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),

    );

    // Comentario de la tabla en la base de datos
    public static $tableComment = 'Tabla para generar estadísticas. Almacena datos de una pregunta que respondió un alumno.';

    public static $fkNamespace = array(
        'Model_Prueba' => 'website',
        'Model_Tipo' => 'website',
        'Model_Pregunta' => 'website'
    ); ///< Namespaces que utiliza esta clase
    
    public function BuscarPregunta($id){
      return $this->db->getTable('
            SELECT ppre.id, u.nombre, u.usuario, ppre.id_prueba_relacionada, ppre.puntos, ppre.fecha_resolucion, p.pregunta, p.id, p.id_texto, p.reordenar 
            FROM alumnoporpregunta AS ppre, pregunta AS p, prueba AS pr, usuario AS u
            WHERE ppre.id_pregunta_relacionada = p.id AND ppre.id_prueba_relacionada = pr.id AND ppre.id_alumno = u.id::text AND ppre.id_prueba_relacionada = :id ORDER BY ppre.id ASC'
            ,['id'=>$id]);
    }
    
    public function BuscarPreguntaPorFecha($id){
      return $this->db->getTable('
            SELECT ppre.id, ppre.id_pregunta_relacionada, ppre.correcta, ppre.fecha_resolucion, p.id, p.pregunta 
            FROM alumnoporpregunta AS ppre, pregunta AS p
            WHERE ppre.id_pregunta_relacionada = p.id AND ppre.id_pregunta_relacionada = :id'
            ,['id'=>$id]);
    }

}
