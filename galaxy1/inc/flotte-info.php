<?php

if(isset($_GET["id"])) {
	$id = intval($_GET["id"], 10);
	if(is_numeric($id)) {
		$balken = get_flotte_mit_id($spieler_id, $id);
		if($balken != "ID nicht gefunden") {
		
			echo "<ul>";		
			echo "<li>Gestartet: " . get_timestamp_in_was_lesbares($balken["Start"]);
			echo "<li>Ankunft am Ziel: " . get_timestamp_in_was_lesbares($balken["Ankunft"]);
			if($balken["Mission"] != "rückkehr") {
				echo "<li>Ankunft in der Heimat ohne Abbruch: " . get_timestamp_in_was_lesbares($balken["Ankunft"] + ($balken["Ankunft"] - $balken["Start"]));
			}			
			echo "<li>Besitzer: " . $balken["Besitzer_Spieler_Name"];
			echo "<li>Mission: " . $balken["Mission"];
			echo "<li>Startkoordinaten: " . $balken["x1"] . ":" . $balken["y1"] . ":" . $balken["z1"] . " " . $balken["Startplanet_Name"];
			echo "<li>Zielkoordinaten: " . $balken["x2"] . ":" . $balken["y2"] . ":" . $balken["z2"] . " " . $balken["Zielplanet_Name"];
			echo "<li>Gesamtkapazität: " . $balken["Kapazitaet"];
			echo "<li>Ausladen (aktuell mitgeführte Ress):<ul>";
			echo "<li>Eisen: " . $balken["Ausladen_Eisen"];
			echo "<li>Silizium: " . $balken["Ausladen_Silizium"];
			echo "<li>Wasser: " . $balken["Ausladen_Wasser"];
			echo "</li></ul>";
			echo "<li>Einladen:<ul>";
			echo "<li>Eisen: " . $balken["Einladen_Eisen"];
			echo "<li>Silizium: " . $balken["Einladen_Silizium"];
			echo "<li>Wasser: " . $balken["Einladen_Wasser"];
			echo "</li></ul>";
			echo "<li>Schiffe:<ul>";
			for ($i = 1; $i<=12; $i++) {
				if ($balken["Schiff_Typ_" . $i] > 0) {
					if ($balken["Schiff_Typ_" . $i] == 1) {
						echo "<li>" . $balken["Schiff_Typ_" . $i] . "x " . spaceships::$shipID[$i]->name;
					} else {
						echo "<li>" . $balken["Schiff_Typ_" . $i] . "x " . spaceships::$shipID[$i]->namePlural;   
					}
				}
			}
			echo "</li></ul>";
			
				
			echo "</ul>";
			
			if($balken["Mission"] != "rückkehr") {
				?>
				<form action="index.php" method="post" autocomplete="off">
				<input type="hidden" name="s" value="index">
				<button type="submit" name="action-flotte-abbrechen" value="<?php echo $id; ?>">Mission abbrechen</button>
				</form>				
				<?php 
			}
				
			
		} else {
			echo "ID nicht gefunden!";
		}
			
	}
}





?>