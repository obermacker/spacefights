<?php
$link = mysql_connect('localhost', 'root', '');

if (!$link) {
	die('Verbindung schlug fehl: ' . mysql_error());
}
?>