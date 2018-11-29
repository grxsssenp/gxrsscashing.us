<?php
include_once 'inc/config.php';
$id = $_GET['id'];
	$sql_select = "SELECT * FROM ".$prefix."_games WHERE id='$id'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$ida = $row['id'];
	$user_id = $row['user_id'];
	$cel = $row['cel'];
	$suma = $row['suma'];
	$chislo = $row['chislo'];
	$hash = $row['hash'];
	$salt12 = $row['salt1'];
	$salt22 = $row['salt2'];
	$win_summa = $row['win_summa'];
	$slat = $row['saltall'];

	$rand = $row['saltall'];
	$rande = preg_replace("/[^0-9]/", '', $rand);
	$rand = str_replace("$rande", "|{$rande}|", $rand);
$number = explode( '|', $rand )[1];
$salt1 = explode( '|', $rand )[0];
$namsalt1 = $salt1."|".$number."|";
$salt2 = str_replace($namsalt1, '', $rand);
}
if($ida == null)
{
		header('location: /');
}
$x = mysql_query("SELECT * FROM ".$prefix."_config WHERE ID='1'");
$cf = mysql_fetch_assoc($x);
?>
<!DOCTYPE html>

		<html lang="ru" data-textdirection="ltr" class="loaded"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="referrer" content="no-referrer">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php echo $name_site ?> - Проверка игры №<?php echo $ida; ?></title>
	  <meta name="description" content="Что такое <?php echo $name_site ?>? Сервис мгновеных игр, где шанс выигрыша указываете сами. Быстрые выплаты без комиссий и прочих сборов.">
    <meta name="author" content="<?php echo $domain_site ?>">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="./files/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./files/style.min.css">
    <link rel="stylesheet" type="text/css" href="./files/font-awesome.min.css">

    <!-- END VENDOR CSS-->
    <!-- BEGIN STACK CSS-->
    <link rel="stylesheet" type="text/css" href="./files/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="./files/app.min.css">
    <link rel="stylesheet" type="text/css" href="./files/colors.min.css">

    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="./files/style.css">
		<link rel="icon" href="./files/<?php echo $favicon?>" type="image/x-icon">
		<link rel="shortcut icon" href="./files/<?php echo $favicon?>" type="image/x-icon">
    <!-- END Custom CSS-->
  </head>
  <body style="background-image: url(../img/<?php echo $bgc_site ?>);" class="horizontal-layout horizontal-menu 2-columns menu-expanded ">
		<?php
		if($cf['preloader_active'] == '1')
		{
			echo '<div class="preloader">
					<div class="page-loader-circle"></div>
			</div>';
		}
		?>


    <div class="app-content container center-layout">
      <div class="content-wrapper">

        <div class="content-body"><!--native-font-stack -->





<section id="description-list-alignment">


<div class="row">
    <!-- Description lists horizontal -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><b>GAME CARD</b><small class="text-muted " style='font-size:90%'> #<?php echo $ida; ?></small></h4>

            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                    <div class="card-text">

                        <dl class="row">
						<div class="table-responsive" >
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID Игрокa</th>
                                <th>Цель</th>
                                <th>Выпало</th>
                                <th>Сумма</th>
                                <th>Выигрыш</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="font-weight:600"><?php echo $user_id; ?></th>
                                <td style="font-weight:600"><?php echo $cel; ?></td>
                                <td style="font-weight:600"><?php echo $chislo; ?></td>
                                <td style="font-weight:600"><?php echo $suma; ?> <?php echo $walletsite; ?></td>
                                <td style="font-weight:600"><?php echo $win_summa; ?> <?php echo $walletsite; ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                            <dt class="col-sm-1 text-xs-left" ><br>Hash</dt>
                            <dd class="col-sm-11" style="word-wrap: break-word;">
						   <br><?php echo $hash; ?> </dd>
                            <dt class="col-sm-1 text-xs-left" >Salt 1</dt>
                            <dd class="col-sm-11" style="word-wrap:break-word;"><?php echo $salt1; ?></dd>
                           <dt class="col-sm-1 text-xs-left" >Number</dt>
						   <dd class="col-sm-11" style="word-wrap:break-word;"><?php echo $chislo; ?></dd>
						   <dt class="col-sm-1 text-xs-left" >Salt 2</dt>
                            <dd class="col-sm-11" style="word-wrap:break-word;"><?php echo $salt2; ?></dd>
							<dt class="col-sm-1 text-xs-left" >Готовая</dt>
                            <dd class="col-sm-11" style="word-wrap:break-word;"><?php echo $slat; ?></dd>
							<dt class="col-sm-1 text-xs-left" >Формула</dt>
                            <dd class="col-sm-11" style="word-wrap:break-word;">Salt 1 + Number + Salt 2 = Hash</dd>
						   <dt class="col-sm-4 offset-sm-4" style="margin-top:10px">
						 <button type="button " id="sucText" style="color:#fff;background: #6c7a89!important; border: 0px solid; " onclick="$('#sucText').html('Hash скопирован')" class="btn   btn-block  btn-clipboard" data-clipboard-text="<?php echo $slat; ?>">Скопировать Hash</button>
						 <a target="_blank" href="https://emn178.github.io/online-tools/sha512.html" style="margin-top:10px;color:#fff;background: #42aaff!important; border: 0px solid;" class="btn btn-block">Проверить игру</a>
						 <a href="/" style="margin-top:10px;color:#fff;background: red!important; border: 0px solid;" class="btn btn-block">Вернуться</a>

						 </dt>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Description lists horizontal-->
</div>
</section>
        </div>
      </div>
    </div>

<script src="./files/jquery-latest.min.js"></script>
<script src="./files/redactor.min.js"></script>
<script src="./files/clipboard.min.js" type="text/javascript"></script>
<script src="./files/script.min.js" type="text/javascript"></script>

<span id="sbmarwusasv5"></span></body></html>
