<?

$db_host ="localhost";
$db_user="server";
$db_passwd = "godqhr1533";
$db_name="aptp";

$conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name);

$result = mysqli_query($conn, "select * from GSR where user_idx=15 ORDER BY timestamp desc;");

for($i=0; $i<10; $i++)
{
  $row = mysqli_fetch_array($result);
  echo $row['gsr'].'<br>';
}
?>
