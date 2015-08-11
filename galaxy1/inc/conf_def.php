<?php

function get_config_def($id, $var_spieler_stufe) {
	
	//print_r ($var_spieler_stufe);

	switch ($id) {
		case 1:
			$Def = array(
			"Schiff_ID" => 1,
			"Def_Name" => "Raketenwerfer",
			"Def_Name_Plural" => "Raketenwerfer",
			"Beschreibung" => "lorem ipsum",
			"Kosten_Eisen" => 500,
			"Kosten_Silizium" => 250,
			"Kosten_Wasser" => 0,
			"Bots" => 1,
			"Bauzeit" => 800,
			"Kapazitaet" => 50,
			"Geschwindigkeit" => 1500,
			"Angriff" => 5,
			"Verteidigung" => 5,
			"Stufe_Werft" => 3,
			"Typ" => "ATT",
			"Kuerzel" => "lJ",
			"Max_Hold" => "-1",
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50
				);
			break;	
		case 2:			
			$Def = array(
			"Schiff_ID" => 2,
			"Def_Name" => "Laserkanone",
			"Def_Name_Plural" => "Laserkanonen",
			"Beschreibung" => "lorem ipsum",
			"Kosten_Eisen" => 1150,
			"Kosten_Silizium" => 525,
			"Kosten_Wasser" => 100,
			"Bots" => 2,
			"Bauzeit" => 800,
			"Kapazitaet" => 100,
			"Geschwindigkeit" => 1400,
			"Angriff" => 15,
			"Verteidigung" => 10,
			"Stufe_Werft" => 5,
			"Typ" => "ATT",
			"Kuerzel" => "sJ",
			"Max_Hold" => "-1",
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50
				);
			break;
		
		case 3:
			$Def = array(
			"Schiff_ID" => 3,
			"Def_Name" => "Ionenkanone",
			"Def_Name_Plural" => "Ionenkanonen",
			"Beschreibung" => "lorem ipsum",			
			"Kosten_Eisen" => 2850,
			"Kosten_Silizium" => 1150,
			"Kosten_Wasser" => 375,
			"Bots" => 5,
			"Bauzeit" => 800,
			"Kapazitaet" => 800,
			"Geschwindigkeit" => 1250,
			"Angriff" => 40,
			"Verteidigung" => 25,
			"Stufe_Werft" => 7,
			"Typ" => "ATT",
			"Kuerzel" => "SK",
			"Max_Hold" => "-1",
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50
			);
			break;
			
		case 4:
			$Def = array(
			"Schiff_ID" => 4,
			"Def_Name" => "Kleiner Schild",
			"Def_Name_Plural" => "Kleiner Schild",
			"Beschreibung" => "lorem ipsum",
			
			"Kosten_Eisen" => 7875,
			"Kosten_Silizium" => 2675,
			"Kosten_Wasser" => 950,
			"Bots" => 13,
			"Bauzeit" => 800,
			"Kapazitaet" => 1500,
			"Geschwindigkeit" => 1000,
			"Angriff" => 100,
			"Verteidigung" => 400,
			"Stufe_Werft" => 9,
			"Typ" => "ATT",
			"Kuerzel" => "Zer",
			"Max_Hold" => "1",
			"Max_Hold_Planet" => 1,
			"Reichweite" => 50
			);
		break;
		
		case 5:
			$Def = array(
			"Schiff_ID" => 5,
			"Def_Name" => "Großer Schild",
			"Def_Name_Plural" => "Großer Schild",
			"Beschreibung" => "lorem ipsum",
			
			"Kosten_Eisen" => 425,
			"Kosten_Silizium" => 300,
			"Kosten_Wasser" => 25,
			"Bots" => 1,
			"Bauzeit" => 800,
			"Kapazitaet" => 5000,
			"Geschwindigkeit" => 1500,
			"Angriff" => 1,
			"Verteidigung" => 10,
			"Stufe_Werft" => 2,
			"Typ" => "TRAN",
			"Kuerzel" => "kT",
			"Max_Hold" => "-1",
			"Max_Hold_Planet" => 1,
			"Reichweite" => 50
			);
		break;
		
		
		case 6:
			$Def = array(
			"Schiff_ID" => 6,
			"Def_Name" => "Dimension Tide",
			"Def_Name_Plural" => "Dimension Tides",
			"Beschreibung" => "Satellite that fires a temporary black hole",				
			"Kosten_Eisen" => 20000000,
			"Kosten_Silizium" => 20000000,
			"Kosten_Wasser" => 20000000,
			"Bots" => 150,
			"Bauzeit" => 800,
			"Kapazitaet" => 0,
			"Geschwindigkeit" => 50,
			"Angriff" => 100000000,
			"Verteidigung" => 20,
			"Stufe_Werft" => 20,
			"Typ" => "SPEZ",
			"Kuerzel" => "DT",
			"Max_Hold_Planet" => -1,
			"Max_Hold" => "1",
			"Reichweite" => 50
			);
			break;
	}
	

	return $Def;
	
}

?>