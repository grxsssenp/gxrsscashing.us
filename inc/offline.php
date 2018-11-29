<?php
include_once "config.php";

$sql_select = "SELECT * FROM ".$prefix."_users";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
do
{
	$time = time();
	if($time > $row['online_time'])
	{
$id = $row['id'];
$update_sql1 = "Update ".$prefix."_users set online='0' WHERE id='$id'";
mysql_query($update_sql1) or die("" . mysql_error());
	}
}
while($row = mysql_fetch_array($result));

?>
