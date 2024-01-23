<?php

// only temporary for compatibility translation german - english

function get_Schiffe_stationiert($_playerID, $_planetID) {  
	
	$_stationedShips = get_ships_stationed($_playerID, $_planetID);

	foreach ($_stationedShips as $_ID => $_Ship) {
		$schiffe[$_ID]['Anzahl'] = $_Ship->numberOfShips;
		$schiffe[$_ID]['ID'] = $_Ship->shipID;
		$schiffe[$_ID]['Name'] = $_Ship->name;
	}
	
	if (isset($schiffe)) { return $schiffe; }
}


function get_tech_stufe_spieler ($_playerID) {
	
	$_result = get_tech_level_player ($_playerID);

	foreach ($_result::$techLevelType as $_ID => $_level){
		$_tech['Tech_'.$_ID] = $_level;
	}
	$_tech['Tech_Schleife_ID'] = $_result::$researchLoopID;

	return $_tech;
}

?>