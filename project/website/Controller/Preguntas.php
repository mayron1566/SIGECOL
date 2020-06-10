<?php

namespace website;

/**
 * Controlador para preguntas
 */
class Controller_Preguntas extends \Controller_App
{

    public function beforeFilter()
    {
        $this->Auth->allow('imagen');
        parent::beforeFilter();
    }

    /**
     * Acción para mostrar la imagen asociada a una pregunta
     */
    public function imagen($pregunta)
    {
        $Pregunta = new Model_Pregunta($pregunta);
        if (!$Pregunta->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Pregunta solicitada no existe', 'error'
            );
            $this->redirect('/');
        }
        if (!$Pregunta->publica) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Pregunta solicitada no es pública', 'error'
            );
            $this->redirect('/');
        }
        if ($Pregunta->imagen_size==0) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Pregunta solicitada no tiene imagen asociada', 'error'
            );
            $this->redirect('/');
        }
        $this->response->sendFile([
            'name' => $Pregunta->imagen_name,
            'type' => $Pregunta->imagen_type,
            'size' => $Pregunta->imagen_size,
            'data' => $Pregunta->imagen_data,
        ], ['cache'=>1]);
    }
    
    /**
     * Acción para mostrar las preguntas públicas del sistema o las del usuario
     */
    public function visualizar()
    {
	$this->set([
	      'usuario' => $this->Auth->User->usuario,
	      'preguntas' => (new Model_Preguntas())->MostrarPreguntas($this->Auth->User->id),
	]);
    }
    
    public function Estadisticas($id)
    {
	$this->set('id', $id);
	$this->redirect('/Estadisticas/EstPorPregunta/'.$id);
    }
}
