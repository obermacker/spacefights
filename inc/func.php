<?php
function sql_error ($error){
	$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2);
	die ('<BR><BR><b>SQL-errror: </b>&nbsp&nbsp' . $error . '&nbsp -> <b>&nbsp' . $backtrace[0]['file'] . '</b>&nbsp function &nbsp<b>' . $backtrace[1]['function'] . '</b>&nbsp line &nbsp<b>' . $backtrace[0]['line'] . '</b><BR>');
}

function random_float ($min,$max) {
	return ($min+lcg_value()*(abs($max-$min)));
}

function create_first_planet($spieler_id, $x, $y, $z, $username, $galaxy_number) {

	if ($galaxy_number == 1) { require 'inc/connect_galaxy_1.php'; }
	if ($galaxy_number == 2) { require 'inc/connect_galaxy_2.php'; }
	$link->set_charset("utf8");
	
	//Spieler
	
	$sql = "INSERT INTO `spieler`(`Spieler_ID`, `Spieler_Name`, `Typ`, `Bot_Produktion_Zeit`, `Tech_1`, `Tech_2`, `Tech_3`, `Tech_4`, `Tech_5`, `Tech_6`, `Tech_7`, `Tech_8`, `Tech_9`, `Tech_10`, `Tech_11`, `Tech_12`, `Tech_Schleife_ID`, `Tech_Schleife_Eisen`, `Tech_Schleife_Name`, `Tech_Schleife_Silizium`, `Tech_Schleife_Wasser`, `Tech_Schleife_Bauzeit_Start`, `Tech_Schleife_Bauzeit_Bis`, `Tech_Schleife_Planet`, `punkte_structur`, `punkte_flotte`, `punkte_forschung`, `Letzter_Planet`, `avatar`) 
	VALUES ('$spieler_id','$username',0,'".time()."',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'')";
	
	$result = mysqli_query($link, $sql) or sql_error(mysqli_error($link));
	
	//Planet
	
	$planetname = $username."s Kolonie";
	$jetzt = time() - (48 * 60 * 60);
	

	$sql = "INSERT INTO `planet`(
		`Spieler_ID`, `Spieler_Name`, `Planet_Name`, `x`, `y`, `z`, `Planet_ID`, 
		`Ressource_Eisen`, `Ressource_Silizium`, `Ressource_Wasser`, `Ressource_Bot`, `Stationiert_Bot`, 
		`Stufe_Gebaeude_1`, `Stufe_Gebaeude_2`, `Stufe_Gebaeude_3`, `Stufe_Gebaeude_4`, `Stufe_Gebaeude_5`, `Stufe_Gebaeude_6`, `Stufe_Gebaeude_7`, `Stufe_Gebaeude_8`, `Stufe_Gebaeude_9`, `Stufe_Gebaeude_10`, `Stufe_Gebaeude_11`, 
		`Grund_Prod_Eisen`, `Grund_Prod_Silizium`, `Grund_Prod_Wasser`, `Prod_Eisen`, `Prod_Silizium`, `Prod_Wasser`, `Produktion_Zeit`, `Ressource_Energie`, `Ressource_Karma`, 
		`Bauschleife_Gebaeude_ID`, `Bauschleife_Gebaeude_Start`, `Bauschleife_Gebaeude_Bis`, `Bauschleife_Gebaeude_Name`, 
		`Bunker_Kapa`, `Bunker_Eisen`, `Bunker_Silizium`, `Bunker_Wasser`, 
		`Bauschleife_Flotte_ID`, 
		`Schiff_Typ_1`, `Schiff_Typ_2`, `Schiff_Typ_3`, `Schiff_Typ_4`, `Schiff_Typ_5`, `Schiff_Typ_6`, `Schiff_Typ_7`, `Schiff_Typ_8`, `Schiff_Typ_9`, `Schiff_Typ_10`, `Schiff_Typ_11`, `Schiff_Typ_12`, 
		`Deff_Typ_1`, `Deff_Typ_2`, `Deff_Typ_3`, `Deff_Typ_4`, `Deff_Typ_5`, `Deff_Typ_6`, 
		`Handel_Kapa`, `Handel_Eisen`, `Handel_Silizium`, `Handel_Wasser`, 
		`punkte`, `Gesamt_Bot`) 
	VALUES 
		('$spieler_id','$username','$planetname',$x, $y, $z, 0,
		20,10,5,0,0,
		0,0,0,0,0,0,0,0,0,0,0,
		20,10,5,0,0,0,$jetzt,0,0,
		0,0,0,0,
		0,0,0,0,
		0,
		0,0,0,0,0,0,0,0,0,0,0,0,
		0,0,0,0,0,0,
		0,0,0,0,
		0,0)";
		
	$result = mysqli_query($link, $sql) or sql_error(mysqli_error($link));

	//spielername in der gala
	require 'inc/connect_spieler.php';
	$link->set_charset("utf8");
	
	$query = "UPDATE `spieler` SET `name_galaxy_$galaxy_number`= '$username' WHERE `spieler_ID` = '$spieler_id'";
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));
	
	
}

function get_timestamp_in_datum_und_zeit($value) {
	//$date = new DateTime(null, new DateTimeZone('Europe/Berlin'));
	$date = new DateTime();
	$date->setTimestamp($value);
	return $date->format(' d.m.Y h:i');
}

function get_in_galaxy_name($spieler_id, $galaxy_number){
	require 'inc/connect_spieler.php';
	$link->set_charset("utf8");
	$query = "SELECT `spieler_ID`, `name_galaxy_1`, `name_galaxy_2`, `name_galaxy_3` FROM `spieler` WHERE `spieler_ID` = '".$spieler_id."'" ;
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));


	$row = mysqli_fetch_object($result);
	$tabelle = "name_galaxy_".$galaxy_number;
	
	$ruckgabe = $row->$tabelle;
	return $ruckgabe;  
}

function check_username_cleaner($value, $spieler_id){
	require 'inc/connect_spieler.php';
	
	$badword = "admin administrator error fehler gast unbekannt unknown test";
	
	$newVal = substr($value, 0, 30);
	if (strlen($newVal) < 2) { return ""; }
	 
	
	if (strpos($badword, strtolower($value)) !== false) {
	    return "fehler"; //Badword filter
	}
	
	$regex ='/[^.:a-zA-ZäüöÄÜÖß0-9-\/]/';
	$newVal = preg_replace($regex," ", $newVal);

	$newVal = htmlspecialchars($newVal);
	$newVal = stripslashes($newVal);
	//$newVal = filter_var($newVal, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
	
	if($spieler_id == 0) { return $newVal;}
	
	$abfrage = "FROM `spieler` WHERE `spieler_ID` <> '$spieler_id' AND (`spieler_name` = '$newVal' OR `name_galaxy_1` =  '$newVal' OR `name_galaxy_2` =  '$newVal' OR `name_galaxy_3` = '$newVal')";
	
	
	$result = $link->query("SELECT count(*) as total $abfrage")
	or die ("Error: #0004  " . mysql_error());
	
	$data = mysqli_fetch_assoc($result);
	
	$anzahl = $data['total'];
	
	if ($anzahl > 0) { return "fehler"; }
	
	return $newVal;
	
}


function check_username_cleaner_register($value){
	require 'inc/connect_spieler.php';

	$badword = "admin administrator error fehler gast unbekannt unknown test";

	$newVal = substr($value, 0, 30);
	if (strlen($newVal) < 2) { return "fehler"; }


	if (strpos($badword, strtolower($value)) !== false) {
		return "fehler"; //Badword filter
	}

	$regex ='/[^.:a-zA-ZäüöÄÜÖß0-9-\/]/';
	$newVal = preg_replace($regex," ", $newVal);

	$newVal = htmlspecialchars($newVal);
	$newVal = stripslashes($newVal);
	//$newVal = filter_var($newVal, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
	
	$abfrage = "FROM `spieler` WHERE `spieler_name` = '$newVal' OR `name_galaxy_1` =  '$newVal' OR `name_galaxy_2` =  '$newVal' OR `name_galaxy_3` = '$newVal'";


	$result = $link->query("SELECT count(*) as total $abfrage")
	or die ("Error: #0004  " . mysql_error());

	$data = mysqli_fetch_assoc($result);

	$anzahl = $data['total'];

	if ($anzahl > 0) { return "fehler"; }

	return $newVal;

}


function check_koordinaten_besetzt($x, $y, $z, $galaxy_number) {
	
	if (!is_numeric($galaxy_number)) { return false; }
	
	if ($galaxy_number == 1) { require 'inc/connect_galaxy_1.php'; }
	if ($galaxy_number == 2) { require 'inc/connect_galaxy_2.php'; }

	$result = $link->query("SELECT count(*) as total from `planet` WHERE `x` = $x AND `y` = $y AND `z` = $z")
	or die ("Error: #0005 " . mysql_error());
		
	$data = mysqli_fetch_assoc($result);
	
	$anzahl = $data['total'];
	
	if ($anzahl > 0) { return false; } else { return true; }
	
		
}

function check_valid_url() {
	
	
	
}

function check_koordinaten_cleaner($value) {
		
		$koords = explode(":", $value);

		if(!isset($koords[0])) { return "nicht gültig"; }  
		if(!isset($koords[1])) { return "nicht gültig"; }
		
		if(!is_numeric($koords[0])) { return "nicht gültig"; }  
		if(!is_numeric($koords[1])) { return "nicht gültig"; }
		
		return $value;
		


}

function usereingabe_cleaner ($value)
{
	$newVal = trim($value);
	$regex ='/[^a-zA-Z0-9\_]/';
	$newVal = preg_replace($regex," ", $newVal);

	$newVal = htmlspecialchars($newVal);
	//$newVal = htmlentities($newVal);
	$newVal = stripslashes($newVal);
	$newVal = filter_var($newVal, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
	#$newVal = mysql_real_escape_string($newVal);
	$newVal = str_replace("-", "", $newVal);
	$newVal = str_replace(".", "", $newVal);
		
	return $newVal;
	
	
}

function get_anzahl_planeten($spieler_id, $galaxy_number){
	if ($galaxy_number == 1) { require 'inc/connect_galaxy_1.php';}
	//if ($galaxy_number == 2) { require 'inc/connect_galaxy_2.php'; mysql_select_db("galaxy2");}
	
	if ($galaxy_number == 2) { return 0;}
	if ($galaxy_number == 3) { return 0;}
	
	
	$result = $link->query("SELECT count(*) as total from `planet` WHERE `Spieler_ID` = '$spieler_id'")
	or die ("Error: #0006 " . mysql_error());
					
	$data = mysqli_fetch_assoc($result);
	
	$anzahl = $data['total'];
	
	return ($anzahl);
	
}

function session_generate () {
	return md5(random_float(1, 200).session_id());
}

function login($username, $passwort, $remember){
	
	if ($username == "" OR $passwort == "") { return ""; }
	
	require 'inc/connect_spieler.php';

	$query = "SELECT `ID`, `spieler_ID`, `spieler_name`, `passwort`, `letzter_login`, `spieler_geloescht`, `name_gala_1`, `aktiv_gala_1`, `letzter_Planet`, `max_Planeten` FROM `spieler` WHERE spieler_name = '$username' LIMIT 1";
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));
	
	if ($row = mysqli_fetch_array($result)) {
		
		if(hash_equals($row["passwort"], crypt($passwort, $row["passwort"])) AND $username == $row["spieler_name"])
		{			
			$_SESSION["spieler_ID"] = $row["spieler_ID"];
			$_SESSION["session_id"] = session_generate();
			$varHTTP_USER_AGENT = md5($_SERVER['HTTP_USER_AGENT']);
			
			$query = "UPDATE spieler SET session_id = '".$_SESSION["session_id"]."', letzter_login = ".time().", HTTP_USER_AGENT = '".$varHTTP_USER_AGENT."' WHERE spieler_ID = '".$_SESSION["spieler_ID"]."'" or die("Error: #0007 " . mysqli_error($link));
			
			$ergebnis =  mysqli_query($link, $query) or sql_error(mysqli_error($link));
			
			if($remember == true) {
				$expire = time() + 3600 * 24 * 60; //Verfalldatum in 60 Tagen
				setcookie("rememberme", "yes", $expire);
				setcookie("user_id", $_SESSION["spieler_ID"], $expire);
				setcookie("auth_token", $_SESSION["session_id"], $expire);
			} else {
				$expire = time() + 3600 * 24 * 60; //Verfalldatum in 60 Tagen
				setcookie("rememberme", "no", $expire);
			}
			
			return "ok";
		}
	}
}

function check_auth($spieler_id, $session_id) {
	
	if(!$spieler_id || !$session_id) { return "nein"; }
	
	require 'inc/connect_spieler.php'; 
		
	$query = "SELECT `ID`, `spieler_ID`, `session_id`, `HTTP_USER_AGENT` FROM `spieler` WHERE `spieler_ID` = '".$spieler_id."' AND `session_id` = '".$session_id."' LIMIT 1" or die("Error: #0009 " . mysqli_error($link));
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));
	$row = mysqli_fetch_array($result);
	
	if($row["HTTP_USER_AGENT"] == md5($_SERVER['HTTP_USER_AGENT']))
	{
		return "ja";	
		
	} else{
		
		return "nein";
	}
}


function registrieren($username, $password) {
	require 'inc/connect_spieler.php';

	$username = check_username_cleaner_register($username);
	$_password = mysqli_real_escape_string($link, $password);
	
	if ($username == "fehler") { return "fehler"; } 

	echo preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/", $_password);

	if(preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/", $_password)) {


		$password_hash = password_hash($password, PASSWORD_BCRYPT);		
		$unique = md5(uniqid(mt_rand(), TRUE));
	
		$sql = "INSERT INTO `spieler`(			
			`spieler_ID`, 
			`spieler_name`, 
			`name_galaxy_1`, 
			`name_galaxy_2`, 
			`name_galaxy_3`, 
			`passwort`, 
			`letzter_login`, 
			`session_id`, 
			`HTTP_USER_AGENT`, 
			`spieler_geloescht`, 
			`name_gala_1`, 
			`aktiv_gala_1`, 
			`letzter_Planet`, 
			`max_Planeten`) 
			VALUES (				
				'$unique',
				'$username',
				'',
				'',
				'',
				'$password_hash',
				0,
				0,
				'',
				0,
				'',
				0,
				0,
				0)";
	
		
		$result = mysqli_query($link, $sql) or sql_error(mysqli_error($link));
		
		if ($result) {
			return "Yeahh!";
			
		} else {
			
			return "Nope.";
			
		}
		

	}
	

}


?>