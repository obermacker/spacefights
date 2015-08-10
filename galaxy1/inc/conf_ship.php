<?php

function get_config_ships($id, $var_spieler_stufe) {
	
	//print_r ($var_spieler_stufe);
	switch ($id) {
		case 1:
			$Ship = array(
			"Schiff_ID" => 1,
			"Raumschiff_Name" => "Leichter Jäger",
			"Raumschiff_Name_Plural" => "Leichte Jäger",
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
			"Reichweite" => 50
				);
			break;	
		case 2:			
			$Ship = array(
			"Schiff_ID" => 2,
			"Raumschiff_Name" => "Schwerer Jäger",
			"Raumschiff_Name_Plural" => "Schwere Jäger",
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
			"Reichweite" => 50
				);
			break;
		
		case 3:
			$Ship = array(
			"Schiff_ID" => 3,
			"Raumschiff_Name" => "Sternenkreuzer",
			"Raumschiff_Name_Plural" => "Sternenkreuzer",
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
			"Reichweite" => 50
			);
			break;
			
		case 4:
			$Ship = array(
			"Schiff_ID" => 4,
			"Raumschiff_Name" => "Zerstörer",
			"Raumschiff_Name_Plural" => "Zerstörer",
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
			"Max_Hold" => "-1",
			"Reichweite" => 50
			);
		break;
		
		case 5:
			$Ship = array(
			"Schiff_ID" => 5,
			"Raumschiff_Name" => "Kleiner Transporter",
			"Raumschiff_Name_Plural" => "Kleine Transporter",
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
			"Reichweite" => 50
			);
		break;
		
		case 6:
			$Ship = array(
			"Schiff_ID" => 6,
			"Raumschiff_Name" => "Großer Transporter",
			"Raumschiff_Name_Plural" => "Große Transporter",
			"Beschreibung" => "lorem ipsum",
			
			"Kosten_Eisen" => 1500,
			"Kosten_Silizium" => 1100,
			"Kosten_Wasser" => 125,
			"Bots" => 3,
			"Bauzeit" => 800,
			"Kapazitaet" => 25000,
			"Geschwindigkeit" => 750,
			"Angriff" => 3,
			"Verteidigung" => 40,
			"Stufe_Werft" => 6,
			"Typ" => "TRAN",
			"Kuerzel" => "gT",
			"Max_Hold" => "-1",
			"Reichweite" => 50
			);
		break;
		
		case 7:
			$Ship = array(
			"Schiff_ID" => 7,
			"Raumschiff_Name" => "Aufklärungssonde",
			"Raumschiff_Name_Plural" => "Aufklärungssonden",
			"Beschreibung" => "lorem ipsum",
			
			"Kosten_Eisen" => 160,
			"Kosten_Silizium" => 90,
			"Kosten_Wasser" => 0,
			"Bots" => 1,
			"Bauzeit" => 800,
			"Kapazitaet" => 0,
			"Geschwindigkeit" => 2500,
			"Angriff" => 0,
			"Verteidigung" => 0,
			"Stufe_Werft" => 1,
			"Typ" => "SONDE",
			"Kuerzel" => "AS",
			"Max_Hold" => "-1",
			"Reichweite" => 50
			);
		break;
	
		case 8:
			$Ship = array(
			"Schiff_ID" => 8,
			"Raumschiff_Name" => "Spionagesonde",
			"Raumschiff_Name_Plural" => "Spionagesonden",
			"Beschreibung" => "lorem ipsum",
			
			"Kosten_Eisen" => 60,
			"Kosten_Silizium" => 125,
			"Kosten_Wasser" => 15,
			"Bots" => 1,
			"Bauzeit" => 800,
			"Kapazitaet" => 0,
			"Geschwindigkeit" => 100000,
			"Angriff" => 0,
			"Verteidigung" => 0,
			"Stufe_Werft" => 4,
			"Typ" => "SONDE",
			"Kuerzel" => "Spio",
			"Max_Hold" => "-1",
			"Reichweite" => 50
			);
			break;

		case 9:
			$Ship = array(
			"Schiff_ID" => 9,
			"Raumschiff_Name" => "Kolonisierungsschiff",
			"Raumschiff_Name_Plural" => "Kolonisierungsschiffe",
			"Beschreibung" => "lorem ipsum",
			
			"Kosten_Eisen" => 3750,
			"Kosten_Silizium" => 4500,
			"Kosten_Wasser" => 1880,
			"Bots" => 12,
			"Bauzeit" => 800,
			"Kapazitaet" => 7500,
			"Geschwindigkeit" => 250,
			"Angriff" => 5,
			"Verteidigung" => 50,
			"Stufe_Werft" => 10,
			"Typ" => "SPEZ",
			"Kuerzel" => "Kolo",
			"Max_Hold" => "-1",
			"Reichweite" => 50
			);
			break;
			
		case 10:
			$Ship = array(
			"Schiff_ID" => 10,
			"Raumschiff_Name" => "Bergungsschiff",
			"Raumschiff_Name_Plural" => "Bergungsschiffe",
			"Beschreibung" => "lorem ipsum",
			
			"Kosten_Eisen" => 1750,
			"Kosten_Silizium" => 750,
			"Kosten_Wasser" => 500,
			"Bots" => 1,
			"Bauzeit" => 800,
			"Kapazitaet" => 25,
			"Geschwindigkeit" => 1500,
			"Angriff" => 0,
			"Verteidigung" => 0,
			"Stufe_Werft" => 10,
			"Typ" => "SPEZ",
			"Kuerzel" => "BS",
			"Max_Hold" => "-1",
			"Reichweite" => 50
			);
			break;

		case 11:
			$Ship = array(
			"Schiff_ID" => 11,
			"Raumschiff_Name" => "Shuttle",
			"Raumschiff_Name_Plural" => "Shuttles",
			"Beschreibung" => "lorem ipsum",
			
			"Kosten_Eisen" => 2000,
			"Kosten_Silizium" => 2000,
			"Kosten_Wasser" => 2000,
			"Bots" => 1,
			"Bauzeit" => 800,
			"Kapazitaet" => 0,
			"Geschwindigkeit" => 1200,
			"Angriff" => 0,
			"Verteidigung" => 0,
			"Stufe_Werft" => 10,
			"Typ" => "SPEZ",
			"Kuerzel" => "STS",
			"Max_Hold" => "-1",
			"Reichweite" => 50
			);
			break;
		case 12:
			$Ship = array(
			"Schiff_ID" => 12,
			"Raumschiff_Name" => "Dimension Tide",
			"Raumschiff_Name_Plural" => "Dimension Tides",
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
			"Max_Hold" => "1",
			"Reichweite" => 50
			);
			break;
	}
	

	return $Ship;
	
}

?>