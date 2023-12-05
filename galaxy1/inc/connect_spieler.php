<?php
//error_reporting(E_ALL);
$link = mysqli_connect("localhost","root","","spieler") or die("Fehler id-cs001 // "  . mysqli_connect_error($link));

if (mysqli_connect_errno()) {
  echo '... '.mysqli_connect_error($mysqli);
}

$link->set_charset("utf8") or die("Fehler id-cs002 // "  . mysqli_connect_error($link));

?>
