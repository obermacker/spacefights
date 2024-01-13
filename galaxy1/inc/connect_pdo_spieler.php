<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_database = "spieler"; 

try {
  $db = new PDO("mysql:dbname=$db_database;host=" .$db_host, $db_username,  $db_password);
  } catch (PDOException $e) {
  echo 'Fehler: ' . htmlspecialchars($e->getMessage());
  exit();
  }
?>
