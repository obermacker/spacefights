<?php

// ***** entfernt ***** //
//			"Kapazitaet" => 50,
//			"Geschwindigkeit" => 1500,
//			"Typ" => "ATT",
//			"Kuerzel" => "lJ",
//			"Reichweite" => 50,

function get_config_defense($id) {
	
	switch ($id) {
		case 0:						// number of posible defenseconsturction
			$defense = array(
				'defense count' => 6	
			);
			break;	
		
		case 1:
			$defense = array(
				'defense id' => $id,

				'name' => lng_echo('rocket launcher name', no_file, echo_off),
				'name plural' => lng_echo('rocket launcher name plural', no_file, echo_off),
				'picture' => 'img/foerderturm.gif',
				'description' => lng_echo('rocket launcher description', no_file, echo_off),

				'construction time' => 80,

				'required iron' => 500,
				'required silicon' => 250,
				'required water' => 0,
				'required karma' => 0,
				'required bots' => 1,

				'required level weapon factory' => 3,

				'required tech level typ 1' => 0,
				'required tech level typ 2' => 2,
				'required tech level typ 3' => 0,
				'required tech level typ 4' => 0,
				'required tech level typ 5' => 0,
				'required tech level typ 6' => 0,
				'required tech level typ 7' => 0,
				'required tech level typ 8' => 0,
				'required tech level typ 9' => 0,
				'required tech level typ 10' => 0,
				'required tech level typ 11' => 0,
				'required tech level typ 12' => 0,

				'max hold' => -1,
				'max hold planet' => -1,

				'attack strength' => 5,
				'defense strength' => 5
				);
			break;	

		case 2:			
			$defense = array(
				'defense id' => $id,

				'name' => lng_echo('laser cannon name', no_file, echo_off),
				'name plural' => lng_echo('laser cannon name plural', no_file, echo_off),
				'picture' => '',
				'description' => lng_echo('laser cannon description', no_file, echo_off),

				'construction time' => 800,

				'required iron' => 1150,
				'required silicon' => 525,
				'required water' => 100,
				'required karma' => 0,
				'required bots' => 2,

				'required level weapon factory' => 5,
				
				'required tech level typ 1' => 0,
				'required tech level typ 2' => 0,
				'required tech level typ 3' => 0,
				'required tech level typ 4' => 0,
				'required tech level typ 5' => 0,
				'required tech level typ 6' => 0,
				'required tech level typ 7' => 0,
				'required tech level typ 8' => 4,
				'required tech level typ 9' => 0,
				'required tech level typ 10' => 0,
				'required tech level typ 11' => 0,
				'required tech level typ 12' => 0,

				'max hold' => -1,
				'max hold planet' => -1,

				'attack strength' => 15,
				'defense strength' => 10
				);
			break;
		
		case 3:
			$defense = array(
				'defense id' => $id,

				'name' => lng_echo('ion cannon name', no_file, echo_off),
				'name plural' => lng_echo('ion cannon name plural', no_file, echo_off),
				'picture' => '',
				'description' => lng_echo('ion cannon description', no_file, echo_off),

				'construction time' => 80,

				'required iron' => 2850,
				'required silicon' => 1150,
				'required water' => 375,
				'required karma' => 0,
				'required bots' => 5,

				'required level weapon factory' => 7,

				'required tech level typ 1' => 0,
				'required tech level typ 2' => 0,
				'required tech level typ 3' => 0,
				'required tech level typ 4' => 0,
				'required tech level typ 5' => 0,
				'required tech level typ 6' => 0,
				'required tech level typ 7' => 0,
				'required tech level typ 8' => 0,
				'required tech level typ 9' => 0,
				'required tech level typ 10' => 0,
				'required tech level typ 11' => 0,
				'required tech level typ 12' => 5,
				
				'max hold' => -1,
				'max hold planet' => -1,

				'attack strength' => 40,
				'defense strength' => 25
				);
			break;
			
		case 4:
			$defense = array(
				'defense id' => $id,

				'name' => lng_echo('small protective shield name', no_file, echo_off),
				'name plural' => lng_echo('small protective shield name plural', no_file, echo_off),
				'picture' => '',
				'description' => lng_echo('small protective shield description', no_file, echo_off),

				'construction time' => (7500 + 6250) * 17,

				'required iron' => 7500,
				'required silicon' => 6250,
				'required water' => 1250,
				'required karma' => 0,
				'required bots' => 17,
				
				'required level weapon factory' => 1,
				
				'required tech level typ 1' => 0,
				'required tech level typ 2' => 0,
				'required tech level typ 3' => 0,
				'required tech level typ 4' => 2,
				'required tech level typ 5' => 0,
				'required tech level typ 6' => 0,
				'required tech level typ 7' => 0,
				'required tech level typ 8' => 0,
				'required tech level typ 9' => 0,
				'required tech level typ 10' => 0,
				'required tech level typ 11' => 0,
				'required tech level typ 12' => 0,
				
				'max hold' => -1,
				'max hold planet' => 1,

				'attack strength' => 100,
				'defense strength' => 400,
				);
		break;
		
		case 5:
			$defense = array(
				'defense id' => $id,

				'name' => lng_echo('big protective shield name', no_file, echo_off),
				'name plural' => lng_echo('big protective shield name plural', no_file, echo_off),
				'picture' => '',
				'description' => lng_echo('big protective shield description', no_file, echo_off),
			
				'construction time' => (35.000 + 27500) * 79,

				'required iron' => 35000,
				'required silicon' => 27500,
				'required water' => 6250,
				'required karma' => 0,
				'required bots' => 79,
				
				'required level weapon factory' => 10,
				
				'required tech level typ 1' => 0,
				'required tech level typ 2' => 0,
				'required tech level typ 3' => 0,
				'required tech level typ 4' => 6,
				'required tech level typ 5' => 0,
				'required tech level typ 6' => 0,
				'required tech level typ 7' => 0,
				'required tech level typ 8' => 0,
				'required tech level typ 9' => 0,
				'required tech level typ 10' => 0,
				'required tech level typ 11' => 0,
				'required tech level typ 12' => 0,

				'max hold' => -1,
				'max hold planet' => 1,
				
				'attack strength' => 1,
				'defense strength' => 10
				);
		break;
		
		
		case 6:
			$defense = array(
				'defense id' => $id,

				'name' => lng_echo('dimension tide name', no_file, echo_off),
				'name plural' => lng_echo('dimension tide name plural', no_file, echo_off),
				'picture' => '',
				'description' => lng_echo('dimension tide description', no_file, echo_off),

				'construction time' => 800,

				'required iron' => 20000000,
				'required silicon' => 20000000,
				'required water' => 20000000,
				'required karma' => 0,
				'required bots' => 150,

				'required level weapon factory' => 20,
				
				'required tech level typ 1' => 10,
				'required tech level typ 2' => 10,
				'required tech level typ 3' => 10,
				'required tech level typ 4' => 10,
				'required tech level typ 5' => 10,
				'required tech level typ 6' => 10,
				'required tech level typ 7' => 10,
				'required tech level typ 8' => 10,
				'required tech level typ 9' => 10,
				'required tech level typ 10' => 10,
				'required tech level typ 11' => 10,
				'required tech level typ 12' => 10,

				'max hold planet' => 1,
				'max hold' => 1,

				'attack strength' => 100000000,
				'defense strength' => 20
				);
			break;
	}
	
	return $defense;
}
?>