<?php
error_reporting(E_ALL);



$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_database = "spieler";

$link = mysqli_connect($db_host, $db_username, $db_password, $db_database) or die("Fehler id-cs001 // "  . mysqli_connect_error($link));

if (mysqli_connect_errno()) {
  echo '... '.mysqli_connect_error($mysqli);
}

$link->set_charset("utf8") or die("Fehler id-cs002 // "  . mysqli_connect_error($link));



?>
