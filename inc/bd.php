<?php
mysql_query("SET NAMES utf8");
mysql_connect("localhost", "kilixt2g_1", "123456")//параметры в скобках ("хост", "имя пользователя", "пароль")
or die("<p>Ошибка подключения к базе данных! " . mysql_error() . "</p>");

mysql_select_db("kilixt2g_1")//параметр в скобках ("имя базы, с которой соединяемся")
 or die("<p>Ошибка выбора базы данных! ". mysql_error() . "</p>");
 mysql_query("SET NAMES utf8");
?>
