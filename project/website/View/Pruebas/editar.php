<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> <script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  //]]>
  </script>

<script type="text/javascript">
    window.onbeforeunload = confirmExit;
    var needToConfirmToExit = true;
    function confirmExit() {
        if(needToConfirmToExit)
            return 'Estás editando una prueba...';
    }

</script>
<script type="text/javascript"> var preguntaId = <?php echo count($Prueba->preguntas)+1; ?>; </script>

<h1>Pruebas &raquo; Editar &raquo; <em><?php echo $Prueba->prueba; ?></em></h1>

<?php

// agregar preguntas existentes con sus respuestas
$preguntaId = 1;
$preguntas = [];
foreach($Prueba->preguntas as &$Pregunta) {
    // crear respuestas para la pregunta
    $respuestas = [];
    foreach($Pregunta->respuestas as &$Respuesta) {
        $value = ($Respuesta->correcta=='t'?'*':'').$Respuesta->respuesta;
        $respuestas[] = <<<EOF
<div>
    <input type="hidden" name="respuestaId{$preguntaId}[]" value="{$Respuesta->id}" />
    <input type="text" name="respuesta{$preguntaId}[]" value="${value}" placeholder="Alternativa" class="respuesta" />
    <a href="#" onclick="$(this).parent().remove(); return false" title="Eliminar"><img src="${_base}/img/icons/16x16/actions/delete.png" alt="del"></a>
</div>
EOF;
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
    $preguntas[] = <<<EOF
<div>
    <input type="hidden" name="preguntas[]" value="{$preguntaId}" />
    <input type="hidden" name="preguntasIds[]" value="{$Pregunta->id}" />
    <input type="hidden" name="id{$preguntaId}" value="{$Pregunta->id}" />
    <div>
        <a href="#" onclick="$(this).parent().parent().remove(); return false" title="Eliminar" class="fright"><img src="${_base}/img/icons/16x16/actions/delete.png" alt="del"></a>
	Arrastrar: <input type="checkbox" name="resp_escrita{$preguntaId}"{$resp_escrita} />
	Mapa: <input type="checkbox" name="mapa{$preguntaId}"{$mapa} />
	Alternativa: <input type="checkbox" name="alternativa{$preguntaId}"{$alternativa} />
	Reordenar: <input type="checkbox" name="reordenar{$preguntaId}"{$reordenar} />
	Completar: <input type="checkbox" name="escrita{$preguntaId}"{$escrita} />
	|-|
        Activa: <input type="checkbox" name="activa{$preguntaId}"{$activa} />
        Pública: <input type="checkbox" name="publica{$preguntaId}"{$publica} />
        ID texto: <select name="tipo{$preguntaId}" class="tipo">
            <option value="1"{$tipo1}>1</option>
            <option value="2"{$tipo2}>2</option>
            <option value="3"{$tipo3}>3</option>
	    <option value="4"{$tipo4}>4</option>
            <option value="5"{$tipo5}>5</option>
            <option value="6"{$tipo6}>6</option>
	    <option value="7"{$tipo7}>7</option>
            <option value="8"{$tipo8}>8</option>
            <option value="9"{$tipo9}>9</option>
        </select>
        Imagen: <input type="file" name="imagen{$preguntaId}" />
    </div>
    <div><textarea name="pregunta{$preguntaId}" placeholder="Pregunta" class="pregunta">{$Pregunta->pregunta}</textarea></div>
    {$imagen}
    <div class="respuestas">
        <a href="javascript:agregarRespuesta({$preguntaId})" title="Agregar alternativa">[+] Agregar alternativa</a>
        <div id="respuestas{$preguntaId}">${respuestas}</div>
        <span>Respuesta(s) correcta(s) inicia(n) con un *</span>
    </div>
    <div class="clear"><textarea name="explicacion{$preguntaId}" placeholder="Explicación" class="explicacion">{$Pregunta->explicacion}</textarea></div>
</div>
EOF;
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
    'value'=>$Prueba->id
]);
echo $f->input([
    'type'=>'select',
    'name'=>'categoria',
    'label'=>'Categoría',
    'options'=>$categorias,
    'value'=>$Prueba->categoria,
    'check'=>'notempty',
    'help'=>'Si la categoría no existe la puede crear <a href="'.$_base.'/categorias/crear">aquí</a>',
]);
echo $f->input([
    'name'=>'prueba',
    'label'=>'Prueba',
    'check'=>'notempty',
    'value'=>$Prueba->prueba,
    'attr'=>'maxlength="100"',
    'help'=>'Nombre de la prueba dentro de la categoría. Se recomienda utilizar el tópico.',
]);
echo $f->input([
    'type'=>'textarea',
    'name'=>'descripcion',
    'label'=>'Descripción',
    'rows'=>5,
    'check'=>'notempty',
    'value'=>$Prueba->descripcion,
    'help'=>'Explicación de que contenidos serán abordados en esta prueba',
]);
echo $f->input([
    'type'=>'checkbox',
    'name'=>'publica',
    'label'=>'Pública',
    'checked'=>$Prueba->publica,
    'help'=>'Indica si la prueba puede ser revisada por cualquier usuario. Útil sólo si la prueba contendrá preguntas públicas. A pesar que la prueba sea pública, aquellas preguntas marcadas como privadas (o no públicas) no serán visibles por los usuarios.',
]);
echo $f->input([
    'type'=>'div',
    'label'=>'Preguntas <a href="javascript:agregarPregunta()" title="Agregar una pregunta"><img src="'.$_base.'/img/icons/16x16/actions/add.png" alt="add" /></a>',
    'value'=>'<div id="preguntas">'.$preguntas.'</div>'
]);
echo $f->end('Guardar cambios');
