<?php
$dbhost = 'tacticcc0nd0.mysql.db';
$dbname = 'tacticcc0nd0';
$dbuser = 'tacticcc0nd0';
$dbpw = '98dQZiG3apn4Ezj';
$db = new PDO('mysql:host=' . $dbhost .';dbname=' . $dbname .';charset=utf8', $dbuser, $dbpw);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);