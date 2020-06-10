<script type="text/javascript">
    window.onbeforeunload = confirmExit;
    var needToConfirmToExit = true;
    function confirmExit() {
        if(needToConfirmToExit)
            return 'Estás editando una prueba...';
    }

</script>
<script type="text/javascript"> var preguntaId = <?php echo count($Prueba->preguntas)+1; ?>; </script>

<h1>Editar respuestas de prueba &raquo; <em><?php echo $Prueba->prueba; ?></em></h1>

<?php

// agregar preguntas existentes con sus respuestas
$preguntaId = 1;
$preguntas = [];
$cont_resp = 0; //contador de respuestas
foreach($Prueba->preguntas as &$Pregunta) {
    // crear respuestas para la pregunta
    $respuestas = [];
    foreach($Pregunta->respuestas as &$Respuesta) {
	$check_correct = $Respuesta->correcta=='t' ? ' checked="checked"' : '';
	if ( $Pregunta->alternativa=='t'){
	$puntaje1 = $Respuesta->puntaje==2 ? ' checked="checked"' : '';
    	$puntaje2 = $Respuesta->puntaje==1 ? ' checked="checked"' : '';
    	$puntaje3 = $Respuesta->puntaje==0 ? ' checked="checked"' : '';
        $value = ($Respuesta->correcta=='t'?'*':'').$Respuesta->respuesta;
        $respuestas[] = <<<EOF
	<div>
    		<input type="hidden" name="respuestaId{$preguntaId}[]" value="{$Respuesta->id}" />
    		<input type="h" name="respuesta{$preguntaId}[]" value="${value}" placeholder="Alternativa" class="respuesta" readonly/>
		Puntaje:
		<input type="radio" name="puntaje{$Respuesta->id}" value="2"{$puntaje1}> Completo
    		<input type="radio" name="puntaje{$Respuesta->id}" value="1"{$puntaje2}> Medio
   		<input type="radio" name="puntaje{$Respuesta->id}" value="0"{$puntaje3}> Nulo 
	</div>
EOF;
    }
	elseif ( $Pregunta->resp_escrita=='t' || $Pregunta->mapa=='t' || $Pregunta->escrita=='t'){
        $value = ($Respuesta->correcta=='t'?'*':'').$Respuesta->respuesta;
        $respuestas[] = <<<EOF
	<div>
    		<input type="hidden" name="respuestaId{$preguntaId}[]" value="{$Respuesta->id}" />
    		<input type="text" name="respuesta{$preguntaId}[]" value="${value}" placeholder="Alternativa" class="respuesta" readonly/>
		Puntaje:
		<input type="checkbox" name="correcta{$Respuesta->id}"{$check_correct}> Correcta
	</div>
EOF;
    }
$cont_resp++;
}
    $respuestas = implode("\n", $respuestas);
    // determinar si es está activa
    $activa = $Pregunta->activa ? ' checked="checked"' : '';
    // determinar tipo de la pregunta
    $tipo1 = $Pregunta->id_texto==1 ? ' selected="selected"' : '';
    $tipo2 = $Pregunta->id_texto==2 ? ' selected="selected"' : '';
    $tipo3 = $Pregunta->id_texto==3 ? ' selected="selected"' : '';
    $tipo4 = $Pregunta->id_texto==4 ? ' selected="selected"' : '';
    $tipo5 = $Pregunta->id_texto==5 ? ' selected="selected"' : '';
    $tipo6 = $Pregunta->id_texto==6 ? ' selected="selected"' : '';
    $tipo7 = $Pregunta->id_texto==7 ? ' selected="selected"' : '';
    $tipo8 = $Pregunta->id_texto==8 ? ' selected="selected"' : '';
    $tipo9 = $Pregunta->id_texto==9 ? ' selected="selected"' : '';
    // determinar si es publica
    $publica = $Pregunta->publica=='t' ? ' checked="checked"' : '';
    // determinar si es escrita
    $resp_escrita = $Pregunta->resp_escrita=='t' ? ' checked="checked"' : '';
    $mapa = $Pregunta->mapa=='t' ? ' checked="checked"' : '';
    $alternativa = $Pregunta->alternativa=='t' ? ' checked="checked"' : '';
    $reordenar = $Pregunta->reordenar=='t' ? ' checked="checked"' : '';
    $escrita = $Pregunta->escrita=='t' ? ' checked="checked"' : '';
    // determinar si tiene imagen
    $imagen = $Pregunta->imagen_size ? '<img src="'.$_base.'/preguntas/imagen/'.$Pregunta->id.'" alt="imagen_'.$Pregunta->id.'" class="imagen round4" />' : '';
    // agregar pregunta
if ( $Pregunta->resp_escrita=='t' || $Pregunta->mapa=='t' || $Pregunta->escrita=='t'){
    $nrbc=$Pregunta->numerocorrectas;
    $nrbm=$Pregunta->numeromedias;
    $preguntas[] = <<<EOF
<div>
    <input type="hidden" name="preguntas[]" value="{$preguntaId}" />
    <input type="hidden" name="preguntasIds[]" value="{$Pregunta->id}" />
    <input type="hidden" name="id{$preguntaId}" value="{$Pregunta->id}" />
    <div>
	<input type="checkbox" name="resp_escrita{$preguntaId}"{$resp_escrita} hidden/>
	<input type="checkbox" name="mapa{$preguntaId}"{$mapa} hidden/>
	<input type="checkbox" name="alternativa{$preguntaId}"{$alternativa} hidden/>
	<input type="checkbox" name="reordenar{$preguntaId}"{$reordenar} hidden/>
	<input type="checkbox" name="escrita{$preguntaId}"{$escrita} hidden/>
        <input type="checkbox" name="activa{$preguntaId}"{$activa} hidden/>
        <input type="checkbox" name="publica{$preguntaId}"{$publica} hidden/>
        <select name="tipo{$preguntaId}" class="tipo" hidden>
            <option value="1"{$tipo1}>1</option>
            <option value="2"{$tipo2}>2</option>
            <option value="3"{$tipo3}>3</option>
            <option value="4"{$tipo4}>1</option>
            <option value="5"{$tipo5}>2</option>
            <option value="6"{$tipo6}>3</option>
            <option value="7"{$tipo7}>1</option>
            <option value="8"{$tipo8}>2</option>
            <option value="9"{$tipo9}>3</option>
        </select>
    <input type="textbox" size=1 name="NRBC{$Pregunta->id}" value="{$nrbc}" > N° buenas para puntaje completo
    <input type="textbox" size=1 name="NRBM{$Pregunta->id}" value="{$nrbm}" > N° buenas para puntaje medio
    </div>
    <div><textarea name="pregunta{$preguntaId}" placeholder="Pregunta" class="pregunta" hidden>{$Pregunta->pregunta}</textarea></div>
    {$imagen}
    <div class="respuestas">
        <div id="respuestas{$preguntaId}">${respuestas}</div>
    </div>
    <div><textarea name="explicacion{$preguntaId}" class="explicacion" hidden>{$Pregunta->explicacion}</textarea></div>
    <div class="clear"><textarea name="dummy" class="explicacion" style="border:none; resize: none;" readonly></textarea></div>
</div>
EOF;
	}
else{
$preguntas[] = <<<EOF
<div>
    <input type="hidden" name="preguntas[]" value="{$preguntaId}" />
    <input type="hidden" name="preguntasIds[]" value="{$Pregunta->id}" />
    <input type="hidden" name="id{$preguntaId}" value="{$Pregunta->id}" />
    <div>
	<input type="checkbox" name="resp_escrita{$preguntaId}"{$resp_escrita} hidden/>
	<input type="checkbox" name="mapa{$preguntaId}"{$mapa} hidden/>
	<input type="checkbox" name="alternativa{$preguntaId}"{$alternativa} hidden/>
	<input type="checkbox" name="reordenar{$preguntaId}"{$reordenar} hidden/>
	<input type="checkbox" name="escrita{$preguntaId}"{$escrita} hidden/>
        <input type="checkbox" name="activa{$preguntaId}"{$activa} hidden/>
        <input type="checkbox" name="publica{$preguntaId}"{$publica} hidden/>
        <select name="tipo{$preguntaId}" class="tipo" hidden>
            <option value="1"{$tipo1}>Fácil</option>
            <option value="2"{$tipo2}>Normal</option>
            <option value="3"{$tipo3}>Difícil</option>
        </select>
    </div>
    <div><textarea name="pregunta{$preguntaId}" placeholder="Pregunta" class="pregunta" hidden>{$Pregunta->pregunta}</textarea></div>
    {$imagen}
    <div class="respuestas">
        <div id="respuestas{$preguntaId}">${respuestas}</div>
    </div>
    <div><textarea name="explicacion{$preguntaId}" class="explicacion" hidden>{$Pregunta->explicacion}</textarea></div>
    <div class="clear"><textarea name="dummy" class="explicacion" style="border:none; resize: none;" readonly></textarea></div>
</div>
EOF;
}
    // aumentar contador de preguntas
    ++$preguntaId;
}
$preguntas = implode("\n", $preguntas);

// crear formulario
$f = new \sowerphp\general\View_Helper_Form();
echo $f->begin([
    'onsubmit'=>'validarEdicionPrueba()'
]);
echo $f->input([
    'type'=>'hidden',
    'name'=>'id',
    'value'=>$Prueba->id,
    'hidden',
]);
echo $f->input([
    'type'=>'hidden',
    'name'=>'categoria',
    'label'=>'Categoría',
    'options'=>$categorias,
    'value'=>$Prueba->categoria,
    'check'=>'notempty',
    'help'=>'Si la categoría no existe la puede crear <a href="'.$_base.'/categorias/crear">aquí</a>',
     'hidden',
]);
echo $f->input([
    'type'=>'hidden',
    'name'=>'prueba',
    'label'=>'Prueba',
    'check'=>'notempty',
    'value'=>$Prueba->prueba,
    'attr'=>'maxlength="100"',
    'help'=>'Nombre de la prueba dentro de la categoría. Se recomienda utilizar el tópico.',
    'hidden',
]);
echo $f->input([
    'type'=>'hidden',
    'name'=>'descripcion',
    'label'=>'Descripción',
    'rows'=>5,
    'check'=>'notempty',
    'value'=>$Prueba->descripcion,
    'help'=>'Explicación de que contenidos serán abordados en esta prueba',
]);
echo $f->input([
    'type'=>'hidden',
    'name'=>'publica',
    'label'=>'Pública',
    'checked'=>$Prueba->publica,
    'help'=>'Indica si la prueba puede ser revisada por cualquier usuario. Útil sólo si la prueba contendrá preguntas públicas. A pesar que la prueba sea pública, aquellas preguntas marcadas como privadas (o no públicas) no serán visibles por los usuarios.',
]);
echo $f->input([
    'type'=>'div',
    'label'=>'Preguntas',
    'value'=>'<div id="preguntas">'.$preguntas.'</div>'
]);
echo $f->end('Guardar cambios');
