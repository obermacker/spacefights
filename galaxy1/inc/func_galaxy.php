<?php
function get_timestamp_in_was_sinnvolles($value) {
	$secs = number_format($value, 0, '', '');
	$dtF = new DateTime("@0");
	$dtT = new DateTime("@$secs");
	return $dtF->diff($dtT)->format('%a Tage %H:%I:%S');	
}

function get_ship($ship_id) {

	$row_ship = get_config_ships($ship_id, 0);
	
	$row_ship["Bauzeit"] = get_timestamp_in_was_sinnvolles($row_ship["Bauzeit"]);
	
	return $row_ship;
	
}

function get_gebäude_raumschiffwert($spieler_id, $planet_id, $gebäude_id) {

	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");
	
	//planet|aktuelle Stufe
	$abfrage = "SELECT `Stufe_Gebaeude_1`, `Stufe_Gebaeude_2`, `Stufe_Gebaeude_3`, `Stufe_Gebaeude_4`, `Stufe_Gebaeude_5`, `Stufe_Gebaeude_6`, `Stufe_Gebaeude_7`, `Stufe_Gebaeude_8`, `Stufe_Gebaeude_9`, `Stufe_Gebaeude_10`, `Stufe_Gebaeude_11` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = '$planet_id'";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_gebäude_nächste_stufe #1 ".$link));
	$result = mysqli_query($link, $query);
	
	$row_aktuelle_Stufe = mysqli_fetch_object($result);
	
	$tabelle = "Stufe_Gebaeude_".$gebäude_id;	
	return $row_aktuelle_Stufe->$tabelle;
	

}


function random_float ($min,$max) {
	return ($min+lcg_value()*(abs($max-$min)));
}

function check_bauschleife_activ($spieler_id, $planet_id) {
	
	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT `Bauschleife_Gebaeude_ID`, `Bauschleife_Gebaeude_Bis` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: check_bauschleife_activ #1 ".$link));
	$result = mysqli_query($link, $query);
	
	$row = mysqli_fetch_object($result);
	
	$bauschleife["ID"] = $row->Bauschleife_Gebaeude_ID; 
	$bauschleife["Bis"] = $row->Bauschleife_Gebaeude_Bis - time(); //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());	
	return $bauschleife;
}

function get_gebäude_nächste_stufe($spieler_id, $planet_id, $gebäude_id, $speed_mod) {
	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");	
	
	//planet|aktuelle Stufe
	$abfrage = "SELECT `Stufe_Gebaeude_1`, `Stufe_Gebaeude_2`, `Stufe_Gebaeude_3`, `Stufe_Gebaeude_4`, `Stufe_Gebaeude_5`, `Stufe_Gebaeude_6`, `Stufe_Gebaeude_7`, `Stufe_Gebaeude_8`, `Stufe_Gebaeude_9`, `Stufe_Gebaeude_10`, `Stufe_Gebaeude_11` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = '$planet_id'";
	
		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_gebäude_nächste_stufe #1 ".$link));
		$result = mysqli_query($link, $query);
		
		$row_aktuelle_Stufe = mysqli_fetch_object($result);
	
	$tabelle = "Stufe_Gebaeude_".$gebäude_id;
	$stufe = $row_aktuelle_Stufe->$tabelle + 1;
	$bauzentrum = $row_aktuelle_Stufe->Stufe_Gebaeude_4 + 1;
	
	//Kosten fürs Gebäude
	
		$row_kosten_nächstes_Gebäude = get_config_structure($gebäude_id);
	
		$Gebäude["Name"] = $row_kosten_nächstes_Gebäude["Name"];
		$Gebäude["Beschreibung"] = $row_kosten_nächstes_Gebäude["Beschreibung"];
		$Gebäude["Wirkung"] = $row_kosten_nächstes_Gebäude["Wirkung"];
		
		$Gebäude["Kosten_Eisen"] = $row_kosten_nächstes_Gebäude["Kosten_Eisen"];
		$Gebäude["Kosten_Silizium"] = $row_kosten_nächstes_Gebäude["Kosten_Silizium"];
		$Gebäude["Kosten_Wasser"] = $row_kosten_nächstes_Gebäude["Kosten_Wasser"];
		$Gebäude["Kosten_Energie"] = $row_kosten_nächstes_Gebäude["Kosten_Energie"];
		$Gebäude["Gewinn_Energie"] = $row_kosten_nächstes_Gebäude["Gewinn_Energie"];
		$Gebäude["Level_Cap"] = $row_kosten_nächstes_Gebäude["Level_Cap"];
		$Gebäude["Gewinn_Ress"] = number_format($row_kosten_nächstes_Gebäude["Gewinn_Ress"], 0, '.', '.');
		$Gebäude["Bauzeit"] = $row_kosten_nächstes_Gebäude["Bauzeit"];
		$Gebäude["Kapazitaet"] = number_format($row_kosten_nächstes_Gebäude["Kapazitaet"], 0, '.', '.');
		$Gebäude["Stufe"] = $stufe;
		
		$mod_gewinn_kapazität = 0;
		$mod_gewinn_energie = 0;
		$mod_ress = 0;
		$mod_gewinn_kapazität = 0;
		
		if ($gebäude_id <= 3 ) { $mod_ress = 1.41; $mod_energie = 1.33; $mod_gewinn_ress = 1.35; $mod_bauzeit = 1.65;}
		
		if ($gebäude_id >= 4) { $mod_ress = 1.5; $mod_energie = 1.5; $mod_gewinn_ress = 0; $mod_bauzeit = 2;}
		
		if ($gebäude_id == 4) { $mod_gewinn_energie = 1.66; }
		
		for($i = 1; $i < $stufe; $i++) {
		
			$Gebäude["Kosten_Eisen"] = $Gebäude["Kosten_Eisen"] * $mod_ress * $speed_mod;
			$Gebäude["Kosten_Silizium"] = $Gebäude["Kosten_Silizium"] * $mod_ress * $speed_mod;
			$Gebäude["Kosten_Wasser"] = $Gebäude["Kosten_Wasser"] * $mod_ress * $speed_mod;
			$Gebäude["Kosten_Energie"] = $Gebäude["Kosten_Energie"] * $mod_energie * $speed_mod;
		
			if ($i <= $Gebäude["Level_Cap"]) {
				$Gebäude["Gewinn_Ress"] = $Gebäude["Gewinn_Ress"] * $mod_gewinn_ress * $speed_mod;
				$Gebäude["Gewinn_Energie"] = $Gebäude["Gewinn_Energie"] * $mod_gewinn_energie;
				$Gebäude["Kapazitaet"] = $Gebäude["Kapazitaet"] * $mod_gewinn_kapazität;
			}
		
			$Gebäude["Bauzeit"] = ($Gebäude["Bauzeit"] * $mod_bauzeit);
			
		}
		
		
		$Gebäude["Kosten_Eisen"] = round($Gebäude["Kosten_Eisen"]);
		$Gebäude["Kosten_Silizium"] = round($Gebäude["Kosten_Silizium"]);
		$Gebäude["Kosten_Wasser"] = round($Gebäude["Kosten_Wasser"]);
		$Gebäude["Kosten_Energie"] = round($Gebäude["Kosten_Energie"]);
		$Gebäude["Gewinn_Energie"] = round($Gebäude["Gewinn_Energie"]);
		$Gebäude["Gewinn_Ress"] = round($Gebäude["Gewinn_Ress"]);
		
		$Gebäude["Bauzeit"] = $Gebäude["Bauzeit"] / (1 * $bauzentrum);
		
		$Gebäude["Bauzeit"] = get_timestamp_in_was_sinnvolles($Gebäude["Bauzeit"]);
		
	return $Gebäude;
	
}

function get_tech_nächste_stufe($spieler_id, $planet_id, $tech_id, $speed_mod) {
	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");

	//spieler|aktuelle Stufe
	$abfrage = "SELECT `Tech_1`, `Tech_2`, `Tech_3`, `Tech_4`, `Tech_5`, `Tech_6`, `Tech_7`, `Tech_8`, `Tech_9`, `Tech_10`, `Tech_11`, `Tech_12`, `Tech_Schleife_ID` FROM `spieler` WHERE `Spieler_ID` = '$spieler_id'";

		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_tech_nächste_stufe #1 ".$link));
		$result = mysqli_query($link, $query);

		$row_aktuelle_Stufe_Tech = mysqli_fetch_array($result);
		
		$tabelle = "Tech_".$tech_id;
		$stufe = $row_aktuelle_Stufe_Tech["Tech_".$tech_id] + 1;
		
	//planet|Stufe Forschungszentrum
	$abfrage = "SELECT `Stufe_Gebaeude_10` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = '$planet_id'";
	
		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_tech_nächste_stufe #2 ".$link));
		$result = mysqli_query($link, $query);
		
		$row_aktuelle_Stufe_Struckture = mysqli_fetch_object($result);
		
		$forschungszentrum = $row_aktuelle_Stufe_Struckture->Stufe_Gebaeude_10;

	//Kosten für die Forschung

		$row_kosten_nächste_Forschung = get_config_tech($tech_id, $row_aktuelle_Stufe_Tech);
		
		$Tech["Name"] = $row_kosten_nächste_Forschung["Name"];
		$Tech["Beschreibung"] = $row_kosten_nächste_Forschung["Beschreibung"];
		$Tech["Wirkung"] = $row_kosten_nächste_Forschung["Wirkung"];
		$Tech["Kosten_Eisen"] = $row_kosten_nächste_Forschung["Kosten_Eisen"];
		$Tech["Kosten_Silizium"] = $row_kosten_nächste_Forschung["Kosten_Silizium"];
		$Tech["Kosten_Wasser"] = $row_kosten_nächste_Forschung["Kosten_Wasser"];
		$Tech["Level_Cap"] = $row_kosten_nächste_Forschung["Level_Cap"];
		$Tech["Bauzeit"] = $row_kosten_nächste_Forschung["Bauzeit"];
		$Tech["Erw_Bedingung"] = $row_kosten_nächste_Forschung["Erw_Bedingung"];
				
		$Tech["Stufe"] = $stufe;

		
		$Tech["Lab"] = $row_kosten_nächste_Forschung["Lab"];
		
		if($Tech["Erw_Bedingung"] == "nicht bestanden") { $Tech["Forschung"] = "N/A" ; return $Tech; } else { $Tech["Forschung"] = "OK"; }
		if($Tech["Lab"] > $forschungszentrum) { $Tech["Forschung"] = "N/A" ; return $Tech; } else { $Tech["Forschung"] = "OK"; }
		
		if($stufe > $Tech["Level_Cap"]) { $Tech["Forschung"] = "MAX" ; return $Tech; } else { $Tech["Forschung"] = "OK"; }
		
		$mod_gewinn_kapazität = 0;
		$mod_gewinn_energie = 0;
		$mod_ress = 0;
		$mod_gewinn_kapazität = 0;
		
		$mod_ress = 1.5; $mod_bauzeit = 2;
		
		for($i = 1; $i < $stufe; $i++) {
		
			$Tech["Kosten_Eisen"] = $Tech["Kosten_Eisen"] * $mod_ress * $speed_mod;
			$Tech["Kosten_Silizium"] = $Tech["Kosten_Silizium"] * $mod_ress * $speed_mod;
			$Tech["Kosten_Wasser"] = $Tech["Kosten_Wasser"] * $mod_ress * $speed_mod;
			$Tech["Kosten_Energie"] = $Tech["Kosten_Energie"] * $mod_energie * $speed_mod;
			$Tech["Bauzeit"] = ($Tech["Bauzeit"] * $mod_bauzeit);
		}
		
		$Tech["Kosten_Eisen"] = round($Tech["Kosten_Eisen"]);
		$Tech["Kosten_Silizium"] = round($Tech["Kosten_Silizium"]);
		$Tech["Kosten_Wasser"] = round($Tech["Kosten_Wasser"]);
		
		$Tech["Bauzeit"] = $Tech["Bauzeit"] / (1 * $forschungszentrum);
		
		$Tech["Bauzeit"] = get_timestamp_in_was_sinnvolles($Tech["Bauzeit"]);
		
		return $Tech;

}

function get_list_of_all_planets($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");
	
	$abfrage = "SELECT `Planet_Name`, `Planet_ID` FROM `Planet` WHERE `Spieler_ID` = '$spieler_id'";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query);
	$ausgabe ="";

	while($row = mysqli_fetch_object($result)) {  
		
	 	if ($row->Planet_ID == $planet_id) { $select = "selected"; } else { $select = "";}
		$ausgabe = $ausgabe . "<option $select>" . $row->Planet_Name . "</option>";

	}
	
	return $ausgabe;
}


function get_koordinaten_planet($spieler_id, $planet_id) {

	require 'inc/connect_galaxy_1.php';
	
	$abfrage = "SELECT `x`, `y`, `z` FROM `Planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query);
	
	$row = mysqli_fetch_object($result);
	
	$ausgabe = $row->x.":".$row->y.":".$row->z;

	return $ausgabe; 

}

function get_Ressbunker_Inhalt($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';
	
	$abfrage = "SELECT 	`Bunker_Kapa`, `Bunker_Eisen`, `Bunker_Silizium`, `Bunker_Wasser` FROM `Planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_Ressbunker_Inhalt #1 ".$link));
	$result = mysqli_query($link, $query);
	
	$row = mysqli_fetch_object($result);
	
	if($row->Bunker_Kapa > 0) {
		
	
	$ausgabe = (($row->Bunker_Eisen + $row->Bunker_Silizium + $row->Bunker_Wasser) * 100 / $row->Bunker_Kapa) . "%";

	} else {
		
		$ausgabe = "-";
		
	}
	
	return $ausgabe; 
	
}


function get_Handelsposten_Inhalt($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT 	`Handel_Kapa`, `Handel_Eisen`, `Handel_Silizium`, `Handel_Wasser` FROM `Planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_Ressbunker_Inhalt #1 ".$link));
	$result = mysqli_query($link, $query);

	$row = mysqli_fetch_object($result);

	if($row->Handel_Kapa > 0) {


		$ausgabe = (($row->Handel_Eisen + $row->Handel_Silizium + $row->Handel_Wasser) * 100 / $row->Handel_Kapa) . "%";

	} else {

		$ausgabe = "-";

	}

	return $ausgabe;

}

function get_Schiffe_stationiert($spieler_id, $planet_id) {

	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");
	$abfrage = "SELECT `Schiff_Typ_1`, `Schiff_Typ_2`, `Schiff_Typ_3`, `Schiff_Typ_4`, `Schiff_Typ_5`, `Schiff_Typ_6`, `Schiff_Typ_7`, `Schiff_Typ_8`, `Schiff_Typ_9`, `Schiff_Typ_10`, `Schiff_Typ_11` FROM `Planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_Schiffe_stationiert #1 ".$link));
	$result = mysqli_query($link, $query);
	

	$row = mysqli_fetch_object($result);
	
	 for($i = 1; $i <= 11; $i++) {
		
		
		$abfrage = "SELECT `Raumschiff_Name`, `Raumschiff_Name_Plural` FROM `raumschiff` WHERE Schiff_ID = " . $i;
		
		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_Schiffe_stationiert #2 ".$link));
		$result_schiffe = mysqli_query($link, $query);
		
		$row_schiffe = mysqli_fetch_object($result_schiffe);
		
		$tabelle = "Schiff_Typ_".$i;
		
		$anzahl = $row->$tabelle;
		
		$anzahl = number_format($anzahl, 0, '.', '.');
		
		if ($row->$tabelle > 0) {
			
			if ($row->$tabelle = 1) {
				$schiffe[$i]["Name"] = $row_schiffe->Raumschiff_Name;
				$schiffe[$i]["Anzahl"] = $anzahl;
			} else {
				$schiffe[$i]["Name"] = $row_schiffe->Raumschiff_Name_Plural;
				$schiffe[$i]["Anzahl"] = $anzahl;
			}

		}
	
	}
	
	
	if (isset($schiffe)) { return $schiffe; }
	
	
	
	
	
}

function get_activity_planet_spieler_schiffe($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';
	
	//planet|gebäude
	$abfrage = "SELECT `Bauschleife_Gebaeude_Name`, `Bauschleife_Gebaeude_Bis`, `Bauschleife_Flotte_Bis` FROM `Planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0010a ".$link));
	$result = mysqli_query($link, $query);
	
	$row = mysqli_fetch_object($result);
	
	
	if ( $row->Bauschleife_Gebaeude_Bis <> 0) { $activity["Gebäude"]["Name"] = $row->Bauschleife_Gebaeude_Name; $activity["Gebäude"]["Zeit-Bis"] = $row->Bauschleife_Gebaeude_Bis - time(); } else { $activity["Gebäude"]["Name"] = ""; $activity["Gebäude"]["Zeit-Bis"] = "-"; }
	
		
	//spieler|forschung
	
	$abfrage = "SELECT `Tech_Schleife_Name`, `Tech_Schleife_Bauzeit` FROM `spieler` WHERE `Spieler_ID` = '$spieler_id'";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0010b ".$link));
	$result = mysqli_query($link, $query);
	
	$row = mysqli_fetch_object($result);
	
	
	if ( $row->Tech_Schleife_Bauzeit <> 0) {  $activity["Forschung"]["Name"] = $row->Tech_Schleife_Name; $activity["Forschung"]["Zeit-Bis"] = $row->Tech_Schleife_Bauzeit - time(); } else { $activity["Forschung"]["Name"] = ""; $activity["Forschung"]["Zeit-Bis"] = "-"; }
	
	return $activity;
	
}

function get_activity_schiffe_Liste($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	$link->set_charset("utf8");
	
	//schiffe

	$abfrage = "SELECT `Name`, `Anzahl`, `Bauzeit_Bis` FROM `bauschleifeflotte` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0010c ".$link));
	$result = mysqli_query($link, $query);

	
	
	$i = 0;
	while($row = mysqli_fetch_object($result)) {
		
		$flotte[$i]["Anzahl"] = number_format($row->Anzahl, 0, '.', '.');
		$flotte[$i]["Name"] = $row->Name;
		$flotte[$i]["Zeit-Bis"] = $row->Bauzeit_Bis - time();

		$i++;

	}



	if (isset($flotte)) { return $flotte; }

}

function get_ressource($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';
	
	$abfrage = "SELECT `Ressource_Eisen`, `Ressource_Silizium`, `Ressource_Wasser`, `Ressource_Bot`, `Stationiert_Bot`, `Ressource_Energie`, `Ressource_Karma` FROM `Planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query);
	
	$row = mysqli_fetch_object($result);
	

	$ressource["Eisen"] = $row->Ressource_Eisen;
	$ressource["Silizium"] = $ausgabe = $row->Ressource_Silizium;
	$ressource["Wasser"] = $row->Ressource_Wasser;
	$ressource["Energie"] = $row->Ressource_Energie;
	$ressource["Bot"] = $row->Ressource_Bot;
	$ressource["Bot Stationiert"] = $row->Stationiert_Bot;
	$ressource["Karma"] = $row->Ressource_Karma;
		
	
	//foreach($ressource as $key => $value) {
	//	$ressource[$key] = number_format(floor($value), 0, '.', '.');
	//}
	
	
	return $ressource;

	
}

function create_first_planet($spieler_id, $x, $y, $z, $username, $galaxy_number) {

	if ($galaxy_number == 1) { require 'inc/connect_galaxy_1.php'; }
	if ($galaxy_number == 2) { require 'inc/connect_galaxy_2.php'; }
	
	$link->set_charset("utf8");
	
	//Spieler
	
	$abfrage = "INSERT INTO `spieler`(`ID`, `Spieler_ID`, `Spieler_Name`, `Typ`, `Bot_Produktion_Zeit`, `Tech_1`, `Tech_2`, `Tech_3`, `Tech_4`, `Tech_5`, `Tech_6`, `Tech_7`, `Tech_8`, `Tech_9`, `Tech_10`, `Tech_11`, `Tech_12`, `Tech_Schleife_ID`, `Tech_Schleife_Eisen`, `Tech_Schleife_Name`, `Tech_Schleife_Silizium`, `Tech_Schleife_Wasser`, `Tech_Schleife_Bauzeit`, `Tech_Schleife_Planet`) VALUES ('','$spieler_id','$username','human',".time().",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query);
	
	//Planet
	
	$planetname = $username."s Kolonie";

	$abfrage = "INSERT INTO `planet`(`Spieler_ID`, `Spieler_Name`, `Planet_Name`, `x`, `y`, `z`, `Grund_Prod_Eisen`, `Grund_Prod_Silizium`, `Grund_Prod_Wasser`) VALUES ('', '$username','$planetname', $x, $y, $z, 20,10,5)";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003b ".$link));
	$result = mysqli_query($link, $query);
	
}

function get_in_galaxy_name($spieler_id, $galaxy_number){
	require 'inc/connect_spieler.php';
	$link->set_charset("utf8");
	$query = "SELECT `spieler_ID`, `name_galaxy_1`, `name_galaxy_2`, `name_galaxy_3` FROM `spieler` WHERE `spieler_ID` = '".$spieler_id."'" or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query);


	$row = mysqli_fetch_object($result);
	$tabelle = "name_galaxy_".$galaxy_number;
	
	$ruckgabe = $row->$tabelle;
	if ($ruckgabe == "") {$ruckgabe = "unbekannt";}
	
	return $ruckgabe;  
}

function check_username_cleaner($value, $spieler_id){
	require 'inc/connect_spieler.php';
	
	$badword = "admin administrator error fehler gast";
	
	$newVal = substr($value, 0, 30);
	if (strlen($newVal) < 3) { return ""; }
	 
	
	if (strpos($badword, strtolower($value)) !== false) {
	    return "fehler"; //Badword filter
	}
	
	$regex ='/[^.:a-zA-ZäüöÄÜÖß0-9-\/]/';
	$newVal = preg_replace($regex," ", $newVal);

	$newVal = htmlspecialchars($newVal);
	$newVal = stripslashes($newVal);
	//$newVal = filter_var($newVal, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
	
	
	mysql_select_db("spieler");
	mysql_query("SET NAMES 'utf8'");
	$abfrage = "FROM `spieler` WHERE `spieler_ID` <> '$spieler_id' AND (`spieler_name` = '$newVal' OR `name_galaxy_1` =  '$newVal' OR `name_galaxy_2` =  '$newVal' OR `name_galaxy_3` = '$newVal')";
	
	
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
	$regex ='/[1-9]\:[1-9]/';
	
	if(preg_match($regex, $value)){ 
		
		$regex ='/[^0-9\:]/';
		$newVal = preg_replace($regex,"", $value);		
		
		$koords = explode(":", $newVal);

		if(!isset($koords[0])) { return "nicht gültig"; }  
		if(!isset($koords[1])) { return "nicht gültig"; }
		
		return $newVal;
		
	}else {	return "nicht gültig";	}

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
	
	
	$result = $link->query("SELECT count(*) as total from `spieler` WHERE `spieler_ID` = '$spieler_id'")
	or die ("Error: #0006 " . mysql_error());
					
	$data = mysqli_fetch_assoc($result);
	
	$anzahl = $data['total'];
	echo "#$galaxy_number $anzahl <br>";
	return ($anzahl);
	
}

function session_generate () {
	return md5(random_float(1, 200).session_id());
}

function login($username, $passwort){
	require 'inc/connect_spieler.php';

	$abfrage = "SELECT `ID`, `spieler_ID`, `spieler_name`, `passwort`, `letzter_login`, `spieler_geloescht`, `name_gala_1`, `aktiv_gala_1`, `letzter_Planet`, `max_Planeten` FROM `spieler` WHERE spieler_name LIKE '$username' LIMIT 1";
	$query = $abfrage or die("Error: #0002 " . mysqli_error($link));
	
	//execute the query.
	
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	
	if($row["passwort"]== $passwort)
	{
		$_SESSION["username"] = $username;
		$_SESSION["spieler_ID"] = $row["spieler_ID"];
		$_SESSION["letzter_planet"] = $row["letzter_Planet"];
		$_SESSION["Max_Planeten"] = $row["max_Planeten"];
	
		$_SESSION["session_id"] = session_generate();
		$varHTTP_USER_AGENT = md5($_SERVER['HTTP_USER_AGENT']);
		
		$query = "UPDATE spieler SET session_id = '".$_SESSION["session_id"]."', letzter_login = ".time().", HTTP_USER_AGENT = '".$varHTTP_USER_AGENT."' WHERE spieler_ID = '".$_SESSION["spieler_ID"]."'" or die("Error: #0007 " . mysqli_error($link));
		
		$ergebnis =  mysqli_query($link, $query)
		OR die("Error: #0001 <br>".mysqli_error($link));
		
		return "ok";
	}
}

function check_auth($spieler_id, $session_id) {
	
	if(!$spieler_id || !$session_id) { return "nein"; }
	
	require 'inc/connect_spieler.php'; 
	mysql_select_db("spieler");
	
	$query = "SELECT `ID`, `spieler_ID`, `session_id`, `HTTP_USER_AGENT` FROM `spieler` WHERE `spieler_ID` = '".$spieler_id."' AND `session_id` = '".$session_id."' LIMIT 1" or die("Error: #0009 " . mysqli_error($link));
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	
	if($row["HTTP_USER_AGENT"] == md5($_SERVER['HTTP_USER_AGENT']))
	{
		return "ja";	
		
	} else{
		
		return "nein";
	}
}

?>