<h1>Estadística por prueba &raquo;  <em><?=$Prueba?></em></h1>
<?php
    if($mostrar==true){
	echo 'No hay estadísticas para mostrar';
    }
    else{
	echo '<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Cantidad de alumnos", { role: "style" } ],
        ["Aprobadas", '.$chart2[0].', "blue"],
        ["Reprobadas", '.$chart2[1].', "red"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: " ",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>';
	echo '<h2>Pruebas aprobadas y reprobadas en el sistema</h2>';
	echo '<center><div id="columnchart_values" style="width: 600px; height: 400px;"></div></center>';
	//segundo grafico y su script
	// ----
	// ----
	echo '<hr/><hr/>';
	echo '<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [\'Task\', \'Cantidad\'],
          [\'Correctamente\',    '.$chart[0].'],
          [\'Incorrectamente\',      '.$chart[1].']
        ]);

        var options = {
          title: \' \',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById(\'piechart_3d\'));
        chart.draw(data, options);
      }
    </script>';
	//imprimir gráfico
	echo '<h2>Preguntas totales respondidas correcta e incorrectamente en el sistema</h2>';
	echo '<center><div id="piechart_3d" style="width: 900px; height: 500px;"></div></center>';
	//tercer gráfico y su script
	// ----
	// ----
	// ----
	echo '<hr/><hr/>';
	echo '<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	      <script type="text/javascript">
		google.load("visualization", "1", {packages:["gauge"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {

		  var data = google.visualization.arrayToDataTable([
		    [\'Label\', \'Value\'],
		    [\'Promedio\', '.number_format((float)$chart3[0]["avg"], 3, '.', '').']
		  ]);

		  var options = {
		    width: 800, height: 240,
		    redFrom: 1.0, redTo: 4.0,
		    yellowFrom:4.0, yellowTo: 5.0,
		    greenFrom: 5.0, greenTo: 7.0,
		    minorTicks: 7,
		    majorTicks: [1,2,3,4,5,6,7],
		    max: 7.0,
		    min: 1.0
		  };

		  var chart = new google.visualization.Gauge(document.getElementById(\'chart_div\'));

		  chart.draw(data, options);
		}
	      </script>';
	echo '<h2>Promedio general de las notas en el sistema</h2>';
	echo '<center><div id="chart_div" style="width: 800px; height: 240px;"></div><center>';
	//cuarto gráfico y su script
	// ----
	// ----
	// ----
	if(isset($chart4)){
	  echo '<hr/><hr/>';
	  echo '<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
		  var data = google.visualization.arrayToDataTable([
		    ["Element", "Cantidad", { role: "style" } ],';
	  foreach($chart4 as $valor){
	      echo '["'.$valor['id_pregunta_relacionada'].'", '.$valor['thecount'].', "red"],';
	  
	  }	
	      echo ']);
	      var view = new google.visualization.DataView(data);
	      view.setColumns([0, 1,
			      { calc: "stringify",
				sourceColumn: 1,
				type: "string",
				role: "annotation" },
			      2]);

	      var options = {
		title: " ",
		width: 600,
		height: 400,
		bar: {groupWidth: "95%"},
		legend: { position: "none" },
	      };
	      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_cantidadincorrectaxprueba"));
	      chart.draw(view, options);
	  }
	  </script>';
		echo '<h2>Cantidad de preguntas respondidas incorrectamente en cantidad de veces</h2>';
		echo '<center>Si pones el cursor sobre el área de una pregunta podrás ver su ID y la cantidad de veces que se respondió incorrectamente, más abajo se encuentra una tabla para averiguar de qué pregunta se trata</center>';
		echo '<center><div id="columnchart_cantidadincorrectaxprueba" style="width: 600px; height: 400px;"></div></center>';
		echo '<center><h3>Tabla pregunta Id - Pregunta - Explicación</h3><center>';
		foreach($chart4 as &$valor) {
		    unset($valor['id']);
		    unset($valor['id_prueba_relacionada']);
		}
		array_unshift($chart4, array('Cantidad de veces resp. incorrectamente', 'Id de la pregunta', 'Pregunta', 'Explicación'));
		new \sowerphp\general\View_Helper_Table($chart4);
	}
    }