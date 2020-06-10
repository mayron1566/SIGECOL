<h1>Estadística &raquo; Pregunta: <em><?=$id?></em> / Enunciado: <em><?=$Enunciado?></em></h1>
<?php
	//require 'googchart_0_1/GoogChart.class.php';
	echo '<h2>Estadística de la pregunta según cantidad de veces respondida correcta/incorrectamente</h2>';
	//echo $DatosDePregunta;
	//generar gráfico
	echo '<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
	  var data = google.visualization.arrayToDataTable([
	    ["Element", "Cantidad de alumnos", { role: "style" } ],
	    ["Buenas", '.$dataEstPorPregunta[0].', "blue"],
	    ["Malas", '.$dataEstPorPregunta[1].', "red"]
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
      var chart = new google.visualization.ColumnChart(document.getElementById("graficopreguntas"));
      chart.draw(view, options);
  }
  </script>';
      //imprimir gráfico
      echo '<center><div id="graficopreguntas" style="width: 600px; height: 400px;"></div></center>';
	