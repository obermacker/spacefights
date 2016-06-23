<?php

require 'inc/connect_galaxy_1.php';

$sql = "SELECT `Spieler_ID`, `x`, `y` FROM `planet` WHERE 1";

$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

$result = mysqli_query($link, $query);

while($row = mysqli_fetch_object($result)) {

	$Planet["X"] = $row->x;
	$Planet["Y"] = $row->y;
	$Planet["Spieler_ID"] = $row->Spieler_ID;
	
	$sql2 = "INSERT INTO `sonnensystem` (`ID`, `Spieler_ID`, `x`, `y`, `Entdeckt`, `locked`) VALUES (NULL, '" . $Planet["Spieler_ID"] . "', '" . $Planet["X"] . "', '" . $Planet["Y"] . "', CURRENT_TIMESTAMP, '1')";
	
	$query2 = $sql2 or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_ship #1 ".$link));
	if(mysqli_query($link, $query2)) {
		
		
	} else {
		
		echo "fuck";
		
	}
}



?>