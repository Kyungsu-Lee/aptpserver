<?

$width = 1500;
$time = 300;

echo '
<html>
<head></head>
<body>
	<iframe width='.$width.' height=500 src="./graph_content_bpm.php?idx='.$_GET['idx'].'&count='.$_GET['count'].'&width='.$width.'&time='.$time.'"></iframe><br>
	<iframe width='.$width.' height=500 src="./graph_content_rri.php?idx='.$_GET['idx'].'&count='.$_GET['count'].'&width='.$width.'&time='.$time.'"></iframe><br>
	<iframe width='.$width.' height=500 src="./graph_content_acc.php?idx='.$_GET['idx'].'&count='.$_GET['count'].'&width='.$width.'&time='.$time.'"></iframe><br>
	<iframe width='.$width.' height=500 src="./graph_content_gsr.php?idx='.$_GET['idx'].'&count='.$_GET['count'].'&width='.$width.'&time='.$time.'"></iframe><br>
	<iframe width='.$width.' height=500 src="./cal.php?idx='.$_GET['idx'].'&count='.$_GET['count'].'&width='.$width.'&time='.$time.'"></iframe><br>
</body>
';

?>
