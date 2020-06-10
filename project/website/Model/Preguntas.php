<?php

// namespace del modelo
namespace website;

/**
 * Clase para mapear la tabla pregunta de la base de datos
 * Comentario de la tabla: Tabla para las preguntas de las pruebas
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla pregunta
 */
class Model_Preguntas extends \Model_Plural_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'pregunta'; ///< Tabla del modelo
    
    /**
     * Acción para mostrar las preguntas del sistema (las públicas)
     */
    public function MostrarPreguntas($id)
    {
	$publica = true;
	if(strcmp($id,'')!=0){
	  return $this->db->getTable(' 
	    SELECT p.id AS prueid, p.pregunta, p.prueba, p.tipo, p.prueba, prue.id, prue.categoria, c.id, c.usuario
            FROM pregunta AS p, prueba AS prue, categoria AS c
            WHERE p.prueba = prue.id AND prue.categoria = c.id AND c.usuario = :id AND p.publica = true
            ORDER BY p.id'
            ,[':id'=>$id]);
        }else{
	  return $this->db->getTable('
            SELECT p.id, p.pregunta, p.prueba, p.tipo, p.prueba, prue.id, prue.categoria, c.id, c.usuario
            FROM pregunta AS p, prueba AS prue, categoria AS c
            WHERE p.prueba = prue.id AND prue.categoria = c.id AND c.usuario = :id AND p.publica = true
            ORDER BY p.id'
            , [':id'=>$id],[':publica'=>$publica]);
        }
        /*
        SELECT p.id, p.pregunta, p.prueba, p.tipo, p.prueba, prue.id, prue.categoria, c.id, c.usuario
            FROM pregunta AS p, prueba AS prue, categoria AS c
            WHERE p.prueba = prue.id AND prue.categoria = c.id AND c.usuario = :id AND p.publica = true
            ORDER BY p.id'
            , [':id'=>$id],[':publica'=>$publica]);
            
        SELECT p.id AS prueid, p.pregunta, p.prueba, p.tipo, p.prueba, prue.id, prue.categoria, c.id, c.usuario
            FROM pregunta AS p, prueba AS prue, categoria AS c
            WHERE p.prueba = prue.id AND prue.categoria = c.id AND c.usuario = 1000 AND p.publica = true
            ORDER BY p.id
            */
    }
}
