<?php

$link = mysqli_connect("localhost","root","", "spieler")
or die("Error " . mysqli_error($link));

mysql_query("SET NAMES 'utf8'");
?>
