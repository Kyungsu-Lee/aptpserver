<?

$width = $_GET['width'];
$time = $_GET['time'];

echo '
<html>
<head></head>
<body>
<div>
	<div id="rri"></div>
</div>
</body>
';

?>

<script src="http://code.jquery.com/jquery-latest.js"></script>
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>

<script type="text/javascript">
$(function() {
    startRefresh();
    startRefresh2();
    startRefresh3();
});

function startRefresh() {
    setTimeout(startRefresh,<?php echo $time; ?>);
    $.get('graph_bpm.php?idx=<?php echo $_GET['idx'];?>&count=<?php echo $_GET['count']; ?>&width=<?php echo $width; ?>', function(data) {
        $('#bpm').html(data);    
    });
}
function startRefresh2() {
    setTimeout(startRefresh2,1000);
    $.get('graph_rri.php?idx=<?php echo $_GET['idx'];?>&count=<?php echo $_GET['count']?>&width=<?php echo $width?>', function(data) {
        $('#rri').html(data);    
    });
}
function startRefresh3() {
    setTimeout(startRefresh3,1000);
    $.get('graph_acc.php?idx=<?php echo $_GET['idx'];?>&count=<?php echo $_GET['count']?>&width=<?php echo $width?>', function(data) {
        $('#acc').html(data);    
    });
}
</script>
