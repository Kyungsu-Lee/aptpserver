<?

$width = 1500;
$time = 1500;

echo '
<html>
<head></head>
<meta http-equiv="refresh" content="10" > 
<body>
	<iframe width='.$width.' height=500 src="./graph_bpm.php?idx='.$_GET['idx'].'&count='.$_GET['count'].'&width='.$width.'"></iframe><br>
	<iframe width='.$width.' height=500 src="./graph_rri.php?idx='.$_GET['idx'].'&count='.$_GET['count'].'&width='.$width.'"></iframe><br>
	<iframe width='.$width.' height=500 src="./graph_acc.php?idx='.$_GET['idx'].'&count='.$_GET['count'].'&width='.$width.'"></iframe><br>
</body>
';

?>


