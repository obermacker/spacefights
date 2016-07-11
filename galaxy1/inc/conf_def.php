<?php

$deffCount=6; 			// Anzahl Deff-Typen

function get_config_deff($id, $var_spieler_stufe) {
	
	//print_r ($var_spieler_stufe);

	switch ($id) {
		case 1:
			$Deff = array(
			"Schiff_ID" => 1,
			"Name" => "Raketenwerfer",
			"Name_Plural" => "Raketenwerfer",
			"Bild" => "img/foerderturm.gif",
			"Beschreibung" => "lorem ipsum",
			
			"Kosten_Eisen" => 500,
			"Kosten_Silizium" => 250,
			"Kosten_Wasser" => 0,
			"Kosten_Karma" => 0,
			"Bots" => 1,
			"Bauzeit" => 80,
			"Kapazitaet" => 50,
			"Geschwindigkeit" => 1500,
			"Angriff" => 5,
			"Verteidigung" => 5,
			"Stufe_Werft" => 3,
			"Typ" => "ATT",
			"Kuerzel" => "lJ",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50,
			"Tech_1" => 0,
			"Tech_2" => 2,
			"Tech_3" => 0,
			"Tech_4" => 0,
			"Tech_5" => 0,
			"Tech_6" => 0,
			"Tech_7" => 0,
			"Tech_8" => 0,
			"Tech_9" => 0,
			"Tech_10" => 0,
			"Tech_11" => 0,
			"Tech_12" => 0
				);
			break;	
		case 2:			
			$Deff = array(
			"Schiff_ID" => 2,
			"Name" => "Laserkanone",
			"Name_Plural" => "Laserkanonen",
			"Bild" => "",
			"Beschreibung" => "lorem ipsum",
			
			"Kosten_Eisen" => 1150,
			"Kosten_Silizium" => 525,
			"Kosten_Wasser" => 100,
			"Kosten_Karma" => 0,
			"Bots" => 2,
			"Bauzeit" => 800,
			"Kapazitaet" => 100,
			"Geschwindigkeit" => 1400,
			"Angriff" => 15,
			"Verteidigung" => 10,
			"Stufe_Werft" => 5,
			"Typ" => "ATT",
			"Kuerzel" => "sJ",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50,
			"Tech_1" => 0,
			"Tech_2" => 0,
			"Tech_3" => 0,
			"Tech_4" => 0,
			"Tech_5" => 0,
			"Tech_6" => 0,
			"Tech_7" => 0,
			"Tech_8" => 4,
			"Tech_9" => 0,
			"Tech_10" => 0,
			"Tech_11" => 0,
			"Tech_12" => 0
				);
			break;
		
		case 3:
			$Deff = array(
			"Schiff_ID" => 3,
			"Name" => "Ionenkanone",
			"Name_Plural" => "Ionenkanonen",
			"Bild" => "",
			"Beschreibung" => "lorem ipsum",			
			
			"Kosten_Eisen" => 2850,
			"Kosten_Silizium" => 1150,
			"Kosten_Wasser" => 375,
			"Kosten_Karma" => 0,
			"Bots" => 5,
			"Bauzeit" => 80,
			"Kapazitaet" => 800,
			"Geschwindigkeit" => 1250,
			"Angriff" => 40,
			"Verteidigung" => 25,
			"Stufe_Werft" => 7,
			"Typ" => "ATT",
			"Kuerzel" => "SK",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50,
			"Tech_1" => 0,
			"Tech_2" => 0,
			"Tech_3" => 0,
			"Tech_4" => 0,
			"Tech_5" => 0,
			"Tech_6" => 0,
			"Tech_7" => 0,
			"Tech_8" => 0,
			"Tech_9" => 0,
			"Tech_10" => 0,
			"Tech_11" => 0,
			"Tech_12" => 5
			);
			break;
			
		case 4:
			$Deff = array(
			"Schiff_ID" => 4,
			"Name" => "kleiner Schild",
			"Name_Plural" => "kleiner Schilde",
			"Bild" => "",
			"Beschreibung" => "lorem ipsum",

			"Kosten_Eisen" => 7500,
			"Kosten_Silizium" => 6250,
			"Kosten_Wasser" => 1250,
			"Kosten_Karma" => 0,
			"Bots" => 17,
			"Bauzeit" => (7500 + 6250) * 17,
			"Kapazitaet" => 1500,
			"Geschwindigkeit" => 1000,
			"Angriff" => 100,
			"Verteidigung" => 400,
			"Stufe_Werft" => 1,
			"Typ" => "ATT",
			"Kuerzel" => "Zer",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => 1,
			"Reichweite" => 50,
			"Tech_1" => 0,
			"Tech_2" => 0,
			"Tech_3" => 0,
			"Tech_4" => 2,
			"Tech_5" => 0,
			"Tech_6" => 0,
			"Tech_7" => 0,
			"Tech_8" => 0,
			"Tech_9" => 0,
			"Tech_10" => 0,
			"Tech_11" => 0,
			"Tech_12" => 0
			);
		break;
		
		case 5:
			$Deff = array(
			"Schiff_ID" => 5,
			"Name" => "großer Schild",
			"Name_Plural" => "großer Schilde",
			"Bild" => "",
			"Beschreibung" => "lorem ipsum",
			
			"Kosten_Eisen" => 35000,
			"Kosten_Silizium" => 27500,
			"Kosten_Wasser" => 6250,
			"Kosten_Karma" => 0,
			"Bots" => 79,
			"Bauzeit" => (35.000 + 27500) * 79,
			"Kapazitaet" => 5000,
			"Geschwindigkeit" => 1500,
			"Angriff" => 1,
			"Verteidigung" => 10,
			"Stufe_Werft" => 10,
			"Typ" => "TRAN",
			"Kuerzel" => "kT",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => 1,
			"Reichweite" => 50,
			"Tech_1" => 0,
			"Tech_2" => 0,
			"Tech_3" => 0,
			"Tech_4" => 6,
			"Tech_5" => 0,
			"Tech_6" => 0,
			"Tech_7" => 0,
			"Tech_8" => 0,
			"Tech_9" => 0,
			"Tech_10" => 0,
			"Tech_11" => 0,
			"Tech_12" => 0
			);
		break;
		
		
		case 6:
			$Deff = array(
			"Schiff_ID" => 6,
			"Name" => "Dimension Tide",
			"Name_Plural" => "Dimension Tides",
			"Bild" => "",
			"Beschreibung" => "Satellite that fires a temporary black hole",				

			"Kosten_Eisen" => 20000000,
			"Kosten_Silizium" => 20000000,
			"Kosten_Wasser" => 20000000,
			"Kosten_Karma" => 0,
			"Bots" => 150,
			"Bauzeit" => 800,
			"Kapazitaet" => 0,
			"Geschwindigkeit" => 50,
			"Angriff" => 100000000,
			"Verteidigung" => 20,
			"Stufe_Werft" => 20,
			"Typ" => "SPEZ",
			"Kuerzel" => "DT",
			"Max_Hold_Planet" => 1,
			"Max_Hold" => 1,
			"Reichweite" => 50,
			"Tech_1" => 10,
			"Tech_2" => 10,
			"Tech_3" => 10,
			"Tech_4" => 10,
			"Tech_5" => 10,
			"Tech_6" => 10,
			"Tech_7" => 10,
			"Tech_8" => 10,
			"Tech_9" => 10,
			"Tech_10" => 10,
			"Tech_11" => 10,
			"Tech_12" => 10
			);
			break;
	}
	

	return $Deff;
	
}

?>