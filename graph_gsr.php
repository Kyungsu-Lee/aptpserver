<?

$db_host ="localhost";
$db_user="server";
$db_passwd = "godqhr1533";
$db_name="aptp";

$conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name);
//$row = mysqli_fetch_array($result);
$count = $_GET['count'];

if(mysqli_connect_errno($conn))
{
	echo 'fail';
}
else
{
	$result = mysqli_query($conn, "select * from GSR where user_idx=".$_GET['idx']." ORDER BY timestamp desc;");

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
echo '
 <html>
  <head>
  </head>
  <body>
    <div id="curve_chart" style="width: '.$_GET['width'].'px; height: 500px"></div>
';

echo '<br>';
echo '<br>';
echo'
  </body>
</html>';
?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {"packages":["corechart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["DATA", "GSR"	],
	<?
	for($i = 0; $i < $count; $i++)
	{
		$time = $arr2[$i]['timestamp'];
		$time = explode(' ', $time)[1];
		echo '["'.$time.'", '.$arr2[$i]["gsr"].' ],';
		$row = mysqli_fetch_array($result);
	}
	?>
        ]);

        var options = {
          title: "GSR",
          curveType: "function",
          legend: { position: "bottom" }
        };

        var chart = new google.visualization.LineChart(document.getElementById("curve_chart"));

        chart.draw(data, options);
      }
    </script>
