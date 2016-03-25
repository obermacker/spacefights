<?php
use phpbb\notification\method\email;
function get_timestamp_in_was_sinnvolles($value) {
	$secs = number_format($value, 0, '', '');
	$dtF = new DateTime("@0");
	$dtT = new DateTime("@$secs");
	return $dtF->diff($dtT)->format('%a Tage %H:%I:%S');	
}

function get_ship($ship_id) {

	$row_ship = get_config_ships($ship_id, 0);
	
	$row_ship["Bauzeit"] = $row_ship["Bauzeit"];
	
	return $row_ship;
	
}

function get_def($def_id) {

	$row_def = get_config_def($def_id, 0);

	$row_def["Bauzeit"] = $row_def["Bauzeit"];//get_timestamp_in_was_sinnvolles($row_def["Bauzeit"]);

	return $row_def;

}

function get_gebäude_aktuelle_stufe($spieler_id, $planet_id, $gebäude_id) {

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

function set_bauschleife_struckture($spieler_id, $planet_id, $gebäude_id, $gebäude_name, $bauzeit, $ressource_eisen, $ressource_silizium, $ressource_wasser, $ressource_energie, $ressource_karma, $kosten_eisen, $kosten_silizium, $kosten_wasser, $kosten_energie, $kosten_karma) {
	require 'inc/connect_galaxy_1.php';
	
	
	$ressource_eisen = $ressource_eisen - $kosten_eisen;
	$ressource_silizium  = $ressource_silizium - $kosten_silizium;
	$ressource_wasser = $ressource_wasser - $kosten_wasser;
	$ressource_energie = $ressource_energie - $kosten_energie;
	$ressource_karma = $ressource_karma  - $kosten_karma;
	$bauzeit = $bauzeit;   
	
	//$abfrage = "UPDATE `planet` SET `Bauschleife_Gebaeude_ID` = $gebäude_id, SET `Bauschleife_Gebaeude_Bis` = " . $time() + $bauzeit . " FROM  WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$abfrage = "UPDATE `planet` SET `Ressource_Eisen`= '$ressource_eisen', `Ressource_Silizium`= '$ressource_silizium', `Ressource_Wasser`= '$ressource_wasser', `Ressource_Energie`= '$ressource_energie', `Ressource_Karma`= '$ressource_karma', `Bauschleife_Gebaeude_ID`= '$gebäude_id', `Bauschleife_Gebaeude_Bis`= '" . $bauzeit . "', `Bauschleife_Gebaeude_Name`= '$gebäude_name' WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
	
	if (mysqli_query($link, $query)) {
	    //echo "Gebäude eingereiht <br>$abfrage<br>";
	} else {
	    die("Fehler in der Bauschleife: " . mysqli_error($link));
	}
		
		
	
}

function set_bauschleife_tech($spieler_id, $planet_id, $tech_id, $tech_name, $bauzeit, $ressource_eisen, $ressource_silizium, $ressource_wasser, $ressource_karma, $kosten_eisen, $kosten_silizium, $kosten_wasser, $kosten_karma) {
	require 'inc/connect_galaxy_1.php';
	
	$ressource_eisen = $ressource_eisen - $kosten_eisen;
	$ressource_silizium  = $ressource_silizium - $kosten_silizium;
	$ressource_wasser = $ressource_wasser - $kosten_wasser;	
	$ressource_karma = $ressource_karma  - $kosten_karma;
	$bauzeit = $bauzeit;
	
	//$abfrage = "UPDATE `planet` SET `Bauschleife_Gebaeude_ID` = $gebäude_id, SET `Bauschleife_Gebaeude_Bis` = " . $time() + $bauzeit . " FROM  WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$abfrage = "UPDATE `planet` SET `Ressource_Eisen`= '$ressource_eisen', `Ressource_Silizium`= '$ressource_silizium', `Ressource_Wasser`= '$ressource_wasser', `Ressource_Karma`= '$ressource_karma' WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
	
	if (mysqli_query($link, $query)) {
		
		
		$abfrage = "UPDATE `spieler` SET `Tech_Schleife_ID` = $tech_id, `Tech_Schleife_Name` = '$tech_name', `Tech_Schleife_Bauzeit` = $bauzeit WHERE `Spieler_ID` = '$spieler_id'";
		
		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_tech #1 ".$link));
		
		if (mysqli_query($link, $query)) {
		
			echo "Tech eingereiht";
		
			} else {
				die("Fehler in der Bauschleife: " . mysqli_error($link));
			}
				

	} else {
		die("Fehler in der Bauschleife: " . mysqli_error($link));
	}
	
	

}

function get_letzte_bauschleife_ship($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT `Bauzeit_Bis` FROM `bauschleifeflotte` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = '$planet_id' ORDER BY Bauzeit_Bis DESC";	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_letzte_bauschleife_ship #1 ".$link));
	$result = mysqli_query($link, $query);
	
	$row = mysqli_fetch_object($result);
	
	

	if(isset($row->Bauzeit_Bis)) { 
		if ($row->Bauzeit_Bis < time()) { //Fallback für den Fall das eine Bauschleife nicht beeendet werden kann
			return time();
		} else {
			return $row->Bauzeit_Bis;
		}
		 
	} else { return time(); }
	
	
}

function get_letzte_bauschleife_deff($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT `Bauzeit_Bis` FROM `bauschleifedeff` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = '$planet_id' ORDER BY Bauzeit_Bis DESC";
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_letzte_bauschleife_ship #1 ".$link));
	$result = mysqli_query($link, $query);

	$row = mysqli_fetch_object($result);



	if(isset($row->Bauzeit_Bis)) {
		if ($row->Bauzeit_Bis < time()) { //Fallback für den Fall das eine Bauschleife nicht beeendet werden kann
			return time();
		} else {
			return $row->Bauzeit_Bis;
		}
			
	} else { return time(); }


}

function set_bauschleife_ship($spieler_id, $planet_id, $ship_id, $ship_name, $anzahl, $bauzeit, $ressource_eisen, $ressource_silizium, $ressource_wasser, $ressource_bot, $ressource_karma, $kosten_eisen, $kosten_silizium, $kosten_wasser, $kosten_bot, $kosten_karma) {
	
	require 'inc/connect_galaxy_1.php';
	
	$von = get_letzte_bauschleife_ship($spieler_id, $planet_id);
	$bis = $von + ($anzahl * $bauzeit);

	$abfrage = "INSERT INTO `bauschleifeflotte` (
			`ID`, 
			`Spieler_ID`, 
			`Planet_ID`, 
			`Typ`, 
			`Eisen`, 
			`Silizium`, 
			`Wasser`,
			`Karma`, 
			`Name`, 
			`Anzahl`, 
			`Bauzeit_Von`, 
			`Bauzeit_Einzel`, 
			`Bauzeit_Bis`) 
			VALUES (NULL, 
			'$spieler_id', 
			'$planet_id', 
			'$ship_id', 
			'$kosten_eisen', 
			'$kosten_silizium', 
			'$kosten_wasser', 
			'$kosten_karma',
			'$ship_name', 
			'$anzahl', 
			'$von', 
			'$bauzeit', 
			'$bis')";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_ship #1 ".$link));
	
	if (mysqli_query($link, $query)) {
		// Ress aufn Planni aktualisiseren
		
		
		$ressource_eisen = $ressource_eisen - ($kosten_eisen * $anzahl);
		$ressource_silizium  = $ressource_silizium - ($kosten_silizium * $anzahl);
		$ressource_wasser = $ressource_wasser - ($kosten_wasser * $anzahl);
		$ressource_karma = $ressource_karma  - ($kosten_karma * $anzahl);
		$ressource_bot = $ressource_bot - ($kosten_bot * $anzahl);
		$bauzeit = $bauzeit;
		
		//$abfrage = "UPDATE `planet` SET `Bauschleife_Gebaeude_ID` = $gebäude_id, SET `Bauschleife_Gebaeude_Bis` = " . $time() + $bauzeit . " FROM  WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
		
		$abfrage = "UPDATE `planet` SET `Ressource_Eisen`= '$ressource_eisen', `Ressource_Silizium`= '$ressource_silizium', `Ressource_Wasser`= '$ressource_wasser', `Ressource_Karma`= '$ressource_karma', `Ressource_Bot` = $ressource_bot WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
		
		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
		
		if (mysqli_query($link, $query)) {
			//echo "Gebäude eingereiht <br>$abfrage<br>";
		} else {
			die("Fehler in der Bauschleife: " . mysqli_error($link));
		}
		
		
	} else {
		die("Fehler in der set_bauschleife_ship: " . mysqli_error($link));
	}
	
}

function set_bauschleife_deff($spieler_id, $planet_id, $ship_id, $ship_name, $anzahl, $bauzeit, $ressource_eisen, $ressource_silizium, $ressource_wasser, $ressource_bot, $ressource_karma, $kosten_eisen, $kosten_silizium, $kosten_wasser, $kosten_bot, $kosten_karma) {

	require 'inc/connect_galaxy_1.php';

	$von = get_letzte_bauschleife_deff($spieler_id, $planet_id);
	$bis = $von + ($anzahl * $bauzeit);

	$abfrage = "INSERT INTO `galaxy1`.`bauschleifedeff` (
	`ID`,
	`Spieler_ID`,
	`Planet_ID`,
	`Typ`,
	`Eisen`,
	`Silizium`,
	`Wasser`,
	`Karma`,
	`Name`,
	`Anzahl`,
	`Bauzeit_Von`,
	`Bauzeit_Einzel`,
	`Bauzeit_Bis`)
	VALUES (NULL,
	'$spieler_id',
	'$planet_id',
	'$ship_id',
	'$kosten_eisen',
	'$kosten_silizium',
	'$kosten_wasser',
	'$kosten_karma',
	'$ship_name',
	'$anzahl',
	'$von',
	'$bauzeit',
	'$bis')";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_ship #1 ".$link));

	if (mysqli_query($link, $query)) {
		// Ress aufn Planni aktualisiseren


		$ressource_eisen = $ressource_eisen - ($kosten_eisen * $anzahl);
		$ressource_silizium  = $ressource_silizium - ($kosten_silizium * $anzahl);
		$ressource_wasser = $ressource_wasser - ($kosten_wasser * $anzahl);
		$ressource_karma = $ressource_karma  - ($kosten_karma * $anzahl);
		$ressource_bot = $ressource_bot - ($kosten_bot * $anzahl);
		$bauzeit = $bauzeit;

		//$abfrage = "UPDATE `planet` SET `Bauschleife_Gebaeude_ID` = $gebäude_id, SET `Bauschleife_Gebaeude_Bis` = " . $time() + $bauzeit . " FROM  WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

		$abfrage = "UPDATE `planet` SET `Ressource_Eisen`= '$ressource_eisen', `Ressource_Silizium`= '$ressource_silizium', `Ressource_Wasser`= '$ressource_wasser', `Ressource_Karma`= '$ressource_karma', `Ressource_Bot` = $ressource_bot WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

		if (mysqli_query($link, $query)) {
			//echo "Gebäude eingereiht <br>$abfrage<br>";
		} else {
			die("Fehler in der Bauschleife: " . mysqli_error($link));
		}


	} else {
		die("Fehler in der set_bauschleife_ship: " . mysqli_error($link));
	}

}

function set_bauschleife_ship_fertig($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';
	
	// erstmal alle auschecken die komplett sind

	$abfrage = "SELECT `ID`, `Typ`, `Spieler_ID`, `Planet_ID`, `Name`, `Anzahl`, `Bauzeit_Von`, `Bauzeit_Einzel`, `Bauzeit_Bis` FROM `bauschleifeflotte`  WHERE `Bauzeit_Bis` <= " . time() . " AND `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_ship_fertig ".$link));
	$result = mysqli_query($link, $query);
		
	while($row = mysqli_fetch_object($result)) {
		
		//schauen wie viele vom Typ sind stationiert

		$tabelle = "Schiff_Typ_" . $row->Typ;
		$abfrage_planet = "SELECT `$tabelle` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
			$query = $abfrage_planet  or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_ship_fertig ".$link));
			$result = mysqli_query($link, $query);
			$row_planet = mysqli_fetch_object($result);
			$schiffe_ist = $row_planet->$tabelle;
		
		//anzahl aktualisieren
		
			$anzahl = $row->Anzahl;
			$schiffe_soll = $schiffe_ist + $anzahl;
			
			//Punkte berechnen
			
			$Ship = get_ship($row->Typ);
			
			$punkte = get_punkte($spieler_id, $planet_id);
			$punkte = $punkte + ((($Ship["Kosten_Eisen"] + $Ship["Kosten_Silizium"] + $Ship["Kosten_Wasser"]) * $anzahl) / 1000);				
			
			$abfrage_planet_update = "UPDATE `planet` SET  `$tabelle` = $schiffe_soll 
			, `punkte` = " . $punkte . " WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
			$query = $abfrage_planet_update or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
			
			if (mysqli_query($link, $query)) {

				if ($anzahl > 1) { $insert_name = $Ship["Name_Plural"]; } else { $insert_name = $Ship["Name"]; } 
												
				$news_typ = "ERFOLG_SYSTEM"; 
				$news_text = "Es wurden $anzahl $insert_name fertiggestellt";
				set_news($spieler_id, $planet_id, $news_typ, $news_text);
			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}
					
		//Bauschliefe löschen
		
			$abfrage_bauschleife_delete = "DELETE FROM `bauschleifeflotte` WHERE `ID` = " . $row->ID; 
			$query = $abfrage_bauschleife_delete or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
				
			if (mysqli_query($link, $query)) {
				
			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}
				
		
	}
	
	
	
	// jetzt nur die teilweise gebauten, z.B. die 10 von 100
	
	$abfrage = "SELECT `ID`, `Typ`, `Spieler_ID`, `Planet_ID`, `Name`, `Anzahl`, `Bauzeit_Von`, `Bauzeit_Einzel`, `Bauzeit_Bis` FROM `bauschleifeflotte`  WHERE `Bauzeit_Von` < " . time() . " AND `Bauzeit_Bis` >= " . time() . " AND `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_ship_fertig ".$link));
	$result = mysqli_query($link, $query);
	
	while($row = mysqli_fetch_object($result)) {

		//schauen wie viele vom Typ sind stationiert
	
		$tabelle = "Schiff_Typ_" . $row->Typ;
		$Ship = get_ship($row->Typ);
		$abfrage_planet = "SELECT `$tabelle` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
		$query = $abfrage_planet  or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_ship_fertig ".$link));
		$result = mysqli_query($link, $query);
		$row_planet = mysqli_fetch_object($result);
		$schiffe_ist = $row_planet->$tabelle;
	
		//anzahl aktualisieren
	
		$fertiggestellte = (int)((time() - $row->Bauzeit_Von) / $row->Bauzeit_Einzel);
		
		$restliche = $row->Anzahl - $fertiggestellte;
		if($fertiggestellte > 0) {
			
			$weiter_ab_zeitpunkt = $row->Bauzeit_Von + ($fertiggestellte *  $row->Bauzeit_Einzel);
		
			$schiffe_soll = $schiffe_ist + $fertiggestellte;
			
			$punkte = get_punkte($spieler_id, $planet_id);
			$punkte = $punkte + ((($Ship["Kosten_Eisen"] + $Ship["Kosten_Silizium"] + $Ship["Kosten_Wasser"]) * $fertiggestellte) / 1000);
				
		
			$abfrage_planet_update = "UPDATE `planet` SET  `$tabelle` = $schiffe_soll
			, `punkte` = " . $punkte . " WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
			$query = $abfrage_planet_update or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
				
			if (mysqli_query($link, $query)) {
				echo "teile fertig";
			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}
				
			//Bauschliefe anpassen
		
			$abfrage_bauschleife_delete = "UPDATE `bauschleifeflotte` SET `Anzahl` = $restliche, `Bauzeit_Von` = $weiter_ab_zeitpunkt  WHERE `ID` = " . $row->ID;
			$query = $abfrage_bauschleife_delete or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
		
			if (mysqli_query($link, $query)) {
				echo "Schleife angepasst";
			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}
		
		}
		
		//--- wenn alle durch sind kann die Bauschleife dann auch gelöscht werden
		
		if($restliche == 0) {
			
			$abfrage_bauschleife_delete = "DELETE FROM `bauschleifeflotte` WHERE `ID` = " . $row->ID;
			$query = $abfrage_bauschleife_delete or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
			
			if (mysqli_query($link, $query)) {
				echo "Schleife gelöscht";
			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}
		
		
		}
		
	}
	
	
}

function set_bauschleife_deff_fertig($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	// erstmal alle auschecken die komplett sind

	$abfrage = "SELECT `ID`, `Typ`, `Spieler_ID`, `Planet_ID`, `Name`, `Anzahl`, `Bauzeit_Von`, `Bauzeit_Einzel`, `Bauzeit_Bis` FROM `bauschleifedeff`  WHERE `Bauzeit_Bis` <= " . time() . " AND `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_Deff_fertig ".$link));
	$result = mysqli_query($link, $query);

	while($row = mysqli_fetch_object($result)) {

		//schauen wie viele vom Typ sind stationiert

		$tabelle = "Deff_Typ_" . $row->Typ;
		$abfrage_planet = "SELECT `$tabelle` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
		$query = $abfrage_planet  or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_Deff_fertig ".$link));
		$result = mysqli_query($link, $query);
		$row_planet = mysqli_fetch_object($result);
		$deff_ist = $row_planet->$tabelle;

		//anzahl aktualisieren

		$anzahl = $row->Anzahl;
		$deff_soll = $deff_ist + $anzahl;
		
		$Deff = get_def($row->Typ);
		
		$punkte = get_punkte($spieler_id, $planet_id);
		$punkte = $punkte + ((($Deff["Kosten_Eisen"] + $Deff["Kosten_Silizium"] + $Deff["Kosten_Wasser"]) * $anzahl) / 1000);
		
		
		$abfrage_planet_update = "UPDATE `planet` SET  `$tabelle` = $deff_soll
		, `punkte` = " . $punkte . " WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
		$query = $abfrage_planet_update or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
			
		if (mysqli_query($link, $query)) {			

			if ($anzahl > 1) { $insert_name = $Deff["Name_Plural"]; } else { $insert_name = $Deff["Name"]; }

			$news_typ = "ERFOLG_SYSTEM";
			$news_text = "Es wurden $anzahl $insert_name fertiggestellt";
			set_news($spieler_id, $planet_id, $news_typ, $news_text);
		} else {
			die("Fehler in der fertigstellung: " . mysqli_error($link));
		}

		//Bauschliefe löschen

		$abfrage_bauschleife_delete = "DELETE FROM `bauschleifedeff` WHERE `ID` = " . $row->ID;
		$query = $abfrage_bauschleife_delete or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

		if (mysqli_query($link, $query)) {

		} else {
			die("Fehler in der fertigstellung: " . mysqli_error($link));
		}


	}



	// jetzt nur die teilweise gebauten, z.B. die 10 von 100
	
	$abfrage = "SELECT `ID`, `Typ`, `Spieler_ID`, `Planet_ID`, `Name`, `Anzahl`, `Bauzeit_Von`, `Bauzeit_Einzel`, `Bauzeit_Bis` FROM `bauschleifedeff`  WHERE `Bauzeit_Von` < " . time() . " AND `Bauzeit_Bis` >= " . time() . " AND `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_Deff_fertig ".$link));
	$result = mysqli_query($link, $query);

	while($row = mysqli_fetch_object($result)) {

		//schauen wie viele vom Typ sind stationiert

		$tabelle = "Deff_Typ_" . $row->Typ;
		$Deff = get_def($row->Typ);
		$abfrage_planet = "SELECT `$tabelle` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
		$query = $abfrage_planet  or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_Deff_fertig ".$link));
		$result = mysqli_query($link, $query);
		$row_planet = mysqli_fetch_object($result);
		$deff_ist = $row_planet->$tabelle;

		//anzahl aktualisieren

		$fertiggestellte = (int)((time() - $row->Bauzeit_Von) / $row->Bauzeit_Einzel);

		$restliche = $row->Anzahl - $fertiggestellte;
		if($fertiggestellte > 0) {
				
			$weiter_ab_zeitpunkt = $row->Bauzeit_Von + ($fertiggestellte *  $row->Bauzeit_Einzel);

			$deff_soll = $deff_ist + $fertiggestellte;
			
			$punkte = get_punkte($spieler_id, $planet_id);
			$punkte = $punkte + ((($Deff["Kosten_Eisen"] + $Deff["Kosten_Silizium"] + $Deff["Kosten_Wasser"]) * $fertiggestellte) / 1000);
			

			$abfrage_planet_update = "UPDATE `planet` SET  `$tabelle` = $deff_soll
			, `punkte` = " . $punkte . " WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
			$query = $abfrage_planet_update or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

			if (mysqli_query($link, $query)) {
				echo "teile fertig";
			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}

			//Bauschliefe anpassen

			$abfrage_bauschleife_delete = "UPDATE `bauschleifedeff` SET `Anzahl` = $restliche, `Bauzeit_Von` = $weiter_ab_zeitpunkt  WHERE `ID` = " . $row->ID;
			$query = $abfrage_bauschleife_delete or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

			if (mysqli_query($link, $query)) {
				echo "Schleife angepasst";
			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}

		}

		//--- wenn alle durch sind kann die Bauschleife dann auch gelöscht werden

		if($restliche == 0) {
				
			$abfrage_bauschleife_delete = "DELETE FROM `bauschleifedeff` WHERE `ID` = " . $row->ID;
			$query = $abfrage_bauschleife_delete or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

			if (mysqli_query($link, $query)) {
				echo "Schleife gelöscht";
			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}


		}

	}


}

function get_punkte($spieler_id, $planet_id) {
	
	require 'inc/connect_galaxy_1.php';
	
	$abfrage = "SELECT `punkte` FROM `planet`  WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error in  ".$link));
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_object($result);
	
	$punkte = $row->punkte;
	
	return $punkte ;
	
}

function set_bauschleife_struckture_fertig($spieler_id, $planet_id, $gebäude_id) {
	
	require 'inc/connect_galaxy_1.php';
	
	$produktion = get_produktion($spieler_id, 0);
	
	$punkte = get_punkte($spieler_id, 0);

	$Gebäude = get_gebäude_nächste_stufe($spieler_id, 0, $gebäude_id, 1);
	
	$tabelle = "Stufe_Gebaeude_" . $gebäude_id;
	
	if($gebäude_id == 1 AND $Gebäude["Gewinn_Ress"] > 0) { $produktion["Eisen"] = $produktion["Eisen"] + $Gebäude["Gewinn_Ress"]; }	
	if($gebäude_id == 2 AND $Gebäude["Gewinn_Ress"] > 0) { $produktion["Silizium"] = $produktion["Silizium"] + $Gebäude["Gewinn_Ress"]; }
	if($gebäude_id == 2 AND $Gebäude["Gewinn_Ress"] > 0) { $produktion["Wasser"] = $produktion["Wasser"] + $Gebäude["Gewinn_Ress"]; }

	if($Gebäude["Gewinn_Energie"] > 0) { $produktion["Energie"] = $produktion["Energie"] + $Gebäude["Gewinn_Energie"]; }
	
	if ($gebäude_id == 6) { $produktion["Bunker_Kapa"] = $produktion["Bunker_Kapa"] + $Gebäude["Kapazitaet"]; }
	if ($gebäude_id == 10) { $produktion["Handel_Kapa"] = $produktion["Handel_Kapa"] + $Gebäude["Kapazitaet"]; }
	
	
	$punkte = $punkte + (($Gebäude["Kosten_Eisen"] + $Gebäude["Kosten_Silizium"] + $Gebäude["Kosten_Wasser"]) / 1000);
	
	$abfrage = "UPDATE `planet` SET
	`$tabelle` = " . $Gebäude["Stufe"] . ",
	`Prod_Eisen` = " . $produktion["Eisen"] . ", 
	`Prod_Silizium` = " .  $produktion["Silizium"] . ",
	`Prod_Wasser` = " . $produktion["Wasser"] . ",
	`Ressource_Energie` = " . $produktion["Energie"] . ",
	`Bunker_Kapa` = " .  $produktion["Bunker_Kapa"] . ",
	`Handel_Kapa` = " . $produktion["Handel_Kapa"] . ",
	`punkte` = " . $punkte . ",	
	`Bauschleife_Gebaeude_ID` = 0, 
	`Bauschleife_Gebaeude_Bis` = 0, 
	`Bauschleife_Gebaeude_Name` = ''
	WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
	
	if (mysqli_query($link, $query)) {
		//echo "Gebäude fertig";
	} else {
		die("Fehler in der fertigstellung: " . mysqli_error($link));
	}
	
	

	
}

function set_bauschleife_tech_fertig($spieler_id, $planet_id, $tech_id) {
	require 'inc/connect_galaxy_1.php';
	
	$produktion = get_produktion($spieler_id, 0);
	
	$punkte = get_punkte($spieler_id, 0);
	
	$Tech = get_tech_nächste_stufe($spieler_id, 0, $tech_id, 1);
	
	$tabelle = "Tech_" . $tech_id;
	
	$punkte = $punkte + (($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"] + $Tech["Kosten_Wasser"]) / 1000);
	
	
	$abfrage = "UPDATE `spieler` SET `" . $tabelle . 
	"` = " . $Tech["Stufe"] . ",
	`Tech_Schleife_ID` = 0, 
	`Tech_Schleife_Name` = '', 
	`Tech_Schleife_Bauzeit` = 0
	 WHERE `Spieler_ID` = '$spieler_id'";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
	
	if (mysqli_query($link, $query)) {
		//echo "Gebäude fertig";
	} else {
		die("$abfrage Fehler in der fertigstellung: " . mysqli_error($link));
	}
	
	
}

function set_bauschleife_structure_abbruch($spieler_id, $planet_id, $gebäude_id) {
	
	require 'inc/connect_galaxy_1.php';
	
	$Gebäude = get_gebäude_nächste_stufe($spieler_id, 0, $gebäude_id, 1);
	$ressource = get_ressource($spieler_id, 0);
	
	//Eisen, Sili, Wasser zurück & Bauschleife löschen

	$ressource["Eisen"] = $ressource["Eisen"] + $Gebäude["Kosten_Eisen"]; 
	$ressource["Silizium"] = $ressource["Silizium"] + $Gebäude["Kosten_Silizium"];
	$ressource["Wasser"] = $ressource["Wasser"] + $Gebäude["Kosten_Wasser"];
	$ressource["Energie"] = $ressource["Energie"] +	$Gebäude["Kosten_Energie"];
	
	$ressource["Karma"] = $ressource["Karma"] + $Gebäude["Kosten_Karma"];
	
	
	$abfrage  = "UPDATE `planet` SET 
	`Ressource_Eisen` = " . $ressource["Eisen"] . ", 
	`Ressource_Silizium` = ". $ressource["Silizium"] .", 
	`Ressource_Wasser` = " . $ressource["Wasser"] . ", 
	`Ressource_Energie` = ". $ressource["Energie"] .",
	`Ressource_Karma` = ". $ressource["Karma"] .",
	`Bauschleife_Gebaeude_ID` = 0, 
	`Bauschleife_Gebaeude_Bis` = 0, 
	`Bauschleife_Gebaeude_Name` = '' 
	WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
	
	if (mysqli_query($link, $query)) {
		//echo "Gebäude abgebrochen <br> $abfrage <br>";
	} else {
		die("Fehler in der fertigstellung: " . mysqli_error($link));
	}
	
	
}

function set_bauschleife_tech_abbruch($spieler_id, $planet_id, $tech_id) {

	require 'inc/connect_galaxy_1.php';

	$Tech = get_tech_nächste_stufe($spieler_id, 0, $tech_id, 1);
	$ressource = get_ressource($spieler_id, 0);

	//Eisen, Sili, Wasser zurück & Bauschleife löschen

	$ressource["Eisen"] = $ressource["Eisen"] + $Tech["Kosten_Eisen"];
	$ressource["Silizium"] = $ressource["Silizium"] + $Tech["Kosten_Silizium"];
	$ressource["Wasser"] = $ressource["Wasser"] + $Tech["Kosten_Wasser"];

	$abfrage  = "UPDATE `planet` SET
	`Ressource_Eisen` = " . $ressource["Eisen"] . ",
	`Ressource_Silizium` = ". $ressource["Silizium"] .",
	`Ressource_Wasser` = " . $ressource["Wasser"] . "
	WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

	if (mysqli_query($link, $query)) {
		
		$abfrage  = "UPDATE `spieler` SET
		`Tech_Schleife_ID` = 0, 
		`Tech_Schleife_Name` = '', 
		`Tech_Schleife_Bauzeit` = 0
		WHERE `Spieler_ID` = '$spieler_id'";
			
			$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
			if (mysqli_query($link, $query)) { 
				echo "Forschung abgebrochen"; 
			} else { 
				die("Fehler im Abbruch: " . mysqli_error($link)); 
			}

	} else {
		die("Fehler in der fertigstellung: " . mysqli_error($link));
	}


}

function set_bauschleife_ship_abbruch($spieler_id, $planet_id, $schleife_id) {
	
	require 'inc/connect_galaxy_1.php';
	
	$abfrage  = "SELECT `ID`, `Typ`, `Anzahl`, `Bauzeit_Von` FROM `bauschleifeflotte` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id AND ID = $schleife_id";
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_ship_abbruch #1 ".$link));
	
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_object($result);
		
		if (!empty($row)) {
		
		$Ship = get_ship($row->Typ);
		$anzahl = $row->Anzahl;
		
		$eisen_ruck = ($Ship["Kosten_Eisen"] * $anzahl) / 3 * 2;
		$silizium_ruck = ($Ship["Kosten_Silizium"] * $anzahl) / 3 * 2;
		$wasser_ruck = ($Ship["Kosten_Wasser"] * $anzahl) / 3 * 2;
		$karma_ruck = ($Ship["Kosten_Karma"] * $anzahl) / 3 * 2;
		$bots_ruck = $Ship["Bots"] * $anzahl;
		
		// update ress & bots auf dem Planeten
		
		$ressource = get_ressource($spieler_id, 0);
		
		//Eisen, Sili, Wasser zurück & Bauschleife löschen
		
		$ressource["Eisen"] = $ressource["Eisen"] + $eisen_ruck;
		$ressource["Silizium"] = $ressource["Silizium"] + $silizium_ruck;
		$ressource["Wasser"] = $ressource["Wasser"] + $wasser_ruck;
		$ressource["Bot"] = $ressource["Bot"] + $bots_ruck;
		$ressource["Karma"] = $ressource["Karma"] + $karma_ruck;
		
		
		$abfrage  = "UPDATE `planet` SET
		`Ressource_Eisen` = " . $ressource["Eisen"] . ",
		`Ressource_Silizium` = ". $ressource["Silizium"] .",
		`Ressource_Wasser` = " . $ressource["Wasser"] . ",
		`Ressource_Bot` = " . $ressource["Bot"] . ",
		`Ressource_Karma` = " . $ressource["Karma"] . "
		WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
		
		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
		if (mysqli_query($link, $query)) {
			
			// lösche Bauschleife
			
			$abfrage = "DELETE FROM `bauschleifeflotte` WHERE ID = " . $row->ID;
			
			$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
			if (mysqli_query($link, $query)) {
				
				// berechne übrige Zeiten neu für nach now starten 
				
				$abfrage  = "SELECT `ID`, `Bauzeit_Von`, `Bauzeit_Bis` FROM `bauschleifeflotte` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id AND Bauzeit_Von > " . time();
				$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
				
				$result = mysqli_query($link, $query);
				
				if (!empty($result)) {
					
					
					$neue_zeit_start = $row->Bauzeit_Von;
					if ($neue_zeit_start < time()) { $neue_zeit_start = time(); }
					
					$starte_ab = $neue_zeit_start;
					
					while($row_bauschleife = mysqli_fetch_object($result)) {
						
						
						$dauer = $row_bauschleife->Bauzeit_Bis - $row_bauschleife->Bauzeit_Von;
						
						$update_von_auf = $starte_ab;
						$update_bis_auf = $update_von_auf + $dauer;
						
												
						$ID = $row_bauschleife->ID;
						
						$sql = "UPDATE `bauschleifeflotte` SET `Bauzeit_Von` = $update_von_auf, `Bauzeit_Bis` = $update_bis_auf WHERE ID = '$ID'";
						
						$starte_ab = $update_bis_auf;

						$query2 = $sql or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
						if (mysqli_query($link, $query2)) {
							
							echo "hat er";
						} else {
							die("die zeiten wurde nicht überschrieben");
						}
						
						
					}
					
					
				} else {
					
					die("Bauschleife kann nicht neu berechnet werden");
				}
				
				
				
			} else {
				die("kann die schleife nciht löschen");
			}
			
			
			
			
			
		} else {
			die("Fehler im Abbruch: " . mysqli_error($link));
		}
		
		

		
		
		
		
	}


		
	
	
	
}

function set_bauschleife_deff_abbruch($spieler_id, $planet_id, $schleife_id) {

	require 'inc/connect_galaxy_1.php';

	$abfrage  = "SELECT `ID`, `Typ`, `Anzahl`, `Bauzeit_Von` FROM `bauschleifedeff` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id AND ID = $schleife_id";
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_ship_abbruch #1 ".$link));

	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_object($result);

	if (!empty($row)) {

		$Deff = get_ship($row->Typ);
		$anzahl = $row->Anzahl;

		$eisen_ruck = ($Deff["Kosten_Eisen"] * $anzahl) / 3 * 2;
		$silizium_ruck = ($Deff["Kosten_Silizium"] * $anzahl) / 3 * 2;
		$wasser_ruck = ($Deff["Kosten_Wasser"] * $anzahl) / 3 * 2;
		$karma_ruck = ($Deff["Kosten_Karma"] * $anzahl) / 3 * 2;
		$bots_ruck = $Deff["Bots"] * $anzahl;

		// update ress & bots auf dem Planeten

		$ressource = get_ressource($spieler_id, 0);

		//Eisen, Sili, Wasser zurück & Bauschleife löschen

		$ressource["Eisen"] = $ressource["Eisen"] + $eisen_ruck;
		$ressource["Silizium"] = $ressource["Silizium"] + $silizium_ruck;
		$ressource["Wasser"] = $ressource["Wasser"] + $wasser_ruck;
		$ressource["Bot"] = $ressource["Bot"] + $bots_ruck;
		$ressource["Karma"] = $ressource["Karma"] + $karma_ruck;


		$abfrage  = "UPDATE `planet` SET
		`Ressource_Eisen` = " . $ressource["Eisen"] . ",
		`Ressource_Silizium` = ". $ressource["Silizium"] .",
		`Ressource_Wasser` = " . $ressource["Wasser"] . ",
		`Ressource_Bot` = " . $ressource["Bot"] . ",
		`Ressource_Karma` = " . $ressource["Karma"] . "
		WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
		if (mysqli_query($link, $query)) {
				
			// lösche Bauschleife
				
			$abfrage = "DELETE FROM `bauschleifedeff` WHERE ID = " . $row->ID;
				
			$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
			if (mysqli_query($link, $query)) {

				// berechne übrige Zeiten neu für nach now starten

				$abfrage  = "SELECT `ID`, `Bauzeit_Von`, `Bauzeit_Bis` FROM `bauschleifedeff` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id AND Bauzeit_Von > " . time();
				$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

				$result = mysqli_query($link, $query);

				if (!empty($result)) {
						
						
					$neue_zeit_start = $row->Bauzeit_Von;
					if ($neue_zeit_start < time()) { $neue_zeit_start = time(); }
						
					$starte_ab = $neue_zeit_start;
						
					while($row_bauschleife = mysqli_fetch_object($result)) {


						$dauer = $row_bauschleife->Bauzeit_Bis - $row_bauschleife->Bauzeit_Von;

						$update_von_auf = $starte_ab;
						$update_bis_auf = $update_von_auf + $dauer;


						$ID = $row_bauschleife->ID;

						$sql = "UPDATE `bauschleifedeff` SET `Bauzeit_Von` = $update_von_auf, `Bauzeit_Bis` = $update_bis_auf WHERE ID = '$ID'";

						$starte_ab = $update_bis_auf;

						$query2 = $sql or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
						if (mysqli_query($link, $query2)) {
								
							echo "hat er";
						} else {
							die("die zeiten wurde nicht überschrieben");
						}


					}
						
						
				} else {
						
					die("Bauschleife kann nicht neu berechnet werden");
				}



			} else {
				die("kann die schleife nciht löschen");
			}
				
				
				
				
				
		} else {
			die("Fehler im Abbruch: " . mysqli_error($link));
		}







	}






}

function check_bauschleife_activ($spieler_id, $planet_id, $zweig) {
	
	require 'inc/connect_galaxy_1.php';

	switch ($zweig) {
		case "Structure":
				$abfrage = "SELECT `Bauschleife_Gebaeude_ID`, `Bauschleife_Gebaeude_Bis` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
				
				$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: check_bauschleife_activ #1 ".$link));
				$result = mysqli_query($link, $query);
				
				$row = mysqli_fetch_object($result);
				
				$bauschleife["ID"] = $row->Bauschleife_Gebaeude_ID;
				$bauschleife["Bis"] = $row->Bauschleife_Gebaeude_Bis; //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());
				$bauschleife["Countdown"] = $row->Bauschleife_Gebaeude_Bis - time();
				return $bauschleife;
					
			break;
		case "Tech":
				$abfrage = "SELECT `Tech_Schleife_ID`, `Tech_Schleife_Bauzeit`  FROM `spieler` WHERE `Spieler_ID` = '$spieler_id'";
				
				$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: check_bauschleife_activ #1 ".$link));
				$result = mysqli_query($link, $query);
				
				$row = mysqli_fetch_object($result);
				
				$bauschleife["ID"] = $row->Tech_Schleife_ID;
				$bauschleife["Bis"] = $row->Tech_Schleife_Bauzeit; //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());
				$bauschleife["Countdown"] = $row->Tech_Schleife_Bauzeit - time(); //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());
				return $bauschleife;
					
			break;
		case "Ship":
				$abfrage = "SELECT `ID`, `Bauzeit_Von`, `Bauzeit_Bis` FROM `bauschleifeflotte` WHERE `Bauzeit_Von` < " . time() . " AND `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
				
				$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: check_bauschleife_activ #1 ".$link));
				$result = mysqli_query($link, $query);
				
				$row = mysqli_fetch_object($result);
				if(!empty($row)) {
					
				
				$bauschleife["ID"] = $row->ID;
				$bauschleife["Bis"] = $row->Bauzeit_Bis; //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());
				$bauschleife["Countdown"] = $row->Bauzeit_Bis - time(); //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());
				return $bauschleife;
				
				}	
			break;
		case "Deff":
				$abfrage = "SELECT `ID`, `Bauzeit_Von`, `Bauzeit_Bis` FROM `bauschleifedeff` WHERE `Bauzeit_Von` < " . time() . " AND `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
				
				$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: check_bauschleife_activ #1 ".$link));
				$result = mysqli_query($link, $query);
				
				$row = mysqli_fetch_object($result);
				if(!empty($row)) {
					
				
				$bauschleife["ID"] = $row->ID;
				$bauschleife["Bis"] = $row->Bauzeit_Bis; //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());
				$bauschleife["Countdown"] = $row->Bauzeit_Bis - time(); //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());
				return $bauschleife;
				
				}	
			break;
	}
	
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
		$Gebäude["Kosten_Karma"] = $row_kosten_nächstes_Gebäude["Kosten_Karma"];
		
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
			$Gebäude["Kosten_Karma"] = $Gebäude["Kosten_Karma"] * $mod_energie * $speed_mod;
		
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
		
		$forschungszentrum = get_gebäude_aktuelle_stufe($spieler_id, 0, 9);

	//Kosten für die Forschung

		$row_kosten_nächste_Forschung = get_config_tech($tech_id, $row_aktuelle_Stufe_Tech);
		
		$Tech["Name"] = $row_kosten_nächste_Forschung["Name"];
		$Tech["Beschreibung"] = $row_kosten_nächste_Forschung["Beschreibung"];
		$Tech["Wirkung"] = $row_kosten_nächste_Forschung["Wirkung"];
		$Tech["Kosten_Eisen"] = $row_kosten_nächste_Forschung["Kosten_Eisen"];
		$Tech["Kosten_Silizium"] = $row_kosten_nächste_Forschung["Kosten_Silizium"];
		$Tech["Kosten_Wasser"] = $row_kosten_nächste_Forschung["Kosten_Wasser"];
		$Tech["Kosten_Energie"] = $row_kosten_nächste_Forschung["Kosten_Energie"];
		$Tech["Level_Cap"] = $row_kosten_nächste_Forschung["Level_Cap"];
		$Tech["Bauzeit"] = $row_kosten_nächste_Forschung["Bauzeit"];
		$Tech["Erw_Bedingung"] = $row_kosten_nächste_Forschung["Erw_Bedingung"];
		$Tech["Kosten_Karma"] = $row_kosten_nächste_Forschung["Kosten_Karma"];
				
		$Tech["Stufe"] = $stufe;

		
		$Tech["Lab"] = $row_kosten_nächste_Forschung["Lab"];
		
		if($Tech["Erw_Bedingung"] == "nicht bestanden") { $Tech["Forschung"] = "N/A" ; return $Tech; } else { $Tech["Forschung"] = "OK"; }
		if($Tech["Lab"] > $forschungszentrum) { $Tech["Forschung"] = "N/A" ; return $Tech; } else { $Tech["Forschung"] = "OK"; }
		
		if($stufe > $Tech["Level_Cap"]) { $Tech["Forschung"] = "MAX" ; return $Tech; } else { $Tech["Forschung"] = "OK"; }
		
		$mod_gewinn_kapazität = 0;
		$mod_gewinn_energie = 0;
		$mod_ress = 0;
		$mod_gewinn_kapazität = 0;
		$mod_energie = 1.5;
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
		
		$Tech["Bauzeit"] = $Tech["Bauzeit"];
		
		return $Tech;

}

function get_list_of_all_planets($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");
	
	$abfrage = "SELECT `Planet_Name`, `Planet_ID` FROM `planet` WHERE `Spieler_ID` = '$spieler_id'";
	
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
	
	$abfrage = "SELECT `x`, `y`, `z` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query);
	
	$row = mysqli_fetch_object($result);
	
	$ausgabe = $row->x.":".$row->y.":".$row->z;

	return $ausgabe; 

}

function get_Ressbunker_Inhalt($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';
	
	$abfrage = "SELECT 	`Bunker_Kapa`, `Bunker_Eisen`, `Bunker_Silizium`, `Bunker_Wasser` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_Ressbunker_Inhalt #1 ".$link));
	$result = mysqli_query($link, $query);
	
	$row = mysqli_fetch_object($result);
	
	$bunker["vorhanden"] = 0;
	
	if($row->Bunker_Kapa > 0) {
		
		$bunker["vorhanden"] = 1;		

		$bunker["Belegt_Prozent"] = (($row->Bunker_Eisen + $row->Bunker_Silizium + $row->Bunker_Wasser) * 100 / $row->Bunker_Kapa);
		$bunker["Eisen"] = (int)$row->Bunker_Eisen;
		$bunker["Silizium"] = (int)$row->Bunker_Silizium;
		$bunker["Wasser"] = (int)$row->Bunker_Wasser;
		$bunker["Kapazität"] = (int)$row->Bunker_Kapa;

		
		$bunker["Eisen_Prozent"] = (int)number_format($row->Bunker_Eisen * 100 / $row->Bunker_Kapa, 0, '','');
		$bunker["Silizium_Prozent"] = (int)number_format($row->Bunker_Silizium * 100 / $row->Bunker_Kapa, 0, '','');
		$bunker["Wasser_Prozent"] = (int)number_format($row->Bunker_Wasser * 100 / $row->Bunker_Kapa, 0, '','');
		
	} else {
		
		$bunker["Belegt_Prozent"] = 0;
		$bunker["Eisen"] = 0;
		$bunker["Silizium"] = 0;
		$bunker["Wasser"] = 0;
		$bunker["Kapazität"] = 0;
		
		
		$bunker["Eisen_Prozent"] = 0;
		$bunker["Silizium_Prozent"] = 0;
		$bunker["Wasser_Prozent"] = 0;
		
		
	}
	
	return $bunker; 
	
}


function get_Handelsposten_Inhalt($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT 	`Handel_Kapa`, `Handel_Eisen`, `Handel_Silizium`, `Handel_Wasser` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

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
	$abfrage = "SELECT `Schiff_Typ_1`, `Schiff_Typ_2`, `Schiff_Typ_3`, `Schiff_Typ_4`, `Schiff_Typ_5`, `Schiff_Typ_6`, `Schiff_Typ_7`, `Schiff_Typ_8`, `Schiff_Typ_9`, `Schiff_Typ_10`, `Schiff_Typ_11` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_Schiffe_stationiert #1 ".$link));
	$result = mysqli_query($link, $query);
	

	$row = mysqli_fetch_object($result);
	
	 for($i = 1; $i <= 11; $i++) {
		
		$row_schiffe = get_ship($i);
		
		$tabelle = "Schiff_Typ_".$i;
		
		$anzahl = $row->$tabelle;
		
		$anzahl = number_format($anzahl, 0, '.', '.');
		
		if ($row->$tabelle > 0) {
			
			if ($row->$tabelle = 1) {
				$schiffe[$i]["Name"] = $row_schiffe["Name"];
				$schiffe[$i]["Anzahl"] = $anzahl;
			} else {
				$schiffe[$i]["Name"] = $row_schiffe["Name_Plural"];
				$schiffe[$i]["Anzahl"] = $anzahl;
			}

		}
	
	}
	
	
	if (isset($schiffe)) { return $schiffe; }
	
	
	
	
	
}

function get_Deff_stationiert($spieler_id, $planet_id) {

	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");
	$abfrage = "SELECT `Deff_Typ_1`, `Deff_Typ_2`, `Deff_Typ_3`, `Deff_Typ_4`, `Deff_Typ_5`, `Deff_Typ_6` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_Schiffe_stationiert #1 ".$link));
	$result = mysqli_query($link, $query);


	$row = mysqli_fetch_object($result);

	for($i = 1; $i <= 6; $i++) {

		$row_deff = get_def($i);

		$tabelle = "Deff_Typ_".$i;

		$anzahl = $row->$tabelle;

		$anzahl = number_format($anzahl, 0, '.', '.');

		if ($row->$tabelle > 0) {
				
			if ($row->$tabelle = 1) {
				$deff[$i]["Name"] = $row_deff["Name"];
				$deff[$i]["Anzahl"] = $anzahl;
			} else {
				$deff[$i]["Name"] = $row_deff["Name_Plural"];
				$deff[$i]["Anzahl"] = $anzahl;
			}

		}

	}


	if (isset($deff)) { return $deff; }





}

function get_activity_planet_spieler_schiffe($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';
	
	//planet|gebäude
	$abfrage = "SELECT `Bauschleife_Gebaeude_Name`, `Bauschleife_Gebaeude_Bis`, `Bauschleife_Flotte_ID` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
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

	$abfrage = "SELECT `ID`, `Name`, `Anzahl`, `Bauzeit_Bis` FROM `bauschleifeflotte` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0010c ".$link));
	$result = mysqli_query($link, $query);

	
	
	$i = 0;
	while($row = mysqli_fetch_object($result)) {
		
		$flotte[$i]["ID"] = $row->ID;
		$flotte[$i]["Anzahl"] = number_format($row->Anzahl, 0, '.', '.');
		$flotte[$i]["Name"] = $row->Name;
		$flotte[$i]["Zeit-Bis"] = $row->Bauzeit_Bis - time();

		$i++;

	}



	if (isset($flotte)) { return $flotte; }

}

function get_activity_deff_Liste($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	$link->set_charset("utf8");

	//schiffe

	$abfrage = "SELECT `ID`, `Name`, `Anzahl`, `Bauzeit_Bis` FROM `bauschleifedeff` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0010c ".$link));
	$result = mysqli_query($link, $query);



	$i = 0;
	while($row = mysqli_fetch_object($result)) {

		$deff[$i]["ID"] = $row->ID;
		$deff[$i]["Anzahl"] = number_format($row->Anzahl, 0, '.', '.');
		$deff[$i]["Name"] = $row->Name;
		$deff[$i]["Zeit-Bis"] = $row->Bauzeit_Bis - time();

		$i++;

	}



	if (isset($deff)) { return $deff; }

}

function get_ressource($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';
	
	$abfrage = "SELECT `Ressource_Eisen`, `Ressource_Silizium`, `Ressource_Wasser`, `Ressource_Bot`, `Stationiert_Bot`, `Ressource_Energie`, `Ressource_Karma` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
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

function refresh_ressource($spieler_id, $planet_id, $zeitpunkt) {
	
	$produktion = get_produktion($spieler_id, 0);	
	$ressource = get_ressource($spieler_id, 0);
	
	//echo "<pre>" . var_dump($produktion) . "</pre>";
	//echo "<pre>" . var_dump($ressource) . "</pre>";
	
	$minuten = ($zeitpunkt - $produktion["Letzte_Aktualisierung"]) / 60;
	
	if ($minuten >= 1) {
		
		$hours = abs($minuten  / 60);
		
		$produktion_eisen = round($ressource["Eisen"] + ($produktion["Eisen"] * $hours), 2);
		$produktion_silizium = round($ressource["Silizium"] + ($produktion["Silizium"] * $hours), 2);
		$produktion_wasser = round($ressource["Wasser"] + ($produktion["Wasser"] * $hours), 2);
		
		//echo "<pre>" . $produktion_eisen . "</pre>";
		//echo "<pre>" . $produktion_silizium . "</pre>";
		//echo "<pre>" . $produktion_wasser . "</pre>";
		
		require 'inc/connect_galaxy_1.php';
		
		$sql = "UPDATE `planet` SET `Ressource_Eisen`= $produktion_eisen , `Ressource_Silizium`= $produktion_silizium, `Ressource_Wasser`= $produktion_wasser, `Produktion_Zeit`= $zeitpunkt WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id"; 
		
		$query = $sql or die("Error in the consult.." . mysqli_error("Error:  refresh_ressource".$link));
		$result = mysqli_query($link, $query);
		
		//echo "<pre>" . $sql . "</pre>";
		
	}	
}


function get_produktion($spieler_id, $planet_id) {
	
	require 'inc/connect_galaxy_1.php';
	
	$abfrage = "SELECT `Prod_Eisen`, `Prod_Silizium`, `Prod_Wasser`, `Bunker_Kapa`, `Handel_Kapa`, `Ressource_Energie`, `Produktion_Zeit`, `Grund_Prod_Eisen`, `Grund_Prod_Silizium`, `Grund_Prod_Wasser` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query);
	
	$row = mysqli_fetch_object($result);
	
	$produktion["Eisen"] = $row->Prod_Eisen + $row->Grund_Prod_Eisen;	
	$produktion["Eisen_Grund"] = (int)$row->Grund_Prod_Eisen;
	$produktion["Eisen_Produktion"] = (int)$row->Prod_Eisen;
	$produktion["Eisen_24"] = ($row->Prod_Eisen + $row->Grund_Prod_Eisen) * 24;
	
	$produktion["Silizium"] = $row->Prod_Silizium + $row->Grund_Prod_Silizium;
	$produktion["Silizium_Grund"] = (int)$row->Grund_Prod_Silizium;
	$produktion["Silizium_Produktion"] = (int)$row->Prod_Silizium;
	$produktion["Silizium_24"] = ($row->Prod_Silizium + $row->Grund_Prod_Silizium) * 24;
	
	$produktion["Wasser"] = $row->Prod_Wasser + $row->Grund_Prod_Wasser;
	$produktion["Wasser_Grund"] = (int)$row->Grund_Prod_Wasser;
	$produktion["Wasser_Produktion"] = (int)$row->Prod_Wasser;
	$produktion["Wasser_24"] = ($row->Prod_Wasser + $row->Grund_Prod_Wasser) * 24;
	
	$produktion["Bunker_Kapa"] = (int)$row->Bunker_Kapa;
	$produktion["Handel_Kapa"] = (int)$row->Handel_Kapa;
	$produktion["Energie"]  = (int)$row->Ressource_Energie;
	$produktion["Letzte_Aktualisierung"]  = (int)$row->Produktion_Zeit;
	
	return $produktion;
	
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
	
	
	mysqli_select_db($link, "spieler");
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

	$result = $link->query("SELECT count(*) as total FROM `planet` WHERE `x` = $x AND `y` = $y AND `z` = $z")
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
	$newVal = preg_replace($regex,"", $newVal);

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
	
	
	$result = $link->query("SELECT count(*) as total FROM `planet` WHERE `spieler_ID` = '$spieler_id'")
	or die ("Error: #0006 " . mysql_error());
					
	$data = mysqli_fetch_assoc($result);	
	$anzahl = $data['total'];		
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
	mysqli_select_db($link, "spieler");
	
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

function set_news($spieler_id, $planet_id, $typ, $text) {
	require 'inc/connect_galaxy_1.php';
	
	$abfrage = "INSERT INTO `message`(
			`Spieler_ID`, 
			`Planet_ID`, 
			`typ`, 
			`text`, 
			`gelesen`, 
			`erstellt`) VALUES (
			'$spieler_id',
			'$planet_id',
			'$typ',
			'$text',
			FALSE,
			NOW()
)";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Fehler im Nachrichtensystem #1 ".$link));
	
	if (mysqli_query($link, $query)) {
		
	} else {
		die("Fehler im Nachrichtensystem " . mysqli_error($link));
	}
	
	
}

define("MAXIMALE_ROBOTS_GESAMT_GALAXY", 27000);
define("MAXIMALE_ROBOTS_GESAMT_PLANET", 3000);
define("SCHRANKE", MAXIMALE_ROBOTS_GESAMT_PLANET / 2);
define("PRODUKTION_JE_STUNDE_MAXIMAL", 5); //weil pro 24h waren es 120 Robots
define("PRODUKTION_JE_STUNDE_MINIMUM", 0.003333);
define("ZEIT_EINHEIT", 60 * 60);



function berechne_robot_zuwachs($spieler_id, $bots_vorhanden_planet) {

	foreach ($bots_vorhanden_planet as $key => $value) {
		if($value < MAXIMALE_ROBOTS_GESAMT_PLANET) {
			if($value > SCHRANKE) { $rechne_mit_anzahl = SCHRANKE - ($value - SCHRANKE); } else { $rechne_mit_anzahl = $value; }
			//$zuwachs = $rechne_mit_anzahl * PRODUKTION_JE_STUNDE_MAXIMAL /  SCHRANKE;
			$zuwachs = round(($rechne_mit_anzahl * (MAXIMALE_ROBOTS_GESAMT_PLANET - $rechne_mit_anzahl) / 100000), 6);
			if ($zuwachs < PRODUKTION_JE_STUNDE_MINIMUM) { $zuwachs = PRODUKTION_JE_STUNDE_MINIMUM; }
			$value = $value + $zuwachs;
			if ($value > MAXIMALE_ROBOTS_GESAMT_PLANET) { $value = MAXIMALE_ROBOTS_GESAMT_PLANET; }
			$bots_vorhanden_planet[$key] = $value;
		}
	}
	return($bots_vorhanden_planet);
}

function get_produktions_zyklen_seit_letzter_aktualisierung($spieler_id) {
	
	
	
	require 'inc/connect_galaxy_1.php';
	
	$abfrage = "SELECT `Bot_Produktion_Zeit` FROM `spieler` WHERE `Spieler_ID` = '$spieler_id'";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query);
	
	$row = mysqli_fetch_object($result);
	
	$timestamp_in_der_db = $row->Bot_Produktion_Zeit; //1458638497 22.03. 10:21
	$vergangene_zyklen = (time() - $timestamp_in_der_db) / ZEIT_EINHEIT;

	return $vergangene_zyklen;
}

function set_produktions_zyklen_seit_letzter_aktualisierung($spieler_id) {

	require 'inc/connect_galaxy_1.php';
	
	$zeit = time();

	$abfrage = "UPDATE `spieler` SET `Bot_Produktion_Zeit` = '$zeit' WHERE `Spieler_ID` = '$spieler_id'";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query);
	
	if (mysqli_query($link, $query)) {
	} else {
		die("Fehler, Robots nicht aktualisisert. " . mysqli_error($link));
	}
	

}

function get_robots_galaxy_db($spieler_id) {
	//zähle Robots
	
	require 'inc/connect_galaxy_1.php';
	
	$abfrage = "SELECT `Stationiert_Bot`, `Ressource_Bot`, `Planet_ID` FROM `planet` WHERE `Spieler_ID` = '$spieler_id'";
	
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query);
	
	$bots_vorhanden_planet = array();
	
	while($row = mysqli_fetch_object($result)) {
		
		$Stationiert_Bot = $row->Stationiert_Bot + 0; 
		$Ressource_Bot = $row->Ressource_Bot + 0;
		
		$bots_vorhanden_planet[] = $Stationiert_Bot + $Ressource_Bot;

	}
	
	
	
	return($bots_vorhanden_planet);
}

function set_robots_galaxy_db($spieler_id, $bots_vorhanden_planet)  {
	require 'inc/connect_galaxy_1.php';

	$i = 0;
	
	foreach ($bots_vorhanden_planet as $value) {
		
		$sql = "UPDATE `planet` SET `Ressource_Bot` = '$value' WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = '$i'";
		
		$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
		$result = mysqli_query($link, $query);
		
		if (mysqli_query($link, $query)) {			
		} else {
			die("Fehler, Robots nicht aktualisisert. " . mysqli_error($link));
		}
		
		
		$i++;
	}
	
	
}

function get_robots_galaxy_array($spieler_id, $bots_vorhanden_planet) {
	//zähle Robots
	$robots_in_der_galaxy = 0;
	foreach ($bots_vorhanden_planet as $value) {
		$robots_in_der_galaxy = $robots_in_der_galaxy + $value;
	}

	return($robots_in_der_galaxy);
}

?>