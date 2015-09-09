<?php

foreach($_POST as $key => $value) {
	
	switch ($key) {		
		case "spieler_name":
			$_POST[$key] = check_username_cleaner($value, $spieler_ID);
			break;
		case "startkkordinate":
			$_POST[$key] = check_koordinaten_cleaner($value);			
			break;
		default:
			$_POST[$key] = usereingabe_cleaner($value);
			break;
	}
	
}

foreach($_POST as $key => $value) {
	//echo "$key ->  $value <br>";

}

$fehler = false; $fehler_msg = "";

$spieler_name = "";
$start_koordinaten = "";

$x = 0; $y = 0;

if (isset($_POST["spieler_name"])) { $spieler_name = $_POST["spieler_name"]; } 
if (isset($_POST["startkkordinate"])) { $start_koordinaten = $_POST["startkkordinate"]; }

if ($spieler_name != "" && $spieler_name != "fehler") {

	if ($start_koordinaten != "nicht gültig"){
		
		$koords = explode(":", $start_koordinaten);
		 		
		if(!isset($koords[0])) { $fehler = true; $fehler_msg = "ungültige Koordinaten"; } 
		if(!isset($koords[1])) { $fehler = true; $fehler_msg = "ungültige Koordinaten"; }
		
		if(!is_numeric($koords[0])) { $fehler = true; $fehler_msg = "ungültige Koordinaten"; }
		if(!is_numeric($koords[1])) { $fehler = true; $fehler_msg = "ungültige Koordinaten"; }
		
		if ($fehler == false) {
			
			
			
			do {

				$ziel = true;
				
				$x = $koords[0] + rand(0, 10) - 5;
				$y = $koords[1] + rand(0, 10) - 5;
				
				$z = rand(1, 12);
				
				if ($x <= 0 OR $x > 50) { $ziel = false; }
				if ($y <= 0 OR $y > 50) { $ziel = false; }
				
				if ($ziel == true) {
					
					$ziel = check_koordinaten_besetzt($x, $y, $z, $_POST["galaxy"]);
					
					
				}
				
								
				
			} while ($ziel = false);
			
			echo "$x & $y & $z <br>";
			
			if (get_anzahl_planeten($spieler_ID, $_POST["galaxy"]) == 0) {
				
				
				create_first_planet($spieler_ID, $x, $y, $z, $spieler_name, $_POST["galaxy"]);
	
				header("Location: galaxy.php");
				exit;

			} else { $fehler = true; $fehler_msg = "Du hast schon Planeten in der Gala, bitte wende Dich an den Administrator"; }
			

		}
		
		
	} else {  $fehler = true; $fehler_msg = "ungültige Koordinaten";  }
	

} else {  $fehler = true; $fehler_msg = "ungültiger Spielername, doppelt oder bereits existent"; }

if ($fehler == true) {
	echo "$fehler_msg <br>";
	echo "<a href='javascript: history.back();'>nochmal</a>";
} 

?>
