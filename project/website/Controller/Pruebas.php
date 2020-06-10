<?php

namespace website;


/**
 * Controlador para las pruebas
 */
class Controller_Pruebas extends \Controller_App
{
    private $allowedImageTypes = [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF];

	 protected $model = false; ///< Atributo con el namespace y clase del modelo singular
    protected $models = false; ///< Atributo con el namespace y clase del modelo plural
    protected $module_url; ///< Atributo con la url para acceder el módulo
    protected $deleteRecord = true; ///< Indica si se permite o no borrar registros
    protected $contraseniaNames = ['contrasenia', 'clave', 'password', 'pass']; ///< Posibles nombres de campo tipo contraseña

    public function beforeFilter()
    {
        $this->Auth->allow('descargar', 'resolver', 'resultado', 'mostrar', 'grafico');
        parent::beforeFilter();
    }

    /**
     * Acción para mostrar menú de acciones de administración de pruebas
     */
    public function index()
    {
        $nav = [
            '/listar' => [
                'name' => 'Pruebas',
                'desc' => 'Crear, editar y/o eliminar pruebas',
                'imag' => '/img/icons/48x48/prueba.png',
            ],
	    '/listar_respuestas' => [
                'name' => 'Planilla Respuestas',
                'desc' => 'Crear, editar y/o eliminar planilla de respuestas de las pruebas',
                'imag' => '/img/icons/48x48/prueba.png',
            ],
	    '/resultados_generales' => [
                'name' => 'Resultados de evaluaciones',
                'desc' => 'Mostrar y exportar resultados de evaluaciones',
                'imag' => '/img/icons/48x48/estgenerales.png',
            ],
            '/../preguntas/visualizar' => [
                'name' => 'Preguntas',
                'desc' => 'Visualizar preguntas públicas',
                'imag' => '/img/icons/48x48/preguntas.png',
            ],
            '/../categorias/listar' => [
                'name' => 'Categorías',
                'desc' => 'Crear, editar y/o eliminar categorías',
                'imag' => '/img/icons/48x48/categorias.png',
            ],
	    '/../Usuarios/importar' => [
                'name' => 'Importar alumnos',
                'desc' => 'Importar datos de excel para generación de alumnos',
                'imag' => '/img/icons/48x48/importar.png',
            ],
        ];
        $this->set([
            'title' => 'Creacion y edicion de pruebas/categorias',
            'nav' => $nav,
            'module' => 'pruebas',
        ]);
        $this->autoRender = false;
        $this->render('Module/index');
    }

    public function listar($page = 1, $orderby = null, $order = 'A')
    {
        $this->set([
            'usuario' => $this->Auth->User->usuario,
            'pruebas' => (new Model_Pruebas())->getByUser($this->Auth->User->id),
        ]);
    }

    public function listar_respuestas($page = 1, $orderby = null, $order = 'A')
    {
        $this->set([
            'usuario' => $this->Auth->User->usuario,
            'pruebas' => (new Model_Pruebas())->getByUser($this->Auth->User->id),
        ]);
    }

    public function resultados_ppregunta($id, $order = '1')
    {

        $this->set('usAct', (new Model_Pruebas())->getByUser($this->Auth->User->id_profesor));  
	  $this->set('user', $this->Auth->User->id_profesor);
	  $this->set('usuarios', (new Model_Usuarios())->conCategoriasPruebasPublicas());
	$Usuario = new \sowerphp\app\Sistema\Usuarios\Model_Usuario($this->Auth->User->id);
        // si el usuario no existe error
        if (!isset($Usuario)) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Error', 'error'
            );
            $this->redirect('/usuarios');
        }
        if (!$Usuario->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Usuario no válido', 'error'
            );
            $this->redirect('/usuarios');
        }
        // buscar pruebas de cada categoria
        $categorias = (new Model_Categorias())->getListByUser(
            $Usuario->id, true
        );
        // el usuario no tiene categorías públicas
        if (!$categorias) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Usuario <em>'.$usuario.'</em> no tiene categorías públicas', 'warning'
            );
            $this->redirect('/usuarios');
        }
        $Pruebas = (new Model_Pruebas())->getByUser($this->Auth->User->id);
	$porpreguntas = (new Model_Alumnoporpregunta())->BuscarPregunta($id);

        /*foreach($categorias as &$categoria) {
            $categoria['pruebas'] = $Pruebas->getByUser(
                $this->Auth->User->id
            );
        }*/
        // setear variables para la vista
        $this->set([
	    'pruebaid' => $id,
	    'porpregunta' => $porpreguntas,
            'usuario' => $Usuario->usuario,
            'nombre' => $Usuario->nombre,
            'categorias' => $categorias,
            'header_title' => $Usuario->usuario,
        ]);


    }

    public function crear()
    {
    $i=0;
    $descAux;//auxiliar de descripcion del pregunta
    $pos=0;//contador de posicion de la pregunta
    $posAux=0;//auxiliar utilizado para la edicion de las preguntas
        // si no se ha enviado el formulario se mostrará
        if(!isset($_POST['submit'])) {
            $this->set(array(
                'categorias' => (new Model_Categorias())->getListByUser($this->Auth->User->id),
            ));
        }
        // si se envió el formulario se procesa
        else {
            $_POST['prueba'] = trim($_POST['prueba']);
            $_POST['descripcion'] = trim($_POST['descripcion']);
            if (!isset($_POST['prueba'][0]) or !isset($_POST['descripcion']) or !(int)$_POST['categoria']) {
                \sowerphp\core\Model_Datasource_Session::message(
                    'Nombre, descripción y categoría de la prueba no pueden estar en blanco', 'warning'
                );
                $this->redirect('/pruebas/crear');
            }
            // guardar prueba
            $Prueba = new Model_Prueba();
            $Prueba->prueba = $_POST['prueba'];
            $Prueba->descripcion = $_POST['descripcion'];
            $Prueba->categoria = $_POST['categoria'];
            $Prueba->publica = isset($_POST['publica']) ? 'true' : 'false';
            $Prueba->save();
            //generar registro
            $Registro_Log = new Model_Registrolog();
            $Registro_Log->id_asoc = $Prueba->id;
            $Registro_Log->fecha = date('Y-m-d H:i:s');
            $Registro_Log->entidad_asoc = 'prueba';
            $Registro_Log->id_actor = $this->Auth->User->id;
            //$Registro_Log->tipo_actor = ACTOR
            $Registro_Log->nota = 'Creación: ' . $Prueba->prueba;
            $Registro_Log->save();
            // agregar preguntas
            foreach($_POST['preguntas'] as &$preguntaId) {
                $_POST['pregunta'.$preguntaId] = trim($_POST['pregunta'.$preguntaId]);
                if (!isset($_POST['pregunta'.$preguntaId][0])) continue;
                // guardar pregunta
                $Pregunta = new Model_Pregunta();
                $Pregunta->pregunta = $_POST['pregunta'.$preguntaId];
                $Pregunta->prueba = $Prueba->id;
                $Pregunta->tipo = 1;
                $Pregunta->explicacion = trim($_POST['explicacion'.$preguntaId]);
                $Pregunta->publica = isset($_POST['publica'.$preguntaId]) ? 'true' : 'false';
                $Pregunta->activa = isset($_POST['activa'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->resp_escrita = isset($_POST['resp_escrita'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->mapa = isset($_POST['mapa'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->alternativa = isset($_POST['alternativa'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->reordenar = isset($_POST['reordenar'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->escrita = isset($_POST['escrita'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->id_texto = $_POST['tipo'.$preguntaId];;
		
                $Pregunta->save();
                //generar registro
		$Registro_Log = new Model_Registrolog();
		$Registro_Log->id_asoc = $Pregunta->id;
		$Registro_Log->fecha = date('Y-m-d H:i:s');
		$Registro_Log->entidad_asoc = 'pregunta';
		$Registro_Log->id_actor = $this->Auth->User->id;
		//$Registro_Log->tipo_actor = ACTOR
		$Registro_Log->nota = 'Creación: ' . $Pregunta->pregunta;
		$Registro_Log->save();
                // guardar imagen si es que existe
                if (!$_FILES['imagen'.$preguntaId]['error']) {
                    $Pregunta->saveImage($_FILES['imagen'.$preguntaId]);
                }
                // agregar respuestas
                foreach ($_POST['respuesta'.$preguntaId] as &$respuesta) {
                    $respuesta = trim($respuesta);
                    if (!isset($respuesta[0])) continue;
                    // determinar si la respuesta es correcta o incorrecta
                    $correcta = 'false';
                    if ($respuesta[0]=='*') {
                        $correcta = 'true';
                        $respuesta = substr($respuesta, 1);
                    }
                    // guardar respuesta
                    $Respuesta = new Model_Respuesta();
                    $Respuesta->respuesta = $respuesta;
                    $Respuesta->pregunta = $Pregunta->id;
                    $Respuesta->correcta = $correcta;
		    $Respuesta->pos = $pos;
                    $Respuesta->save();
		    $pos++;
                }
	     $pos=0;
            }
            // mensaje y redireccionar
            \sowerphp\core\Model_Datasource_Session::message(
               'Prueba creada', 'ok'
            );
            $this->redirect('/pruebas/editar_respuestas/'.$Prueba->id.'');
        }
    }

    /**
     * Controlador para editar un registro de tipo Prueba
     */
    public function editar($id)
    {
	$i=0;
	$descAux;
	$pos=0;//contador de posicion de la pregunta
        $posAux=0;//auxiliar utilizado para la edicion de las preguntas
        $Prueba = new Model_Prueba($id, false, false, false);
        // si el registro que se quiere editar y no existe error
        if (!$Prueba->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La prueba solicitada no existe, no se puede editar',
                'error'
            );
            $this->redirect('/pruebas/listar');
        }
        // si no es el dueño de la prueba error
        if ($Prueba->getCategoria()->usuario!=$this->Auth->User->id) {
            \sowerphp\core\Model_Datasource_Session::message(
                'No es el autor de la prueba, no se puede editar',
                'error'
            );
            $this->redirect('/pruebas/listar');
        }
        // si no se ha enviado el formulario se mostrará
        if (!isset($_POST['submit'])) {
            $this->set(array(
                'Prueba' => $Prueba,
                'categorias' => (new Model_Categorias())->getListByUser($this->Auth->User->id),
            ));
        }
        // si se envió el formulario se procesa
        else {
            $_POST['prueba'] = trim($_POST['prueba']);
            $_POST['descripcion'] = trim($_POST['descripcion']);
            if (!isset($_POST['prueba'][0]) or !isset($_POST['descripcion']) or !(int)$_POST['categoria']) {
                \sowerphp\core\Model_Datasource_Session::message(
                    'Nombre, descripción y categoría de la prueba no pueden estar en blanco', 'warning'
                );
                $this->redirect('/pruebas/editar/'.$Prueba->id);
            }
            //datos para comparar la edición y añadir al log
            $NombrePrueba = $Prueba->prueba;
            $Descripcion = $Prueba->descripcion;
            $Categoria = $Prueba->categoria;
            $PublicaPrueba = ($Prueba->publica) ? 'true' : 'false';
            // guardar datos generales de la prueba
            $Prueba->prueba = $_POST['prueba'];
            $Prueba->descripcion = $_POST['descripcion'];
            $Prueba->categoria = $_POST['categoria'];
            $Prueba->publica = isset($_POST['publica']) ? 'true' : 'false';
            $Prueba->modificada = date('Y-m-d H:i:s');
            $Prueba->save();
            //generar registro
            $Registro_Log = new Model_Registrolog();
            $Registro_Log->id_asoc = $Prueba->id;
            $Registro_Log->fecha = date('Y-m-d H:i:s');
            $Registro_Log->entidad_asoc = 'prueba';
            //$Registro_Log->tipo_actor = ACTOR
            
            
            $Registro_Log->id_actor = $this->Auth->User->id;
            //Comparaciones para ver qué se cambió
            $String1='';
            $GenerarLog = false;
            if(strcmp($NombrePrueba, $Prueba->prueba) != 0){
	      $String1 = '-Nombre de ' .$NombrePrueba. ' a ' . $Prueba->prueba;
	      $GenerarLog = true;
            }
            $String2 ='';
            if(strcmp($Descripcion,$Prueba->descripcion) != 0){
	      $String2 = '-Descripcion de ' . $Descripcion . ' a ' . $Prueba->descripcion;
	      $GenerarLog = true;
            }
            $String3 ='';
            if(strcmp($Categoria,$Prueba->categoria) != 0){
	      $String3 = '-Categoria de ' . $Categoria . ' a ' . $Prueba->categoria;
	      $GenerarLog = true;
            }
            $String4 ='';
            if(strcmp($PublicaPrueba,$Prueba->publica) != 0){
	      $String4 = '-Privacidad de ' . $PublicaPrueba . ' a ' . $Prueba->publica;
	      $GenerarLog = true;
            }
            //Generar o no el log
            if($GenerarLog == true){
	      $Registro_Log->nota = 'Modificación: '.$Prueba->prueba.' ' . $String1. $String2.$String3.$String4;
	      $Registro_Log->save();
            }
            // limpiar preguntas, dejando solo las que han sido pasadas
            if (is_array($_POST['preguntasIds']))
                $Prueba->dejarPreguntas($_POST['preguntasIds']);
            // guardar preguntas
            foreach ($_POST['preguntas'] as &$preguntaId) {
                $_POST['pregunta'.$preguntaId] = trim($_POST['pregunta'.$preguntaId]);
                if (!isset($_POST['pregunta'.$preguntaId][0])) continue;
           // guardar prueba
           
            //generar registro
            $Registro_Log = new Model_Registrolog();
            $Registro_Log->id_asoc = $Pregunta->id;
            $Registro_Log->fecha = date('Y-m-d H:i:s');
            $Registro_Log->entidad_asoc = 'pregunta';
            //$Registro_Log->tipo_actor = ACTOR
            $Registro_Log->id_actor = $this->Auth->User->id;
                // guardar pregunta
                $Pregunta = new Model_Pregunta();
                $Pregunta->id = !empty($_POST['id'.$preguntaId]) ? $_POST['id'.$preguntaId] : null;
                $Pregunta->get();
                //datos para comparar la edición y añadir al log
		    $NombrePregunta = $Pregunta->pregunta;
		    $PublicaPregunta = ($Pregunta->publica) ? 'true' : 'false';
		    $TipoPregunta = $Pregunta->tipo;
		    $ExplicacionPregunta = $Pregunta->explicacion;
		    $ActivaPregunta = ($Pregunta->activa)? 'true' : 'false';
                $Pregunta->pregunta = $_POST['pregunta'.$preguntaId];
                $Pregunta->prueba = $Prueba->id;
                $Pregunta->tipo = 1;
                $Pregunta->explicacion = trim($_POST['explicacion'.$preguntaId]);
                $Pregunta->publica = isset($_POST['publica'.$preguntaId]) ? 'true' : 'false';
                $Pregunta->activa = isset($_POST['activa'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->resp_escrita = isset($_POST['resp_escrita'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->mapa = isset($_POST['mapa'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->alternativa = isset($_POST['alternativa'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->reordenar = isset($_POST['reordenar'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->escrita = isset($_POST['escrita'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->numerocorrectas=0;
		$Pregunta->numeromedias=0;
		$Pregunta->id_texto = $_POST['tipo'.$preguntaId];
		echo $_POST['tipo'.$preguntaId];
                $Pregunta->save();
                // guardar imagen si es que existe
                
                //Comparaciones para ver qué se cambió
            $String1='';
            $GenerarLog = false;
            if(strcmp($NombrePregunta, $Pregunta->pregunta) != 0){
	      $String1 = '-Enunciado de: ' .$NombrePregunta. ' a: ' . $Pregunta->pregunta. ' ';
	      $GenerarLog = true;
            }
            $String2 ='';
            if(strcmp($PublicaPregunta,$Pregunta->publica) != 0){
	      $String2 = '-Privacidad de: ' . $PublicaPregunta . ' a: ' . $Pregunta->publica.' ';
	      $GenerarLog = true;
            }
            $String3 ='';
            if(strcmp($ExplicacionPregunta,$Pregunta->explicacion) != 0){
	      $String3 = '-Explicación de: ' . $ExplicacionPregunta . ' a: ' . $Pregunta->explicacion. ' ';
	      $GenerarLog = true;
            }
            $String4 ='';
            if(strcmp($ActivaPregunta,$Pregunta->activa) != 0){
	      $String4 = '-Activa de: ' . $ActivaPregunta . ' a: ' . $Pregunta->activa. ' ';
	      $GenerarLog = true;
            }
            //Generar o no el log
            if($GenerarLog == true){
	      $Registro_Log->nota = 'Modificación: '.$Pregunta->pregunta.' ' . $String1. $String2.$String3.$String4;
	      $Registro_Log->save();
            }
            // mensaje y redireccionar
            
            //

                if (!$_FILES['imagen'.$preguntaId]['error']) {
                    $detectedType = exif_imagetype($_FILES['imagen'.$preguntaId]['tmp_name']);
                    if (!in_array($detectedType, $this->allowedImageTypes)) {
                        \sowerphp\core\Model_Datasource_Session::message(
                            'Imagen debe ser PNG, JPG o GIF', 'warning'
                        );
                        $this->redirect('/pruebas/editar/'.$Prueba->id);
                    }
                    $Pregunta->saveImage($_FILES['imagen'.$preguntaId]);
                }
                // limpiar respuestas, dejando solo las que han sido pasadas
                if (is_array($_POST['respuestaId'.$preguntaId]))
                    $Pregunta->dejarRespuestas($_POST['respuestaId'.$preguntaId]);
                // guardar respuestas
                foreach ($_POST['respuesta'.$preguntaId] as $key => &$respuesta) {
                    $respuesta = trim($respuesta);
                    if (!isset($respuesta[0])) continue;
                    // determinar si la respuesta es correcta o incorrecta
                    $correcta = 'false';
                    if ($respuesta[0]=='*') {
                        $correcta = 'true';
                        $respuesta = substr($respuesta, 1);
                    }
                    // guardar respuesta
                    $Respuesta = new Model_Respuesta();
                    $Respuesta->id = !empty($_POST['respuestaId'.$preguntaId][$key]) ? $_POST['respuestaId'.$preguntaId][$key] : null;
                    $Respuesta->get();
                    $Respuesta->respuesta = $respuesta;
                    $Respuesta->pregunta = $Pregunta->id;
                    $Respuesta->correcta = $correcta;
		    $Respuesta->pos = $pos;
                    $Respuesta->save();
		    $pos++;
                }
		$pos=0;
            }
            // mensaje y redireccionar
            \sowerphp\core\Model_Datasource_Session::message(
                'Prueba editada',
                'ok'
            );
            $this->redirect('/pruebas/editar_respuestas');
        }
    }

    public function editar_respuestas($id)
    {

	$pos=0;//contador de posicion de la pregunta
        $posAux=0;//auxiliar utilizado para la edicion de las preguntas
        $Prueba = new Model_Prueba($id, false, false, false);
        // si el registro que se quiere editar y no existe error
        if (!$Prueba->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La prueba solicitada no existe, no se puede editar',
                'error'
            );
            $this->redirect('/pruebas/listar');
        }
        // si no es el dueño de la prueba error
        if ($Prueba->getCategoria()->usuario!=$this->Auth->User->id) {
            \sowerphp\core\Model_Datasource_Session::message(
                'No es el autor de la prueba, no se puede editar',
                'error'
            );
            $this->redirect('/pruebas/listar');
        }
        // si no se ha enviado el formulario se mostrará
        if (!isset($_POST['submit'])) {
            $this->set(array(
                'Prueba' => $Prueba,
                'categorias' => (new Model_Categorias())->getListByUser($this->Auth->User->id),
            ));
        }
        // si se envió el formulario se procesa
        else {
            $_POST['prueba'] = trim($_POST['prueba']);
            $_POST['descripcion'] = trim($_POST['descripcion']);
            if (!isset($_POST['prueba'][0]) or !isset($_POST['descripcion']) or !(int)$_POST['categoria']) {
                \sowerphp\core\Model_Datasource_Session::message(
                    'Nombre, descripción y categoría de la prueba no pueden estar en blanco', 'warning'
                );
                $this->redirect('/pruebas/editar/'.$Prueba->id);
            }
            //datos para comparar la edición y añadir al log
            $NombrePrueba = $Prueba->prueba;
            $Descripcion = $Prueba->descripcion;
            $Categoria = $Prueba->categoria;
            $PublicaPrueba = ($Prueba->publica) ? 'true' : 'false';
            // guardar datos generales de la prueba
            $Prueba->prueba = $_POST['prueba'];
            $Prueba->descripcion = $_POST['descripcion'];
            $Prueba->categoria = $_POST['categoria'];
            $Prueba->publica = isset($_POST['publica']) ? 'true' : 'false';
            $Prueba->modificada = date('Y-m-d H:i:s');
	    $Prueba->save();
            //generar registro
            $Registro_Log = new Model_Registrolog();
            $Registro_Log->id_asoc = $Prueba->id;
            $Registro_Log->fecha = date('Y-m-d H:i:s');
            $Registro_Log->entidad_asoc = 'prueba';
            //$Registro_Log->tipo_actor = ACTOR
            
            
            $Registro_Log->id_actor = $this->Auth->User->id;
            //Comparaciones para ver qué se cambió
            $String1='';
            $GenerarLog = false;
            if(strcmp($NombrePrueba, $Prueba->prueba) != 0){
	      $String1 = '-Nombre de ' .$NombrePrueba. ' a ' . $Prueba->prueba;
	      $GenerarLog = true;
            }
            $String2 ='';
            if(strcmp($Descripcion,$Prueba->descripcion) != 0){
	      $String2 = '-Descripcion de ' . $Descripcion . ' a ' . $Prueba->descripcion;
	      $GenerarLog = true;
            }
            $String3 ='';
            if(strcmp($Categoria,$Prueba->categoria) != 0){
	      $String3 = '-Categoria de ' . $Categoria . ' a ' . $Prueba->categoria;
	      $GenerarLog = true;
            }
            $String4 ='';
            if(strcmp($PublicaPrueba,$Prueba->publica) != 0){
	      $String4 = '-Privacidad de ' . $PublicaPrueba . ' a ' . $Prueba->publica;
	      $GenerarLog = true;
            }
            //Generar o no el log
            if($GenerarLog == true){
	      $Registro_Log->nota = 'Modificación: '.$Prueba->prueba.' ' . $String1. $String2.$String3.$String4;
	      $Registro_Log->save();
            }
            // limpiar preguntas, dejando solo las que han sido pasadas
            if (is_array($_POST['preguntasIds']))
                $Prueba->dejarPreguntas($_POST['preguntasIds']);
            // guardar preguntas
            foreach ($_POST['preguntas'] as &$preguntaId) {
		$i=0;
                $_POST['pregunta'.$preguntaId] = trim($_POST['pregunta'.$preguntaId]);
                if (!isset($_POST['pregunta'.$preguntaId][0])) continue;
           // guardar prueba
           
            //generar registro
            $Registro_Log = new Model_Registrolog();
            $Registro_Log->id_asoc = $Pregunta->id;
            $Registro_Log->fecha = date('Y-m-d H:i:s');
            $Registro_Log->entidad_asoc = 'pregunta';
            //$Registro_Log->tipo_actor = ACTOR
            $Registro_Log->id_actor = $this->Auth->User->id;
                // guardar pregunta
                $Pregunta = new Model_Pregunta();
                $Pregunta->id = !empty($_POST['id'.$preguntaId]) ? $_POST['id'.$preguntaId] : null;
                $Pregunta->get();
                //datos para comparar la edición y añadir al log
		    $NombrePregunta = $Pregunta->pregunta;
		    $PublicaPregunta = ($Pregunta->publica) ? 'true' : 'false';
		    $TipoPregunta = $Pregunta->tipo;
		    $ExplicacionPregunta = $Pregunta->explicacion;
		    $ActivaPregunta = ($Pregunta->activa)? 'true' : 'false';
                $Pregunta->pregunta = $_POST['pregunta'.$preguntaId];
                $Pregunta->prueba = $Prueba->id;
                $Pregunta->tipo = 1;
                $Pregunta->explicacion = trim($_POST['explicacion'.$preguntaId]);
                $Pregunta->publica = isset($_POST['publica'.$preguntaId]) ? 'true' : 'false';
                $Pregunta->activa = isset($_POST['activa'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->resp_escrita = isset($_POST['resp_escrita'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->mapa = isset($_POST['mapa'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->alternativa = isset($_POST['alternativa'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->reordenar = isset($_POST['reordenar'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->escrita = isset($_POST['escrita'.$preguntaId]) ? 'true' : 'false';
		$Pregunta->id_texto = $_POST['tipo'.$preguntaId];
                // guardar imagen si es que existe
                
                //Comparaciones para ver qué se cambió
            $String1='';
            $GenerarLog = false;
            if(strcmp($NombrePregunta, $Pregunta->pregunta) != 0){
	      $String1 = '-Enunciado de: ' .$NombrePregunta. ' a: ' . $Pregunta->pregunta. ' ';
	      $GenerarLog = true;
            }
            $String2 ='';
            if(strcmp($PublicaPregunta,$Pregunta->publica) != 0){
	      $String2 = '-Privacidad de: ' . $PublicaPregunta . ' a: ' . $Pregunta->publica.' ';
	      $GenerarLog = true;
            }
            $String3 ='';
            if(strcmp($ExplicacionPregunta,$Pregunta->explicacion) != 0){
	      $String3 = '-Explicación de: ' . $ExplicacionPregunta . ' a: ' . $Pregunta->explicacion. ' ';
	      $GenerarLog = true;
            }
            $String4 ='';
            if(strcmp($ActivaPregunta,$Pregunta->activa) != 0){
	      $String4 = '-Activa de: ' . $ActivaPregunta . ' a: ' . $Pregunta->activa. ' ';
	      $GenerarLog = true;
            }
            //Generar o no el log
            if($GenerarLog == true){
	      $Registro_Log->nota = 'Modificación: '.$Pregunta->pregunta.' ' . $String1. $String2.$String3.$String4;
	      $Registro_Log->save();
            }
            // mensaje y redireccionar
            
            //
		
                // limpiar respuestas, dejando solo las que han sido pasadas
                if (is_array($_POST['respuestaId'.$preguntaId]))
                    $Pregunta->dejarRespuestas($_POST['respuestaId'.$preguntaId]);
                // guardar respuestas
                foreach ($_POST['respuesta'.$preguntaId] as $key => &$respuesta) {
                    $respuesta = trim($respuesta);
                    if (!isset($respuesta[0])) continue;
                    // determinar si la respuesta es correcta o incorrecta
                    $correcta = 'false';
                    if ($respuesta[0]=='*') {
                        $correcta = 'true';
                        $respuesta = substr($respuesta, 1);
                    }
                    // guardar respuesta
                    $Respuesta = new Model_Respuesta();
                    $Respuesta->id = !empty($_POST['respuestaId'.$preguntaId][$key]) ? $_POST['respuestaId'.$preguntaId][$key] : null;
                    $Respuesta->get();
                    $Respuesta->respuesta = $respuesta;
                    $Respuesta->pregunta = $Pregunta->id;
		    $Respuesta->pos = $pos;
	            if ($Pregunta->alternativa=='true'){
		    	$Respuesta->puntaje=$_POST['puntaje'.$Respuesta->id];
			if($Respuesta->puntaje == 2) $Respuesta->correcta= 't';
			if($Respuesta->puntaje == 1) $Respuesta->media_correcta= 't';
			if($Respuesta->puntaje == 0) $Respuesta->nula= 't';
			$puntaje_t+=2;	
			}
	 	    else if ($Pregunta->escrita=='true' || $Pregunta->mapa=='true' || $Pregunta->resp_escrita=='true'){
			$Pregunta->numerocorrectas=$_POST['NRBC'.$Pregunta->id];
			$Pregunta->numeromedias=$_POST['NRBM'.$Pregunta->id];
			$Respuesta->correcta = isset($_POST['correcta'.$Respuesta->id]) ? 'true' : 'false';
			$puntaje_t+=2;	
			}
		    else{
			if ($i==0){
				$Respuesta->puntaje=2;
				$puntaje_t+=2;	
				}
			else if ($i<5){
				$Respuesta->puntaje=1;	
				$puntaje_t+=1;	
				}
			else {
				$Respuesta->puntaje=2;
				$puntaje_t+=2;		
				}
			}
		    //$Pregunta->escrita = isset($_POST['escrita'.$preguntaId]) ? 'true' : 'false';
                    $Respuesta->save();
		    $pos++;
		    $i++;
                }

		$Pregunta->save();
		$pos=0;
            }

            // mensaje y redireccionar
            \sowerphp\core\Model_Datasource_Session::message(
                'Prueba editada',
                'ok'
            );
            $this->redirect('/pruebas/listar_respuestas');
        }
    }


    public function eliminar($id)
    {
        $Prueba = new Model_Prueba($id, false, false);
        // si el registro que se quiere eliminar y no existe error
        if (!$Prueba->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La prueba solicitada no existe, no se puede eliminar',
                'error'
            );
            $this->redirect('/pruebas/listar');
        }
        // si no es el dueño de la prueba error
        if ($Prueba->getCategoria()->usuario!=$this->Auth->User->id) {
            \sowerphp\core\Model_Datasource_Session::message(
                'No es el autor de la prueba, no se puede eliminar',
                'error'
            );
            $this->redirect('/pruebas/listar');
        }
        //generar registro
            $Registro_Log = new Model_Registrolog();
            $Registro_Log->id_asoc = $Prueba->id;
            $Registro_Log->fecha = date('Y-m-d H:i:s');
            $Registro_Log->entidad_asoc = 'prueba';
            $Registro_Log->id_actor = $this->Auth->User->id;
            //$Registro_Log->tipo_actor = ACTOR
            $Registro_Log->nota = 'Eliminación: '. $Prueba->prueba;
            $Registro_Log->save();
        // eliminar prueba
        $Prueba->delete();
        \sowerphp\core\Model_Datasource_Session::message(
            'Prueba eliminada', 'ok'
        );
        $this->redirect('/pruebas/listar');
    }

    public function subir($id)
    {
        $Prueba = new Model_Prueba($id);
        // si el registro que se quiere editar y no existe error
        if (!$Prueba->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La prueba solicitada no existe, no se puede editar',
                'error'
            );
            $this->redirect('/pruebas/listar');
        }
        // si no es el dueño de la prueba error
        if ($Prueba->getCategoria()->usuario!=$this->Auth->User->id) {
            \sowerphp\core\Model_Datasource_Session::message(
                'No es el autor de la prueba, no se puede editar',
                'error'
            );
            $this->redirect('/pruebas/listar');
        }
        // solo se procesa si el orden es mayor a 1
        if($Prueba->orden>1) {
            $Prueba->intercambiarOrden($Prueba->orden-1);
        }
        // redireccionar
        $this->redirect('/pruebas/listar');
    }

    public function bajar($id)
    {
        $Prueba = new Model_Prueba($id);
        // si el registro que se quiere editar y no existe error
        if (!$Prueba->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La prueba solicitada no existe, no se puede editar',
                'error'
            );
            $this->redirect('/pruebas/listar');
        }
        // si no es el dueño de la prueba error
        if ($Prueba->getCategoria()->usuario!=$this->Auth->User->id) {
            \sowerphp\core\Model_Datasource_Session::message(
                'No es el autor de la prueba, no se puede editar',
                'error'
            );
            $this->redirect('/pruebas/listar');
        }
        // solo se procesa si el orden es menor que el maximo existente
        $Pruebas = new Model_Pruebas();
        $Pruebas->setWhereStatement(['categoria = :categoria'], [':categoria'=>$Prueba->categoria]);
        if($Prueba->orden<$Pruebas->getMax('orden')) {
            $Prueba->intercambiarOrden($Prueba->orden+1);
        }
        // redireccionar
        $this->redirect('/pruebas/listar');
    }

    public function generar()
    {
        $categorias = (new Model_Categorias())->getListByUser($this->Auth->User->id);
        $Pruebas = new Model_Pruebas();
        $pruebas = [];
        foreach($categorias as &$categoria) {
            $aux = $Pruebas->getByCategoria($categoria['id']);
            foreach($aux as &$prueba) {
                $pruebas[] = [
                    $prueba['id'],
                    $categoria['categoria'],
                    $prueba['prueba'],
                    $prueba['preguntas'],
                ];
            }
        }
        $this->set([
            'tipos' => (new Model_Tipos())->getList(true),
            'pruebas' => $pruebas,
        ]);
    }

    public function generar_pdf()
    {
        // si no se viene por POST redireccionar
        if (!isset($_POST['submit'])) {
            \sowerphp\core\Model_Datasource_Session::message(
                'No puede acceder directamente a la página '.$this->request->request,
                'warning'
            );
            $this->redirect('/pruebas/generar');
        }
        // determinar cantidad de cada tipo
        $tipos_porcentaje = [];
	$preguntas = [];
	$id=$_POST['prueba_id'];
        $tipos = (new Model_Tipos())->getList();
        foreach($tipos as &$t) {
            $tipos_porcentaje[$t['id']] = !empty($_POST['tipo_'.$t['id']]) ? $_POST['tipo_'.$t['id']] : 0;
        }
        // obtener preguntas
        /*$preguntas = (new Model_Pruebas())->getPreguntas(
            $id,
            $this->Auth->User->id,
            $tipos_porcentaje,
            $_POST['preguntas']
        );
	*/
	$pregunta = (new Model_Pruebas())->getDatos(
            $id
        );
	$aux = $pregunta;
            foreach($aux as &$prueba) {
                $preguntas[] = [
                    $prueba['nombre'],
                    $prueba['id_pregunta_relacionada'],
                    $prueba['puntos'],
                ];
            }
        // asignar variables para la vista
        $this->set([
            'pruebas_cantidad' => $_POST['pruebas'],
            'materia' => $_POST['materia'],
            'titulo' => $_POST['titulo'],
            'autor' => $this->Auth->User->nombre,
            'organizacion' => $_POST['organizacion'],
            'fecha' => $_POST['fecha'],
            'descuento' => $_POST['descuento'],
            'preguntas' => $preguntas,
        ]);

    }

   

    /**
     * Acción para mostrar formulario para resolver prueba en línea
     */
    public function resolver($prueba)
    {

        $Prueba = new Model_Prueba($prueba); // do the magic
        // si la prueba no existe se da un mensaje de error
        if (!$Prueba->exists(true)) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La prueba que ha solicidado no existe, no especificó una o bien es una prueba privada (o de categoría privada)',
                'error'
            );
            $this->redirect('/');
        }
        // setear variables
        $this->set(array(
            'id'=>$Prueba->id,
            'categoria'=>$Prueba->getCategoria()->categoria,
            'prueba'=>$Prueba->prueba,
	    'descripcion'=>$Prueba->descripcion,
            'autor'=>$Prueba->autor,
            'generada'=>$Prueba->generada,
            'modificada'=>$Prueba->modificada,
            'creada'=>$Prueba->creada,
            'preguntas'=>$Prueba->preguntas,
            'total'=>$Prueba->questions(),
            'usuario'=>$Prueba->getCategoria()->getUsuario()->usuario,
            'categoria_id'=>$Prueba->categoria,
            'categoria_url'=>\sowerphp\core\Utility_String::normalize($Prueba->getCategoria()->categoria),
            'header_title'=>'Resolver '.$Prueba->prueba.' ('.$Prueba->getCategoria()->categoria.') by '.$Prueba->getCategoria()->getUsuario()->usuario,
        ));
    }

    /**
     * Acción para mostrar los resultados de la prueba enviada en línea
     */
    public function resultado($prueba)
    {
	$i=0;
	$puntaje_t=0;
	$contR=0;
        $Prueba = new Model_Prueba($prueba);
        // si la prueba no existe error
        if (!$Prueba->exists(true)) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La prueba que ha solicidado no existe, no especificó una o bien es una prueba privada (o de categoría privada)',
                'error'
            );
            $this->redirect('/');
        }
        // si no se viene de un formulario error
        if (!isset($_POST['submit'])) {
            \sowerphp\core\Model_Datasource_Session::message(
                'No puede acceder directamente a la página de resultados',
                'error'
            );
            $this->redirect('/p/'.$prueba);
        }
        // si es un formulario se procesa
        else {
            // armar arreglo con las respuestas
            $respuestas = array();
	    $rep;
	    $resp;
	    $conttext = 1;
	    $resp= '';
	    $respaux= '';
            foreach($_POST as $key => &$value) {
                if(substr($key, 0, 8) == 'pregunta') {
		    $resp.= $conttext.') ';
                    $respuestas[substr($key, 8)] = $value;
		    //print_r(array_values($value));
		    //$resp= print_r(array_values($respuestas)); //revisar esta parte, posible solucion a problemas del mapa conceptual
		    $cont = 0;
		foreach($value as $valor){
			if ($cont == 0){
				$resp.=  $valor;
				$respaux.= $valor;
				}
			else{
				$resp.= ' - '.$valor;
				$respaux.= '-'.$valor;
				}
			$cont++;
			}
			$conttext++;
			$resp.= '<br \>';
			$respaux.= '_';
		    foreach($Prueba->preguntas as &$question) {
			
			if($question->mapa==TRUE || $question->escrita==TRUE|| $question->reordenar==TRUE || $question->resp_escrita==TRUE){
				if ($question->reordenar==TRUE) $contR+=1;
            			foreach($question->respuestas as &$answer) {
                			for ($i=0; $i<count($value); $i++ ){
						if ($value[$i]==$answer->respuesta)
							$answer->possel=$i;
						}
           		 	}
       		 	}
		   }
                   sort($respuestas[substr($key, 8)]);
			}
                }
		//echo $resp;
            }
            $fecha = date('Y-m-d H:i:s');
            $alumno = $this->Auth->User->id;
            // procesar respuestas
            $correctas = $this->_check($Prueba->preguntas, $respuestas, $alumno, ($Prueba->id), $fecha, $respaux, $value);
            // setear variables para la vista
            $total = $Prueba->questions();
	    $puntaje_t+=2*($total - $contR);
	    $puntaje_r=$contR*8;
	    $puntaje_t+=$puntaje_r;
            $porcentaje = ($correctas/$total)*100;
            //setear variables para las estadísticas
            $PorPrueba = new Model_Alumnoporprueba();
            $PorPrueba->fecha_resolucion = $fecha;
            $PorPrueba->id_alumno = $alumno;
            $PorPrueba->cantidad_preguntas = $puntaje_r;
            $PorPrueba->total_buenas = intval(($correctas*100)/$puntaje_t);
            //$PorPrueba->total_omitidas = ??;
            $PorPrueba->total_malas = $total - $correctas;
            $PorPrueba->nota = $correctas;
            $PorPrueba->id_prueba_relacionada = $Prueba->id;
	    $PorPrueba->respuestas = $resp;
            $PorPrueba->save();
            $this->set(array(
                'id'=>$Prueba->id,
                'categoria'=>$Prueba->getCategoria()->categoria,
                'prueba'=>$Prueba->prueba,
                'autor'=>$Prueba->autor,
                'generada'=>$Prueba->generada,
                'modificada'=>$Prueba->modificada,
                'creada'=>$Prueba->creada,
                'correctas' => $correctas.' / '.$total,
                'porcentaje' => number_format($porcentaje).' / 100',
                'nota' => $correctas,
                'usuario'=>$Prueba->getCategoria()->getUsuario()->usuario,
                'categoria_id'=>$Prueba->categoria,
                'categoria_url'=>\sowerphp\core\Utility_String::normalize($Prueba->getCategoria()->categoria),
            ));
        }

    private function _check($preguntas, $respuestas, $usuario, $prueba, $fecha, $respaux, $value)
    {
        $correctas = 0;
	$puntaje = 0;
	$i=0;
	$strlen = strlen($respaux);//tamaño del string respaux para recorrerlo e ir guardando las respuestas en la variable respuestas
	$stringaux= '';
	$findme = '_';//Variable que separa cada respuesta dentro del strung respaux
        // para cada pregunta de la prueba
        foreach($preguntas as &$pregunta) {
		$PorPregunta = new Model_Alumnoporpregunta();
		$PorPregunta2 = new Model_Alumnoporpregunta($prueba);
		foreach($PorPregunta2 as $alumnito){
			echo $alumnito;
		
		}
		$PorPregunta->id_prueba_relacionada = $prueba;
		$PorPregunta->fecha_resolucion = $fecha;
		$PorPregunta->id_alumno= $usuario;
		$PorPregunta->cantidad_alternativas = 0;
		$PorPregunta->correcta = 0;
		$PorPregunta->tipo = $pregunta->tipo;
		$PorPregunta->id_pregunta_relacionada = $pregunta->id;
		$PorPregunta->puntos = 0;
		while($i < $strlen) {
			if ($respaux[$i] == $findme){
				$i++;
				break;
				}
			else{
				$stringaux.= $respaux[$i];
				$i++;
				}
			}

		$PorPregunta->respuesta = $stringaux;
		$stringaux = '';
		//$PorPregunta->puntaje_pregunta =
            // verificar solo si se respondió la pregunta
	    if ($pregunta->mapa==TRUE || $pregunta->escrita==TRUE){
		if(isset($respuestas[$pregunta->id])){
			$PorPregunta->puntos = $pregunta->verPuntaje($pregunta->numeromedias, $pregunta->numerocorrectas);
			if ($PorPregunta->puntos != 0) $PorPregunta->correcta = 1;
			$puntaje+=$PorPregunta->puntos;
			$PorPregunta->cantidad_alternativas = count($pregunta->loadAnswers(false));
			++$correctas;
			}
		}
            else if($pregunta->alternativa==TRUE && isset($respuestas[$pregunta->id])) {
		$PorPregunta->puntos = $pregunta->verPuntajeAlt($respuestas[$pregunta->id]);
		if ($PorPregunta->puntos != 0) $PorPregunta->correcta = 1;
		$puntaje+=$PorPregunta->puntos;
		$PorPregunta->cantidad_alternativas = count($pregunta->loadAnswers(false));
		++$correctas;
            }
	    else if($pregunta->resp_escrita==TRUE && isset($respuestas[$pregunta->id])) {
		
		$PorPregunta->puntos = $pregunta->verPuntajeEsc($pregunta->numeromedias, $pregunta->numerocorrectas, $respuestas[$pregunta->id]);
		if ($PorPregunta->puntos != 0) $PorPregunta->correcta = 1;
		$puntaje+=$PorPregunta->puntos;
		$PorPregunta->cantidad_alternativas = count($pregunta->loadAnswers(false));
		++$correctas;
            }
	    else if($pregunta->reordenar==TRUE && isset($respuestas[$pregunta->id]) && $pregunta->answersCorrect()==$respuestas[$pregunta->id]) {
		$PorPregunta->puntos = $pregunta->verPuntajeRe();
		if ($PorPregunta->puntos != 0) $PorPregunta->correcta = 1;
		$puntaje+=$PorPregunta->puntos;
		$PorPregunta->cantidad_alternativas = count($pregunta->loadAnswers(false));
		++$correctas;
            }
            $PorPregunta->save();
        }
        return $puntaje;
    }

    public function mostrar($prueba)
    {
        $Prueba = new Model_Prueba($prueba); // do the magic
        // si la prueba no existe se da un mensaje de error
        if (!$Prueba->exists(true)) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La prueba que ha solicidado no existe, no especificó una o bien es una prueba privada (o de categoría privada)',
                'error'
            );
            $this->redirect('/');
        }
        // total de preguntas
        $publicas = $Prueba->questions();
        // definir pregunta random
        $Pregunta = $Prueba->preguntas[rand(0,$publicas-1)];
        // setear variables
        $this->set(array(
            'id'=>$Prueba->id,
            'categoria'=>$Prueba->getCategoria()->categoria,
            'prueba'=>$Prueba->prueba,
            'autor'=>$Prueba->autor,
            'generada'=>$Prueba->generada,
            'modificada'=>$Prueba->modificada,
            'creada'=>$Prueba->creada,
            'Pregunta'=>$Pregunta,
            'publicas'=>$publicas,
            'usuario'=>$Prueba->getCategoria()->getUsuario()->usuario,
            'categoria_id'=>$Prueba->categoria,
            'categoria_url'=>\sowerphp\core\Utility_String::normalize($Prueba->getCategoria()->categoria),
            'header_title'=>$Prueba->prueba.' ('.$Prueba->getCategoria()->categoria.') by '.$Prueba->getCategoria()->getUsuario()->usuario,
        ));
    }

    public function resultados_generales ($page = 1, $orderby = null, $order = 'A')
    {
	  $this->set('usAct', (new Model_Pruebas())->getByUser($this->Auth->User->id_profesor));  
	  $this->set('user', $this->Auth->User->id_profesor);
	  $this->set('usuarios', (new Model_Usuarios())->conCategoriasPruebasPublicas());
	$Usuario = new \sowerphp\app\Sistema\Usuarios\Model_Usuario($this->Auth->User->id);
        // si el usuario no existe error
        if (!isset($Usuario)) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Error', 'error'
            );
            $this->redirect('/usuarios');
        }
        if (!$Usuario->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Usuario no válido', 'error'
            );
            $this->redirect('/usuarios');
        }
        // buscar pruebas de cada categoria
        $categorias = (new Model_Categorias())->getListByUser(
            $Usuario->id, true
        );
        // el usuario no tiene categorías públicas
        if (!$categorias) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Usuario <em>'.$usuario.'</em> no tiene categorías públicas', 'warning'
            );
            $this->redirect('/usuarios');
        }
        $Pruebas = (new Model_Pruebas())->getByUser($this->Auth->User->id);
	$aux=0;
	$total= array();
	$promedio= array();
	$nota= array();
	foreach($Pruebas as &$prueba) {
		$porpruebas = (new Model_Alumnoporprueba())->resultadosG($prueba['id']);
   		array_push($total, count(array_column($porpruebas, 'total_buenas')));
		if ($total[$aux]==0){array_push($promedio, 0);}
		else{array_push($promedio, ((array_sum(array_column($porpruebas, 'total_buenas'))))/$total[$aux]);}
		if ($total[$aux]==0){array_push($nota, 0);}
		else{array_push($nota, ((array_sum(array_column($porpruebas, 'nota'))))/$total[$aux]);}
		$aux++;
		
	}
        /*foreach($categorias as &$categoria) {
            $categoria['pruebas'] = $Pruebas->getByUser(
                $this->Auth->User->id
            );
        }*/
        // setear variables para la vista
        $this->set([
	    'porprueba' => $promedio,
	    'notas' => $nota,
	    'pruebass' => $Pruebas,
            'usuario' => $Usuario->usuario,
            'nombre' => $Usuario->nombre,
            'categorias' => $categorias,
            'header_title' => $Usuario->usuario,
        ]);



    }


    public function grafico($tipo, $prueba)
    {
        $Prueba = new Model_Prueba($prueba); // do the magic
        // si la prueba no existe se da un mensaje de error
        if(!$Prueba->exists(true)) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La prueba que ha solicidado no existe, no especificó una o bien es una prueba privada (o de categoría privada)',
                'error'
            );
            $this->redirect('/');
        }
        echo 'prueba id :'.$prueba;
        // datos
        if ($tipo == 'privadas_publicas') {
            $title = 'Preguntas privadas y públicas';
            $publicas = $Prueba->questions();
            $data = ['Privadas'=>$Prueba->totalPreguntas()-$publicas, 'Públicas'=>$publicas];
        } else if ($tipo == 'por_tipo') {
            $title = 'Preguntas por tipo';
            $data = $Prueba->preguntasPorTipo();
        }
        // generar gráfico
        $chart = new \sowerphp\general\View_Helper_Chart();
        $chart->pie($title, $data, ['width'=>450, 'height'=>250]);
    }


}




