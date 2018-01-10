<?

$db_host ="localhost";
$db_user="root";
$db_passwd = "godqhr1533";
$db_name="aptp";

$conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name);
$row = mysqli_fetch_array($result);
$count = $_GET['count'];

if(mysqli_connect_errno($conn))
{
	echo 'fail';
}
else
{
	$result = mysqli_query($conn, "select * from BPM where user_idx=".$_GET['idx']." ORDER BY timestamp desc;");

	$arr = array();
	$arr_rri = array();

	for($i=0; $i<$count; $i++)
	{
		$row = mysqli_fetch_array($result);
		$arr[] = $row;
	}

	for($i=0; $i<$count; $i++)
	{
		$arr2[($count-1)-$i] = $arr[$i];
	}

}

echo '<html>
<head>
  <title>Graph 3D styles</title>

  <style>
    body {font: 15pt arial;}
  </style>

</head>

<body onload="drawVisualization()">

<p>
  <label for="style"> Style:
    <select id="style">
      <option value="bar">bar</option>
      <option value="bar-color">bar-color</option>
      <option value="bar-size">bar-size</option>

      <option value="dot">dot</option>
      <option value="dot-line">dot-line</option>
      <option value="dot-color">dot-color</option>
      <option value="dot-size">dot-size</option>

      <option value="grid">grid</option>
      <option value="line">line</option>
      <option value="surface">surface</option>
    </select>
  </label>
</p>

<p>
  <label for="perspective">
    <input type="checkbox" id="perspective" checked> Show perspective
  </label>
</p>

<p>
  <label for="xBarWidth"> Bar width X:
    <input type="text" id="xBarWidth" value="" style="width:50px;"> (only applicable for styles "bar" and "bar-color")
  </label>
</p>
<p>
  <label for="yBarWidth"> Bar width Y:
    <input type="text" id="yBarWidth" value="" style="width:50px;"> (only applicable for styles "bar" and "bar-color")
  </label>
</p>

<div id="mygraph"></div>

<div id="info"></div>
</body>
</html>';
?>

  <script type="text/javascript" src="../../dist/vis.js"></script>

  <script type="text/javascript">
    var data = null;
    var graph = null;

	var ddd = 
	[
		[
		<?php
			for($i=0; $i<($count-1); $i++)
				echo $arr2[$i]['bpm'].',';
		?>
		<?php
			echo $arr2[($count-1)]['bpm'];
		?>
		]
	];


    function custom(x, y) {
     // return (-Math.sin(x/Math.PI) * Math.cos(y/Math.PI) * 10 + 10);
	return ddd[0][24 * x+y];
    }

    // Called when the Visualization API is loaded.
    function drawVisualization() {
  //    var style = document.getElementById("style").value;
  var style = "bar";
      var showPerspective = document.getElementById("perspective").checked;
      var xBarWidth = parseFloat(document.getElementById("xBarWidth").value) || undefined;
      var yBarWidth = parseFloat(document.getElementById("yBarWidth").value) || undefined;
      var withValue = ["bar-color", "bar-size", "dot-size", "dot-color"].indexOf(style) != -1;

      // Create and populate a data table.
      data = [];

      // create some nice looking data with sin/cos
      var steps_x = 24;  // number of datapoints will be steps*steps
      var steps_y = 10;  // number of datapoints will be steps*steps
      var axisMax_x = 24;
      var axisMax_y = 10;
      var axisStep_x = axisMax_x / steps_x;
      var axisStep_y = axisMax_y / steps_y;
      for (var x = 0; x <= axisMax_x; x+=axisStep_x) {
        for (var y = 0; y <= axisMax_y; y+=axisStep_y) {
          var z = custom(x,y);
          if (withValue) {
            var value = (y - x);
            data.push({x:x, y:y, z: z, style:value});
          }
          else {
            data.push({x:x, y:y, z: z});
          }
        }
      }

      // specify options
      var options = {
        width:  "1000px",
        height: "1000px",
        style: style,
        xBarWidth: xBarWidth,
        yBarWidth: yBarWidth,
        showPerspective: showPerspective,
        showGrid: true,
        showShadow: false,
        keepAspectRatio: true,
        verticalRatio: 0.5 
      };

      var camera = graph ? graph.getCameraPosition() : null;

      // create our graph
      var container = document.getElementById("mygraph");
      graph = new vis.Graph3d(container, data, options);

      if (camera) graph.setCameraPosition(camera); // restore camera position

      document.getElementById("style").onchange = drawVisualization;
      document.getElementById("perspective").onchange = drawVisualization;
      document.getElementById("xBarWidth").onchange = drawVisualization;
      document.getElementById("yBarWidth").onchange = drawVisualization;
    }
  </script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {"packages":["corechart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["DATA", "BPM"	],
	<?
	for($i = 0; $i < $count; $i++)
	{
		$time = $arr2[$i]['timestamp'];
		$time = explode(' ', $time)[1];
		echo '["'.$time.'", '.$arr2[$i]["bpm"].' ],';
		$row = mysqli_fetch_array($result);
	}
	?>
        ]);

        var options = {
          title: "BPM",
          curveType: "function",
          legend: { position: "bottom" }
        };

        var chart = new google.visualization.LineChart(document.getElementById("curve_chart"));

        chart.draw(data, options);
      }
    </script>

