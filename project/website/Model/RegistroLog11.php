<?php

// namespace del modelo
namespace website;

/**
 * Clase para mapear la tabla Registro_Log de la base de datos
 * Comentario de la tabla: Tabla para los registros del sistema
 * Esta clase permite almacenar la información de las distintas transacciones en el sistema
 */
class Model_RegistroLog extends \Model_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'registrolog'; ///< Tabla del modelo

    // Atributos de la clase (columnas en la base de datos)
    
    public $id; ///< Identificador del registro u log: integer NOT NULL DEFAULT 'nextval('registro_log_id_seq'::regclass)' AUTO PK
    public $fecha; ///< Fecha en la que se generó el registro: character varying(50) NULL DEFAULT ''
    public $entidad_asoc; ///< Entidad asociada, es la entidad que se vió alterada externamente: character varying(50) NULL DEFAULT ''
    public $id_actor; ///< Identificador del actor que efectuó una manipulación al sistema: integer
    public $tipo_actor; ///< Indica el tipo de actor o entidad del actor que efectuó una manipulación: character varying(50) NULL DEFAULT ''
    public $nota; ///< Comentario sobre qué se manipuló en el sistema: character varying(100) NULL DEFAULT ''
    public $cat_id; ///< Identificador de la categoría: character varying(50) NULL DEFAULT ''
    public $preg_id; ///< Identificador de la pregunta: character varying(50) NULL DEFAULT ''
    public $prue_id; ///< Identificador de la prueba: character varying(50) NULL DEFAULT ''
    public $resp_id; ///< Identificador de la respuesta: character varying(50) NULL DEFAULT ''
    public $tipo_id; ///< Identificador del tipo: character varying(50) NULL DEFAULT ''
    public $us_id; ///< Identificador del usuario: character varying(50) NULL DEFAULT ''
    
    // Información de las columnas de la tabla en la base de datos
    public static $columnsInfo = array(
        'id' => array(
            'name'      => 'Id',
            'comment'   => 'Identificador del registro u log',
            'type'      => 'integer',
            'length'    => null,
            'null'      => false,
            'default'   => 'nextval(\'registro_log_id_seq\'::regclass)',
            'auto'      => true,
            'pk'        => true,
            'fk'        => null
        ),
        'fecha' => array(
            'name'      => 'Fecha',
            'comment'   => 'Fecha en la que se generó el registro',
            'type'      => 'character varying',
            'length'    => 50,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'entidad_asoc' => array(
            'name'      => 'Entidad_asoc',
            'comment'   => 'Entidad asociada, es la entidad que se vió alterada externamente',
            'type'      => 'character varying',
            'length'    => 50,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'id_actor' => array(
            'name'      => 'Id_actor',
            'comment'   => 'Identificador del actor que efectuó una manipulación al sistema',
            'type'      => 'integer',
            'length'    => null,
            'null'      => false,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'tipo_actor' => array(
            'name'      => 'Tipo_actor',
            'comment'   => 'Indica el tipo de actor o entidad del actor que efectuó una manipulación',
            'type'      => 'character varying',
            'length'    => 50,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'nota' => array(
            'name'      => 'Nota',
            'comment'   => 'Comentario sobre qué se manipuló en el sistema',
            'type'      => 'character varying',
            'length'    => 100,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
	'cat_id' => array(
            'name'      => 'Cat_id',
            'comment'   => 'Identificador de la categoría',
            'type'      => 'integer',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'categoria', 'column' => 'id')
        ),
        'preg_id' => array(
            'name'      => 'Preg_id',
            'comment'   => 'Identificador de la pregunta',
            'type'      => 'integer',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'pregunta', 'column' => 'id')
        ),
        'prue_id' => array(
            'name'      => 'Prue_id',
            'comment'   => 'Identificador de la prueba',
            'type'      => 'integer',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'prueba', 'column' => 'id')
        ),
        'resp_id' => array(
            'name'      => 'Resp_id',
            'comment'   => 'Identificador de la respuesta',
            'type'      => 'integer',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'respuesta', 'column' => 'id')
        ),
        'tipo_id' => array(
            'name'      => 'Tipo_id',
            'comment'   => 'Identificador del tipo',
            'type'      => 'integer',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'tipo', 'column' => 'id')
        ),
        'us_id' => array(
            'name'      => 'Us_id',
            'comment'   => 'Identificador del usuario',
            'type'      => 'integer',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'usuario', 'column' => 'id')
        ),
  );

    // Comentario de la tabla en la base de datos
    public static $tableComment = 'Tabla para los registros para posterior auditoría computacional';

    public static $fkNamespace = array(
        'Model_Usuario' => 'sowerphp\app\Sistema\Usuarios',
        'Model_Categoria' => 'website',
        'Model_Pregunta' => 'website',
        'Model_Prueba' => 'website',
        'Model_Respuesta' => 'website',
        'Model_Tipo' => 'website'
    ); ///< Namespaces que utiliza esta clase

}
