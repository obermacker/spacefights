<?php
//error_reporting(E_ALL);
$link = mysqli_connect("localhost","root","", "galaxy1") or die("Fehler id-cg-1-main001 // "  . mysqli_connect_error($link));

if (mysqli_connect_errno($link)) {
  echo '... '.mysqli_connect_error($mysqli);
}

$link->set_charset("utf8") or die("Fehler id-cg-1-main002 // "  . mysqli_connect_error($link));

?>
