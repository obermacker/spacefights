<?php
class spaceships {
	// static $possibleTypes = 12; // number of possible spacseship types
	static $shipID = [1,2,3,4,5,6,7,8,9,10,11,12,13];

	static function init() {
		self::$shipID = [
			1  => (object) array (
					'spaceshipID' => 1,
					
					'name' => lng_echo('light fighter name', no_file, echo_off),
					'namePlural' => lng_echo('light fighter name plural', no_file, echo_off),
					//'type' => lng_echo('light fighter type', no_file, echo_off), // "ATT"
					//'shortcut' => lng_echo('light fighter shortcut', no_file, echo_off), // "lJ"
					'description' => lng_echo('light fighter description', no_file, echo_off),
					'picture' => 'img/spaceshipExample.png',
								
					'loadingCapacity' => 50,
					'maxSpeed' => 1500,
					'maxRange' => 50,

					'attackStrength' => 5,
					'defenseStrength' => 5,

					'specialFunction' => '',

					'constructionTime' => (500 + 250)  * 1,

					'requiredIron' => 500,
					'requiredSilicon' => 250,
					'requiredWater' => 0,
					'requiredKarma' => 0,
					'requiredBots' => 1,
					
					'requiredTechLevelType' => array ( //require propulsion technology level 2
						1 => 0,	2 => 0,	3 => 2,	4 => 0,	5 => 0,	6 => 0,
						7 => 0,	8 => 0,	9 => 0,	10=> 0,	11=> 0,	12=> 0),

					'requiredLevelSpaceshipYard' => 3,

					'maxHold' => -1,
					'maxHoldPlanet' => -1
					)
			,2 => (object) array (
					'spaceshipID' => 2,
					
					'name' => lng_echo('heavy fighter name', no_file, echo_off),
					'namePlural' => lng_echo('heavy fighter name plural', no_file, echo_off),
					//'type' => lng_echo('heavy fighter type', no_file, echo_off), // "ATT"
					//'shortcut' => lng_echo('heavy fighter shortcut', no_file, echo_off), // "sJ"
					'description' => lng_echo('heavy fighter description', no_file, echo_off),
					'picture' => '',
								
					'loadingCapacity' => 100,
					'maxSpeed' => 1400,
					'maxRange' => 50,
		
					'attackStrength' => 15,
					'defenseStrength' => 10,
		
					'specialFunction' => '',
		
					'constructionTime' => (1150 + 525) * 2,
		
					'requiredIron' => 1150,
					'requiredSilicon' => 525,
					'requiredWater' => 100,
					'requiredKarma' => 0,
					'requiredBots' => 2,
					
					'requiredTechLevelType' => array ( //require propulsion technology level 4
						1 => 0,	2 => 0,	3 => 4,	4 => 0,	5 => 0,	6 => 0,
						7 => 0,	8 => 0,	9 => 0,	10=> 0,	11=> 0,	12=> 0),
		
					'requiredLevelSpaceshipYard' => 5,
		
					'maxHold' => -1,
					'maxHoldPlanet' => -1
					)
			,3 => (object) array (
					'spaceshipID' => 3,
					
					'name' => lng_echo('star cruiser name', no_file, echo_off),
					'namePlural' => lng_echo('star cruiser name plural', no_file, echo_off),
					//'type' => lng_echo('star cruiser type', no_file, echo_off),  // "ATT"
					//'shortcut' => lng_echo('star cruiser shortcut', no_file, echo_off), // "SK"
					'description' => lng_echo('star cruiser description', no_file, echo_off),
					'picture' => '',
								
					'loadingCapacity' => 800,
					'maxSpeed' => 1250,
					'maxRange' => 50,
		
					'attackStrength' => 40,
					'defenseStrength' => 25,
		
					'specialFunction' => '',
		
					'constructionTime' => (2850 + 1150 ) * 5,
		
					'requiredIron' => 2850,
					'requiredSilicon' => 1150,
					'requiredWater' => 375,
					'requiredKarma' => 0,
					'requiredBots' => 5,
					
					'requiredTechLevelType' => array ( //require laser technology level 6
						1 => 0,	2 => 0,	3 => 0,	4 => 0,	5 => 0,	6 => 0,
						7 => 0,	8 => 6,	9 => 0,	10=> 0,	11=> 0,	12=> 0),
		
					'requiredLevelSpaceshipYard' => 7,
		
					'maxHold' => -1,
					'maxHoldPlanet' => -1
				)
			,4 => (object) array (
					'spaceshipID' => 4,
					
					'name' => lng_echo('star destroyer name', no_file, echo_off),
					'namePlural' => lng_echo('star destroyer name plural', no_file, echo_off),
					//'type' => lng_echo('star destroyer type', no_file, echo_off), // "ATT"
					//'shortcut' => lng_echo('star destroyer shortcut', no_file, echo_off), // "Zer"
					'description' => lng_echo('star destroyer description', no_file, echo_off),
					'picture' => '',
								
					'loadingCapacity' => 1500,
					'maxSpeed' => 1000,
					'maxRange' => 50,
		
					'attackStrength' => 100,
					'defenseStrength' => 400,
		
					'specialFunction' => '',
		
					'constructionTime' => (7875 + 2675 ) * 13,
		
					'requiredIron' => 7875,
					'requiredSilicon' => 2675,
					'requiredWater' => 950,
					'requiredKarma' => 0,
					'requiredBots' => 13,
					
					'requiredTechLevelType' => array ( //require ion technology level 8
						1 => 0,	2 => 0,	3 => 0,	4 => 0,	5 => 0,	6 => 0,
						7 => 0,	8 => 0,	9 => 0,	10=> 0,	11=> 0,	12=> 8),
		
					'requiredLevelSpaceshipYard' => 9,
		
					'maxHold' => -1,
					'maxHoldPlanet' => -1
				)
			,5 => (object) array (
					'spaceshipID' => 5,
					
					'name' => lng_echo('small transport ship name', no_file, echo_off),
					'namePlural' => lng_echo('small transport ship name plural', no_file, echo_off),
					//'type' => lng_echo('small transport ship type', no_file, echo_off), // "TRAN"
					//'shortcut' => lng_echo('small transport ship shortcut', no_file, echo_off), // "kT"
					'description' => lng_echo('small transport ship description', no_file, echo_off),
					'picture' => '',
								
					'loadingCapacity' => 5000,
					'maxSpeed' => 1500,
					'maxRange' => 50,
		
					'attackStrength' => 1,
					'defenseStrength' => 10,
		
					'specialFunction' => 'trade',
		
					'constructionTime' => (425 + 300) * 1,
		
					'requiredIron' => 425,
					'requiredSilicon' => 300,
					'requiredWater' => 25,
					'requiredKarma' => 0,
					'requiredBots' => 1,
					
					'requiredTechLevelType' => array ( //require transportation technology level 2
						1 => 0,	2 => 0,	3 => 0,	4 => 0,	5 => 2,	6 => 0,
						7 => 0,	8 => 0,	9 => 0,	10=> 0,	11=> 0,	12=> 0),
		
					'requiredLevelSpaceshipYard' => 2,
		
					'maxHold' => -1,
					'maxHoldPlanet' => -1
				)
			,6 => (object) array (
					'spaceshipID' => 6,
					
					'name' => lng_echo('large transport ship name', no_file, echo_off),
					'namePlural' => lng_echo('large transport ship name plural', no_file, echo_off),
					//'type' => lng_echo('large transport ship type', no_file, echo_off), // "TRAN"
					//'shortcut' => lng_echo('large transport ship shortcut', no_file, echo_off), // "gT"
					'description' => lng_echo('large transport ship description', no_file, echo_off),
					'picture' => '',
								
					'loadingCapacity' => 25000,
					'maxSpeed' => 750,
					'maxRange' => 50,
		
					'attackStrength' => 3,
					'defenseStrength' => 40,
		
					'specialFunction' => 'trade',
		
					'constructionTime' => (1500 + 1100) * 3,
		
					'requiredIron' => 1500,
					'requiredSilicon' => 1100,
					'requiredWater' => 125,
					'requiredKarma' => 0,
					'requiredBots' => 3,
					
					'requiredTechLevelType' => array ( //require transportation technology level 4
						1 => 0,	2 => 0,	3 => 0,	4 => 0,	5 => 4,	6 => 0,
						7 => 0,	8 => 0,	9 => 0,	10=> 0,	11=> 0,	12=> 0),
		
					'requiredLevelSpaceshipYard' => 6,
		
					'maxHold' => -1,
					'maxHoldPlanet' => -1
				)
			,7 => (object) array (
					'spaceshipID' => 7,
					
					'name' => lng_echo('reconnaissance probe name', no_file, echo_off),
					'namePlural' => lng_echo('reconnaissance probe name plural', no_file, echo_off),
					//'type' => lng_echo('reconnaissance probe type', no_file, echo_off), // "SONDE"
					//'shortcut' => lng_echo('reconnaissance probe shortcut', no_file, echo_off), /// "AS"
					'description' => lng_echo('reconnaissance probe description', no_file, echo_off),
					'picture' => '',
								
					'loadingCapacity' => 0,
					'maxSpeed' => 25000,
					'maxRange' => 50,
		
					'attackStrength' => 0,
					'defenseStrength' => 0,
		
					'specialFunction' => 'scout',
		
					'constructionTime' => (160 + 90) * 1,
		
					'requiredIron' => 160,
					'requiredSilicon' => 90,
					'requiredWater' => 0,
					'requiredKarma' => 0,
					'requiredBots' => 1,
					
					'requiredTechLevelType' => array ( //require probe technology level 1
						1 => 1,	2 => 0,	3 => 0,	4 => 0,	5 => 0,	6 => 0,
						7 => 0,	8 => 0,	9 => 0,	10=> 0,	11=> 0,	12=> 0),
		
					'requiredLevelSpaceshipYard' => 1,
		
					'maxHold' => -1,
					'maxHoldPlanet' => -1
				)
			,8 => (object) array (
					'spaceshipID' => 8,
					
					'name' => lng_echo('spy probe name', no_file, echo_off),
					'namePlural' => lng_echo('spy probe name plural', no_file, echo_off),
					//'type' => lng_echo('spy probe type', no_file, echo_off), // "SONDE"
					//'shortcut' => lng_echo('spy probe shortcut', no_file, echo_off), // "Spio"
					'description' => lng_echo('spy probe description', no_file, echo_off),
					'picture' => '',
								
					'loadingCapacity' => 0,
					'maxSpeed' => 100000,
					'maxRange' => 50,
		
					'attackStrength' => 0,
					'defenseStrength' => 0,
		
					'specialFunction' => 'spy',
		
					'constructionTime' => (60 + 125) * 1,
		
					'requiredIron' => 60,
					'requiredSilicon' => 125,
					'requiredWater' => 15,
					'requiredKarma' => 0,
					'requiredBots' => 1,
					
					'requiredTechLevelType' => array ( //require probe technology level 5
						1 => 5,	2 => 0,	3 => 0,	4 => 0,	5 => 0,	6 => 0,
						7 => 0,	8 => 0,	9 => 0,	10=> 0,	11=> 0,	12=> 0),
		
					'requiredLevelSpaceshipYard' => 4,
		
					'maxHold' => -1,
					'maxHoldPlanet' => -1
				)
			,9 => (object) array (
					'spaceshipID' => 9,
					
					'name' => lng_echo('colonization ship name', no_file, echo_off),
					'namePlural' => lng_echo('colonization ship name plural', no_file, echo_off),
					//'type' => lng_echo('colonization ship type', no_file, echo_off), // "SPEZ"
					//'shortcut' => lng_echo('colonization ship shortcut', no_file, echo_off), // "Kolo"
					'description' => lng_echo('colonization ship description', no_file, echo_off),
					'picture' => '',
								
					'loadingCapacity' => 7500,
					'maxSpeed' => 250,
					'maxRange' => 50,
		
					'attackStrength' => 5,
					'defenseStrength' => 50,
		
					'specialFunction' => 'colonization',
		
					'constructionTime' => (3750 + 4500) * 12,
		
					'requiredIron' => 3750,
					'requiredSilicon' => 4500,
					'requiredWater' => 1880,
					'requiredKarma' => 0,
					'requiredBots' => 12,
					
					'requiredTechLevelType' => array ( //require propulsion technology level 8
						1 => 0,	2 => 0,	3 => 8,	4 => 0,	5 => 0,	6 => 0,
						7 => 0,	8 => 0,	9 => 0,	10=> 0,	11=> 0,	12=> 0),
		
					'requiredLevelSpaceshipYard' => 8,
		
					'maxHold' => -1,
					'maxHoldPlanet' => -1
				)
			,10 => (object) array (
					'spaceshipID' => 10,
					
					'name' => lng_echo('salvage ship name', no_file, echo_off),
					'namePlural' => lng_echo('salvage ship name plural', no_file, echo_off),
					//'type' => lng_echo('salvage ship type', no_file, echo_off), // "SPEZ"
					//'shortcut' => lng_echo('salvage ship shortcut', no_file, echo_off), // "BS"
					'description' => lng_echo('salvage ship description', no_file, echo_off),
					'picture' => '',
								
					'loadingCapacity' => 25,
					'maxSpeed' => 1500,
					'maxRange' => 50,
		
					'attackStrength' => 0,
					'defenseStrength' => 0,
		
					'specialFunction' => 'rescue',
		
					'constructionTime' => (1750 + 750) * 1,
		
					'requiredIron' => 1750,
					'requiredSilicon' => 750,
					'requiredWater' => 500,
					'requiredKarma' => 0,
					'requiredBots' => 1,
					
					'requiredTechLevelType' => array ( //require recycling technology level 1
						1 => 0,	2 => 0,	3 => 0,	4 => 0,	5 => 0,	6 => 0,
						7 => 1,	8 => 0,	9 => 0,	10=> 0,	11=> 0,	12=> 0),
		
					'requiredLevelSpaceshipYard' => 10,
		
					'maxHold' => -1,
					'maxHoldPlanet' => -1
				)
			,11 => (object) array (
					'spaceshipID' => 11,
					
					'name' => lng_echo('shuttle name', no_file, echo_off),
					'namePlural' => lng_echo('shuttle name plural', no_file, echo_off),
					//'type' => lng_echo('shuttle type', no_file, echo_off), // "SPEZ"
					//'shortcut' => lng_echo('shuttle shortcut', no_file, echo_off), // "STS"
					'description' => lng_echo('shuttle description', no_file, echo_off),
					'picture' => '',
								
					'loadingCapacity' => 0,
					'maxSpeed' => 1200,
					'maxRange' => 50,
		
					'attackStrength' => 0,
					'defenseStrength' => 0,
		
					'specialFunction' => 'bot',
		
					'constructionTime' => (2000 + 2000) * 1,
		
					'requiredIron' => 2000,
					'requiredSilicon' => 2000,
					'requiredWater' => 2000,
					'requiredKarma' => 0,
					'requiredBots' => 1,
					
					'requiredTechLevelType' => array ( //require probe & transportation technology level 10
						1 =>10,	2 => 0,	3 => 0,	4 => 0,	5 =>10,	6 => 0,
						7 => 0,	8 => 0,	9 => 0,	10=> 0,	11=> 0,	12=> 0),
		
					'requiredLevelSpaceshipYard' => 10,
		
					'maxHold' => -1,
					'maxHoldPlanet' => -1
				)
			,12 => (object) array (
					'spaceshipID' => 12,
					
					'name' => lng_echo('dimension tide name', no_file, echo_off),
					'namePlural' => lng_echo('dimension tide name plural', no_file, echo_off),
					//'type' => lng_echo('dimension tide type', no_file, echo_off), // "SPEZ"
					//'shortcut' => lng_echo('dimension tide shortcut', no_file, echo_off), // "DT"
					'description' => lng_echo('dimension tide description', no_file, echo_off),
					'picture' => '',
								
					'loadingCapacity' => 0,
					'maxSpeed' => 50,
					'maxRange' => 50,
		
					'attackStrength' => 100000000,
					'defenseStrength' => 20,
		
					'specialFunction' => 'bot',
		
					'constructionTime' => 800,
		
					'requiredIron' => 20000000,
					'requiredSilicon' => 20000000,
					'requiredWater' => 20000000,
					'requiredKarma' => 1000,
					'requiredBots' => 150,
					
					'requiredTechLevelType' => array ( 
						1 =>10,	2 =>10,	3 =>10,	4 =>10,	5 =>10,	6 =>10,
						7 =>10,	8 =>10,	9 =>10,	10=>10,	11=>10,	12=>10),
		
					'requiredLevelSpaceshipYard' => 20,
		
					'maxHold' => -1,
					'maxHoldPlanet' => -1
					)
			];
	}
}

spaceships::init();
//shipspace::$name = 'umpf';
$temp=spaceships::$shipID[1];
$temp=spaceships::$shipID[1]->name;
$temp=spaceships::$shipID;
$temp=spaceships::$shipID[1]->requiredTechLevelType;
$temp=spaceships::$shipID[1]->requiredTechLevelType[3];
$temp=spaceships::$shipID[1]->requiredTechLevelType;
?>