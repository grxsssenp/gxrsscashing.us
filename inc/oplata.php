<?php
include_once "config.php";

if($_REQUEST['MERCHANT_ORDER_ID'])
{
  $q = mysql_query("SELECT * FROM ".$prefix."_users WHERE login='".$_REQUEST['us_user']."'");
  $row = mysql_fetch_assoc($q);

  $merchant_ids = "$fk_id";
  $merchant_secrets = "$fk_secret_2";

  function getIP() {
  if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
    return $_SERVER['REMOTE_ADDR'];
  }
  if (!in_array(getIP(), array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '88.198.88.98'))) {
    die("hacking attempt!");
  }

  $sign = md5($merchant_ids.':'.$_REQUEST['AMOUNT'].':'.$merchant_secrets.':'.$_REQUEST['MERCHANT_ORDER_ID']);

  if ($sign != $_REQUEST['SIGN']) {
    die('wrong sign');
  }else{
    $userid = $row['id'];
    $refer = $row['referer'];
    $data = date('Y-m-d H:i:s');
    $qiwi = $_REQUEST['us_pay'];
    $transaction = rand(1000,9999);
    mysql_query("INSERT INTO ".$prefix."_payments (`user_id`, `suma`, `data`, `qiwi`, `transaction`) VALUES ('".$userid."','".$_REQUEST['AMOUNT']."','".$data."','".$qiwi."','".$transaction."')");

    $balance = $row['balance'] + $_REQUEST['AMOUNT'];
    mysql_query("UPDATE ".$prefix."_users SET `balance`='".$balance."' WHERE login='".$_REQUEST['us_user']."'");

    $balancerefer = ($_REQUEST['AMOUNT'] / 100) * 10;
    mysql_query("UPDATE ".$prefix."_users SET `balance`=`balance`+'".$balancerefer."' WHERE login='".$refer."'");
    die('YES');
  }
  die('YES');
}

if($_POST['m_orderid'])
{
  if (!in_array($_SERVER['REMOTE_ADDR'], array('185.71.65.92', '185.71.65.189', '149.202.17.210'))) return;

  if (isset($_POST['m_operation_id']) && isset($_POST['m_sign']))
  {
  	$ms_keys = $m_key;

  	$arHash = array(
  		$_POST['m_operation_id'],
  		$_POST['m_operation_ps'],
  		$_POST['m_operation_date'],
  		$_POST['m_operation_pay_date'],
  		$_POST['m_shop'],
  		$_POST['m_orderid'],
  		$_POST['m_amount'],
  		$_POST['m_curr'],
  		$_POST['m_desc'],
  		$_POST['m_status']
  	);

  	if (isset($_POST['m_params']))
  	{
  		$arHash[] = $_POST['m_params'];
  	}

  	$arHash[] = $ms_keys;

  	$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

  	if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success')
  	{
  		echo $_POST['m_orderid'].'|success';
      $name = $_POST['m_orderid'];
      $code = explode(" ", $name);
      $login = $code['0'];
      $q = mysql_query("SELECT * FROM ".$prefix."_users WHERE login='".$login."'");
      $row = mysql_fetch_assoc($q);
      $userid = $row['id'];
      $refer = $row['referer'];
      $data = date('Y-m-d H:i:s');
      $transaction = $code['1'];
      mysql_query("INSERT INTO ".$prefix."_payments (`user_id`, `suma`, `data`, `qiwi`, `transaction`) VALUES ('".$userid."','".$_POST['m_amount']."','".$data."','Payeer','".$transaction."')");

      $balance = $row['balance'] + $_POST['m_amount'];
      mysql_query("UPDATE ".$prefix."_users SET `balance`='".$balance."' WHERE login='".$login."'");

      $balancerefer = ($_POST['m_amount'] / 100) * 10;
      mysql_query("UPDATE ".$prefix."_users SET `balance`=`balance`+'".$balancerefer."' WHERE login='".$refer."'");
  		exit;
  	}

  	echo $_POST['m_orderid'].'|error';
  }
}
?>
