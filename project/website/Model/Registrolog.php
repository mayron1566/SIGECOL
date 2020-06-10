<?php

// namespace del modelo
namespace website;

/**
 * Clase para mapear la tabla registrolog de la base de datos
 * Comentario de la tabla: Tabla para los registros para posterior auditoría computacional
 * Esta clase permite trabajar sobre un registro de la tabla registrolog
 */
class Model_Registrolog extends \Model_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'registrolog'; ///< Tabla del modelo

    // Atributos de la clase (columnas en la base de datos)
    public $id; ///< Identificador del registro_log: integer(32) NOT NULL DEFAULT 'nextval('registrolog_id_seq'::regclass)' AUTO PK 
    public $fecha; ///< Fecha en la que se generó el registro: timestamp without time zone() NULL DEFAULT 'now()' 
    public $entidad_asoc; ///< Entidad asociada, es la entidad que se vió alterada externamente: character varying(100) NULL DEFAULT '' 
    public $id_actor; ///< Identificador del actor que efectuó una manipulación al sistema: integer(32) NULL DEFAULT '' FK:usuario.id
    public $tipo_actor; ///< Indica el tipo de actor o entidad del actor que efectuó una manipulación: character varying(100) NULL DEFAULT '' 
    public $nota; ///< Comentario sobre qué se manipuló en el sistema: text() NULL DEFAULT '' 
    public $id_asoc; ///< Identificador de la entidad asociada modificada: integer(32) NULL DEFAULT '0' 

    // Información de las columnas de la tabla en la base de datos
    public static $columnsInfo = array(
        'id' => array(
            'name'      => 'Id',
            'comment'   => 'Identificador del registro_log',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => false,
            'default'   => 'nextval(\'registrolog_id_seq\'::regclass)',
            'auto'      => true,
            'pk'        => true,
            'fk'        => null
        ),
        'fecha' => array(
            'name'      => 'Fecha',
            'comment'   => 'Fecha en la que se generó el registro',
            'type'      => 'timestamp without time zone',
            'length'    => null,
            'null'      => true,
            'default'   => 'now()',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'entidad_asoc' => array(
            'name'      => 'Entidad Asoc',
            'comment'   => 'Entidad asociada, es la entidad que se vió alterada externamente',
            'type'      => 'character varying',
            'length'    => 100,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'id_actor' => array(
            'name'      => 'Id Actor',
            'comment'   => 'Identificador del actor que efectuó una manipulación al sistema',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'usuario', 'column' => 'id')
        ),
        'tipo_actor' => array(
            'name'      => 'Tipo Actor',
            'comment'   => 'Indica el tipo de actor o entidad del actor que efectuó una manipulación',
            'type'      => 'character varying',
            'length'    => 100,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'nota' => array(
            'name'      => 'Nota',
            'comment'   => 'Comentario sobre qué se manipuló en el sistema',
            'type'      => 'text',
            'length'    => null,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'id_asoc' => array(
            'name'      => 'Id Asoc',
            'comment'   => 'Identificador de la entidad asociada modificada',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '0',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),

    );

    // Comentario de la tabla en la base de datos
    public static $tableComment = 'Tabla para los registros para posterior auditoría computacional';

    public static $fkNamespace = array(
        'Model_Usuario' => 'website'
    ); ///< Namespaces que utiliza esta clase

}
