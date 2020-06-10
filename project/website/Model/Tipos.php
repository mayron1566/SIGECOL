<?php

// namespace del modelo
namespace website;

/**
 * Clase para mapear la tabla tipo de la base de datos
 * Comentario de la tabla: Tabla para los tipos de preguntas que pueden existir
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla tipo
 */
class Model_Tipos extends \Model_Plural_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'tipo'; ///< Tabla del modelo

    public function getList($conPorcentaje = false)
    {
        if ($conPorcentaje) {
            return $this->db->getTable(
                'SELECT id, tipo, porcentaje FROM tipo ORDER BY peso'
            );
        } else {
            return $this->db->getTable(
                'SELECT id, tipo FROM tipo ORDER BY peso'
            );
        }
    }

}
