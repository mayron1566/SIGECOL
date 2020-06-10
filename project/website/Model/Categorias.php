<?php

namespace website;

/**
 * Modelo para trabajar con varias categorías
 */
class Model_Categorias extends \Model_Plural_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'categoria'; ///< Tabla del modelo

    public function getListByUser($id, $onlypublics = false)
    {
        return $this->db->getTable('
            SELECT id, categoria
            FROM categoria
            WHERE
                usuario = :id
                '.($onlypublics?'AND publica = true':'').'
            ORDER BY orden, categoria
        ', [':id'=>$id]);
    }

    public function getByUser($id)
    {
        return $this->db->getTable('
            SELECT c.id, c.categoria, c.publica, t.pruebas
            FROM categoria AS c LEFT JOIN (
                SELECT p.categoria, COUNT(*) AS pruebas
                FROM prueba AS p, categoria AS c
                WHERE p.categoria = c.id AND c.usuario = :id
                GROUP BY p.categoria
            ) AS t ON t.categoria = c.id
            WHERE c.usuario = :id
            ORDER BY c.orden, c.categoria
        ', [':id'=>$id]);
    }

}
