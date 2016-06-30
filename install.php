<?php
error_reporting(E_ALL);
session_start();
// Zum Aufbau der Verbindung zur Datenbank
define ( 'MYSQL_HOST',      '127.0.0.1:3308' );
define ( 'MYSQL_BENUTZER',  'root' );
define ( 'MYSQL_KENNWORT',  '' );
define ( 'MYSQL_DATENBANK_User', 'sf_User' );
define ( 'MYSQL_DATENBANK_Galaxy_1', 'sf_Galaxy1' );

define ( 'MAIN_ADMIN_NAME', '' ); 		//<- change this
define ( 'MAIN_ADMIN_PASSWORD', '');	//<- change this

if(MAIN_ADMIN_NAME == '' || MAIN_ADMIN_PASSWORD == '') {

	die("Fehler, Blanko-Admin"); exit();

}


$db_link = mysqli_connect (MYSQL_HOST,
		MYSQL_BENUTZER,
		MYSQL_KENNWORT);

if ( $db_link )
{
	//print_r( $db_link);
}
else
{
	// hier sollte dann später dem Programmierer eine
	// E-Mail mit dem Problem zukommen gelassen werden
	die('keine Verbindung möglich: ' . mysqli_error($db_link));
}

// zuweisen der MySQL-Anweisung einer Variablen
$sql = 'CREATE DATABASE IF NOT EXISTS ' . MYSQL_DATENBANK_User;

$result = mysqli_query($db_link, $sql)
or die("Anfrage fehlgeschlagen: " . mysqli_error($db_link));

//User Tabelle Anlegen

$db_link = mysqli_connect (MYSQL_HOST,
		MYSQL_BENUTZER,
		MYSQL_KENNWORT,
		MYSQL_DATENBANK_User);

if ( $db_link )
{
	$sql = "CREATE TABLE IF NOT EXISTS `main_user` (
	  `ID` int(11) NOT NULL,
	  `spieler_ID` varchar(58) NOT NULL,
	  `spieler_name` varchar(30) NOT NULL,
	  `name_galaxy_1` varchar(30) NOT NULL,
	  `name_galaxy_2` varchar(30) NOT NULL,
	  `name_galaxy_3` varchar(30) NOT NULL,
	  `passwort` varchar(255) NOT NULL,
	  `letzter_login` int(9) NOT NULL,
	  `session_id` varchar(255) NOT NULL,
	  `HTTP_USER_AGENT` varchar(255) NOT NULL,
	  `spieler_geloescht` int(11) NOT NULL,
	  `name_gala_1` varchar(30) NOT NULL,
	  `aktiv_gala_1` int(11) NOT NULL,
	  `letzter_Planet` int(11) NOT NULL,
	  `max_Planeten` int(11) NOT NULL
	) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;";
	
	
	$result = mysqli_query($db_link, $sql)
	or die("2. Anfrage fehlgeschlagen: " . mysqli_error($db_link));
	
	
	$sql = "ALTER TABLE `main_user` ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `spieler_ID` (`spieler_ID`), ADD UNIQUE KEY `spieler_ID_2` (`spieler_ID`);";
	$result = mysqli_query($db_link, $sql)
	or die("2. Anfrage fehlgeschlagen: " . mysqli_error($db_link));
	
	$sql = "ALTER TABLE `main_user` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;";
	$result = mysqli_query($db_link, $sql)
	or die("2. Anfrage fehlgeschlagen: " . mysqli_error($db_link));
	
	
	//admin anlegen
	
	if(!MAIN_ADMIN_NAME == '' || !MAIN_ADMIN_PASSWORD == '') {
		
		
		$spieler_id = md5((1+lcg_value()*(abs(200-1))).session_id());
		$pw = md5(MAIN_ADMIN_PASSWORD);
		
		$sql = "INSERT INTO `main_user`(`spieler_ID`, `spieler_name`, `passwort`) VALUES ('$spieler_id', '". MAIN_ADMIN_NAME . "', '$pw')";

		$result = mysqli_query($db_link, $sql)
		or die("2. Anfrage fehlgeschlagen: " . mysqli_error($db_link));
		
		
		
	}
	
	
	
	}
else
{
	// hier sollte dann später dem Programmierer eine
	// E-Mail mit dem Problem zukommen gelassen werden
	die('keine Verbindung möglich: ' . mysqli_error($db_link));
}


		

?>