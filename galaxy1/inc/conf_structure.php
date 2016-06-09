<?php

function get_config_structure($id) {
	
	switch ($id) {
		case 1:
			$Gebäude["Name"] = "Eisen-Mine";
			$Gebäude["Beschreibung"] = "Diese Mine wird zur Förderung von Eisen benötigt.";
			$Gebäude["Wirkung"] = "Erhöht die Fördermenge von Eisen";
			$Gebäude["Level_Cap"] = 30;
				
			$Gebäude["Kosten_Eisen"] = 55;
			$Gebäude["Kosten_Silizium"] = 15;
			$Gebäude["Kosten_Wasser"] = 0;
			$Gebäude["Kosten_Energie"] = 8;
		
			$Gebäude["Gewinn_Ress"] = 20;
			$Gebäude["Gewinn_Energie"] = 0;
			$Gebäude["Kapazitaet"] = 0;
				
			$Gebäude["Bauzeit"] = 101;
			
			break;
				
		case 2:
			$Gebäude["Name"] = "Silizium-Mine";
			$Gebäude["Beschreibung"] = "Diese Mine wird zur Förderung von Silizium benötigt.";
			$Gebäude["Wirkung"] = "Erhöht die Fördermenge von Silizium";
			$Gebäude["Level_Cap"] = 30;
				
			$Gebäude["Kosten_Eisen"] = 85;
			$Gebäude["Kosten_Silizium"] = 25;
			$Gebäude["Kosten_Wasser"] = 0;
			$Gebäude["Kosten_Energie"] = 10;
		
			$Gebäude["Gewinn_Ress"] = 10;
			$Gebäude["Gewinn_Energie"] = 0;
			$Gebäude["Kapazitaet"] = 0;
				
			$Gebäude["Bauzeit"] = 145;
			break;
			
		case 3:
			$Gebäude["Name"] = "Wasserbrunnen";
			$Gebäude["Beschreibung"] = "Diese Mine wird zur Förderung von Wasser benötigt.";
			$Gebäude["Wirkung"] = "Erhöht die Fördermenge von Wasser";
			$Gebäude["Level_Cap"] = 30;
				
			$Gebäude["Kosten_Eisen"] = 110;
			$Gebäude["Kosten_Silizium"] = 30;
			$Gebäude["Kosten_Wasser"] = 0;
			$Gebäude["Kosten_Energie"] = 12;
				
			$Gebäude["Gewinn_Ress"] = 5;
			$Gebäude["Gewinn_Energie"] = 0;
			$Gebäude["Kapazitaet"] = 0;
				
			$Gebäude["Bauzeit"] = 202;
			break;
			
		case 4:
			$Gebäude["Name"] = "Kraftwerk";
			$Gebäude["Beschreibung"] = "Das Kraftwerk wird benötigt um die anderen Gebäude mit Energie zu versorgen.";
			$Gebäude["Wirkung"] = "Erhöht die Energie.";
			$Gebäude["Level_Cap"] = 100;
				
			$Gebäude["Kosten_Eisen"] = 70;
			$Gebäude["Kosten_Silizium"] = 30;
			$Gebäude["Kosten_Wasser"] = 10;
			$Gebäude["Kosten_Energie"] = 0;
				
			$Gebäude["Gewinn_Ress"] = 0;
			$Gebäude["Gewinn_Energie"] = 10;
			$Gebäude["Kapazitaet"] = 0;
				
			$Gebäude["Bauzeit"] = 144;
			break;
			

		case 5:
			$Gebäude["Name"] = "Bauzentrum";
			$Gebäude["Beschreibung"] = "Beschleunigt den Bau neuer Gebäude.";
			$Gebäude["Wirkung"] = "Bauzeit = Reg. Bauzeit / (1 + Stufe Bauzentrum)";
			$Gebäude["Level_Cap"] = -1;
		
			$Gebäude["Kosten_Eisen"] = 400;
			$Gebäude["Kosten_Silizium"] = 120;
			$Gebäude["Kosten_Wasser"] = 200;
			$Gebäude["Kosten_Energie"] = 0;
		
			$Gebäude["Gewinn_Ress"] = 0;
			$Gebäude["Gewinn_Energie"] = 0;
			$Gebäude["Kapazitaet"] = 0;
		
			$Gebäude["Bauzeit"] = 720;
			break;
				
		
		case 6:
			$Gebäude["Name"] = "Rohstoffbunker";
			$Gebäude["Beschreibung"] = "Tief unter der Erde sind die Rohstoffe vor feindlichen Übergriffen sicher.";
			$Gebäude["Wirkung"] = "Rohstoffe im Rohstoffbunker können von Feinden nicht geplündert werden.";
			$Gebäude["Level_Cap"] = -1;
		
			$Gebäude["Kosten_Eisen"] = 10000;
			$Gebäude["Kosten_Silizium"] = 6250;
			$Gebäude["Kosten_Wasser"] = 2500;
			$Gebäude["Kosten_Energie"] = 0;
		
			$Gebäude["Gewinn_Ress"] = 0;
			$Gebäude["Gewinn_Energie"] = 0;
			$Gebäude["Kapazitaet"] = 15000;
		
			$Gebäude["Bauzeit"] = 23400;
			break;
				
		case 7:
			$Gebäude["Name"] = "Raumschiffwerft";
			$Gebäude["Beschreibung"] = "Ermöglicht den Bau von Raumschiffen.";
			$Gebäude["Wirkung"] = "Raumschiffe können schneller gebaut werden.";
			$Gebäude["Level_Cap"] = -1;
		
			$Gebäude["Kosten_Eisen"] = 800;
			$Gebäude["Kosten_Silizium"] = 400;
			$Gebäude["Kosten_Wasser"] = 200;
			$Gebäude["Kosten_Energie"] = 0;
		
			$Gebäude["Gewinn_Ress"] = 0;
			$Gebäude["Gewinn_Energie"] = 0;
			$Gebäude["Kapazitaet"] = 0;
		
			$Gebäude["Bauzeit"] = 1728;
			break;
				
		case 8:
			$Gebäude["Name"] = "Waffenfabrik";
			$Gebäude["Beschreibung"] = "Ermöglicht den Bau von Waffenanlagen.";
			$Gebäude["Wirkung"] = "Beschleunigt und Verbessert Waffenanlagen.";
			$Gebäude["Level_Cap"] = -1;
		
			$Gebäude["Kosten_Eisen"] = 600;
			$Gebäude["Kosten_Silizium"] = 480;
			$Gebäude["Kosten_Wasser"] = 200;
			$Gebäude["Kosten_Energie"] = 0;
		
			$Gebäude["Gewinn_Ress"] = 0;
			$Gebäude["Gewinn_Energie"] = 0;
			$Gebäude["Kapazitaet"] = 0;
		
			$Gebäude["Bauzeit"] = 1555;
			break;
				
		case 9:
			$Gebäude["Name"] = "Forschungslabor";
			$Gebäude["Beschreibung"] = "Dient zum erforschen und verbessern neuer Technologien.";
			$Gebäude["Wirkung"] = "Beschleunigt die Erforschung neuer Technologien.";
			$Gebäude["Level_Cap"] = -1;
		
			$Gebäude["Kosten_Eisen"] = 200;
			$Gebäude["Kosten_Silizium"] = 400;
			$Gebäude["Kosten_Wasser"] = 200;
			$Gebäude["Kosten_Energie"] = 0;
		
			$Gebäude["Gewinn_Ress"] = 0;
			$Gebäude["Gewinn_Energie"] = 0;
			$Gebäude["Kapazitaet"] = 0;
		
			$Gebäude["Bauzeit"] = 864;
			break;
	
		case 10:
			$Gebäude["Name"] = "Handelsposten";
			$Gebäude["Beschreibung"] = "Ermöglicht die Teilnahme am interstellaren Handel.";
			$Gebäude["Wirkung"] = "Höhere Stufen wirken unterschiedlich, siehe FAQ.";
			$Gebäude["Level_Cap"] = -1;
		
			$Gebäude["Kosten_Eisen"] = 10000;
			$Gebäude["Kosten_Silizium"] = 2500;
			$Gebäude["Kosten_Wasser"] = 5000;
			$Gebäude["Kosten_Energie"] = 0;
		
			$Gebäude["Gewinn_Ress"] = 0;
			$Gebäude["Gewinn_Energie"] = 0;
			$Gebäude["Kapazitaet"] = 0;
		
			$Gebäude["Bauzeit"] = 18000;
			break;
		}
	
		$Gebäude["Kosten_Karma"] = 0;

	return $Gebäude;
	
}

?>