<?php

// namespace del controlador
namespace website;

/**
 * Clase para el controlador asociado a la tabla categoria de la base de
 * datos
 * Comentario de la tabla: Tabla para categorías de las pruebas
 * Esta clase permite controlar las acciones entre el modelo y vista para la
 * tabla categoria	
 */
class Controller_Categorias extends \Controller_App
{

    public function listar()
    {
        $this->set([
            'usuario' => $this->Auth->User->usuario,
            'categorias' => (new Model_Categorias())->getByUser($this->Auth->User->id),
        ]);
    }

    public function crear()
    {
        if (isset($_POST['submit'])) {
            $_POST['categoria'] = trim($_POST['categoria']);
            if (!isset($_POST['categoria'][0])) {
                \sowerphp\core\Model_Datasource_Session::message(
                    'Nombre de la categoría no puede estar en blanco', 'warning'
                );
                $this->redirect('/categorias/crear');
            }
            // guardar prueba
            $Categoria = new Model_Categoria();
            $Categoria->categoria = $_POST['categoria'];
            $Categoria->usuario = $this->Auth->User->id;
            $Categoria->publica = isset($_POST['publica']) ? 'true' : 'false';
            $Categoria->save();
            
            //generar registro
            $Registro_Log = new Model_Registrolog();
            $Registro_Log->id_asoc = $Categoria->id;
            $Registro_Log->fecha = date('Y-m-d H:i:s');
            $Registro_Log->entidad_asoc = 'categoria';
            $Registro_Log->id_actor = $this->Auth->User->id;
            //$Registro_Log->tipo_actor = ACTOR
            $Registro_Log->nota = 'Creación: ' . $Categoria->categoria;
            $Registro_Log->save();
            
            // mensaje y redireccionar
            \sowerphp\core\Model_Datasource_Session::message(
               'Categoría creada', 'ok'
            );
            $this->redirect('/categorias/listar');
        }
    }

    public function editar($id)
    {
        $Categoria = new Model_Categoria($id);
        // si el registro que se quiere editar y no existe error
        if (!$Categoria->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La categoría solicitada no existe, no se puede editar',
                'error'
            );
            $this->redirect('/categorias/listar');
        }
        // si no es el dueño de la categoría error
        if ($Categoria->usuario!=$this->Auth->User->id) {
            \sowerphp\core\Model_Datasource_Session::message(
                'No es el autor de la categoría, no se puede editar',
                'error'
            );
            $this->redirect('/categorias/listar');
        }
        // editar si se envió formulario
        if (isset($_POST['submit'])) {
            $_POST['categoria'] = trim($_POST['categoria']);
            if (!isset($_POST['categoria'][0])) {
                \sowerphp\core\Model_Datasource_Session::message(
                    'Nombre de la categoría no puede estar en blanco', 'warning'
                );
                $this->redirect('/categorias/crear');
            }
            //datos para comparar la edición y añadir al log
            $NombreCategoria = $Categoria->categoria;
            $PublicaCategoria = ($Categoria->publica) ? 'true' : 'false';
            // guardar prueba
            $Categoria->categoria = $_POST['categoria'];
            $Categoria->publica = isset($_POST['publica']) ? 'true' : 'false';
            $Categoria->save();
            //generar registro
            $Registro_Log = new Model_Registrolog();
            $Registro_Log->id_asoc = $Categoria->id;
            $Registro_Log->fecha = date('Y-m-d H:i:s');
            $Registro_Log->entidad_asoc = 'categoria';
            //$Registro_Log->tipo_actor = ACTOR
            $Registro_Log->id_actor = $this->Auth->User->id;
            //Comparaciones para ver qué se cambió
            $String1='';
            $GenerarLog = false;
            if(strcmp($NombreCategoria, $Categoria->categoria) != 0){
	      $String1 = '-Nombre de ' .$NombreCategoria. ' a ' . $Categoria->categoria;
	      $GenerarLog = true;
            }
            $String2 ='';
            if(strcmp($PublicaCategoria,$Categoria->publica) != 0){
	      $String2 = '-Privacidad de ' . $PublicaCategoria . ' a ' . $Categoria->publica;
	      $GenerarLog = true;
            }
            //Generar o no el log
            if($GenerarLog == true){
	      $Registro_Log->nota = 'Modificación: '.$Categoria->categoria.' ' . $String1. $String2;
	      $Registro_Log->save();
            }
            // mensaje y redireccionar
            \sowerphp\core\Model_Datasource_Session::message(
               'Categoría editada', 'ok'
            );
            $this->redirect('/categorias/listar');
        } else {
            $this->set('Categoria', $Categoria);
        }
    }

    public function eliminar($id)
    {
        $Categoria = new Model_Categoria($id);
        // si el registro que se quiere editar y no existe error
        if (!$Categoria->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La categoría solicitada no existe, no se puede eliminar',
                'error'
            );
            $this->redirect('/categorias/listar');
        }
        // si no es el dueño de la categoría error
        if ($Categoria->usuario!=$this->Auth->User->id) {
            \sowerphp\core\Model_Datasource_Session::message(
                'No es el autor de la categoría, no se puede eliminar',
                'error'
            );
            $this->redirect('/categorias/listar');
        }
        // si tiene pruebas creadas no se puede eliminar
        if ($Categoria->pruebasCount()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Categoría tiene pruebas asociadas, no se puede eliminar',
                'error'
            );
            $this->redirect('/categorias/listar');
        }
        //generar registro
            $Registro_Log = new Model_Registrolog();
            $Registro_Log->id_asoc = $Categoria->id;
            $Registro_Log->fecha = date('Y-m-d H:i:s');
            $Registro_Log->entidad_asoc = 'categoria';
            $Registro_Log->id_actor = $this->Auth->User->id;
            //$Registro_Log->tipo_actor = ACTOR
            $Registro_Log->nota = 'Eliminación: '. $Categoria->categoria;
            $Registro_Log->save();
        // eliminar prueba
        $Categoria->delete();
        \sowerphp\core\Model_Datasource_Session::message(
            'Categoría eliminada', 'ok'
        );
        $this->redirect('/categorias/listar');
    }

    public function subir($id)
    {
        $Categoria = new Model_Categoria($id);
        // si el registro que se quiere editar y no existe error
        if (!$Categoria->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La categoría solicitada no existe, no se puede editar',
                'error'
            );
            $this->redirect('/categorias/listar');
        }
        // si no es el dueño de la categoría error
        if ($Categoria->usuario!=$this->Auth->User->id) {
            \sowerphp\core\Model_Datasource_Session::message(
                'No es el autor de la categoría, no se puede editar',
                'error'
            );
            $this->redirect('/categorias/listar');
        }
        // solo se procesa si el orden es mayor a 1
        if($Categoria->orden>1) {
            $Categoria->intercambiarOrden($Categoria->orden-1);
        }
        // redireccionar
        $this->redirect('/categorias/listar');
    }

    public function bajar($id)
    {
        $Categoria = new Model_Categoria($id);
        // si el registro que se quiere editar y no existe error
        if (!$Categoria->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La categoría solicitada no existe, no se puede editar',
                'error'
            );
            $this->redirect('/categorias/listar');
        }
        // si no es el dueño de la categoría error
        if ($Categoria->usuario!=$this->Auth->User->id) {
            \sowerphp\core\Model_Datasource_Session::message(
                'No es el autor de la categoría, no se puede editar',
                'error'
            );
            $this->redirect('/categorias/listar');
        }
        // solo se procesa si el orden es menor que el maximo existente
        $Categorias = new Model_Categorias();
        $Categorias->setWhereStatement(['usuario = :usuario'], [':usuario'=>$this->Auth->User->id]);
        if($Categoria->orden<$Categorias->getMax('orden')) {
            $Categoria->intercambiarOrden($Categoria->orden+1);
        }
        // redireccionar
        $this->redirect('/categorias/listar');
    }

}
