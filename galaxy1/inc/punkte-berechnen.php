<table>
<?php

//$spieler_id_alt = $spieler_id;
//$spieler_id = "";

$punkte_neu = array();
$punkte_neu["Gebäude"] = 0;

for($gebäude_id = 1; $gebäude_id <= 10; $gebäude_id++) {
	$gebäude = get_gebäude_aktuelle_stufe($spieler_id, 0, $gebäude_id);
	
	$row_kosten_nächstes_Gebäude = get_config_structure($gebäude_id);
	
	$Gebäude["Kosten_Eisen"] = $row_kosten_nächstes_Gebäude["Kosten_Eisen"];
	$Gebäude["Kosten_Silizium"] = $row_kosten_nächstes_Gebäude["Kosten_Silizium"];
	$Gebäude["Kosten_Wasser"] = $row_kosten_nächstes_Gebäude["Kosten_Wasser"];
	$Gebäude["Name"] = $row_kosten_nächstes_Gebäude["Name"];
	$mod_ress = 0;
	if ($gebäude_id <= 3 ) { $mod_ress = 1.41; }	
	if ($gebäude_id >= 4) { $mod_ress = 1.5; }	
	echo "<th colspan=4>" . $Gebäude["Name"] . "</th>";
	echo "<tr><td>Stufe</td>";
	echo "<td>Eisen</td>";
	echo "<td>Sili</td>";
	echo "<td>Wasser</td>";
	echo "<td>Punkte</td></tr>";
	for($z = 1; $z <= $gebäude; $z++) {
		
		$Gebäude["Kosten_Eisen"] = $Gebäude["Kosten_Eisen"] * $mod_ress;
		$Gebäude["Kosten_Silizium"] = $Gebäude["Kosten_Silizium"] * $mod_ress;
		$Gebäude["Kosten_Wasser"] = $Gebäude["Kosten_Wasser"] * $mod_ress;
		
		$punkte_neu["Gebäude"] = $punkte_neu["Gebäude"] + (round($Gebäude["Kosten_Eisen"]) + round($Gebäude["Kosten_Silizium"]) + round($Gebäude["Kosten_Wasser"])) / 1000;
		
		echo "<tr>";
		echo "<td>" . $z . "</td>";
		echo "<td>" . round($Gebäude["Kosten_Eisen"]) . "</td>";
		echo "<td>" . round($Gebäude["Kosten_Silizium"]) . "</td>";
		echo "<td>" . round($Gebäude["Kosten_Wasser"]) . "</td>";
		echo "<td>" . $punkte_neu["Gebäude"] . "</td>";
		echo "</tr>";
		
	}
}




?>
</table>

<?php 

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
		echo "<td>Punkte</td></tr>";
		
		for($i = 1; $i < $stufe; $i++) {
		
			$Tech["Kosten_Eisen"] = $Tech["Kosten_Eisen"] * $mod_ress;
			$Tech["Kosten_Silizium"] = $Tech["Kosten_Silizium"] * $mod_ress;
			$Tech["Kosten_Wasser"] = $Tech["Kosten_Wasser"] * $mod_ress;

			$punkte_neu["Forschung"] = $punkte_neu["Forschung"] + (round($Tech["Kosten_Eisen"]) + round($Tech["Kosten_Silizium"]) + round($Tech["Kosten_Wasser"])) / 1000;
			
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
echo "<td>Punkte</td></tr>";

for($ship_id = 1; $ship_id <= 11; $ship_id++) {
	$schiffe_anzahl = get_addiere_schiffe_stationiert($spieler_id, $ship_id);
	$schiff = get_ship($ship_id);
	$ress = $schiff['Kosten_Eisen'] + $schiff['Kosten_Silizium'] + $schiff['Kosten_Wasser'];
	$punkte_neu["Flotte"] = $punkte_neu["Flotte"] + ($ress / 1000 * $schiffe_anzahl);
	echo "<tr>";
	echo "<td>" . $schiffe_anzahl . "</td>";
	echo "<td>" . $schiff["Name"] . "</td>";
	echo "<td>" . round($schiff["Kosten_Eisen"]) . "</td>";
	echo "<td>" . round($schiff["Kosten_Silizium"]) . "</td>";
	echo "<td>" . round($schiff["Kosten_Wasser"]) . "</td>";
	echo "<td>" . $punkte_neu["Flotte"] . "</td>";
	echo "</tr>";
}

for($ship_id = 1; $ship_id <= 11; $ship_id++) {
	$schiffe_anzahl = get_addiere_schiffe_luft($spieler_id, $ship_id);
	$schiff = get_ship($ship_id);
	$ress = $schiff['Kosten_Eisen'] + $schiff['Kosten_Silizium'] + $schiff['Kosten_Wasser'];
	$punkte_neu["Flotte"] = $punkte_neu["Flotte"] + ($ress / 1000 * $schiffe_anzahl);
	echo "<tr>";
	echo "<td>" . $schiffe_anzahl . "</td>";
	echo "<td>" . $schiff["Name"] . "</td>";
	echo "<td>" . round($schiff["Kosten_Eisen"]) . "</td>";
	echo "<td>" . round($schiff["Kosten_Silizium"]) . "</td>";
	echo "<td>" . round($schiff["Kosten_Wasser"]) . "</td>";
	echo "<td>" . $punkte_neu["Flotte"] . "</td>";
	echo "</tr>";
}



for($defense_id = 1; $defense_id <= get_defense_count(); $defense_id++) {
	$defense_quantity = get_total_stationed_defense_in_galaxy ($spieler_id, $defense_id);
	$defense = get_defense($defense_id);
	$ress = $defense['required iron'] + $defense['required silicon'] + $defense['required water'];
	$punkte_neu["Flotte"] = $punkte_neu["Flotte"] + ($ress / 1000 * $defense_quantity);
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
echo "<h4>Punkte Flotte " . $punkte_neu["Flotte"] . " </h4>";


korrigiere_punkte($spieler_id, $punkte_neu["Gebäude"],  $punkte_neu["Flotte"], $punkte_neu["Forschung"]);

//$spieler_id = $spieler_id_alt;


?>