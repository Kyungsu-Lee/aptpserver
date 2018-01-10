<?php

header("Refresh:1");

$con=mysqli_connect('localhost','aptp','aptp1100','aptp');

$token = $_GET['token'];
$querys = "select * from accesstoken where access_token='$token'";
$results = mysqli_query($con, $querys);
$rows = mysqli_fetch_row($results);

$query = "select * from STLess where user_idx=".$rows[1]." order by timestamp desc";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_row($result);

//echo 'stress : '.$row[1].'<br>';
echo $row[1];

?>
