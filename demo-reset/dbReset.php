<?php
// Script de réinitialisation du jeu de données de démo

$dbhost = 'tacticcc0nd0.mysql.db';
$dbname = 'tacticcc0nd0';
$dbuser = 'tacticcc0nd0';
$dbpw = '98dQZiG3apn4Ezj';
$resetfile = './www/Condominium/demo-reset/db_reset.sql';

// Réinitialiation des données de la base (sauf les codes postaux) :
system('cat ' . $resetfile . ' | mysql --host=' . $dbhost . ' --user=' . $dbuser . ' --password=' . $dbpw . ' ' . $dbname );