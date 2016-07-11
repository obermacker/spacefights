<?php

$techCount=12; 		//Anzahl TechTypen

function get_config_tech($id, $var_spieler_stufe) {
	
	$Tech["Beschreibung"] = "/lost_id/";
	$Tech["Wirkung"] = "/lost_id/";
	$Tech["Kosten_Karma"] = "";
	$Tech["Kosten_Energie"] = 0;
	
	//print_r ($var_spieler_stufe);
	
	$Tech["Erw_Bedingung"] = "bestanden"; //Beispiel in Case 8 Lasertechnik
	
	
	
	switch ($id) {
		case 1:
			$Tech["Name"] = "Sondentechnik";
			$Tech["Bild"] = "img/foerderturm.gif";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 400;
			$Tech["Kosten_Silizium"] = 800;
			$Tech["Kosten_Wasser"] = 200;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 1;
			
			//Bedingung
			$Tech["Lab"] = 1;			
			$Tech["Sort"] = 6;
			break;
				
		case 2:
			$Tech["Name"] = "Raketentechnik";
			$Tech["Bild"] = "";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 400;
			$Tech["Kosten_Silizium"] = 200;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 1;
			
			//Bedingung
			$Tech["Lab"] = 1;
			$Tech["Sort"] = 2;
			break;
				
		case 3:
			$Tech["Name"] = "Antriebstechnik";
			$Tech["Bild"] = "";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 400;
			$Tech["Kosten_Silizium"] = 200;
			$Tech["Kosten_Wasser"] = 400;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 2;
			
			//Bedingung
			$Tech["Lab"] = 2;
			$Tech["Sort"] = 1;
			break;
		
		case 4:
			$Tech["Name"] = "Schildtechnik";
			$Tech["Bild"] = "";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 0;
			$Tech["Kosten_Silizium"] = 600;
			$Tech["Kosten_Wasser"] = 200;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 3;
			
			//Bedingung
			$Tech["Lab"] = 3;
			$Tech["Sort"] = 5;
			break;
	
		case 5:
			$Tech["Name"] = "Transporttechnik";
			$Tech["Bild"] = "";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 400;
			$Tech["Kosten_Silizium"] = 250;
			$Tech["Kosten_Wasser"] = 150;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 4;
			
			//Bedingung
			$Tech["Lab"] = 4;
			$Tech["Sort"] = 8;
			break;
	
		case 6:
			$Tech["Name"] = "Flottentechnik";
			$Tech["Bild"] = "";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 0;
			$Tech["Kosten_Silizium"] = 400;
			$Tech["Kosten_Wasser"] = 600;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 5;
			
			//Bedingung
			$Tech["Lab"] = 5;
			$Tech["Sort"] = 9;
			break;
	
		case 7:
			$Tech["Name"] = "Recycling";
			$Tech["Bild"] = "";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 36000;
			$Tech["Kosten_Silizium"] = 0;
			$Tech["Kosten_Wasser"] = 8000;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 5;
			
			//Bedingung
			$Tech["Lab"] = 5;
			$Tech["Sort"] = 11;
			break;
	
		case 8:
			$Tech["Name"] = "Lasertechnik";
			$Tech["Bild"] = "";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 600;
			$Tech["Kosten_Silizium"] = 0;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 6;
			
			//Bedingung
			$Tech["Lab"] = 6;
			$Tech["Sort"] = 3;

			//Erweiterte Bedingung
				
			//Vorraussetzung für Lasertechnik ist Raketentechnik mind. Stufe 5
			if($var_spieler_stufe["2"] >= 5) { $Tech["Erw_Bedingung"] = "bestanden"; } else { $Tech["Erw_Bedingung"] = "nicht bestanden"; }

			break;
	
		case 9:
			$Tech["Name"] = "Spionageabwehrtechnik";
			$Tech["Bild"] = "";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 200;
			$Tech["Kosten_Silizium"] = 0;
			$Tech["Kosten_Wasser"] = 600;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 7;
			
			//Bedingung
			$Tech["Lab"] = 7;
			$Tech["Sort"] = 7;
			break;
	
		case 10:
			$Tech["Name"] = "Kolonisierungstechnik";
			$Tech["Bild"] = "";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 40000;
			$Tech["Kosten_Silizium"] = 80000;
			$Tech["Kosten_Wasser"] = 20000;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 8;
			
			//Bedingung
			$Tech["Lab"] = 8;
			$Tech["Sort"] = 10;
			break;
	
		case 11:
			$Tech["Name"] = "Ökonomik";
			$Tech["Bild"] = "";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 80000;
			$Tech["Kosten_Silizium"] = 20000;
			$Tech["Kosten_Wasser"] = 1000;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 9;
			
			//Bedingung
			$Tech["Lab"] = 9;
			$Tech["Sort"] = 12;
			break;

		case 12:
			$Tech["Name"] = "Ionentechnik";
			$Tech["Bild"] = "";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 1000;
			$Tech["Kosten_Silizium"] = 400;
			$Tech["Kosten_Wasser"] = 200;
		
			$Tech["Bauzeit"] = ($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"]) * 10;
			
			//Bedingung
			$Tech["Lab"] = 10;
			$Tech["Sort"] = 4;
			break;
	}
	

	return $Tech;
	
}

?>