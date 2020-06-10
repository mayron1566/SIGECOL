<?php

// namespace del modelo
namespace website;

/**
 * Clase para mapear la tabla alumnoporprueba de la base de datos
 * Comentario de la tabla: Tabla que servirá para extraer estadísticas. Aloja datos de una prueba realizada por un alumno.
 * Esta clase permite trabajar sobre un registro de la tabla alumnoporprueba
 */
class Model_Alumnoporprueba extends \Model_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'alumnoporprueba'; ///< Tabla del modelo

    // Atributos de la clase (columnas en la base de datos)
    public $id; ///< Identificador de la tabla alumnoporprueba (número secuencial): integer(32) NOT NULL DEFAULT 'nextval('alumnoporprueba_id_seq'::regclass)' AUTO PK 
    public $fecha_resolucion; ///< Fecha en la que el alumno resolvió la prueba: timestamp without time zone() NULL DEFAULT 'now()' 
    public $id_alumno; ///< Identificador del alumno que resolvió la prueba: character varying(100) NULL DEFAULT '' 
    public $cantidad_preguntas; ///< Cantidad total de preguntas que contenía la evaluación: integer(32) NULL DEFAULT '' 
    public $total_buenas; ///< Total de preguntas contestadas correctamente por el alumno: integer(32) NULL DEFAULT '' 
    public $total_malas; ///< Total de preguntas contestadas incorrectamente por el alumno: integer(32) NULL DEFAULT '' 
    public $total_omitidas; ///< Total de preguntas omitidas por el alumno: integer(32) NULL DEFAULT '' 
    public $nota; ///< Calificación final obtenida al resolver la evaluación: character varying(100) NULL DEFAULT '' 
    public $id_prueba_relacionada; ///< Id de la prueba a la cual se le guardó registro: integer(32) NULL DEFAULT '' FK:prueba.id
    public $respuestas;

    // Información de las columnas de la tabla en la base de datos
    public static $columnsInfo = array(
        'id' => array(
            'name'      => 'Id',
            'comment'   => 'Identificador de la tabla alumnoporprueba (número secuencial)',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => false,
            'default'   => 'nextval(\'alumnoporprueba_id_seq\'::regclass)',
            'auto'      => true,
            'pk'        => true,
            'fk'        => null
        ),
        'fecha_resolucion' => array(
            'name'      => 'Fecha Resolucion',
            'comment'   => 'Fecha en la que el alumno resolvió la prueba',
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
            'comment'   => 'Identificador del alumno que resolvió la prueba',
            'type'      => 'character varying',
            'length'    => 100,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'cantidad_preguntas' => array(
            'name'      => 'Cantidad Preguntas',
            'comment'   => 'Cantidad total de preguntas que contenía la evaluación',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'total_buenas' => array(
            'name'      => 'Total Buenas',
            'comment'   => 'Total de preguntas contestadas correctamente por el alumno',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'total_malas' => array(
            'name'      => 'Total Malas',
            'comment'   => 'Total de preguntas contestadas incorrectamente por el alumno',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'total_omitidas' => array(
            'name'      => 'Total Omitidas',
            'comment'   => 'Total de preguntas omitidas por el alumno',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'nota' => array(
            'name'      => 'Nota',
            'comment'   => 'Calificación final obtenida al resolver la evaluación',
            'type'      => 'character varying',
            'length'    => 100,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'id_prueba_relacionada' => array(
            'name'      => 'Id Prueba Relacionada',
            'comment'   => 'Id de la prueba a la cual se le guardó registro',
            'type'      => 'integer',
            'length'    => 32,
            'null'      => true,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => array('table' => 'prueba', 'column' => 'id')
        ),
	'respuestas' => array(
            'name'      => 'Respuestas',
            'comment'   => '',
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
    public static $tableComment = 'Tabla que servirá para extraer estadísticas. Aloja datos de una prueba realizada por un alumno.';

    public static $fkNamespace = array(
        'Model_Prueba' => 'website'
    ); ///< Namespaces que utiliza esta clase

    /**
    * Función para obtener las preguntas malas y buenas en el sistema
    */

    public function resultadosG($id){
      return $this->db->getTable('
            SELECT pp.id, pp.nota, pp.total_buenas, pp.cantidad_preguntas, pp.nota
            FROM alumnoporprueba AS pp WHERE id_prueba_relacionada = :id'
            , [':id'=>$id]);
    }	

    public function preguntasmalasvsbuenas(){
      return $this->db->getTable('
            SELECT pp.id, pp.cantidad_preguntas, pp.total_buenas, pp.total_malas
            FROM alumnoporprueba AS pp');
    }
    
    /**
    * Función para obtener las notas azules en el sistema
    */
    public function notasensistemaazul(){
      return $this->db->getTable('
            SELECT COUNT(pp.id)
            FROM alumnoporprueba AS pp
            WHERE (pp.nota)>=\'4.0\';
            ');
    }
    
    /**
    * Función para obtener las notas rojas en el sistema
    */
    public function notasensistemaroja(){
      return $this->db->getTable('
            SELECT COUNT(pp.id)
            FROM alumnoporprueba AS pp
            WHERE (pp.nota)<\'4.0\';
            ');
    }
    
    /**
    * Función para obtener el promedio de las notas en el sistema
    */
    public function promediodenotas(){
      return $this->db->getTable('
            WITH cte AS (
	    SELECT
		CASE 
		    WHEN nota ~ \'[0-9]\' THEN CAST(nota AS decimal) -- cast to numeric field
		END AS num,
		CASE 
		    WHEN nota ~ \'[a-zA-Z]\' THEN nota
		END AS a
	    FROM alumnoporprueba
	    )
	    SELECT AVG(num), COUNT(a) FROM cte;');
    }
    
    /**
    * Función para obtener las preguntas malas y buenas de una prueba
    */
    public function preguntasmalasvsbuenasPrueba($id){
      return $this->db->getTable('
            SELECT id, cantidad_preguntas, total_buenas, total_malas
            FROM alumnoporprueba 
            WHERE id_prueba_relacionada = :id'
            , [':id'=>$id]);
    }
    
    
    /**
    * Función para obtener las notas azules en el sistema de una prueba
    */
    public function notasensistemaazulPrueba($id){
      return $this->db->getTable('
            SELECT COUNT(pp.id)
            FROM alumnoporprueba AS pp
            WHERE (pp.nota)>=\'4.0\' AND id_prueba_relacionada = :id'
            , [':id'=>$id]);
    }
    
     /**
    * Función para obtener las notas rojas en el sistema de una prueba
    */
    public function notasensistemarojaPrueba($id){
      return $this->db->getTable('
            SELECT COUNT(pp.id)
            FROM alumnoporprueba AS pp
            WHERE (pp.nota)<\'4.0\'  AND id_prueba_relacionada = :id'
            , [':id'=>$id]);
    }
    
     /**
    * Función para obtener el promedio de las notas en el sistema
    */
    public function promediodenotasPrueba($id){
      return $this->db->getTable('
            WITH cte AS (
	    SELECT
		CASE 
		    WHEN nota ~ \'[0-9]\' THEN CAST(nota AS decimal) -- cast to numeric field
		END AS num,
		CASE 
		    WHEN nota ~ \'[a-zA-Z]\' THEN nota
		END AS a
	    FROM alumnoporprueba
	    WHERE id_prueba_relacionada = :id
	    )
	    SELECT AVG(num), COUNT(a) FROM cte;'
	    , [':id'=>$id]);
    }
    
    /**
    * Función para obtener la cantidad de veces que una
    * pregunta se respondió incorrectamente en una prueba 
    */
    public function conteodepreguntaserroneasPrueba($id){
      return $this->db->getTable('
          SELECT COUNT(pp.id) as thecount, pp.id_prueba_relacionada, pp.id_pregunta_relacionada, pre.id, pre.pregunta,pre.explicacion
            FROM alumnoporpregunta AS pp, pregunta AS pre
            WHERE id_prueba_relacionada = :id AND pp.correcta = \'0\' AND pre.id = pp.id_pregunta_relacionada
            GROUP BY pp.id_prueba_relacionada, pp.id_pregunta_relacionada, pre.id, pre.explicacion
            ORDER BY thecount DESC;'
            , [':id'=>$id]);
    }
    
    /**
    * Función para obtener las notas obtenidas en una evaluación en específico
    */
    public function notasPrueba($id){
      return $this->db->getTable('
          SELECT pp.nota, pp.id_alumno, pp.fecha_resolucion, pp.id_prueba_relacionada, pp.respuestas, us.id, us.nombre, us.usuario, us.email
            FROM alumnoporprueba AS pp, usuario AS us
            WHERE id_prueba_relacionada = :id AND CAST(pp.id_alumno AS Integer)= us.id
            ORDER BY fecha_resolucion DESC;'
            , [':id'=>$id]);
    }
}
