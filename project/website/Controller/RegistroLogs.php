<?php

// namespace del controlador
namespace website;

/**
 * Clase para el controlador asociado a la tabla registrolog de la base de
 * datos
 * Comentario de la tabla: Tabla para los registros para posterior auditoría computacional
 * Esta clase permite controlar las acciones entre el modelo y vista para la
 * tabla registrolog
 */
class Controller_RegistroLogs extends \Controller_Maintainer
{

    protected $namespace = __NAMESPACE__; ///< Namespace del controlador y modelos asociados

    public function index()
    {
        $this->redirect('/RegistroLogs/mostrar');
    }
    
    public function mostrar()
    {                        
	if(isset($_POST['usuario'])){
	  $this->set([
	      'usuario' => $this->Auth->User->usuario,
	      'registrologs' => (new Model_Registrologs())->MostrarLogs($_POST['usuario']),
	  ]);
	}else{
	   $this->set([
	      'usuario' => $this->Auth->User->usuario,
	      'registrologs' => (new Model_Registrologs())->MostrarLogs(''),
	  ]);
	}
    }
}
