<?php
session_start();
 ini_set( 'display_errors', true );
//error_reporting( 0 );

 
require 'inc/func.php';
require 'inc/connect_spieler.php'; 
 
mysql_select_db("spieler");

if (login(check_username_cleaner ($_POST["sf_username"], 0), $_POST["sf_password"]) == "ok"){
    header('Location: galaxy.php');    
    }
else
    {
    	echo "Benutzername und/oder Passwort waren falsch. <a href=\".\">Login</a>";
    }


?>
