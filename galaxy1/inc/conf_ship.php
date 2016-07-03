<?php

function get_config_ships($id) {
	
	//print_r ($var_spieler_stufe);
	
	$Erw_Bedingung = "bestanden";	
	switch ($id) {
		case 1: 
			$Ship = array(
			"Schiff_ID" => 1,
			"Name" => "Leichter Jäger",
			"Name_Plural" => "Leichte Jäger",
			"Beschreibung" => "lorem ipsum",
			"Modul" => "",
			"Kosten_Eisen" => 500,
			"Kosten_Silizium" => 250,
			"Kosten_Wasser" => 0,
			"Kosten_Karma" => 0,
			"Bots" => 1,
			"Bauzeit" => (500 + 250)  * 1,
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
			"Tech_2" => 0,
			"Tech_3" => 2,	//Antriebstechnik - Stufe 2
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
			$Ship = array(
			"Schiff_ID" => 2,
			"Name" => "Schwerer Jäger",
			"Name_Plural" => "Schwere Jäger",
			"Beschreibung" => "lorem ipsum",
			"Modul" => "",
			"Kosten_Eisen" => 1150,
			"Kosten_Silizium" => 525,
			"Kosten_Wasser" => 100,
			"Kosten_Karma" => 0,
			"Bots" => 2,
			"Bauzeit" => (1150 + 525) * 2,
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
			"Tech_3" => 4, //Antriebstechnik - Stufe 4
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
		
		case 3:
			$Ship = array(
			"Schiff_ID" => 3,
			"Name" => "Sternenkreuzer",
			"Name_Plural" => "Sternenkreuzer",
			"Beschreibung" => "lorem ipsum",
			"Modul" => "",
			"Kosten_Eisen" => 2850,
			"Kosten_Silizium" => 1150,
			"Kosten_Wasser" => 375,
			"Kosten_Karma" => 0,
			"Bots" => 5,
			"Bauzeit" => (2850 + 1150 ) * 5,
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
			"Tech_8" => 6, //Lasertechnik - Stufe 6
			"Tech_9" => 0,
			"Tech_10" => 0,
			"Tech_11" => 0,
			"Tech_12" => 0
			);
			break;
			
		case 4:
			$Ship = array(
			"Schiff_ID" => 4,
			"Name" => "Zerstörer",
			"Name_Plural" => "Zerstörer",
			"Beschreibung" => "lorem ipsum",
			"Modul" => "",
			"Kosten_Eisen" => 7875,
			"Kosten_Silizium" => 2675,
			"Kosten_Wasser" => 950,
			"Kosten_Karma" => 0,
			"Bots" => 13,
			"Bauzeit" => (7875 + 2675 ) * 13,
			"Kapazitaet" => 1500,
			"Geschwindigkeit" => 1000,
			"Angriff" => 100,
			"Verteidigung" => 400,
			"Stufe_Werft" => 9,
			"Typ" => "ATT",
			"Kuerzel" => "Zer",
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
			"Tech_12" => 8 //Ionentechnik - Stufe 8
			);
		break;
		
		case 5:
			$Ship = array(
			"Schiff_ID" => 5,
			"Name" => "Kleiner Transporter",
			"Name_Plural" => "Kleine Transporter",
			"Beschreibung" => "lorem ipsum",
			"Modul" => "trade;",
			"Kosten_Eisen" => 425,
			"Kosten_Silizium" => 300,
			"Kosten_Wasser" => 25,
			"Kosten_Karma" => 0,
			"Bots" => 1,
			"Bauzeit" => (425 + 300) * 1,
			"Kapazitaet" => 5000,
			"Geschwindigkeit" => 1500,
			"Angriff" => 1,
			"Verteidigung" => 10,
			"Stufe_Werft" => 2,
			"Typ" => "TRAN",
			"Kuerzel" => "kT",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50,
			"Tech_1" => 0,
			"Tech_2" => 0,
			"Tech_3" => 0,
			"Tech_4" => 0,
			"Tech_5" => 2, //Transporttechnik - Stufe 2
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
			$Ship = array(
			"Schiff_ID" => 6,
			"Name" => "Großer Transporter",
			"Name_Plural" => "Große Transporter",
			"Beschreibung" => "lorem ipsum",
			"Modul" => "trade;",
			"Kosten_Eisen" => 1500,
			"Kosten_Silizium" => 1100,
			"Kosten_Wasser" => 125,
			"Kosten_Karma" => 0,
			"Bots" => 3,
			"Bauzeit" => (1500 + 1100) * 3,
			"Kapazitaet" => 25000,
			"Geschwindigkeit" => 200000, //750,
			"Angriff" => 3,
			"Verteidigung" => 40,
			"Stufe_Werft" => 6,
			"Typ" => "TRAN",
			"Kuerzel" => "gT",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50,
			"Tech_1" => 0,
			"Tech_2" => 0,
			"Tech_3" => 0,
			"Tech_4" => 0,
			"Tech_5" => 4, //Transporttechnik - Stufe 4
			"Tech_6" => 0,
			"Tech_7" => 0,
			"Tech_8" => 0,
			"Tech_9" => 0,
			"Tech_10" => 0,
			"Tech_11" => 0,
			"Tech_12" => 0
			);
		break;
		
		case 7:
			$Ship = array(
			"Schiff_ID" => 7,
			"Name" => "Aufklärungssonde",
			"Name_Plural" => "Aufklärungssonden",
			"Beschreibung" => "lorem ipsum",
			"Modul" => "scout;",
			"Kosten_Eisen" => 160,
			"Kosten_Silizium" => 90,
			"Kosten_Wasser" => 0,
			"Kosten_Karma" => 0,
			"Bots" => 1,
			"Bauzeit" => (160 + 90) * 1,
			"Kapazitaet" => 0,
			"Geschwindigkeit" => 25000,
			"Angriff" => 0,
			"Verteidigung" => 0,
			"Stufe_Werft" => 1,
			"Typ" => "SONDE",
			"Kuerzel" => "AS",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50,
			"Tech_1" => 1, //Sondentechnik - Stufe 1
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
			"Tech_12" => 0
			);
		break;
	
		case 8:
			$Ship = array(
			"Schiff_ID" => 8,
			"Name" => "Spionagesonde",
			"Name_Plural" => "Spionagesonden",
			"Beschreibung" => "lorem ipsum",
			"Modul" => "spy;",
			"Kosten_Eisen" => 60,
			"Kosten_Silizium" => 125,
			"Kosten_Wasser" => 15,
			"Kosten_Karma" => 0,
			"Bots" => 1,
			"Bauzeit" => (60 + 125) * 1,
			"Kapazitaet" => 0,
			"Geschwindigkeit" => 100000,
			"Angriff" => 0,
			"Verteidigung" => 0,
			"Stufe_Werft" => 4,
			"Typ" => "SONDE",
			"Kuerzel" => "Spio",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50,
			"Tech_1" => 5, //Sondentechnik - Stufe 5
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
			"Tech_12" => 0
			);
			break;

		case 9:
			$Ship = array(
			"Schiff_ID" => 9,
			"Name" => "Kolonisierungsschiff",
			"Name_Plural" => "Kolonisierungsschiffe",
			"Beschreibung" => "lorem ipsum",
			"Modul" => "colonization;",
			"Kosten_Eisen" => 3750,
			"Kosten_Silizium" => 4500,
			"Kosten_Wasser" => 1880,
			"Kosten_Karma" => 0,
			"Bots" => 12,
			"Bauzeit" => (3750 + 4500) * 12,
			"Kapazitaet" => 7500,
			"Geschwindigkeit" => 100000, //250,
			"Angriff" => 5,
			"Verteidigung" => 50,
			"Stufe_Werft" => 8,
			"Typ" => "SPEZ",
			"Kuerzel" => "Kolo",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50,
			"Tech_1" => 0,
			"Tech_2" => 0,
			"Tech_3" => 8, //Antriebstechnik - Stufe 8
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
			
		case 10:
			$Ship = array(
			"Schiff_ID" => 10,
			"Name" => "Bergungsschiff",	
			"Name_Plural" => "Bergungsschiffe",
			"Beschreibung" => "lorem ipsum",
			"Modul" => "rescue;",
			"Kosten_Eisen" => 1750,
			"Kosten_Silizium" => 750,
			"Kosten_Wasser" => 500,
			"Kosten_Karma" => 0,
			"Bots" => 1,
			"Bauzeit" => (1750 + 750) * 1,
			"Kapazitaet" => 25,
			"Geschwindigkeit" => 1500,
			"Angriff" => 0,
			"Verteidigung" => 0,
			"Stufe_Werft" => 10,
			"Typ" => "SPEZ",
			"Kuerzel" => "BS",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50,
			"Tech_1" => 0,
			"Tech_2" => 0,
			"Tech_3" => 0,
			"Tech_4" => 0,
			"Tech_5" => 0,
			"Tech_6" => 0,
			"Tech_7" => 1, //Recycling - Stufe 1
			"Tech_8" => 0,
			"Tech_9" => 0,
			"Tech_10" => 0,
			"Tech_11" => 0,
			"Tech_12" => 0
			);
			break;

		case 11:
			$Ship = array(
			"Schiff_ID" => 11,
			"Name" => "Shuttle",
			"Name_Plural" => "Shuttles",
			"Beschreibung" => "lorem ipsum",
			"Modul" => "bot;",
			"Kosten_Eisen" => 2000,
			"Kosten_Silizium" => 2000,
			"Kosten_Wasser" => 2000,
			"Kosten_Karma" => 0,
			"Bots" => 1,
			"Bauzeit" => (2000 + 2000) * 1,
			"Kapazitaet" => 0,
			"Geschwindigkeit" => 1200,
			"Angriff" => 0,
			"Verteidigung" => 0,
			"Stufe_Werft" => 10,
			"Typ" => "SPEZ",
			"Kuerzel" => "STS",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => -1,
			"Reichweite" => 50,
			"Tech_1" => 10,
			"Tech_2" => 0,
			"Tech_3" => 0,
			"Tech_4" => 0,
			"Tech_5" => 10,
			"Tech_6" => 0,
			"Tech_7" => 0,
			"Tech_8" => 0,
			"Tech_9" => 0,
			"Tech_10" => 0,
			"Tech_11" => 0,
			"Tech_12" => 0
			);
			break;
		case 12:
			$Ship = array(
			"Schiff_ID" => 12,
			"Name" => "Dimension Tide",
			"Name_Plural" => "Dimension Tides",
			"Beschreibung" => "Satellite that fires a temporary black hole",
			"Modul" => "",
			"Kosten_Eisen" => 20000000,
			"Kosten_Silizium" => 20000000,
			"Kosten_Wasser" => 20000000,
			"Kosten_Karma" => 1000,
			"Bots" => 150,
			"Bauzeit" => 800,
			"Kapazitaet" => 0,
			"Geschwindigkeit" => 50,
			"Angriff" => 100000000,
			"Verteidigung" => 20,
			"Stufe_Werft" => 20,
			"Typ" => "SPEZ",
			"Kuerzel" => "DT",
			"Max_Hold" => -1,
			"Max_Hold_Planet" => -1,
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
	

	return $Ship;
	
}

?>