<?php

namespace website;

/** PHPExcel_IOFactory */
include 'PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';
/**
 * Clase final para el controlador asociado a la tabla usuario de la base de datos
 * Comentario de la tabla: Tabla para usuarios del sistema
 * Esta clase permite controlar las acciones entre el modelo y vista para la tabla usuario
 */
final class Controller_Usuarios extends \Controller_App
{   
    protected $data;
    public function beforeFilter()
    {
        $this->Auth->allow('index', 'mostrar', 'importar');
        parent::beforeFilter();
    }

    /**
     * Acción para mostrar el listado de usuarios
     */
    public function index()
    {
	if(isset($this->Auth->User->id)){
	  $this->set('usAct', (new Model_Pruebas())->getByUser($this->Auth->User->id_profesor));  
	  $this->set('user', $this->Auth->User->id_profesor);
	  $this->set('usuarios', (new Model_Usuarios())->conCategoriasPruebasPublicas());
	}else{
	  echo '<center>No se ha iniciado sesión aún</center>';
	}
    }

    /**
     * Controlador para mostrar el perfil público de un usuario
     * @param usuario Usuario que se quiere visualizar
     */
    public function mostrar($usuario)
    {
        $Usuario = new \sowerphp\app\Sistema\Usuarios\Model_Usuario($usuario);
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
        $Pruebas = new Model_Pruebas();
        foreach($categorias as &$categoria) {
            $categoria['pruebas'] = $Pruebas->getByCategoria(
                $categoria['id'], true
            );
        }
        // setear variables para la vista
        $this->set([
            'usuario' => $Usuario->usuario,
            'nombre' => $Usuario->nombre,
            'categorias' => $categorias,
            'header_title' => $Usuario->usuario,
        ]);
    }

    public function _api_crud_GET($usuario = null)
    {
        // entregar colección de usuarios
        if ($usuario===null) {
            return (new Model_Usuarios())->conCategoriasPruebasPublicas();
        }
        // entregar un usuario
        else {
            $Usuario = new \sowerphp\app\Sistema\Usuarios\Model_Usuario($usuario);
            // si el usuario no existe error
            if (!$Usuario->exists()) {
                $this->Api->send('Usuario no válido', 404);
            }
            // crear datos del usuario
            $categorias = (new Model_Categorias())->getListByUser(
                $Usuario->id, true
            );
            $Pruebas = new Model_Pruebas();
            foreach($categorias as &$categoria) {
                $categoria['pruebas'] = $Pruebas->getByCategoria(
                    $categoria['id'], true
                );
            }
            return [
                'usuario' => $Usuario->usuario,
                'nombre' => $Usuario->nombre,
                'categorias' => $categorias,
            ];
        }
    }
    
    /**
     * Controlador para direccionar la importación
     */
    public function importar(){
    }
    
    /**
     * Controlador para importar los alumnos registrados en un documento xls
     * @param excel Excel del cual se importarán los alumnos
     */
    public function usuariosimportar(){
	//Si no se seleccionó un archivo para importar
	if (!isset($_FILES['file'])){
	   \sowerphp\core\Model_Datasource_Session::message(
                '¡No se ha seleccionado un archivo excel desde donde importar!', 'warning'
            );
            $this->redirect('/usuarios/importar');

            }
	//Si no es un excel
	if (strcmp($_FILES['file']['type'], "application/vnd.ms-excel")!=0){
	  \sowerphp\core\Model_Datasource_Session::message(
                'Seleccione un archivo que sea de tipo excel', 'warning'
            );
            $this->redirect('/usuarios/importar');
        }
        $file = $_FILES['file']['tmp_name'];
	$inputFileType = 'Excel5';
	$inputFileName = $file;
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$objPHPExcelReader = $objReader->load($inputFileName);
	
	$sheetData = $objPHPExcelReader->getActiveSheet()->toArray(null,true,true,true);
      $this->set([
	  'usuario' => $this->Auth->User->usuario,
	  'usuarios' => $this->registrarusuarios($objPHPExcelReader, $this->Auth->User->id),
	  ]);
    }
    
    public function comprobar_email($email){
	  $mail_correcto = 0;
	  //compruebo unas cosas primeras
	  if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
	    if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
		//miro si tiene caracter .
		if (substr_count($email,".")>= 1){
		  //obtengo la terminacion del dominio
		  $term_dom = substr(strrchr ($email, '.'),1);
		  //compruebo que la terminación del dominio sea correcta
		  if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
		      //compruebo que lo de antes del dominio sea correcto
		      $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
		      $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
		      if ($caracter_ult != "@" && $caracter_ult != "."){
			$mail_correcto = 1;
		      }
		  }
		}
	    }
	  }
	  if ($mail_correcto)
	    return 1;
	  else
	    return 0;
      } 
    
    public function registrarusuarios($objPHPExcelReader, $Id_profesor){
	//require_once("");
	$mensajes = "Información: </br>";
	//recorrer filas del excel
	for($row = 2; $row !=null; $row++){
	    if($objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue()!=''){
		    // verificar que campos no sean vacios
		    $Nombre = $objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
		    $Apellido = $objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
		    $Rut = $objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
		    $Email = $objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
		    if(($Nombre !='') AND ($Apellido!='') AND ($Rut!='') AND ($Email!='') AND ($this->comprobar_email($Email))){
			// validar que el usuario y/o correo no exista previamente
			$Usuario = new Model_Usuario();
			$Usuario->nombre = $objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue().' '.$objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
			$Usuario->usuario = 'us'.$objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
			$Usuario->email = strtolower($objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue());
			if ($Usuario->checkIfUserAlreadyExists()) {
			    $mensajes = $mensajes.'<br/>Usuario con rut '.$objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue().' ya está en uso';
			    continue;
			}
			if ($Usuario->checkIfEmailAlreadyExists()) {
			    $mensajes = $mensajes.'<br/>Email '.$objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue().' ya está en uso';
			    continue;
			}
			// asignar contraseña al usuario
			$contrasenia = substr($Rut, 5);
			$Usuario->contrasenia = $Usuario->hashPassword($contrasenia);
			$Usuario->id_profesor =  $Id_profesor;
			// asignar hash al usuario
			do {
			
			    $Usuario->hash = \sowerphp\core\Utility_String::random(32);
			} while ($Usuario->checkIfHashAlreadyExists ());
			if ($Usuario->save()) {
			    // asignar grupos por defecto al usuario
			    /*if (is_array($config) and !empty($config['groups']))
				$Usuario->saveGroups($config['groups']);*/
			    // enviar correo
			    $emailConfig = \sowerphp\core\Configure::read('email.default');
			    /*if (!empty($emailConfig['type']) && !empty($emailConfig['user']) && !empty($emailConfig['pass'])) {
				$layout = $this->layout;
				$this->layout = null;
				$this->set([
				    'nombre'=>$Usuario->nombre,
				    'usuario'=>$Usuario->usuario,
				    'contrasenia'=>$contrasenia,
				]);
				$msg = $this->render('Usuarios/crear_email')->body();
				$this->layout = $layout;
				$email = new \sowerphp\core\Network_Email();
				$email->to($Usuario->email);
				$email->subject('Cuenta de usuario creada');
				$email->send($msg);
				\sowerphp\core\Model_Datasource_Session::message(
				    'Registro creado, se envió contraseña a '.$Usuario->email,
				    'ok'
				);
			    } else {*/
				echo $Id_profesor;
				$mensajes = $mensajes.'<br/>Registro de usuario: us'.$objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue().' creado con contraseña: '.$contrasenia;
			    //}
			} else {
			    $mensajes = $mensajes.'<br/>Registro de usuario '.$objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue().' falló por algún motivo '.$objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue().' ya está en uso';
			}
			$mensajes = $mensajes.'</br> Ingresado :'.$objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
		    }else{
			if (($this->comprobar_email($Email))==0) {
			     $mensajes = $mensajes.'<br/>Email '.$Email.' no válido';
			}
			if(($objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue()=='')
			 OR($objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue()=='')
			 OR($objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue()=='')
			 OR($objPHPExcelReader->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue()=='')){
			     $mensajes = $mensajes.'<br/>Se detectaron campos vacíos, favor rellenar.';
			}
		    }
	    }else{
	      break;
	    }
	}
	return $mensajes;
    }

}
