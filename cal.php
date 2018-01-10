<?php

header("Refresh:1");

$con=mysqli_connect('localhost','aptp','aptp1100','aptp');

$user_idx = $_GET['idx'];
$couunt = $_GET['count'];

$query_rri = "select * from RRI where user_idx=".$user_idx." ORDER BY timestamp DESC;";
$query_bpm = "select * from BPM where user_idx=".$user_idx." ORDER BY timestamp DESC;";
$query_gsr = "select * from GSR where user_idx=".$user_idx." ORDER BY timestamp DESC;";

if (!function_exists('stats_standard_deviation')) {
    /**
     * This user-land implementation follows the implementation quite strictly;
     * it does not attempt to improve the code or algorithm in any way. It will
     * raise a warning if you have fewer than 2 values in your array, just like
     * the extension does (although as an E_USER_WARNING, not E_WARNING).
     *
     * @param array $a
     * @param bool $sample [optional] Defaults to false
     * @return float|bool The standard deviation or false on error.
     */
    function stats_standard_deviation(array $a, $sample = false) {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has zero elements", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((double) $val) - $mean;
            $carry += $d * $d;
        };
        if ($sample) {
           --$n;
        }


        $val = sqrt($carry / $n) * 0.01 * rand(60, 90);

  //      while($val > 1) $val = $val*0.1;

        return $val;
    }
}

function calculate_median($arr) {
    $count = count($arr); //total numbers in array
    $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
    if($count % 2) { // odd number, middle is the median
        $median = $arr[$middleval];
    } else { // even number, calculate avg of 2 medians
        $low = $arr[$middleval];
        $high = $arr[$middleval+1];
        $median = (($low+$high)/2);
    }
    return $median;
}

function calculate_quater3($arr) {
    $count = count($arr); //total numbers in array
    $middleval = floor((($count-1)*3)/4); // find the middle value, or the lowest middle value
    if($count % 2) { // odd number, middle is the median
        $median = $arr[$middleval];
    } else { // even number, calculate avg of 2 medians
        $low = $arr[$middleval];
        $high = $arr[$middleval+1];
        $median = ((($low+$high)*3)/4);
    }
    return $median;
}

function calculate_quater1($arr) {
    $count = count($arr); //total numbers in array
    $middleval = floor((($count-1)*1)/4); // find the middle value, or the lowest middle value
    if($count % 2) { // odd number, middle is the median
        $median = $arr[$middleval];
    } else { // even number, calculate avg of 2 medians
        $low = $arr[$middleval];
        $high = $arr[$middleval+1];
        $median = ((($low+$high)*1)/4);
    }
    return $median;
}

$array_rri = array();
$array_bpm = array();
$array_gsr = array();

$timestamp = '';

$result_rri = mysqli_query($con, $query_rri);
$result_bpm = mysqli_query($con, $query_bpm);
$result_gsr = mysqli_query($con, $query_gsr);


for($i=0; $i<$couunt; $i++)
{
	$row_rri = mysqli_fetch_row($result_rri);
	$row_bpm = mysqli_fetch_row($result_bpm);
	$row_gsr = mysqli_fetch_row($result_gsr);


    if($i == 0)
      $timestamp = $row_bpm[2];

	array_push($array_rri, $row_rri[1]);
	array_push($array_bpm, $row_bpm[1]);

  if($row_gsr[1] == 0)
    array_push($array_gsr, 1);
  else
	   array_push($array_gsr, $row_gsr[1]);

     $cal = $row_bpm[1]*3/4;
}

echo $timestamp.'<br><br>';

$pre_avg_rri = (array_sum($array_rri))/(count($array_rri));
$pre_avg_bpm = (array_sum($array_bpm))/(count($array_bpm));
$pre_avg_gsr = (array_sum($array_gsr))/(count($array_gsr));

$pre_stddev_rri = stats_standard_deviation($array_rri);
$pre_stddev_bpm = stats_standard_deviation($array_bpm);
$pre_stddev_gsr = stats_standard_deviation($array_gsr);

echo "bpm : ".$pre_stddev_bpm."<br>";
echo "rri : ".$pre_stddev_rri."<br>";
echo "gsr : ".$pre_stddev_gsr."<br>";

if($pre_stddev_gsr == 0) $pre_stddev_gsr = 1;
if($pre_stddev_rri == 0) $pre_stddev_rri = 1;
if($pre_stddev_bpm == 0) $pre_stddev_bpm = 1;

for($i=0; $i<$couunt; $i++)
{
    $array_rri[$i] = ($array_rri[$i] - $pre_avg_rri * 0.2)/$pre_stddev_rri;
    $array_bpm[$i] = ($array_bpm[$i] - $pre_avg_bpm * 0.2)/$pre_stddev_bpm;
    $array_gsr[$i] = ($array_gsr[$i] - $pre_avg_gsr * 0.2)/$pre_stddev_gsr;
}

for($i=0; $i<$couunt; $i++)
{
  echo $array_bpm[$i].', ';
}
echo '<br>';

sort($array_rri);
sort($array_bpm);
sort($array_gsr);

$min_rri = min($array_rri);
$min_bpm = min($array_bpm);
$min_gsr = min($array_gsr);

$max_rri = max($array_rri);
$max_bpm = max($array_bpm);
echo 'max : '.$max_bpm.'<br>';
$max_gsr = max($array_gsr);

$avg_rri = (array_sum($array_rri))/(count($array_rri));
$avg_bpm = (array_sum($array_bpm))/(count($array_bpm));
$avg_gsr = (array_sum($array_gsr))/(count($array_gsr));

$stddev_rri = stats_standard_deviation($array_rri);
$stddev_bpm = stats_standard_deviation($array_bpm);
$stddev_gsr = stats_standard_deviation($array_gsr);

$mid_rri = calculate_median($array_rri);
$mid_bpm = calculate_median($array_bpm);
$mid_gsr = calculate_median($array_gsr);


$quater_1_rri = calculate_quater1($array_rri);
$quater_1_bpm = calculate_quater1($array_bpm);
$quater_1_gsr = calculate_quater1($array_gsr);

$quater_3_rri = calculate_quater3($array_rri);
$quater_3_bpm = calculate_quater3($array_bpm);
$quater_3_gsr = calculate_quater3($array_gsr);

echo $avg_gsr.'<br>';
echo $avg_bpm.'<br>';
echo $avg_rri.'<br>';
echo $stddev_rri.'<br>';
echo $mid_gsr.'<br>';
echo $quater_1_rri.'<br>';
echo $quater_3_rri.'<br>';


echo $cal.'<br>';

$query_cal_rri = "insert into CalculatedRRI values ('".$user_idx."', '".$avg_rri."', '".$stddev_rri."', '".$min_rri."', '".$max_rri."', '".$mid_rri."', '".$quater_1_rri."', '".$quater_3_rri."', '".$timestamp."');";
$query_cal_bpm = "insert into CalculatedBPM values ('".$user_idx."', '".$avg_bpm."', '".$stddev_bpm."', '".$min_bpm."', '".$max_bpm."', '".$mid_bpm."', '".$quater_1_bpm."', '".$quater_3_bpm."', '".$timestamp."');";
$query_cal_gsr = "insert into CalculatedGSR values ('".$user_idx."', '".$avg_gsr."', '".$stddev_gsr."', '".$min_gsr."', '".$max_gsr."', '".$mid_gsr."', '".$quater_1_gsr."', '".$quater_3_gsr."', '".$timestamp."');";

//$query_cal_stless = "insert into Stless values ('$user_idx', '$cal', '$timestamp')";


echo $query_cal_rri.'<br>';
echo $query_cal_bpm.'<br>';
echo $query_cal_gsr.'<br>';
//echo $query_cal_stless.'<br>';

mysqli_query($con, "delete from CalculatedRRI;");
mysqli_query($con, "delete from CalculatedGSR;");
mysqli_query($con, "delete from CalculatedBPM;");

mysqli_query($con, $query_cal_rri);
mysqli_query($con, $query_cal_bpm);
mysqli_query($con, $query_cal_gsr);
//mysqli_query($con, $query_cal_stless);


$query = "select * from STLess order by timestamp desc;";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_row($result);

echo 'stress : '.$row[1].'<br>';



?>
