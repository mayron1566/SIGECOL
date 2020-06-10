
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
var preguntasTotales = <?php echo $total; ?>;
var preguntaActual = 0;
var preguntaAnte=0;
var palabra='';
var resultado;
var click=0;
var click2=17
var boton=0;
var botonid='';
var zoom;
var a;
function time(){
	
	}

function zoomIn() {
           zoom = document.getElementsByClassName("cuadro_text");
	   zoom[boton].style.transform = "scale(1.15)" ;

        }

function zoomOut() {
            zoom = document.getElementsByClassName("cuadro_text");
	   zoom[boton].style.transform = "scale(1)" ;
        }


function myFunction() {
  botonid='botonsig'.concat(boton);
  var x = document.getElementById(botonid);
    x.style.display = "block";
} 

function myFunction_1() {
	click++;
	if (click==click2){
		botonid='botonsig'.concat(boton);
  		var x = document.getElementById(botonid);
		x.style.display = "block";
		click=0;
		if (click2==17){
			click2=5;
			}
	}
} 

function myFunction_2() {
	click++;
	if (click==17){
		botonid='botonsig'.concat(boton);
  		var x = document.getElementById(botonid);
		x.style.display = "block";
		click=0;
	}
} 

  function procesar_selección_HTML()
{
  var texto =texto_HTML.value;
  var inicio=texto_HTML.selectionStart
  var fin   =texto_HTML.selectionEnd
  resultado =procesar_selección(texto,inicio,fin)
}

function procesar_selección(texto,inicio_selección,fin_selección)
{
  var longitud=texto.length

  var inicio=texto.slice(0               ,inicio_selección)
  var medio =texto.slice(inicio_selección,fin_selección   )
  var fin   =texto.slice(fin_selección   ,longitud        )


  return medio
}

function myFunction0() {
  document.getElementById("textbox0").value = resultado;
}

function myFunction1() {
  document.getElementById("textbox1").value = resultado;
}
 
function myFunction2() {
  document.getElementById("textbox2").value = resultado;
}

function myFunction3() {
  document.getElementById("textbox3").value = resultado;
}

function myFunction4() {
  document.getElementById("textbox4").value = resultado;
}

function myFunction5() {
  document.getElementById("textbox5").value = resultado;
}  
  /*$( function() {
     var texto=$( 'texto' ).text();
    $( 'texto' ).draggable({revert: true,
    helper: 'clone'});
  } ); //funcion para crear el texto arrastrable

  $( function() {
    $( 'input[class="dr"]' ).droppable({drop: function (event, ui) {
        this.value = $(ui.draggable).text();
	palabra=this.value;
    }});
  } );*/ //funcion para que los inputs acepten los textos arrastrables


  $( function() {
    $( "#sortable1" ).sortable();
    $( "#sortable1" ).disableSelection();
  } );

$( function() {
    $( "#sortable2" ).sortable();
    $( "#sortable2" ).disableSelection();
  } );

$( function() {
    $( "#sortable3" ).sortable();
    $( "#sortable3" ).disableSelection();
  } );

$( function() {
    $( "#sortable4" ).sortable();
    $( "#sortable4" ).disableSelection();
  } );

$(function(){
    $('input[type="submit"]').css('display', 'none');
    siguientePregunta();
});

$(function(){
    $('input[type="submit"]').css('display', 'none');
    preguntaAnt();
});

function eliminar0(obj) {
  anterior=obj.getAttribute('ante');
  if (anterior!="0") anadir0(anterior,obj);
  sel=obj.form.getElementsByClassName("mapa0");
  for(i=0;ele=sel[i];i++)
    if(ele!=obj)
      for(j=0;opt=ele.options[j];j++)
        if(opt.value==obj.value) {
          obj.setAttribute('ante',opt.value);
          ele.removeChild( ele.options[j]);
          }
};

function anadir0(num,obj) {
  sel=obj.form.getElementsByClassName("mapa0");
  for(i=0;ele=sel[i];i++) 
    if(ele!=obj){
      ele.options[ele.options.length]=new Option("*"+num,num);
	}
};  

function eliminar1(obj) {
  anterior=obj.getAttribute('ante');
  if (anterior!="0") anadir1(anterior,obj);
  sel=obj.form.getElementsByClassName("mapa1");
  for(i=0;ele=sel[i];i++)
    if(ele!=obj)
      for(j=0;opt=ele.options[j];j++)
        if(opt.value==obj.value) {
          obj.setAttribute('ante',opt.value);
          ele.removeChild( ele.options[j]);
          }
};

function anadir1(num,obj) {
  sel=obj.form.getElementsByClassName("mapa1");
  for(i=0;ele=sel[i];i++) 
    if(ele!=obj){
      ele.options[ele.options.length]=new Option(num,num);
	}
}; 

function eliminar2(obj) {
  anterior=obj.getAttribute('ante');
  if (anterior!="0") anadir2(anterior,obj);
  sel=obj.form.getElementsByClassName("mapa2");
  for(i=0;ele=sel[i];i++)
    if(ele!=obj)
      for(j=0;opt=ele.options[j];j++)
        if(opt.value==obj.value) {
          obj.setAttribute('ante',opt.value);
          ele.removeChild( ele.options[j]);
          }
};

function anadir2(num,obj) {
  sel=obj.form.getElementsByClassName("mapa2");
  for(i=0;ele=sel[i];i++) 
    if(ele!=obj){
      ele.options[ele.options.length]=new Option(num,num);
	}
};  

function eliminar3(obj) {
  anterior=obj.getAttribute('ante');
  if (anterior!="0") anadir3(anterior,obj);
  sel=obj.form.getElementsByClassName("mapa3");
  for(i=0;ele=sel[i];i++)
    if(ele!=obj)
      for(j=0;opt=ele.options[j];j++)
        if(opt.value==obj.value) {
          obj.setAttribute('ante',opt.value);
          ele.removeChild( ele.options[j]);
          }
};

function anadir3(num,obj) {
  sel=obj.form.getElementsByClassName("mapa3");
  for(i=0;ele=sel[i];i++) 
    if(ele!=obj){
      ele.options[ele.options.length]=new Option(num,num);
	}
};   


function eliminar4(obj) {
  anterior=obj.getAttribute('ante');
  if (anterior!="0") anadir4(anterior,obj);
  sel=obj.form.getElementsByClassName("mapa4");
  for(i=0;ele=sel[i];i++)
    if(ele!=obj)
      for(j=0;opt=ele.options[j];j++)
        if(opt.value==obj.value) {
          obj.setAttribute('ante',opt.value);
          ele.removeChild( ele.options[j]);
          }
};

function anadir4(num,obj) {
  sel=obj.form.getElementsByClassName("mapa4");
  for(i=0;ele=sel[i];i++) 
    if(ele!=obj){
      ele.options[ele.options.length]=new Option(num,num);
	}
};  

function eliminar5(obj) {
  anterior=obj.getAttribute('ante');
  if (anterior!="0") anadir5(anterior,obj);
  sel=obj.form.getElementsByClassName("mapa5");
  for(i=0;ele=sel[i];i++)
    if(ele!=obj)
      for(j=0;opt=ele.options[j];j++)
        if(opt.value==obj.value) {
          obj.setAttribute('ante',opt.value);
          ele.removeChild( ele.options[j]);
          }
};

function anadir5(num,obj) {
  sel=obj.form.getElementsByClassName("mapa5");
  for(i=0;ele=sel[i];i++) 
    if(ele!=obj){
      ele.options[ele.options.length]=new Option(num,num);
	}
};  

function eliminar6(obj) {
  anterior=obj.getAttribute('ante');
  if (anterior!="0") anadir6(anterior,obj);
  sel=obj.form.getElementsByClassName("mapa6");
  for(i=0;ele=sel[i];i++)
    if(ele!=obj)
      for(j=0;opt=ele.options[j];j++)
        if(opt.value==obj.value) {
          obj.setAttribute('ante',opt.value);
          ele.removeChild( ele.options[j]);
          }
};

function anadir6(num,obj) {
  sel=obj.form.getElementsByClassName("mapa6");
  for(i=0;ele=sel[i];i++) 
    if(ele!=obj){
      ele.options[ele.options.length]=new Option(num,num);
	}
};  



</script>

<?php




//Mapa conceptual por defecto
$mapac="_&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
\n\n\n\n_&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp_
\n_&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp_&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp_&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp_&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
\n\n\n\n\n\n_&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp_&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp_&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp_
\n\n\n\n\n\n\n_&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp\n_\n_\n_\n_\n_\n__________	  
	 							";	
						
$mapab="_______

 
	 							";	

$reorder="\n\n_______________________________"; 										

$cmap=3; //default 2, modificado para experimentacion
$aumentoClass=1;

// formulario para preguntas
$form = new \sowerphp\general\View_Helper_Form('inline');
echo $form->begin($_base.'/pruebas/resultado/'.$id);
 
echo '<ol id="preguntas" class="preguntas">';
echo '<br />';
echo '<i><font size=6>'.$prueba.'</font></i>';
echo '<br />';
echo '<br />';
$n = 1;
$texto=0;
$findme = '_';
$i=0;
$explicacion='-';
$explicacionAnt='';
$mapa="0";
$pruebaTerminada=0;
$j=0;//contador para preguntas de drag and drop
$k=0;
$botonsig=0;
$explicacion2='';
$funcion=1;
$textoAux=0;
foreach($preguntas as &$pregunta) {
    // mostrar pregunta
    $pruebaTerminada++;
    $idTextbox=0;
    $auxExp='';
    $auxExp2='';
    $auxExp3='';
    $contador=0;
    $question='';
    $arreglo=array();
    $strlen=strlen( $pregunta->pregunta );
    echo '<li id="pregunta',$n,'" style="display:none">';
    $explicacion = nl2br($pregunta->explicacion."\n\n");
    $question= nl2br($pregunta->pregunta);
    if (strip_tags($explicacionAnt)!=strip_tags($explicacion)){
    	$texto++;
	$textoAux++;
	}
    echo '<div  style="font-size:18px;"><strong>Texto ',$texto,':</strong></div><br />';
    if ($pregunta->resp_escrita==TRUE){
    for($j=0; $j<strlen($question); $j++){
	if ($question[$j]!=$findme){
		$auxExp.=$question[$j];
		}
	if ($question[$j]==$findme || $j+1==strlen($question)){
		$auxExp2.='<texto>'."$auxExp".'</texto>';
		$auxExp2.=' ';
		$auxExp='';
	
			}

		}
	$auxExp3= strip_tags($question, '<texto>');;
		
	}
	echo '<br />';
	echo '<div id="div1" class="cuadro_text">';
	        echo '<button type="button" onclick="zoomIn();"><span class="glyphicon glyphicon-search" aria-hidden="true"></span><font size="+1"> + </font></button>';
    	    echo '<button type="button" onclick="zoomOut();"><span class="glyphicon glyphicon-search" aria-hidden="true"></span><font size="+1"> - </font></button>';
            echo '<texto>'."$explicacion".'</texto>';
        echo '</div>';
	echo '<br />';

	

    if ($pregunta->alternativa==TRUE) {
    	$nuevoTexto = nl2br($pregunta->pregunta);
	echo $nuevoTexto;
	}
    // mostrar imagen
    if(!empty($pregunta->imagen_name)) {
        echo '<br /><img src="',$_base,'/preguntas/imagen/',$pregunta->id,'" alt="',$pregunta->imagen_name,'" class="round4" style="max-width:100%;margin:1em 0;" />';
    }

 //Muestra las preguntas seleccion de texto
    if ($pregunta->resp_escrita==TRUE) {
	$tipoP="resp_escrita";
	$nuevoTexto = nl2br($pregunta->pregunta);
    	echo '<div  style="font-size:19px;">5. A continuacion leer del siguiente recuadro y seleccionar tres conjuntos de palabras que definan el carácter descriptivo de la muestra (por ejemplo: estrato social). Para esto seleccione trozos del texto y oprima Insertar texto:</div>';
echo '<br />';
echo '<br />';
echo '<div  style="font-size:18px;"><b>Texto 2</b></div>';	
echo '<textarea id="texto_HTML" onkeyup    ="procesar_selección_HTML()"
  onkeydown  ="procesar_selección_HTML()"
  onmouseup  ="procesar_selección_HTML()"
  onmousedown="procesar_selección_HTML()"
  onmousemove="procesar_selección_HTML()"  style="width: 1050px; height: 110px; font-size:30px; border-style: double; border-width: 5px; border-color: black" readonly>'.$auxExp3.'</textarea>';
	echo '<br />';	
	echo '<br />';
	echo '<ol class="alternativas">';
    	foreach($pregunta->respuestas as &$answer) {
				//echo '<input type="textbox" name="pregunta'.$pregunta->id.'[]" label="'.$answer->respuesta.'" value=""/>';
				echo '<input type="textbox" id="textbox'.$idTextbox.'" class="dr" name="pregunta'.$pregunta->id.'[]" label="'.$answer->respuesta.'" value="" size="32" readonly/>';
				echo '<button type="button" onclick="myFunction'.$idTextbox.'(); myFunction();">Insertar texto</button>';
				echo '<br />';
				$contador++;
				$i++;
				$idTextbox++;
				
    	}
	$i=0;
	echo '<br />';
    }


 //Muestra las preguntas de alternativas
    elseif ($pregunta->alternativa==TRUE){
	// mostrar cantidad de preguntas que se deben seleccionar
    	// mostrar alternativas
    	echo '<ol class="alternativas">';
    	foreach($pregunta->respuestas as &$answer) {
     	  echo '<li style="font-size:18px;">';
	   echo '<input type="radio" name="pregunta'.$pregunta->id.'[]" label="'.$answer->respuesta.'" value="'.$answer->respuesta.'" onclick="myFunction();"/>'.$answer->respuesta.'';
      	  echo '</li>';
	
    	}
	//echo 	'</select>';
    }

 //Muestra los mapas conceptuales
    elseif ($pregunta->mapa==TRUE){
	$conteo_mapa=count($pregunta->respuestas);
	$nuevoTexto = nl2br($pregunta->pregunta);
	$strlen=strlen($nuevoTexto);
	while($i < $strlen) {
		echo $nuevoTexto[$i];
		$i++;
		}
	$i=0;
	if ($conteo_mapa>=12){
		$nuevoTexto = nl2br($mapac);
		$cmap=3;
		}
	else{
		$nuevoTexto = nl2br($mapab);
		$cmap=4;
		$idTextbox=13;
		}
	$strlen=strlen($nuevoTexto);
	echo '</br>';
	echo '<ol class="alternativas">';
	echo '<div id="div'.$cmap.'">';
    	foreach($pregunta->respuestas as &$answer) {
		while($i < $strlen) {
			if ($nuevoTexto[$i] == $findme){
				//echo '<input type="textbox" name="pregunta'.$pregunta->id.'[]" label="'.$answer->respuesta.'" value=""/>';
				//echo '<div id="select'.$idTextbox.'">';
				echo '<select id="select'.$idTextbox.'" class="mapa'.$mapa.'" ante="0" name="pregunta'.$pregunta->id.'[]" onchange="if (this.selectedIndex) eliminar'.$mapa.'(this); myFunction();">';
				echo '<option value="" selected disabled hidden>Seleccione</option>';
				foreach($pregunta->respuestas as &$answer) {
					array_push($arreglo, $answer->respuesta);
					}
				sort($arreglo);
				for ($k=0; $k<count($arreglo); $k++){
					echo '<option value="'.$arreglo[$k].'">'.$arreglo[$k].'</option>';
					}
				$arreglo=array();
				$contador++;
				$i++;
				$idTextbox++;
				break;
				}
			echo $nuevoTexto[$i];
			 $i++;
			}
	if ($contador==count($pregunta->answersCorrect()) && $i < $strlen){
		while($i < $strlen) {
			echo $nuevoTexto[$i];
			 $i++;
			}
		}
	//echo 	'</select>';
	echo 	'</select>';
    	}
	$mapa++;
	$i=0;
	$funcion++;
	echo '<br />';
	echo '</div>';
    }

//Preguntas de completar la oracion
    elseif ($pregunta->escrita==TRUE){
	$nuevoTexto = nl2br($pregunta->pregunta);
	$strlen=strlen($nuevoTexto);
	echo 'Seleccionar respuestas:';
	echo '<ol class="alternativas">';
	echo '<div id="div5">';
    	foreach($pregunta->respuestas as &$answer) {
		while($i < $strlen) {
			if ($nuevoTexto[$i] == $findme){
				//echo '<input type="textbox" name="pregunta'.$pregunta->id.'[]" label="'.$answer->respuesta.'" value=""/>';
				echo '<font color="red" size=4>*</font>';
				echo '<select class="mapa'.$mapa.'" ante="0" name="pregunta'.$pregunta->id.'[]" onchange="if (this.selectedIndex) eliminar'.$mapa.'(this); myFunction_1();">';
				echo '<option value="" selected disabled hidden>Seleccione</option>';
				foreach($pregunta->respuestas as &$answer) {
					array_push($arreglo, $answer->respuesta);
					}
				sort($arreglo);
				for ($k=0; $k<count($arreglo); $k++){
					echo '<option value="'.$arreglo[$k].'">'.$arreglo[$k].'</option>';
					}
				$arreglo=array();
				$contador++;
				$i++;
				break;
				}
			echo $nuevoTexto[$i];
			 $i++;
			}
	if ($contador==count($pregunta->answersCorrect()) && $i < $strlen){
		while($i < $strlen) {
			echo $nuevoTexto[$i];
			 $i++;
			}
		}
	echo 	'</select>';
    	}
	$mapa++;
	$i=0;
	echo '<br />';
	echo '</div>';
    }
//preguntas de reordenar u ordenar sentencias

if ($pregunta->reordenar==TRUE) {
	$nuevoTexto = nl2br($pregunta->pregunta);
	$strlen=strlen($nuevoTexto);
	while($i < $strlen) {
		echo $nuevoTexto[$i];
		$i++;
		}
	$i=0;
	$nuevoTexto = nl2br($reorder);
	$strlen=strlen($nuevoTexto);
	echo '<br />';
	echo '<br />';
	echo '<ol class="alternativas">';
	echo '<b>Mayor importancia</b>';
	echo '<br />';
	echo '______________________';
	echo '<ol id="sortable'.$aumentoClass.'">';
		while($i < $strlen) {
			if ($nuevoTexto[$i] == $findme){
				foreach($pregunta->respuestas as &$answer) {
					array_push($arreglo, $answer->respuesta);
					}
				shuffle($arreglo);
				for ($k=0; $k<count($arreglo); $k++){
					echo '<li class="ui-state-default" onclick="myFunction();"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input type="textbox" id="textbox'.$arreglo[$k].'" name="pregunta'.$pregunta->id.'[]" value="'.$arreglo[$k].'" style="width: 550px;" readonly></li>';
					}
				//echo '<input type="textbox" name="pregunta'.$pregunta->id.'[]" label="'.$answer->respuesta.'" value=""/>';
				$contador++;
				$i++;
				break;
				}
			echo $nuevoTexto[$i];
			 $i++;
			}
	if ($contador==count($pregunta->answersCorrect()) && $i < $strlen){
		while($i < $strlen) {
			echo $nuevoTexto[$i];
			 $i++;
			}
		}
	$i=0;
	$aumentoClass++;
	echo '</ol>';
	echo '<br />';
	echo '<p><b>Menor importancia</b></p>';
    }


    	echo '</ol>';
	
    echo '<div id="botones">';
    // mostrar enlace para siguiente pregunta
    if (strip_tags($explicacionAnt)==strip_tags($explicacion)){
    	echo '<a id="botonant'.$botonsig.'" class="botonant" href="javascript:preguntaAnt()" accesskey="n" onclick="boton--">&lt;&lt;Pregunta anterior </a>';
	$explicacionAnt=$explicacion;
	}
    else{
	$explicacionAnt=$explicacion;
	}
    if ($pruebaTerminada==$total){
	echo $form->end('Enviar respuestas de la prueba');
	}
    else {echo '<a id="botonsig'.$botonsig.'" class="botonsig" href="javascript:siguientePregunta()" accesskey="n" onclick="boton++" hidden>Siguiente pregunta &gt;&gt;</a>';}
    // terminar pregunta
    echo '</li>';
    // incrementar contador
    ++$n;
    $botonsig++;
}
echo '</div>';
echo '</ol>';


// fin del formulario para preguntas

