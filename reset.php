<?php
include_once 'inc/config.php';
$hash = $_GET['id'];
$sql_select = "SELECT * FROM ".$prefix."_email WHERE `hash`='$hash'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$sql_select = "SELECT * FROM ".$prefix."_users WHERE `id`='".$row['user_id']."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$login = $row['login'];
}
$x = mysql_query("SELECT * FROM ".$prefix."_config WHERE ID='1'");
$cf = mysql_fetch_assoc($x);
if($cf['preloader_active'] == '1')
{
	$pr = '<div class="preloader">
			<div class="page-loader-circle"></div>
	</div>';
}
	if(time() > $row['data'])
	{
	 $body = <<<HERE

	 <html lang="ru" data-textdirection="ltr" class="loaded" slick-uniqueid="12">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="referrer" content="no-referrer">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>$name_site - Восстановление пароля</title>
<link rel="stylesheet" type="text/css" href="./files/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./files/style.min.css">
<link rel="stylesheet" type="text/css" href="./files/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="./files/bootstrap-extended.min.css">
<link rel="stylesheet" type="text/css" href="./files/app.min.css">
<link rel="stylesheet" type="text/css" href="./files/colors.min.css">
<link rel="stylesheet" type="text/css" href="./files/style.css">
<link rel="icon" href="./files/$favicon" type="image/x-icon">
<link rel="shortcut icon" href="./files/$favicon" type="image/x-icon">
<script src="./files/jquery-latest.min.js"></script>
</head><body style="background-image: url(../img/$bgc_site);" data-open="click" data-menu="horizontal-menu" data-col="2-columns" class="horizontal-layout horizontal-menu 2-columns    menu-expanded " cz-shortcut-listen="true">$pr<div class="app-content container center-layout"><div class="content-wrapper"><div class="content-body"><!--native-font-stack --><section id="description-list-alignment"><div class="row"><div class="col-sm-6 offset-sm-3"><div class="card"><div class="card-header"><h4 class="card-title text-xs-center"><b>Восстановление пароля для </b><small class="text-muted" style="font-size:120%">$login</small></h4></div>
            <div class="card-body collapse in">
                <div class="card-block">
		<div class="card-text">
			<div class="form-group">
				<div class="position-relative has-icon-left">
  				<fieldset class="form-group position-relative has-icon-left">
  					<input type="password" id="pass" class="form-control" placeholder="Введите новый пароль">
  					<div style="top:13px;" class="form-control-position">
  						<i class="ft-lock"></i>
  					</div>
  				</fieldset>
					<fieldset class="form-group position-relative has-icon-left">
						<input type="password" id="repeatPass" class="form-control" placeholder="Повторите новый пароль">
						<div style="top:13px;" class="form-control-position">
							<i class="ft-unlock"></i>
						</div>
					</fieldset>
					<input type="hidden" id="hash" class="form-control" value="$hash">
					<input type="hidden" id="uid" class="form-control" value="$login">
				</div>
			</div>
			<a id="error_reset" class="btn  btn-block btnError" style="color:#fff;display:none"></a>
			<a id="succes_resetPass" class="btn  btn-block btnSuccess	" style="color:#fff;display:none">Пароль изменен</a>
			<div class="col-lg-4 offset-lg-4 col-sm-12 col-xs-12">
			<a onclick="new_reset_pass()" class="bg-blue-grey bg-lighten-2  btn  btn-block mr-1 mb-1" style="margin-top:15px;color:#fff;background: #6c7a89!important; border: 0px solid;">Изменить</a>
		<script src="./files/js.cookie.js" type="text/javascript"></script>
		<script src="./files/redactor.min.js" type="text/javascript"></script>
		<script src="./files/clipboard.min.js" type="text/javascript"></script>
		<script src="./files/script.min.js" type="text/javascript"></script>
		<script>$(function() {window.history.replaceState(null, null, window.location.pathname);});</script>
</div></div></div></div></div></div></div></section></div></div></div></body></html>

HERE;

	}
	else
	{
		$sql_del = "DELETE FROM ".$prefix."_email WHERE `id`='".$row['user_id']."'";
		$result = mysql_query($sql_del);
		$body = <<<HERE

			<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="referrer" content="no-referrer">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="/files/fav_logo.ico">
<title>$name_site - Восстановление пароля</title>
<link rel="stylesheet" type="text/css" href="./files/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./files/style.min.css">
<link rel="stylesheet" type="text/css" href="./files/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="./files/bootstrap-extended.min.css">
<link rel="stylesheet" type="text/css" href="./files/app.min.css">
<link rel="stylesheet" type="text/css" href="./files/colors.min.css">
<link rel="stylesheet" type="text/css" href="./files/style.css">
<link rel="icon" href="./files/$favicon" type="image/x-icon">
<link rel="shortcut icon" href="./files/$favicon" type="image/x-icon">
<script src="./files/jquery-latest.js"></script>
</head>
<body data-open="click" data-menu="horizontal-menu" data-col="2-columns" class="horizontal-layout horizontal-menu 2-columns    menu-expanded " cz-shortcut-listen="true"><div class="app-content container center-layout"><div class="content-wrapper"><div class="content-body"><!--native-font-stack --><section id="description-list-alignment"><div class="row"><div class="col-sm-6 offset-sm-3"><div class="card"><div class="card-header"><h4 class="card-title text-xs-center"><b>Восстановление пароля</b></h4></div>
            <div class="card-body collapse in">
                <div style="text-align: center;" class="card-block">Ссылка больше не действительна
								<a href="/" class="bg-blue-grey bg-lighten-2  btn  btn-block mr-1 mb-1" style="margin-top:15px;color:#fff;background: #6c7a89!important; border: 0px solid;">Вернуться на сайт</a></div></div></div></div></div></section></div></div></div>
</body>
HERE;
	}
}
else
{
	$body = <<<HERE

			<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="referrer" content="no-referrer">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="/files/fav_logo.ico">
<title>$name_site - Восстановление пароля</title>
<link rel="stylesheet" type="text/css" href="./files/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./files/style.min.css">
<link rel="stylesheet" type="text/css" href="./files/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="./files/bootstrap-extended.min.css">
<link rel="stylesheet" type="text/css" href="./files/app.min.css">
<link rel="stylesheet" type="text/css" href="./files/colors.min.css">
<link rel="stylesheet" type="text/css" href="./files/style.css">
<link rel="icon" href="./files/$favicon" type="image/x-icon">
<link rel="shortcut icon" href="./files/$favicon" type="image/x-icon">
<script src="./files/jquery-latest.js"></script>
</head>
<body data-open="click" data-menu="horizontal-menu" data-col="2-columns" class="horizontal-layout horizontal-menu 2-columns    menu-expanded " cz-shortcut-listen="true"><div class="app-content container center-layout"><div class="content-wrapper"><div class="content-body"><!--native-font-stack --><section id="description-list-alignment"><div class="row"><div class="col-sm-6 offset-sm-3"><div class="card"><div class="card-header"><h4 class="card-title text-xs-center"><b>Восстановление пароля</b></h4></div>
            <div class="card-body collapse in">
                <div style="text-align: center;" class="card-block">Ссылка больше не действительна
								<a href="/" class="bg-blue-grey bg-lighten-2  btn  btn-block mr-1 mb-1" style="margin-top:15px;color:#fff;background: #6c7a89!important; border: 0px solid;">Вернуться на сайт</a></div></div></div></div></div></section></div></div></div>
</body>
HERE;
}
echo "$body";
?>
