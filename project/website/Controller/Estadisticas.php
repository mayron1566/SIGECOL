<?php

namespace website;

/**
 * Controlador para las estadisticas
 */
class Controller_Estadisticas extends \Controller_App
{

    /*public function beforeFilter()
    {
        $this->Auth->allow('descargar', 'resolver', 'resultado', 'mostrar', 'grafico');
        parent::beforeFilter();
    }
*/
    /**
     * Acción para mostrar menú de acciones de estadisticas
     */
    public function index()
    {
        $nav = [
	    '/estadisticasgenerales' => [
                'name' => 'Estadísticas generales',
                'desc' => 'Visualizar estadísticas generales del sistema',
                'imag' => '/img/icons/48x48/estgenerales.png',
            ],
            '/../preguntas/visualizar' => [
                'name' => 'Estadísticas de preguntas',
                'desc' => 'Visualizar preguntas públicas',
                'imag' => '/img/icons/48x48/preguntas.png',
            ],
        ];
        $this->set([
            'title' => 'Estadísticas',
            'nav' => $nav,
            'module' => 'estadisticas',
        ]);
        $this->autoRender = false;
        $this->render('Module/index');
    } 
    
    public function estadisticasgenerales(){
	// Se define el array de valores y el array de la leyenda
	$datos = (new Model_Alumnoporprueba())->preguntasmalasvsbuenas();
	$total_buenas = array_sum(array_column($datos, 'total_buenas'));
	$total_malas = array_sum(array_column($datos, 'total_malas'));
	$chart = array($total_buenas,$total_malas);
	if($total_buenas!=0 && $total_malas!=0){
	  $this->set([
	      'chart' => $chart,
	      'chart2' => $this->EstPorNota(),
	      'chart3' => (new Model_Alumnoporprueba())->promediodenotas(),
	  ]);
	}else{
	  echo 'No hay estadísticas para mostrar';
	}
    }
    
    public function EstPorNota(){
	$azul = (new Model_Alumnoporprueba())->notasensistemaazul();
	$azul = $azul[0]['count'];
	$rojos = (new Model_Alumnoporprueba())->notasensistemaroja();
	$rojos = $rojos[0]['count'];
	$dataEstPorNota = array($azul,$rojos,);
	return $dataEstPorNota;
    }
    
    public function EstPorPregunta($id){
	$Pregunta = new Model_Pregunta($id);
	if (!$Pregunta->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La pregunta solicitada no existe','error'
            );
            $this->redirect('/preguntas/visualizar');
        }
	$DatosDePregunta = (new Model_Alumnoporpregunta())->BuscarPregunta($id);
	$total_buenas = 0;
	$total_malas = 0;
	foreach($DatosDePregunta as &$pregunta){
	    if($pregunta['correcta'] == 1){
	      $total_buenas++;
	    }else{
	      $total_malas++;
	    }  
	}
	$this->set([
	  'id' => $id,
	  'Enunciado' => $pregunta['pregunta'],
	  'dataEstPorPregunta' => array($total_buenas,$total_malas),
	]);
    }
    
    public function EstPorPrueba($id){
	$Prueba = new Model_Prueba($id);
	if (!$Prueba->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'La prueba solicitada no existe',
                'error'
            );
            $this->redirect('/pruebas/listar');
        }
	//chart1
	$datos = (new Model_Alumnoporprueba())->preguntasmalasvsbuenasPrueba($id);
	$total_buenas = array_sum(array_column($datos, 'total_buenas'));
	$total_malas = array_sum(array_column($datos, 'total_malas'));
	$chart = array($total_buenas,$total_malas);
	//chart2
	$azul = (new Model_Alumnoporprueba())->notasensistemaazulPrueba($id);
	$azul = $azul[0]['count'];
	$rojos = (new Model_Alumnoporprueba())->notasensistemarojaPrueba($id);
	$rojos = $rojos[0]['count'];
	$chart2 = array($azul,$rojos);
	//variable para mostrar o no los gráficos
	$mostrar = false;
	if($azul==0 && $rojos==0)
	  $mostrar = true;
	$this->set([
	    'Prueba' => $Prueba->prueba,
	    'chart' => $chart,
	    'chart2' => $chart2,
	    'chart3' => (new Model_Alumnoporprueba())->promediodenotasPrueba($id),
	    'chart4' => (new Model_Alumnoporprueba())->conteodepreguntaserroneasPrueba($id),
	    'mostrar' => $mostrar,
	  ]);
    }
    
     public function VerNotas($id){
	$Notas = (new Model_Alumnoporprueba())->notasPrueba($id);
	$Prueba = new Model_Prueba($id);
	$this->set([
	  'notas' => $Notas,
	  'Prueba' => $Prueba->prueba,
	]);
    }
}
