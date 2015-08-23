<?php

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
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 1;			
			
			break;
				
		case 2:
			$Tech["Name"] = "Raketentechnik";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 1;
			
			break;
				
		case 3:
			$Tech["Name"] = "Antriebstechnik";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 2;
			
			break;
		
		case 4:
			$Tech["Name"] = "Schildtechnik";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 3;
			
			break;
	
		case 5:
			$Tech["Name"] = "Transporttechnik";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 4;
			
			break;
	
		case 6:
			$Tech["Name"] = "Flottentechnik";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 5;
			
			break;
	
		case 7:
			$Tech["Name"] = "Recycling";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 5;
			
			break;
	
		case 8:
			$Tech["Name"] = "Lasertechnik";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 6;

			//Erweiterte Bedingung
				
			//Vorraussetzung für Lasertechnik ist Raketentechnik mind. Stufe 5
			if($var_spieler_stufe["2"] >= 5) { $Tech["Erw_Bedingung"] = "bestanden"; } else { $Tech["Erw_Bedingung"] = "nicht bestanden"; }

			break;
	
		case 9:
			$Tech["Name"] = "Spionageabwehrtechnik";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 7;
			
			break;
	
		case 10:
			$Tech["Name"] = "Kolonisierungstechnik";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 8;
			
			break;
	
		case 11:
			$Tech["Name"] = "Ökonomik";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 9;
			
			break;

		case 12:
			$Tech["Name"] = "Ionentechnik";
			$Tech["Level_Cap"] = 30;
				
			$Tech["Kosten_Eisen"] = 55;
			$Tech["Kosten_Silizium"] = 15;
			$Tech["Kosten_Wasser"] = 0;
		
			$Tech["Bauzeit"] = 101;
			
			//Bedingung
			$Tech["Lab"] = 10;
			
			break;
	}
	

	return $Tech;
	
}

?>