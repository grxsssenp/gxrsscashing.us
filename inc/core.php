<?php
include_once "qiwi.php";
include_once "config.php";
$nw = $qiwi_check;
$sql_select = "SELECT * FROM ".$prefix."_games ORDER BY `id` DESC LIMIT 20";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
do
{
	$id = $row['user_id'];
	$sql_select1 = "SELECT * FROM ".$prefix."_users WHERE id='$id'";
$result1 = mysql_query($sql_select1);
$row1 = mysql_fetch_array($result1);

if($row['shans'] >= 60)
{
	$sts = "success";
}
if($row['shans'] < 60 && $row['shans'] >= 30)
{
	$sts = "warning";
}
if($row['shans'] <= 29)
{
	$sts = "danger";
}

if($row['type'] == "win")
{
	$st = "success";
}
if($row['type'] == "lose")
{
	$st = "danger";
}
$login = ucfirst($row['login']);
	$game =  <<<HERE
$game
<tr data-user="$row[user_id]" data-game="$row[id]" onclick="window.open('game?id=$row[id]');"><td class="text-truncate " style="font-weight:600">$login</td><td class="text-truncate $st" style="font-weight:600">$row[chislo]</td><td class="text-truncate " style="font-weight:600">$row[cel]</td><td class="text-truncate " style="font-weight:600">$row[suma] $walletsite</td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px" class="progress progress-sm progress-$sts mb-0" value="$row[shans]" max="100"></progress></span></td><td class="text-truncate $st " style="font-weight:600">$row[win_summa] $walletsite</td></tr>
HERE;
$st = "";
$sts = "";
$login = "";
}
while($row = mysql_fetch_array($result));

$sid = $_COOKIE["sid"];
$time = time() + 5;
$ip = $_SERVER["REMOTE_ADDR"];
$update_sql1 = "Update ".$prefix."_users set online='1', online_time='$time', ip='$ip' WHERE hash='$sid'";
    mysql_query($update_sql1) or die("" . mysql_error());

$sql_select = "SELECT COUNT(*) FROM ".$prefix."_users WHERE online='1'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);

$sql_selectx = "SELECT COUNT(*) FROM ".$prefix."_games ORDER BY `id` DESC LIMIT 15";
$resultx = mysql_query($sql_selectx);
$rowx = mysql_fetch_array($resultx);

$online = $row['COUNT(*)'];
$count = $rowx['COUNT(*)'];

//otvet
    $result = array(
			'game' => "$game",
		  'online' => "$online",
			'count' => "$count"
  	);

    echo json_encode($result);
?>
