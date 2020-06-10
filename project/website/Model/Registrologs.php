<?php

// namespace del modelo
namespace website;

/**
 * Clase para mapear la tabla registrolog de la base de datos
 * Comentario de la tabla: Tabla para los registros para posterior auditoría computacional
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla registrolog
 */
class Model_Registrologs extends \Model_Plural_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'registrolog'; ///< Tabla del modelo

    /**
     * Acción para mostrar los logsdel sistema
     */
    public function MostrarLogs($id)
    {
	if(strcmp($id,'')!=0){
	  return $this->db->getTable('
            SELECT r.id, r.fecha, r.entidad_asoc, r.id_actor, r.nota, r.id_asoc 
            FROM registrolog AS r
            WHERE r.id_actor = :id
            ORDER BY fecha'
            , [':id'=>$id]);
        }else{
	  return $this->db->getTable('
            SELECT r.id, r.fecha, r.entidad_asoc, r.id_actor, r.nota, r.id_asoc 
            FROM registrolog AS r
            ORDER BY fecha');
        }
    }
}
