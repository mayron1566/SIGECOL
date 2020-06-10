<?php

namespace website;

/**
 * Modelo para trabajar con datos de varios usuarios
 */
class Model_Usuarios extends \Model_Plural_App
{

    public function conCategoriasPruebasPublicas()
    {
        return $this->db->getTable('
            SELECT u.usuario, u.nombre, c.categorias, p.pruebas
            FROM
                usuario AS u,
                (
                    SELECT usuario, COUNT(*) AS categorias
                    FROM categoria
                    WHERE publica = true
                    GROUP BY usuario
                ) AS c,
                (
                    SELECT c.usuario, SUM(p.pruebas) AS pruebas
                    FROM
                        categoria AS c,
                        (
                            SELECT categoria, COUNT(*) AS pruebas
                            FROM prueba
                            WHERE publica = true
                            GROUP BY categoria
                        ) AS p
                    WHERE p.categoria = c.id
                    GROUP BY c.usuario
                ) AS p
            WHERE
                u.activo = true
                AND c.usuario = u.id
                AND p.usuario = u.id
            ORDER BY u.usuario
        ');
    }

public function idPruebaAsociada($profesor)
    {
        return $this->db->getTable('
            SELECT p.id
            FROM
                prueba AS p,
                
            WHERE
                u.activo = true
                AND c.usuario = u.id
                AND p.usuario = u.id
            ORDER BY u.usuario
        ');
    }

}
