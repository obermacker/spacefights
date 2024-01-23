<table>
<?php

//$spieler_id_alt = $spieler_id;
//$spieler_id = "";

$punkte_neu = array();
$punkte_neu["Gebäude"] = 0;

$number_of_planets = get_number_of_planets($spieler_id, 1);

for ($planet_id = 0 ; $planet_id < $number_of_planets ; $planet_id++ ) {
	for($gebäude_id = 1; $gebäude_id <= 10; $gebäude_id++) {
	 		
		$gebäude = get_structure_level($spieler_id, $planet_id, $gebäude_id);
		$row_kosten_nächstes_Gebäude = get_config_structure($gebäude_id);
		
		$Gebäude["Kosten_Eisen"] = $row_kosten_nächstes_Gebäude["Kosten_Eisen"];
		$Gebäude["Kosten_Silizium"] = $row_kosten_nächstes_Gebäude["Kosten_Silizium"];
		$Gebäude["Kosten_Wasser"] = $row_kosten_nächstes_Gebäude["Kosten_Wasser"];
		$Gebäude["Name"] = $row_kosten_nächstes_Gebäude["Name"];
//		$mod_ress = 0;
//		if ($gebäude_id <= 3 ) { $mod_ress = 1.41; }	
// 		if ($gebäude_id >= 4) { $mod_ress = 1.5; }	
		echo "<th colspan=4><BR>" . $Gebäude["Name"] . " / Planet ". get_koordinaten_planet($spieler_id, $planet_id)["Anzeige"] . "</th>";
		echo "<tr><td>Stufe</td>";
		echo "<td>Eisen</td>";
		echo "<td>Sili</td>";
		echo "<td>Wasser</td>";
		echo "<td>1000stel Punkte</td></tr>";
		for($z = 1; $z <= $gebäude; $z++) {
			if ($z == 1) {
				$mod_ress = 1;
			} else {
				if ($gebäude_id <= 3 ) { $mod_ress = 1.41;}
		 		if ($gebäude_id >= 4) { $mod_ress = 1.5; }	
			}
			$Gebäude["Kosten_Eisen"] = $Gebäude["Kosten_Eisen"] * $mod_ress;
			$Gebäude["Kosten_Silizium"] = $Gebäude["Kosten_Silizium"] * $mod_ress;
			$Gebäude["Kosten_Wasser"] = $Gebäude["Kosten_Wasser"] * $mod_ress;
			
			$punkte_neu["Gebäude"] = $punkte_neu["Gebäude"] + round($Gebäude["Kosten_Eisen"]) + round($Gebäude["Kosten_Silizium"]) + round($Gebäude["Kosten_Wasser"]);
			
			echo "<tr>";
			echo "<td>" . $z . "</td>";
			echo "<td>" . round($Gebäude["Kosten_Eisen"]) . "</td>";
			echo "<td>" . round($Gebäude["Kosten_Silizium"]) . "</td>";
			echo "<td>" . round($Gebäude["Kosten_Wasser"]) . "</td>";
			echo "<td>" . $punkte_neu["Gebäude"] . "</td>";
			echo "</tr>";
		}	
	}
}




?>
</table>

<?php 
$punkte_neu["Gebäude"] = round($punkte_neu["Gebäude"]/1000);
echo "<h4>Punkte Gebäude " . $punkte_neu["Gebäude"] . " </h4>"

?>

<table>
<?php 
$punkte_neu["Forschung"] = 0;

for($tech_id = 1; $tech_id <= 12; $tech_id++) {
	
	$Tech = get_tech_nächste_stufe($spieler_id, 0, $tech_id, 1);
	
	$mod_ress = 1.5;
	if ($Tech["Forschung"] == "OK") {
		$stufe = $Tech["Stufe"];
		
		echo "<th colspan=4>" . $Tech["Name"] . "</th>";
		echo "<tr><td>Stufe</td>";
		echo "<td>Eisen</td>";
		echo "<td>Sili</td>";
		echo "<td>Wasser</td>";
		echo "<td>1000stel Punkte</td></tr>";
		
		for($i = 1; $i < $stufe; $i++) {
			if ($i == 1) {
				$mod_ress = 1;
			} else {
				$mod_ress = 1.5; 
			}		
			$Tech["Kosten_Eisen"] = $Tech["Kosten_Eisen"] * $mod_ress;
			$Tech["Kosten_Silizium"] = $Tech["Kosten_Silizium"] * $mod_ress;
			$Tech["Kosten_Wasser"] = $Tech["Kosten_Wasser"] * $mod_ress;

			$punkte_neu["Forschung"] = $punkte_neu["Forschung"] + round($Tech["Kosten_Eisen"]) + round($Tech["Kosten_Silizium"]) + round($Tech["Kosten_Wasser"]);
			
			echo "<tr>";
			echo "<td>" . $i . "</td>";
			echo "<td>" . round($Tech["Kosten_Eisen"]) . "</td>";
			echo "<td>" . round($Tech["Kosten_Silizium"]) . "</td>";
			echo "<td>" . round($Tech["Kosten_Wasser"]) . "</td>";
			echo "<td>" . $punkte_neu["Forschung"] . "</td>";
			echo "</tr>";
				
		}
	}
}

?>
</table>

<?php 
$punkte_neu["Forschung"] = round($punkte_neu["Forschung"]/1000);
echo "<h4>Punkte Forschung " . $punkte_neu["Forschung"] . " </h4>"
?>

<table>
	
<?php 
$punkte_neu["Flotte"] = 0;

echo "<th colspan=4>Flottenpunkte</th>";
echo "<tr><td>Anzahl</td>";
echo "<td>Name</td>";
echo "<td>Eisen</td>";
echo "<td>Sili</td>";
echo "<td>Wasser</td>";
echo "<td>1000stel Punkte</td></tr>";
echo "<th colspan=4>Schiffe stationiert</th>";
$schiffe = get_all_ships_stationed($playerID);
foreach ($schiffe as $ship_id => $schiffe_anzahl){
	$ress = spaceships::$shipID[$ship_id]->requiredIron + spaceships::$shipID[$ship_id]->requiredSilicon + spaceships::$shipID[$ship_id]->requiredWater;
	$punkte_neu["Flotte"] = $punkte_neu["Flotte"] + ($ress * $schiffe_anzahl);
	echo "<tr>";
	echo "<td>" . $schiffe_anzahl . "</td>";
	echo "<td>" . spaceships::$shipID[$ship_id]->name . "</td>";
	echo "<td>" . round(spaceships::$shipID[$ship_id]->requiredIron) . "</td>";
	echo "<td>" . round(spaceships::$shipID[$ship_id]->requiredSilicon) . "</td>";
	echo "<td>" . round(spaceships::$shipID[$ship_id]->requiredWater) . "</td>";
	echo "<td>" . $punkte_neu["Flotte"] . "</td>";
	echo "</tr>";
}

echo "<th colspan=4>Schiffe unterwegs</th>";
$schiffe = get_all_ships_in_the_air($playerID);
foreach ($schiffe as $ship_id => $schiffe_anzahl){
	$ress = spaceships::$shipID[$ship_id]->requiredIron + spaceships::$shipID[$ship_id]->requiredSilicon + spaceships::$shipID[$ship_id]->requiredWater;
	$punkte_neu["Flotte"] = $punkte_neu["Flotte"] + ($ress * $schiffe_anzahl);
	echo "<tr>";
	echo "<td>" . $schiffe_anzahl . "</td>";
	echo "<td>" . spaceships::$shipID[$ship_id]->name . "</td>";
	echo "<td>" . round(spaceships::$shipID[$ship_id]->requiredIron) . "</td>";
	echo "<td>" . round(spaceships::$shipID[$ship_id]->requiredSilicon) . "</td>";
	echo "<td>" . round(spaceships::$shipID[$ship_id]->requiredWater) . "</td>";
	echo "<td>" . $punkte_neu["Flotte"] . "</td>";
	echo "</tr>";
}


echo "<th colspan=4>Verteidigungsanlagen</th>";
for($defense_id = 1; $defense_id <= get_defense_count(); $defense_id++) {
	$defense_quantity = get_total_stationed_defense_in_galaxy ($spieler_id, $defense_id);
	$defense = get_defense($defense_id);
	$ress = $defense['required iron'] + $defense['required silicon'] + $defense['required water'];
	$punkte_neu["Flotte"] = $punkte_neu["Flotte"] + ($ress * $defense_quantity);
	echo "<tr>";
	echo "<td>" . $defense_quantity . "</td>";
	echo "<td>" . $defense["name"] . "</td>";
	echo "<td>" . round($defense['required iron']) . "</td>";
	echo "<td>" . round($defense['required silicon']) . "</td>";
	echo "<td>" . round($defense['required water']) . "</td>";
	echo "<td>" . $punkte_neu["Flotte"]. "</td>";
	echo "</tr>";
}

?>
</table>
<?php 
$punkte_neu["Flotte"] = round($punkte_neu["Flotte"]/1000);
echo "<h4>Punkte Flotte " . $punkte_neu["Flotte"] . " </h4>";


korrigiere_punkte($spieler_id, $punkte_neu["Gebäude"],  $punkte_neu["Flotte"], $punkte_neu["Forschung"]);

//$spieler_id = $spieler_id_alt;


?>