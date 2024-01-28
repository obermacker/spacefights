<?php
/* begin: error handling */

error_reporting(E_ERROR);
mysqli_report(MYSQLI_REPORT_STRICT);
set_exception_handler('catchExeption');

//set_exception_handler(null);
//$test = 1/0;

function shortenPath($_file){
	$_file = str_replace('\\','/',$_file);
	return substr($_file,strpos($_file,'/galaxy'));
}

function catchExeption($ex) {
	?><!DOCTYPE html>
	<body>
		<style>
			@keyframes animation_blink {0% { border-color:red; } 50% { border-color:black;}}
			body {font-size: 80%;}
			.GuruMeditation {font-family: Lucida Grande,Lucida Sans Unicode,Lucida Sans,Geneva,Verdana,sans-serif; color:red;
								padding: 10pt; margin: 10pt 10pt 10pt 10pt; Border: 4pt; border-color: red; border-style: solid;
								animation-name: animation_blink; animation-timing-function: step-end; animation-duration: 2s; animation-iteration-count: infinite;}
			.GuruMeditation p {font-family: Arial, sans-serif; margin: 5pt 0pt 15pt 0pt; font-size: 200%; font-weight: bold;}
			.GuruMeditation .left {margin-left: 5pt; float: left;}
			.GuruMeditation .right {margin-right: 5pt; float: right;}
			.GuruMeditation .sqlError {display: flex; float: left;}
			.GuruMeditation .headLine {width:100%; display:flow-root;}
			.GuruMeditation .traceRow {padding:2pt 5pt 2pt 5pt; display:flex;}
			.GuruMeditation .traceCol1 {float:left; width:30%;}
			.GuruMeditation .traceCol2 {float:left; width:25%;}
			.GuruMeditation .traceCol3 {float:left; width:45%;}
			.GuruMeditation .traceCol23 {float:left; width:70%;}
			.GuruMeditationContainer {margin:auto; width: 100%; min-width: 890px; max-width: 1218px;}
			.GuruMeditationContainer td {vertical-align: text-top;padding: 3pt 2pt 2pt 3pt;}
		</style>
		<div id=hiddenContainer style=display:none;>
			<div class=GuruMeditationContainer>
				<div class=GuruMeditation>
					<div class=headLine>
						<p class=left>Guru Meditation</p>
						<p class=right><?php if (get_class($ex)=='Exception') {echo explode('\\',$ex->getMessage())[0];}else{echo get_class($ex);} ?></p>
					</div>
					<div class=tracing>
						<?php
						if (get_class($ex)=='Exception') {$_message = explode('\\',$ex->getMessage())[1];} else {$_message = explode('\\',$ex->getMessage())[0];}

						$_showLastRow=true;

						foreach (array_reverse($ex->getTrace()) as $_key => $_value){
							switch (true) {
								case $_value['function'] == 'sql_error':
									?>
									<div class=traceRow>
										<div class=traceCol1 style=text-indent:<?= $_key; ?>em;><?= shortenPath($_value['file'].':'.$_value['line']); ?></div>
										<div class=traceCol23>
											<div class=sqlError style=width:55pt;><b><?= explode('\\',$ex->getMessage())[0]; ?></b></div>
											<div class=sqlError style=width:90.5%;><?= explode('\\',$ex->getMessage())[1]; ?></div>
										</div>
									</div>
									<?php
									$_showLastRow=false;
									break;

								case $_value['function'] == 'our_sql_query' and get_class($ex)=='Exception':
									if (explode('\\',$ex->getMessage())[1]==''){
										?>
										<div class=traceRow>
										<div class=traceCol1 style=text-indent:<?= $_key; ?>em;><?= shortenPath($_value['file']).':'.$_value['line']; ?></div>
										<div class=traceCol23>
											<div class=sqlError style=width:100%;><b><?= explode('\\',$ex->getMessage())[0]; ?></b></div>
											<div class=sqlError style=width:55pt;margin-top:5pt;><b>query</b></div>
											<div class=sqlError style=width:90.5%;margin-top:5pt;><?= $_value['args'][1]; ?></div>
										</div>
										<?php
									} else {
										?>
										<div class=traceRow>
										<div class=traceCol1 style=text-indent:<?= $_key; ?>em;><?= shortenPath($_value['file']).':'.$_value['line']; ?></div>
										<div class=traceCol23>
											<div class=sqlError style=width:55pt;><b><?= explode('\\',$ex->getMessage())[0]; ?></b></div>
											<div class=sqlError style=width:90.5%;><?= explode('\\',$ex->getMessage())[1]; ?></div>
											<div class=sqlError style=width:55pt;margin-top:5pt;><b>query</b></div>
											<div class=sqlError style=width:90.5%;margin-top:5pt;><?= $_value['args'][1]; ?></div>
										</div>
										<?php
									}
									$_showLastRow=false;
									break;

								default:
									$_showLastRow=true;
									?>
									<div class=traceRow>
										<div class=traceCol1 style=text-indent:<?= $_key; ?>em;><?= shortenPath($_value['file']).':'.$_value['line'] ?></div>
										<div class=traceCol2><?= $_value['function'] ?></div>
										<div class=traceCol3>
											<?php
											if (shortenPath($ex->getFile()).$ex->getLine() != shortenPath($_value['file']).$_value['line']){
												foreach ($_value['args'] as $_i => $_args){
													if (is_object($_args)) {
														echo '['.$_i.']&nbsp;&nbsp;&nbsp;[object of class:&nbsp;&nbsp;'.get_class($_args).']<br>';
													} elseif ($_value['function'] == 'require') {
														echo '['.$_i.']&nbsp;&nbsp;&nbsp;'.shortenPath($_args).'<br>';
													} else {
														echo '['.$_i.']&nbsp;&nbsp;&nbsp;'.$_args.'<br>';
													}
												}
											} else {
												echo $_message;
												$_showLastRow=false;
											}
											?>
										</div>
									</div>
									<?php
							}
						}
						if ($_showLastRow) {
							if (shortenPath($ex->getFile()).$ex->getLine() != shortenPath($ex->getTrace()[0]['file']).$ex->getTrace()[0]['line']) {
								?>
								<div class=traceRow>
									<div class=traceCol1 style=text-indent:<?= $_key+1 ?>em;><?= shortenPath($ex->getFile()).':'.$ex->getLine() ?></div>
									<div class=traceCol23><?= $_message ?></div>
								</div>
								<?php
							} else {
								?>
								<div class=traceRow><div class=traceCol1></div><div class=traceCol23><?= $_message ?></div></div>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<script>
			document.body.innerHTML = document.getElementById('hiddenContainer').innerHTML + document.body.innerHTML;
			document.body.style.backgroundColor="black";
			document.body.style.color="white";
		</script>
	</body>
	<?php

	// Fatal error: Uncaught mysqli_sql_exception: Access denied for user 'db12333748-03'@'localhost' to database 'galaxy1' in /is/htdocs/wp12333748_UM2R2512W7/www/sfplus/galaxy1/inc/func_galaxy.php:2349 Stack trace: #0 /is/htdocs/wp12333748_UM2R2512W7/www/sfplus/galaxy1/inc/func_galaxy.php(2349): mysqli_select_db(Object(mysqli), 'galaxy1') #1 /is/htdocs/wp12333748_UM2R2512W7/www/sfplus/galaxy1/inc/nachrichten.php(49): get_message('c3209e2c7309423...', 'c3209e2c7309423...', 'ES') #2 /is/htdocs/wp12333748_UM2R2512W7/www/sfplus/galaxy1/index.php(807): require('/is/htdocs/wp12...') #3 {main} thrown in /is/htdocs/wp12333748_UM2R2512W7/www/sfplus/galaxy1/inc/func_galaxy.php on line 2349
	// PHP Fatal error:  Uncaught Error: Undefined constant "args" in C:\\Users\\AGCS\\#GIT#\\spacefights.2023\\galaxy1\\inc\\debug.php:38\nStack trace:\n#0 [internal function]: catchExeption(Object(Exception))\n#1 {main}\n  thrown in C:\\Users\\AGCS\\#GIT#\\spacefights.2023\\galaxy1\\inc\\debug.php on line 38, referer: http://agcs-pc.fritz.box/galaxy1/index.php?s=Raumschiffe
	// PHP Fatal error:  Uncaught mysqli_sql_exception: Unknown database 'spieler' in C:\\Users\\AGCS\\#GIT#\\spacefights\\inc\\connect_spieler.php:3\nStack trace:\n#0 C:\\Users\\AGCS\\#GIT#\\spacefights\\inc\\connect_spieler.php(3): mysqli_connect('localhost', 'root', Object(SensitiveParameterValue), 'spieler')\n#1 C:\\Users\\AGCS\\#GIT#\\spacefights\\login.php(6): require('C:\\\\Users\\\\AGCS\\\\#...')\n#2 {main}\n  thrown in C:\\Users\\AGCS\\#GIT#\\spacefights\\inc\\connect_spieler.php on line 3, referer: http://sf.localhost/
	error_log('PHP error: '.$ex->getMessage().' in '.$ex->getFile().':'.$ex->getLine().'\nStack trace:\n'.$ex->getTrace());

	//syslog(11,$message);
	//header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	//die($message);

	//throw new Exception("Oh nein, ein Fehler!",33);
	//echo "Alles ok!";
	die;
}

/* end: error handling */


define ('no_file',false); 				define ('echo_off',false);
define ('open_file',true);				define ('echo_on',true);
define ('must_have_results',false); 	define ('no_result_allowed',true);
define ('max_one_result',1); 			define ('no_limit_of_results',0);

use phpbb\notification\method\email;

function sql_error ($error){
	throw new exception ('SQL Error\\'.$error);
}

function our_sql_query ($_link,$_query,$_noRows=no_result_allowed,$_maxRows=no_limit_of_results){
	$_result = mysqli_query($_link,$_query) or throw new exception ('SQL Error\\'.mysqli_error($_link));
	if (!$_noRows and $_result->num_rows == 0) {throw new Exception('SQL Warning: Found no Rows');}
	if ($_maxRows != no_limit_of_results and $_result->num_rows > $_maxRows) {throw new Exception('SQL Warning: More Than '.$_maxRows.' Rows\\'.$query);}
	return $_result;
}

function get_timestamp_in_was_lesbares($value) {	// old function
	return format_timestamp($value);
}

function format_timestamp($_value) {
	return date('d.m.Y H:i:s', round($_value,0));
}

function get_rangliste($spieler_id) {
	require 'inc/connect_galaxy_1.php';

	$sql = "SELECT `Spieler_Name`, SUM(`punkte_structur` + `punkte_flotte` + `punkte_forschung`) AS Punkte FROM `spieler` GROUP BY `Spieler_Name` ORDER BY Punkte DESC";

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

	if($result = mysqli_query($link, $query)) {
		$i = 0;
		while($row = mysqli_fetch_object($result)) {
			$punkte[$i]["Name"] = $row->Spieler_Name;
			$punkte[$i]["Punkte"] = $row->Punkte;
			$i++;
		}

		return $punkte;

	} else {
		return false;
	}


}

function get_Spielerliste($spieler_id) {
	require 'inc/connect_galaxy_1.php';

	$sql = "SELECT `Spieler_Name` FROM `spieler` WHERE `Spieler_ID` <> '$spieler_id'";

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

	$spieler["Error"] = false;
	$spieler["Message"] = "";

	if($result = mysqli_query($link, $query)) {
		$i = 0;
		while($row = mysqli_fetch_object($result)) {
			$spieler["result"][$i]["Name"] = $row->Spieler_Name;
			$i++;
		}

		return $spieler;

	} else {

		$spieler["Error"] = true;
		$spieler["Message"] = "Keine Spieler vorhanden";

		return $spieler;
	}


}

function get_liste_planeten_im_system($px, $py, $spieler_id) {

	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");

	$abfrage = "SELECT `Spieler_ID`, `Spieler_Name`, `Planet_Name`, `z` FROM `planet` WHERE `x` = $px AND `y` = $py";
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_liste_planeten_im_system #1 ".$link));

	if(!$result = mysqli_query($link, $query)) { die("fehler"); }

	$Systeme["vorhanden"] = false;
	$Systeme["eigenes_system"] = false;
	while($row = mysqli_fetch_object($result)) {
		$id = $row->z;
		$Systeme[$id]["Spieler"] = $row->Spieler_Name;
		$Systeme[$id]["Planet"]= $row->Planet_Name;
		$Systeme["vorhanden"] = true;
		if($row->Spieler_ID == $spieler_id) { $Systeme["eigenes_system"] = true; }
	}

	for($i = 1; $i <= 12; $i++) {

		if(!isset($Systeme[$i])) {
			$Systeme[$i]["Spieler"] = "";
			$Systeme[$i]["Planet"]= "";
		}

	}


	return $Systeme;


}

function get_defense_count (){
	return get_config_defense(0)['defense count'];
}

function get_defense($defense_id) {
	return get_config_defense($defense_id);
}

function get_structure_level($_player_id, $_planet_id, $_structure_id) {

	require 'inc/connect_galaxy_1.php';

	$query = 'SELECT Stufe_Gebaeude_1, Stufe_Gebaeude_2, Stufe_Gebaeude_3, Stufe_Gebaeude_4, Stufe_Gebaeude_5, Stufe_Gebaeude_6, Stufe_Gebaeude_7, Stufe_Gebaeude_8, Stufe_Gebaeude_9, Stufe_Gebaeude_10, Stufe_Gebaeude_11 FROM planet WHERE Spieler_ID = \''.$_player_id.'\' AND Planet_ID = '.$_planet_id;
	$row = mysqli_fetch_object(our_sql_query($link,$query,must_have_results,max_one_result));
	$column = "Stufe_Gebaeude_".$_structure_id;
	$Player['playerID']='122334555';

	return $row->$column;
}

function random_float ($min,$max) {
	return ($min+lcg_value()*(abs($max-$min)));
}

function set_construction_loop_structure($_loopData){

	require 'inc/connect_galaxy_1.php';

	$_loopData->planetResourcesIron  	-= $_loopData->structureCostIron;
	$_loopData->planetResourcesSilicon	-= $_loopData->structureCostSilicon;
	$_loopData->planetResourcesWater	-= $_loopData->structureCostWater;
	$_loopData->planetResourcesEnergy	-= $_loopData->structureCostEnergy;
	$_loopData->playerResourcesKarma	-= $_loopData->structureCostKarma;   // later save at player dataset

	$_ds = new datasetPlanet;

	$_query = 'UPDATE '.$_ds::table.' SET '
				.$_ds::constructionLoopStart.			' = \''.time().'\', '
				.$_ds::constructionLoopUntil.			' = \''.$_loopData->constructionLoopUntil.'\', '
				.$_ds::constructionLoopStructureID.		' = \''.$_loopData->constructionLoopStructureID.'\', '
				.$_ds::constructionLoopStructureName.	' = \''.$_loopData->constructionLoopStructureName.'\', '
				.$_ds::resourcesAvailable[iron].				' = \''.$_loopData->planetResourcesIron.'\', '
				.$_ds::resourcesAvailable[silicon].			' = \''.$_loopData->planetResourcesSilicon.'\', '
				.$_ds::resourcesAvailable[water].			' = \''.$_loopData->planetResourcesWater.'\', '
				.$_ds::resourcesAvailable[energy].			' = \''.$_loopData->planetResourcesEnergy.'\' '
				.'WHERE	'.$_ds::playerID.' = \''.$_loopData->playerID.'\' '
					.'AND '.$_ds::planetID.' = \''.$_loopData->planetID.'\'';

	our_sql_query($link,$_query);

	// send Message to User //
	$_message = lng_echo ('contruction loop structure started', no_file, echo_off
							,array('structure_name' => $_loopData->constructionLoopStructureName , 'loop_until' => format_timestamp($_loopData->constructionLoopUntil)));
	set_message(0, "System", $_loopData->playerID, $_loopData->playerName, "set_construction_loop_structure", $_message, 0, 1, 0);
}


function set_bauschleife_tech($spieler_id, $planet_id, $tech_id, $tech_name, $bauStart, $bauzeit, $ressource_eisen, $ressource_silizium, $ressource_wasser, $ressource_karma, $kosten_eisen, $kosten_silizium, $kosten_wasser, $kosten_karma, $username) {
	require 'inc/connect_galaxy_1.php';

	$ressource_eisen = $ressource_eisen - $kosten_eisen;
	$ressource_silizium  = $ressource_silizium - $kosten_silizium;
	$ressource_wasser = $ressource_wasser - $kosten_wasser;
	$ressource_karma = $ressource_karma  - $kosten_karma;
	$bauzeit = $bauzeit;

	//$abfrage = "UPDATE `planet` SET `Bauschleife_Gebaeude_ID` = $gebäude_id, SET `Bauschleife_Gebaeude_Bis` = " . $time() + $bauzeit . " FROM  WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$abfrage = "UPDATE `planet` SET `Ressource_Eisen`= '$ressource_eisen', `Ressource_Silizium`= '$ressource_silizium', `Ressource_Wasser`= '$ressource_wasser', `Ressource_Karma`= '$ressource_karma' WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

	if (mysqli_query($link, $query)) {


		$abfrage = "UPDATE `spieler` SET `Tech_Schleife_ID` = $tech_id, `Tech_Schleife_Name` = '$tech_name', `Tech_Schleife_Bauzeit_Bis` = $bauzeit, `Tech_Schleife_Bauzeit_Start` = $bauStart  WHERE `Spieler_ID` = '$spieler_id'";

		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_tech #1 ".$link));

		if (mysqli_query($link, $query)) {

			$text =  $tech_name . " wird geforscht. Forschung geplant bis " . get_timestamp_in_was_lesbares($bauzeit);
			set_message(0, "System", $spieler_id, $username, "set_bauschleife_tech", $text, 0, 1, 0);

			} else {
				die("Fehler in der Bauschleife: " . mysqli_error($link));
			}

	} else {
		die("Fehler in der Bauschleife: " . mysqli_error($link));
	}



}

function get_letzte_bauschleife_ship($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT `Bauzeit_Bis` FROM `bauschleifeflotte` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = '$planet_id' ORDER BY Bauzeit_Bis DESC";
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_letzte_bauschleife_ship #1 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row = mysqli_fetch_object($result);



	if(isset($row->Bauzeit_Bis)) {
		if ($row->Bauzeit_Bis < time()) { //Fallback für den Fall das eine Bauschleife nicht beeendet werden kann
			return time();
		} else {
			return $row->Bauzeit_Bis;
		}

	} else { return time(); }


}

function get_end_of_last_defense_construction_loop ($player_id, $planet_id) { 		// ex-function: get_letzte_bauschleife_deff
	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT `construction_time_end` FROM `construction_loops_defense` WHERE `player_id` = '$player_id' AND `planet_id` = '$planet_id' ORDER BY construction_time_end DESC";
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_letzte_bauschleife_ship #1 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row = mysqli_fetch_object($result);

	if(isset($row->construction_time_end)) {
		if ($row->construction_time_end < time()) { 		// Fallback for the case that a construction loop can not be stopped
			return time();
		} else {
			return $row->construction_time_end;
		}
	} else {
		return time();
	}
}


function set_bauschleife_ship($spieler_id, $planet_id, $ship_id, $ship_name, $anzahl, $bauzeit, $ressource_eisen, $ressource_silizium, $ressource_wasser, $ressource_bot, $ressource_karma, $kosten_eisen, $kosten_silizium, $kosten_wasser, $kosten_bot, $kosten_karma) {

	require 'inc/connect_galaxy_1.php';

	$von = get_letzte_bauschleife_ship($spieler_id, $planet_id);
	$bis = $von + ($anzahl * $bauzeit);

	$abfrage = "INSERT INTO `bauschleifeflotte` (
			`ID`,
			`Spieler_ID`,
			`Planet_ID`,
			`Typ`,
			`Eisen`,
			`Silizium`,
			`Wasser`,
			`Karma`,
			`Name`,
			`Anzahl`,
			`Bauzeit_Von`,
			`Bauzeit_Einzel`,
			`Bauzeit_Bis`)
			VALUES (NULL,
			'$spieler_id',
			'$planet_id',
			'$ship_id',
			'$kosten_eisen',
			'$kosten_silizium',
			'$kosten_wasser',
			'$kosten_karma',
			'$ship_name',
			'$anzahl',
			'$von',
			'$bauzeit',
			'$bis')";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_ship #1 ".$link));

	if (mysqli_query($link, $query)) {
		// Ress aufn Planni aktualisiseren


		$ressource_eisen = $ressource_eisen - ($kosten_eisen * $anzahl);
		$ressource_silizium  = $ressource_silizium - ($kosten_silizium * $anzahl);
		$ressource_wasser = $ressource_wasser - ($kosten_wasser * $anzahl);
		$ressource_karma = $ressource_karma  - ($kosten_karma * $anzahl);
		$ressource_bot = $ressource_bot - ($kosten_bot * $anzahl);
		$bauzeit = $bauzeit;

		//$abfrage = "UPDATE `planet` SET `Bauschleife_Gebaeude_ID` = $gebäude_id, SET `Bauschleife_Gebaeude_Bis` = " . $time() + $bauzeit . " FROM  WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

		$abfrage = "UPDATE `planet` SET `Ressource_Eisen`= '$ressource_eisen', `Ressource_Silizium`= '$ressource_silizium', `Ressource_Wasser`= '$ressource_wasser', `Ressource_Karma`= '$ressource_karma', `Ressource_Bot` = $ressource_bot WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

		if (mysqli_query($link, $query)) {
			//echo "Gebäude eingereiht <br>$abfrage<br>";
		} else {
			die("Fehler in der Bauschleife: " . mysqli_error($link));
		}


	} else {
		die("Fehler in der set_bauschleife_ship: " . mysqli_error($link));
	}

}

function set_defense_construction_loop ($player_id, $planet_id, $quantity, $defense) { 	// ex-function: set_bauschleife_deff

	$resources = get_ressource($player_id, $planet_id);

	// -------------- only for the time , if all variables are translated !!! ------------------ //
			$resources = german_res_to_english_res ($resources);
	// -------------- only for the time , if all variables are translated !!! ------------------ //

	require 'inc/connect_galaxy_1.php';

	$start_time = get_end_of_last_defense_construction_loop ($player_id, $planet_id);
	$end_time = $start_time + ($quantity * $defense['construction time']);

	$abfrage = "INSERT INTO `construction_loops_defense` (`id`, `player_id`, `planet_id`, `defense_id`, `required_iron`, `required_silicon`, `required_water`, `required_karma`, `required_bots`,`name`, `quantity`, `construction_time_start`, `construction_time`, `construction_time_end`) VALUES (NULL, '" . $player_id . "'," . $planet_id . "," . $defense['defense id'] . "," . $defense['required iron'] . "," . $defense['required silicon'] . "," . $defense['required water'] . "," . $defense['required karma'] . "," . $defense['required bots'] . ",'" . $defense['name'] . "'," . $quantity . "," . $start_time . "," . $defense['construction time'] . "," . $end_time . ")";
	$query  = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_ship #1 ".$link));
	mysqli_query($link, $query) or sql_error(mysqli_error($link));

	//  set resources on planet to new values
	$resources['iron'] 	-= ($defense['required iron'] * $quantity);
	$resources['silicon'] 	-= ($defense['required silicon'] * $quantity);
	$resources['water']	-= ($defense['required water'] * $quantity);
	$resources['karma']	-= ($defense['required karma'] * $quantity);
	$resources['bots']	-= ($defense['required bots'] * $quantity);

	$abfrage = "UPDATE `planet` SET `Ressource_Eisen`= " . $resources['iron'] . ", `Ressource_Silizium`= " . $resources['silicon'] . ", `Ressource_Wasser`= " . $resources['water'] . ", `Ressource_Karma`= " . $resources['karma'] . ", `Ressource_Bot` = " . $resources['bots'] . " WHERE `Spieler_ID` = '" . $player_id . "' AND `Planet_ID` = " . $planet_id;
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
	mysqli_query($link, $query) or sql_error(mysqli_error($link));
}


function get_existing_defense($player_id, $planet_id, $defense_id) {		// ex-function: get_deff_in_Besitz

	require 'inc/connect_galaxy_1.php';

	$existing_defense['planet'] = 0;
	$existing_defense['galaxy'] = 0;

	$tabelle = "Deff_Typ_" . $defense_id;

	//this planet
	$query = "SELECT SUM(`$tabelle`) AS total FROM (SELECT `Spieler_ID`, `Planet_ID`, `$tabelle` FROM `planet` WHERE `Spieler_ID` = '$player_id' AND `Planet_ID` = $planet_id) x";
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

	$row = mysqli_fetch_object($result);
	$existing_defense["planet"] += $row->total;


	//this planet construction loops
	$query = "SELECT SUM(`quantity`) AS total FROM (SELECT `player_id`, `planet_id`, `defense_id` , `quantity` FROM `construction_loops_defense` WHERE `defense_id` = '$defense_id' AND `player_id` = '$player_id' AND `planet_id` = $planet_id) x";
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

	$row = mysqli_fetch_object($result);
	$existing_defense["planet"] += $row->total;


	//this galaxy
	$query = "SELECT SUM(`$tabelle`) AS total FROM (SELECT `Spieler_ID`, `Planet_ID`, `$tabelle` FROM `planet` WHERE `Spieler_ID` = '$player_id') x";
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

	$row = mysqli_fetch_object($result);
	$existing_defense["galaxy"] += $row->total;


	//this galaxy construction loops

	$query = "SELECT SUM(`quantity`) AS total FROM (SELECT `player_id`, `planet_id`, `defense_id`, `quantity` FROM `construction_loops_defense` WHERE `defense_id` = '$defense_id' AND `player_id` = '$player_id') x";
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

	$row = mysqli_fetch_object($result);
	$existing_defense["galaxy"] += $row->total;

	return $existing_defense;
}


function get_schiffe_in_Besitz($spieler_id, $planet_id, $ship_id) {
	$tabelle = "Schiff_Typ_" . $ship_id;

	//aktuelle Planet
	$sql_planet = "SELECT `Spieler_ID`, `Planet_ID`, `$tabelle` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	$sql_summe_planet = "SELECT SUM(`$tabelle`) AS summe_planet FROM ($sql_planet) x";
	//aktuelle Planet Bauschleife


	$sql_planet_bauschleife = "SELECT `Spieler_ID`, `Planet_ID`, `Typ` , `Anzahl` FROM `bauschleifeflotte` WHERE `Typ` = '$ship_id' AND `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	$sql_summe_planet_bauschleife = "SELECT SUM(`Anzahl`) AS summe_planet_bauschleife FROM ($sql_planet_bauschleife) x";

	//aktuelle Galaxy
	$sql_galaxy = "SELECT `Spieler_ID`, `Planet_ID`, `$tabelle` FROM `planet` WHERE `Spieler_ID` = '$spieler_id'";
	$sql_summe_galaxy = "SELECT SUM(`$tabelle`) AS summe_galaxy FROM ($sql_galaxy) x";

	$sql_galaxy_bauschleife = "SELECT `Spieler_ID`, `Planet_ID`, `Typ`, `Anzahl` FROM `bauschleifeflotte` WHERE `Typ` = '$ship_id' AND `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	$sql_summe_galaxy_bauschleife = "SELECT SUM(`Anzahl`) AS summe_galaxy_bauschleife FROM ($sql_galaxy_bauschleife) x";

	$schiff_in_Besitz["Planet"] = 0;
	$schiff_in_Besitz["Galaxy"] = 0;

	require 'inc/connect_galaxy_1.php';

	if($row_summe_planet = mysqli_query($link, $sql_summe_planet)) {

		$result = mysqli_fetch_object($row_summe_planet);
		$schiff_in_Besitz["Planet"] = $schiff_in_Besitz["Planet"] + $result->summe_planet;

	} else {

		die("Fehler in der Bauschleife: " . mysqli_error($link));
	}

	if($row_summe_planet_bauschleife = mysqli_query($link, $sql_summe_planet_bauschleife)) {

		$result = mysqli_fetch_object($row_summe_planet_bauschleife);
		$schiff_in_Besitz["Planet"] = $schiff_in_Besitz["Planet"] + $result->summe_planet_bauschleife;

	} else {

		die("Fehler in der Bauschleife: " . mysqli_error($link));
	}


	if($row_summe_galaxy = mysqli_query($link, $sql_summe_galaxy)) {

		$result = mysqli_fetch_object($row_summe_galaxy);
		$schiff_in_Besitz["Galaxy"] = $schiff_in_Besitz["Galaxy"] + $result->summe_galaxy;


	} else {

		die("Fehler in der Bauschleife: " . mysqli_error($link));
	}


	if($row_summe_galaxy_bauschleife = mysqli_query($link, $sql_summe_galaxy_bauschleife)) {

		$result = mysqli_fetch_object($row_summe_galaxy_bauschleife);
		$schiff_in_Besitz["Galaxy"] = $schiff_in_Besitz["Galaxy"] + $result->summe_galaxy_bauschleife;

	} else {

		die("Fehler in der Bauschleife: " . mysqli_error($link));
	}


	return $schiff_in_Besitz;



	//

}

function set_bauschleife_ship_fertig($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	// erstmal alle auschecken die komplett sind

	$abfrage = "SELECT `ID`, `Typ`, `Spieler_ID`, `Planet_ID`, `Name`, `Anzahl`, `Bauzeit_Von`, `Bauzeit_Einzel`, `Bauzeit_Bis` FROM `bauschleifeflotte`  WHERE `Bauzeit_Bis` <= " . time() . " AND `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_ship_fertig ".$link));
	$result_bauschleifeflotte = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));

	while($row = mysqli_fetch_object($result_bauschleifeflotte)) {

		//schauen wie viele vom Typ sind stationiert

		$tabelle = "Schiff_Typ_" . $row->Typ;
		$abfrage_planet = "SELECT `$tabelle`, `Stationiert_Bot`, `Planet_Name` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
			$query = $abfrage_planet  or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_ship_fertig ".$link));
			$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
			$row_planet = mysqli_fetch_object($result);
			$schiffe_ist = $row_planet->$tabelle;
			$_planetName = $row_planet->Planet_Name;

		//anzahl aktualisieren

			$anzahl = $row->Anzahl;
			$schiffe_soll = $schiffe_ist + $anzahl;

			//Punkte berechnen

			$Ship = spaceships::$shipID[$row->Typ];

			$punkte = get_punkte($spieler_id, $planet_id);
			//$punkte = $punkte + ((($Ship["Kosten_Eisen"] + $Ship["Kosten_Silizium"] + $Ship["Kosten_Wasser"]) * $anzahl) / 1000);

			//Bots berechnen

			$bots_anzahl = $row_planet->Stationiert_Bot + ($Ship->requiredBots * $anzahl);

			$abfrage_planet_update = "UPDATE `planet` SET  `$tabelle` = $schiffe_soll
			, `punkte` = " . "0" . ", `Stationiert_Bot` = $bots_anzahl WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
			$query = $abfrage_planet_update or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

			if (mysqli_query($link, $query)) {

				if ($anzahl > 1) { $insert_name = $Ship->namePlural; } else { $insert_name = $Ship->name; }

				//$news_typ = "ERFOLG_SYSTEM";
				$news_text = "Es wurden $anzahl $insert_name fertiggestellt";
				set_message(0, "System", $spieler_id, $username, "set_bauschleife_ship_fertig", $_planetName.': '.$news_text, 0, 1, 0);
				// set_news($spieler_id, $planet_id, $news_typ, $news_text);
			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}

		//Bauschliefe löschen

			$abfrage_bauschleife_delete = "DELETE FROM `bauschleifeflotte` WHERE `ID` = '" . $row->ID . "'";
			$query = $abfrage_bauschleife_delete or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

			if (mysqli_query($link, $query)) {

			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}


	}
	// jetzt nur die teilweise gebauten, z.B. die 10 von 100

	$abfrage = "SELECT `ID`, `Typ`, `Spieler_ID`, `Planet_ID`, `Name`, `Anzahl`, `Bauzeit_Von`, `Bauzeit_Einzel`, `Bauzeit_Bis` FROM `bauschleifeflotte`  WHERE `Bauzeit_Von` < " . time() . " AND `Bauzeit_Bis` >= " . time() . " AND `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_ship_fertig ".$link));
	$result_bauschleifeflotte = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));

	while($row = mysqli_fetch_object($result_bauschleifeflotte)) {

		//schauen wie viele vom Typ sind stationiert

		$tabelle = "Schiff_Typ_" . $row->Typ;
		$Ship = spaceships::$shipID[$row->Typ];
		$abfrage_planet = "SELECT `$tabelle`, `Stationiert_Bot`, `Planet_Name` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
		$query = $abfrage_planet  or die("Error in the consult.." . mysqli_error("Error in set_bauschleife_ship_fertig ".$link));
		$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
		$row_planet = mysqli_fetch_object($result);
		$schiffe_ist = $row_planet->$tabelle;
		$_planetName = $row_planet->Planet_Name;

		//anzahl aktualisieren

		$fertiggestellte = (int)((time() - $row->Bauzeit_Von) / $row->Bauzeit_Einzel);

		$restliche = $row->Anzahl - $fertiggestellte;
		if($fertiggestellte > 0) {

			$weiter_ab_zeitpunkt = $row->Bauzeit_Von + ($fertiggestellte *  $row->Bauzeit_Einzel);

			$schiffe_soll = $schiffe_ist + $fertiggestellte;

			$punkte = get_punkte($spieler_id, $planet_id);
			//$punkte = $punkte + ((($Ship["Kosten_Eisen"] + $Ship["Kosten_Silizium"] + $Ship["Kosten_Wasser"]) * $fertiggestellte) / 1000);

			//Bots berechnen

			$bots_anzahl = $row_planet->Stationiert_Bot + ($Ship->requiredBots * $fertiggestellte);

			$abfrage_planet_update = "UPDATE `planet` SET  `$tabelle` = $schiffe_soll
			, `punkte` = " . "0" . ", `Stationiert_Bot` = $bots_anzahl WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
			$query = $abfrage_planet_update or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

			if (mysqli_query($link, $query)) {

				if ($fertiggestellte > 1) { $insert_name = $Ship->namePlural; } else { $insert_name = $Ship->name; }

				//$news_typ = "ERFOLG_SYSTEM";
				$news_text = "Es wurden $fertiggestellte $insert_name fertiggestellt";
				set_message(0, "System", $spieler_id, $username, "set_bauschleife_ship_fertig (teil)", $_planetName.': '.$news_text, "",  1);
				//set_news($spieler_id, $planet_id, $news_typ, $news_text);

			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}

			//Bauschliefe anpassen

			$abfrage_bauschleife_delete = "UPDATE `bauschleifeflotte` SET `Anzahl` = $restliche, `Bauzeit_Von` = $weiter_ab_zeitpunkt  WHERE `ID` = " . $row->ID;
			$query = $abfrage_bauschleife_delete or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

			if (mysqli_query($link, $query)) {

			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}

		}

		//--- wenn alle durch sind kann die Bauschleife dann auch gelöscht werden

		if($restliche == 0) {

			$abfrage_bauschleife_delete = "DELETE FROM `bauschleifeflotte` WHERE `ID` = " . $row->ID;
			$query = $abfrage_bauschleife_delete or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

			if (mysqli_query($link, $query)) {
				//echo "Schleife gelöscht";
			} else {
				die("Fehler in der fertigstellung: " . mysqli_error($link));
			}


		}

	}
}

function set_defense_construction_loop_finished ($player_id, $planet_id) {		// ex-function: set_bauschleife_deff_fertig
	require 'inc/connect_galaxy_1.php';

	// get finished construction loops and delete them
	$query = "SELECT `id`, `player_id`, `planet_id`, `defense_id`, `name`, `quantity`, `construction_time`, `construction_time_start`, `construction_time_end` FROM `construction_loops_defense`  WHERE `construction_time_end` <= " . time() . " AND `player_id` = '$player_id' AND `planet_id` = $planet_id";
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

	while($row_construction_loop = mysqli_fetch_object($result)) {

		// get stationed defense
		$column = 'Deff_Typ_' . $row_construction_loop->defense_id;
		$query = "SELECT `$column`, `Planet_Name` FROM `planet` WHERE `Spieler_ID` = '$player_id' AND `Planet_ID` = $planet_id";
		$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

		$row_planet = mysqli_fetch_object($result);
		$defense_now = $row_planet->$column;
		$_planetName = $row_planet->Planet_Name;

		// calculate new value for stationed defense
		$defense = get_defense($row_construction_loop->defense_id);
		$quantity = $row_construction_loop->quantity;
		$defense_now += $quantity;

		// !!! punkte update macht so keinen sinn !!!
		//$punkte = get_punkte($player_id, $planet_id);
		//$punkte = $punkte + ((($Deff["Kosten_Eisen"] + $Deff["Kosten_Silizium"] + $Deff["Kosten_Wasser"]) * $anzahl) / 1000);
		//
		//$abfrage_planet_update = "UPDATE `planet` SET  `$tabelle` = $deff_soll
		//, `punkte` = " . "0" . " WHERE `Spieler_ID` = '$player_id' AND `Planet_ID` = $planet_id";
		//$query = $abfrage_planet_update or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

		$query = "UPDATE `planet` SET  `$column` = $defense_now WHERE `Spieler_ID` = '$player_id' AND `Planet_ID` = $planet_id";
		mysqli_query($link, $query) or sql_error(mysqli_error($link));

		// set news
		$news_typ = lng_echo ('success system', no_file, echo_off);
		if ($quantity > 1) { $news_text = lng_echo ('contruction loop finished plural', no_file, echo_off, array('defense_name' => $defense['name plural'] , 'quantity' => $quantity));}
		else { $news_text = lng_echo ('contruction loop finished', no_file, echo_off, array('defense_name' => $defense['name'] , 'quantity' => $quantity));}

		set_message(0, "System", $player_id, $username, "set_defense_construction_loop_finished", $_planetName.': '.$news_text, 0, 1, 0);
		//set_news($player_id, $planet_id, $news_typ, $news_text);

		// delete construction loop
		$query = "DELETE FROM `construction_loops_defense` WHERE `id` = " . $row_construction_loop->id;
		mysqli_query($link, $query) or sql_error(mysqli_error($link));
	}


	// get partial finished construction loops and update them (e.g. 10 of 100, remaining 90)
	$query = "SELECT `id`, `player_id`, `planet_id`, `defense_id`, `name`, `quantity`, `construction_time`, `construction_time_start`, `construction_time_end` FROM `construction_loops_defense`  WHERE `construction_time_end` > " . time() . " AND `player_id` = '$player_id' AND `planet_id` = $planet_id";
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

	while($row_construction_loop = mysqli_fetch_object($result)) {

		// get stationed defense
		$column = 'Deff_Typ_' . $row_construction_loop->defense_id;
		$query = "SELECT `$column` FROM `planet` WHERE `Spieler_ID` = '$player_id' AND `Planet_ID` = $planet_id";
		$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

		$row_planet = mysqli_fetch_object($result);
		$defense_now = $row_planet->$column;

		// calculate new value for stationed defense
		$defense = get_defense($row_construction_loop->defense_id);
		$quantity_finished = round_down ((time() - $row_construction_loop->construction_time_start) / $row_construction_loop->construction_time);
		$quantity_remaining = $row_construction_loop->quantity - $quantity_finished;

		if($quantity_finished > 0) {
			$new_start_time = $row_construction_loop->construction_time_end - ($quantity_remaining * $row_construction_loop->construction_time);
			$defense_now += $quantity_finished;

			// !!! punkte update macht so keinen sinn !!!
			// $punkte = get_punkte($player_id, $planet_id);
			//$punkte = $punkte + ((($Deff["Kosten_Eisen"] + $Deff["Kosten_Silizium"] + $Deff["Kosten_Wasser"]) * $fertiggestellte) / 1000);
			//
			// $abfrage_planet_update = "UPDATE `planet` SET  `$tabelle` = $deff_soll
			// , `punkte` = " . "0" . " WHERE `Spieler_ID` = '$player_id' AND `Planet_ID` = $planet_id";
			// $query = $abfrage_planet_update or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

			$query = "UPDATE `planet` SET  `$column` = $defense_now WHERE `Spieler_ID` = '$player_id' AND `Planet_ID` = $planet_id";
			mysqli_query($link, $query) or sql_error(mysqli_error($link));

			// update construction loop
			if ($quantity_remaining == 0) {			//  if nothing remanining, delete construction loop
				$query =  "DELETE FROM `construction_loops_defense` WHERE `id` = " . $row_construction_loop->id;
			} else {
				$query = "UPDATE `construction_loops_defense` SET `quantity` = $quantity_remaining, `construction_time_start` = $new_start_time  WHERE `id` = " . $row_construction_loop->id;
			}
			mysqli_query($link, $query) or sql_error(mysqli_error($link));
		}
	}
}


function get_punkte($spieler_id) {

	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT `punkte_structur`, `punkte_flotte`, `punkte_forschung` FROM `spieler`  WHERE `Spieler_ID` = '$spieler_id'";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error in  ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
	$row = mysqli_fetch_object($result);

	$punkte = array();
	$punkte["punkte_structur"] = $row->punkte_structur;
	$punkte["punkte_forschung"] = $row->punkte_forschung;
	$punkte["punkte_flotte"] = $row->punkte_flotte;

	return $punkte;

}

function set_bauschleife_struckture_fertig($spieler_id, $planet_id, $gebäude_id, $username) {

	require 'inc/connect_galaxy_1.php';

	$produktion = get_produktion($spieler_id, $planet_id);

	$punkte = get_punkte($spieler_id, $planet_id);

	$Gebäude = get_gebäude_nächste_stufe($spieler_id, $planet_id, $gebäude_id, 1);

	$tabelle = "Stufe_Gebaeude_" . $gebäude_id;

	if($gebäude_id == 1 AND $Gebäude["Gewinn_Ress"] > 0) { $produktion["Eisen"] = $produktion["Eisen"] + $Gebäude["Gewinn_Ress"]; }
	if($gebäude_id == 2 AND $Gebäude["Gewinn_Ress"] > 0) { $produktion["Silizium"] = $produktion["Silizium"] + $Gebäude["Gewinn_Ress"]; }
	if($gebäude_id == 2 AND $Gebäude["Gewinn_Ress"] > 0) { $produktion["Wasser"] = $produktion["Wasser"] + $Gebäude["Gewinn_Ress"]; }

	if($Gebäude["Gewinn_Energie"] > 0) { $produktion["Energie"] = $produktion["Energie"] + $Gebäude["Gewinn_Energie"]; }

	if ($gebäude_id == 6) { $produktion["Bunker_Kapa"] = $produktion["Bunker_Kapa"] + $Gebäude["Kapazitaet"]; }
	if ($gebäude_id == 10) { $produktion["Handel_Kapa"] = $produktion["Handel_Kapa"] + $Gebäude["Kapazitaet"]; }


	//$punkte["punkte_structur"] = $punkte + (($Gebäude["Kosten_Eisen"] + $Gebäude["Kosten_Silizium"] + $Gebäude["Kosten_Wasser"]) / 1000);

	$abfrage = "UPDATE `planet` SET
	`$tabelle` = " . $Gebäude["Stufe"] . ",
	`Prod_Eisen` = " . $produktion["Eisen"] . ",
	`Prod_Silizium` = " .  $produktion["Silizium"] . ",
	`Prod_Wasser` = " . $produktion["Wasser"] . ",
	`Ressource_Energie` = " . $produktion["Energie"] . ",
	`Bunker_Kapa` = " .  $produktion["Bunker_Kapa"] . ",
	`Handel_Kapa` = " . $produktion["Handel_Kapa"] . ",
	`Bauschleife_Gebaeude_ID` = 0,
	`Bauschleife_Gebaeude_Start` = 0,
	`Bauschleife_Gebaeude_Bis` = 0,
	`Bauschleife_Gebaeude_Name` = ''
	WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

	if (mysqli_query($link, $query)) {

		$text =  $Gebäude["Name"] . " ist jetzt fertiggestellt";
		set_message(0, "System", $spieler_id, $username, "set_bauschleife_struckture_fertig", $text, 0, 1, 0);


	} else {
		die("Fehler in der fertigstellung: " . mysqli_error($link));
	}




}

function set_bauschleife_tech_fertig($spieler_id, $planet_id, $tech_id, $username) {
	require 'inc/connect_galaxy_1.php';

	$produktion = get_produktion($spieler_id, $planet_id);

	$punkte = get_punkte($spieler_id, $planet_id);

	$Tech = get_tech_nächste_stufe($spieler_id, $planet_id, $tech_id, 1);

	$tabelle = "Tech_" . $tech_id;

	//$punkte = $punkte + (($Tech["Kosten_Eisen"] + $Tech["Kosten_Silizium"] + $Tech["Kosten_Wasser"]) / 1000);


	$abfrage = "UPDATE `spieler` SET `" . $tabelle .
	"` = " . $Tech["Stufe"] . ",
	`Tech_Schleife_ID` = 0,
	`Tech_Schleife_Name` = '',
	`Tech_Schleife_Bauzeit_Bis` = 0,
	`Tech_Schleife_Bauzeit_Start` = 0
	 WHERE `Spieler_ID` = '$spieler_id'";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

	if (mysqli_query($link, $query)) {
		$text =  $Tech["Name"] . " wurde erforscht.";
		set_message(0, "System", $spieler_id, $username, "set_bauschleife_tech_fertig", $text, 0, 1, 0);
	} else {
		die("$abfrage Fehler in der fertigstellung: " . mysqli_error($link));
	}


}

function set_bauschleife_structure_abbruch($spieler_id, $planet_id, $gebäude_id, $username) {

	require 'inc/connect_galaxy_1.php';

	$Gebäude = get_gebäude_nächste_stufe($spieler_id, $planet_id, $gebäude_id, 1);
	$ressource = get_ressource($spieler_id, $planet_id);

	//Eisen, Sili, Wasser zurück & Bauschleife löschen

	$ressource["Eisen"] = $ressource["Eisen"] + $Gebäude["Kosten_Eisen"];
	$ressource["Silizium"] = $ressource["Silizium"] + $Gebäude["Kosten_Silizium"];
	$ressource["Wasser"] = $ressource["Wasser"] + $Gebäude["Kosten_Wasser"];
	$ressource["Energie"] = $ressource["Energie"] +	$Gebäude["Kosten_Energie"];

	$ressource["Karma"] = $ressource["Karma"] + $Gebäude["Kosten_Karma"];


	$abfrage  = "UPDATE `planet` SET
	`Ressource_Eisen` = " . $ressource["Eisen"] . ",
	`Ressource_Silizium` = ". $ressource["Silizium"] .",
	`Ressource_Wasser` = " . $ressource["Wasser"] . ",
	`Ressource_Energie` = ". $ressource["Energie"] .",
	`Ressource_Karma` = ". $ressource["Karma"] .",
	`Bauschleife_Gebaeude_Start` = 0,
	`Bauschleife_Gebaeude_ID` = 0,
	`Bauschleife_Gebaeude_Bis` = 0,
	`Bauschleife_Gebaeude_Name` = ''
	WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

	if (mysqli_query($link, $query)) {
		$text =  $Gebäude["Name"] . " wurde abgebrochen. Ressourcen wurden gutgeschrieben (Eisen: " . $Gebäude["Kosten_Eisen"] . " Silizium: " . $Gebäude["Kosten_Silizium"] . " Wasser: " . $Gebäude["Kosten_Wasser"] . " Energie: " . $Gebäude["Kosten_Energie"] . ")";
		set_message(0, "System", $spieler_id, $username, "set_bauschleife_structure_abbruch" , $text, 0, 1, 0);
	} else {
		die("Fehler in der fertigstellung: " . mysqli_error($link));
	}


}

function set_bauschleife_tech_abbruch($spieler_id, $planet_id, $tech_id, $username) {

	require 'inc/connect_galaxy_1.php';

	$Tech = get_tech_nächste_stufe($spieler_id, $planet_id, $tech_id, 1);
	$ressource = get_ressource($spieler_id, $planet_id);

	//Eisen, Sili, Wasser zurück & Bauschleife löschen

	$ressource["Eisen"] = $ressource["Eisen"] + $Tech["Kosten_Eisen"];
	$ressource["Silizium"] = $ressource["Silizium"] + $Tech["Kosten_Silizium"];
	$ressource["Wasser"] = $ressource["Wasser"] + $Tech["Kosten_Wasser"];

	$abfrage  = "UPDATE `planet` SET
	`Ressource_Eisen` = " . $ressource["Eisen"] . ",
	`Ressource_Silizium` = ". $ressource["Silizium"] .",
	`Ressource_Wasser` = " . $ressource["Wasser"] . "
	WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

	if (mysqli_query($link, $query)) {

		$abfrage  = "UPDATE `spieler` SET
		`Tech_Schleife_ID` = 0,
		`Tech_Schleife_Name` = '',
		`Tech_Schleife_Bauzeit_Bis` = 0,
		`Tech_Schleife_Bauzeit_Start` = 0
		WHERE `Spieler_ID` = '$spieler_id'";

			$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
			if (mysqli_query($link, $query)) {

				$text =  $Tech["Name"] . " wurde abgebrochen. Ressourcen wurden gutgeschrieben (Eisen: " . $Tech["Kosten_Eisen"] . " Silizium: " . $Tech["Kosten_Silizium"] . " Wasser: " . $Tech["Kosten_Wasser"] . ")";
				set_message(0, "System", $spieler_id, $username, "set_bauschleife_tech_abbruch", $text, 0, 1, 0);

			} else {
				die("Fehler im Abbruch: " . mysqli_error($link));
			}

	} else {
		die("Fehler in der fertigstellung: " . mysqli_error($link));
	}


}

function set_bauschleife_ship_abbruch($spieler_id, $planet_id, $schleife_id) {

	require 'inc/connect_galaxy_1.php';

	$abfrage  = "SELECT `ID`, `Typ`, `Anzahl`, `Bauzeit_Von` FROM `bauschleifeflotte` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id AND ID = $schleife_id";
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_ship_abbruch #1 ".$link));

	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
	$row = mysqli_fetch_object($result);

		if (!empty($row)) {

		$Ship = spaceships::$shipID[$row->Typ];
		$anzahl = $row->Anzahl;

		$eisen_ruck = ($Ship->requiredIron * $anzahl) / 3 * 2;
		$silizium_ruck = ($Ship->requiredSilicon * $anzahl) / 3 * 2;
		$wasser_ruck = ($Ship->requiredWater * $anzahl) / 3 * 2;
		$karma_ruck = ($Ship->requiredKarma * $anzahl) / 3 * 2;
		$bots_ruck = $Ship->requiredBots * $anzahl;

		// update ress & bots auf dem Planeten

		$ressource = get_ressource($spieler_id, $planet_id);

		//Eisen, Sili, Wasser zurück & Bauschleife löschen

		$ressource["Eisen"] = $ressource["Eisen"] + $eisen_ruck;
		$ressource["Silizium"] = $ressource["Silizium"] + $silizium_ruck;
		$ressource["Wasser"] = $ressource["Wasser"] + $wasser_ruck;
		$ressource["Bot"] = $ressource["Bot"] + $bots_ruck;
		$ressource["Karma"] = $ressource["Karma"] + $karma_ruck;


		$abfrage  = "UPDATE `planet` SET
		`Ressource_Eisen` = " . $ressource["Eisen"] . ",
		`Ressource_Silizium` = ". $ressource["Silizium"] .",
		`Ressource_Wasser` = " . $ressource["Wasser"] . ",
		`Ressource_Bot` = " . $ressource["Bot"] . ",
		`Ressource_Karma` = " . $ressource["Karma"] . "
		WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
		if (mysqli_query($link, $query)) {

			// lösche Bauschleife

			$abfrage = "DELETE FROM `bauschleifeflotte` WHERE ID = " . $row->ID;

			$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
			if (mysqli_query($link, $query)) {

				// berechne übrige Zeiten neu für nach now starten

				$abfrage  = "SELECT `ID`, `Bauzeit_Von`, `Bauzeit_Bis` FROM `bauschleifeflotte` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id AND Bauzeit_Von > " . time();
				$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));

				$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

				if (!empty($result)) {


					$neue_zeit_start = $row->Bauzeit_Von;
					if ($neue_zeit_start < time()) { $neue_zeit_start = time(); }

					$starte_ab = $neue_zeit_start;

					while($row_bauschleife = mysqli_fetch_object($result)) {


						$dauer = $row_bauschleife->Bauzeit_Bis - $row_bauschleife->Bauzeit_Von;

						$update_von_auf = $starte_ab;
						$update_bis_auf = $update_von_auf + $dauer;


						$ID = $row_bauschleife->ID;

						$sql = "UPDATE `bauschleifeflotte` SET `Bauzeit_Von` = $update_von_auf, `Bauzeit_Bis` = $update_bis_auf WHERE ID = '$ID'";

						$starte_ab = $update_bis_auf;

						$query2 = $sql or die("Error in the consult.." . mysqli_error("Error: set_bauschleife_struckture #1 ".$link));
						if (mysqli_query($link, $query2)) {

							//echo "hat er";
						} else {
							die("die zeiten wurde nicht überschrieben");
						}


					}


				} else {

					die("Bauschleife kann nicht neu berechnet werden");
				}



			} else {
				die("kann die schleife nciht löschen");
			}





		} else {
			die("Fehler im Abbruch: " . mysqli_error($link));
		}







	}
}


function set_defense_construction_loop_abort ($player_id, $planet_id, $loop_id) { 		// ex-function: set_bauschleife_deff_abbruch

	require 'inc/connect_galaxy_1.php';

	$query  = "SELECT `id`, `defense_id`, `quantity`, `construction_time_start` FROM `construction_loops_defense` WHERE `player_id` = '$player_id' AND `planet_id` = $planet_id AND id = $loop_id";

	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));
	$row = mysqli_fetch_object($result);

	if (!empty($row)) {

		$defense = get_defense($row->defense_id);
		$quantity = $row->quantity;

		// update resources & bots on planet
		$resources = get_ressource($player_id, $planet_id);

	// -------------- only for the time , if all variables are translated !!! ------------------ //
			$resources = german_res_to_english_res ($resources);
	// -------------- only for the time , if all variables are translated !!! ------------------ //

		//put resources back (only 2/3 of  payed resources !) & delete constuction loop

		$resources['iron'] 	+= ($defense['required iron'] *  $quantity * 2 / 3);
		$resources['silicon'] 	+= ($defense['required silicon'] *  $quantity * 2 / 3);
		$resources['water'] 	+= ($defense['required water'] *  $quantity * 2 / 3);
		$resources['karma']	+= ($defense['required karma'] *  $quantity * 2 / 3);
		$resources['bots'] 	+= ($defense['required bots'] *  $quantity);


		$query  = "UPDATE `planet` SET
		`Ressource_Eisen`	= " . $resources['iron'] . 	", `Ressource_Silizium` 	= ". $resources['silicon'] .",
		`Ressource_Wasser`= " . $resources['water']  . 	", `Ressource_Bot` = " . $resources['bots'] . ",
		`Ressource_Karma` = " . $resources['karma'] . 	" WHERE `Spieler_ID` = '$player_id' AND `Planet_ID` = $planet_id";
		mysqli_query($link, $query) or sql_error(mysqli_error($link));

		// delete construction loop
		$query = "DELETE FROM `construction_loops_defense` WHERE id = " . $row->id;
		mysqli_query($link, $query) or sql_error(mysqli_error($link));

		// recalculate construction times for remanining loops
		$query  = "SELECT `id`, `construction_time_start`, `construction_time_end` FROM `construction_loops_defense` WHERE `player_id` = '$player_id' AND `planet_id` = $planet_id ";
		$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));
		$row = mysqli_fetch_object ($result);

		if (!empty($row)) {
			// check if first entry begin after current time and correct beginning
			if ($row->construction_time_start > time()) {$new_start_time = time();}
				else {$new_start_time = $row->construction_time_start;}

			$new_end_time = $new_start_time + $row->construction_time_end - $row->construction_time_start;

			$query = "UPDATE `construction_loops_defense` SET `construction_time_start` = $new_start_time, `construction_time_end` = $new_end_time WHERE ID = '$row->id'";
			mysqli_query($link, $query) or sql_error(mysqli_error($link));

			$new_start_time = $new_end_time;

			while($row = mysqli_fetch_object($result)) {
				$new_end_time = $new_start_time + $row->construction_time_end - $row->construction_time_start;

				$query = "UPDATE `construction_loops_defense` SET `construction_time_start` = $new_start_time, `construction_time_end` = $new_end_time WHERE ID = '$row->id'";
				mysqli_query($link, $query) or sql_error(mysqli_error($link));

				$new_start_time = $new_end_time;
			}
		}
	}
}


function check_bauschleife_activ($spieler_id, $planet_id, $zweig) {

	require 'inc/connect_galaxy_1.php';

	switch ($zweig) {
		case "Structure":
			$abfrage = "SELECT `Bauschleife_Gebaeude_ID`, `Bauschleife_Gebaeude_Bis`, `Bauschleife_Gebaeude_Start` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = '$planet_id'";

			$query = $abfrage;
			$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

			$row = mysqli_fetch_object($result);

			if($row->Bauschleife_Gebaeude_ID != "0") {
				$bauschleife["ID"] = $row->Bauschleife_Gebaeude_ID;
				$bauschleife["Start"] = $row->Bauschleife_Gebaeude_Start; //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());
				$bauschleife["Bis"] = $row->Bauschleife_Gebaeude_Bis; //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());
				$bauschleife["Countdown"] = $row->Bauschleife_Gebaeude_Bis - time();

				return $bauschleife;
			}
		break;

		case "Tech":
			$abfrage = "SELECT `Tech_Schleife_ID`, `Tech_Schleife_Bauzeit_Bis` , `Tech_Schleife_Bauzeit_Start`  FROM `spieler` WHERE `Spieler_ID` = '$spieler_id'";

			$query = $abfrage;
			$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

			$row = mysqli_fetch_object($result);

			if($row->Tech_Schleife_ID != "0") {
				$bauschleife["ID"] = $row->Tech_Schleife_ID;
				$bauschleife["Start"] = $row->Tech_Schleife_Bauzeit_Start;
				$bauschleife["Bis"] = $row->Tech_Schleife_Bauzeit_Bis;
				$bauschleife["Countdown"] = $row->Tech_Schleife_Bauzeit_Bis - time();

				return $bauschleife;
			}
		break;

		case "Ship":
			$abfrage = "SELECT `ID`, `Bauzeit_Von`, `Bauzeit_Bis` FROM `bauschleifeflotte` WHERE `Bauzeit_Von` < " . time() . " AND `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

			$query = $abfrage;
			$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

			$row = mysqli_fetch_object($result);
			if(!empty($row)) {
				$bauschleife["ID"] = $row->ID;
				$bauschleife["Start"] = $row->Bauzeit_Von;
				$bauschleife["Bis"] = $row->Bauzeit_Bis; //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());
				$bauschleife["Countdown"] = $row->Bauzeit_Bis - time(); //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());

				return $bauschleife;
			}
		break;

		case "defense":
			$abfrage = "SELECT `id`, `construction_time_start`, `construction_time_end` FROM `construction_loops_defense` WHERE `construction_time_start` < " . time() . " AND `player_id` = '$spieler_id' AND `planet_id` = $planet_id";

			$query = $abfrage;
			$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

			$row = mysqli_fetch_object($result);

			if(!empty($row)) {
				$bauschleife["ID"] = $row->id;
				$bauschleife["Start"] = $row->construction_time_start;
				$bauschleife["Bis"] = $row->construction_time_end; //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());
				$bauschleife["Countdown"] = $row->construction_time_end - time(); //get_timestamp_in_was_sinnvolles($row->Bauschleife_Gebaeude_Bis - time());

				return $bauschleife;
			}
		break;
	}
}

function get_gebäude_nächste_stufe($spieler_id, $planet_id, $gebäude_id, $speed_mod) {
	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");

	//planet|aktuelle Stufe
	$abfrage = "SELECT `Stufe_Gebaeude_1`, `Stufe_Gebaeude_2`, `Stufe_Gebaeude_3`, `Stufe_Gebaeude_4`, `Stufe_Gebaeude_5`, `Stufe_Gebaeude_6`, `Stufe_Gebaeude_7`, `Stufe_Gebaeude_8`, `Stufe_Gebaeude_9`, `Stufe_Gebaeude_10`, `Stufe_Gebaeude_11` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = '$planet_id'";

		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_gebäude_nächste_stufe #1 ".$link));
		$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

		$row_aktuelle_Stufe = mysqli_fetch_object($result);

	$tabelle = "Stufe_Gebaeude_".$gebäude_id;
	$stufe = $row_aktuelle_Stufe->$tabelle + 1;

	$bauzentrum = $row_aktuelle_Stufe->Stufe_Gebaeude_5;

	//Kosten fürs Gebäude

		$row_kosten_nächstes_Gebäude = get_config_structure($gebäude_id);

		$Gebäude["Name"] = $row_kosten_nächstes_Gebäude["Name"];
		$Gebäude["Beschreibung"] = $row_kosten_nächstes_Gebäude["Beschreibung"];
		$Gebäude["Wirkung"] = $row_kosten_nächstes_Gebäude["Wirkung"];
		$Gebäude["Bild"] = $row_kosten_nächstes_Gebäude["Bild"];

		$Gebäude["Kosten_Eisen"] = $row_kosten_nächstes_Gebäude["Kosten_Eisen"];
		$Gebäude["Kosten_Silizium"] = $row_kosten_nächstes_Gebäude["Kosten_Silizium"];
		$Gebäude["Kosten_Wasser"] = $row_kosten_nächstes_Gebäude["Kosten_Wasser"];
		$Gebäude["Kosten_Energie"] = $row_kosten_nächstes_Gebäude["Kosten_Energie"];
		$Gebäude["Gewinn_Energie"] = $row_kosten_nächstes_Gebäude["Gewinn_Energie"];
		$Gebäude["Level_Cap"] = $row_kosten_nächstes_Gebäude["Level_Cap"];
		$Gebäude["Gewinn_Ress"] = number_format($row_kosten_nächstes_Gebäude["Gewinn_Ress"], 0, '.', '.');
		$Gebäude["Bauzeit"] = $row_kosten_nächstes_Gebäude["Bauzeit"];
		$Gebäude["Kapazitaet"] = number_format($row_kosten_nächstes_Gebäude["Kapazitaet"], 0, '.', '.');
		$Gebäude["Stufe"] = $stufe;
		$Gebäude["Kosten_Karma"] = $row_kosten_nächstes_Gebäude["Kosten_Karma"];

		$mod_gewinn_kapazität = 0;
		$mod_gewinn_energie = 0;
		$mod_ress = 0;
		$mod_gewinn_kapazität = 0;

		if ($gebäude_id <= 3 ) { $mod_ress = 1.41; $mod_energie = 1.33; $mod_gewinn_ress = 1.35; $mod_bauzeit = 1.65;}

		if ($gebäude_id >= 4) { $mod_ress = 1.5; $mod_energie = 1.5; $mod_gewinn_ress = 0; $mod_bauzeit = 2;}

		if ($gebäude_id == 4) { $mod_gewinn_energie = 1.41; }

		for($i = 1; $i < $stufe; $i++) {

			$Gebäude["Kosten_Eisen"] = $Gebäude["Kosten_Eisen"] * $mod_ress * $speed_mod;
			$Gebäude["Kosten_Silizium"] = $Gebäude["Kosten_Silizium"] * $mod_ress * $speed_mod;
			$Gebäude["Kosten_Wasser"] = $Gebäude["Kosten_Wasser"] * $mod_ress * $speed_mod;
			$Gebäude["Kosten_Energie"] = $Gebäude["Kosten_Energie"] * $mod_energie * $speed_mod;
			$Gebäude["Kosten_Karma"] = $Gebäude["Kosten_Karma"] * $mod_energie * $speed_mod;

			if ($i <= $Gebäude["Level_Cap"]) {
				$Gebäude["Gewinn_Ress"] = $Gebäude["Gewinn_Ress"] * $mod_gewinn_ress * $speed_mod;
				$Gebäude["Gewinn_Energie"] = $Gebäude["Gewinn_Energie"] * $mod_gewinn_energie;
				$Gebäude["Kapazitaet"] = $Gebäude["Kapazitaet"] * $mod_gewinn_kapazität;

			}

			$Gebäude["Bauzeit"] = ($Gebäude["Bauzeit"] * $mod_bauzeit);

		}


		$Gebäude["Kosten_Eisen"] = round($Gebäude["Kosten_Eisen"]);
		$Gebäude["Kosten_Silizium"] = round($Gebäude["Kosten_Silizium"]);
		$Gebäude["Kosten_Wasser"] = round($Gebäude["Kosten_Wasser"]);
		$Gebäude["Kosten_Energie"] = round($Gebäude["Kosten_Energie"]);
		$Gebäude["Gewinn_Energie"] = round($Gebäude["Gewinn_Energie"]);
		$Gebäude["Gewinn_Ress"] = round($Gebäude["Gewinn_Ress"]);

		$Gebäude["Wirkung"] = $Gebäude["Wirkung"]  .
		"<br>Name: " . $Gebäude["Name"] . "<br>" .
		"Bauzentrum Stufe: " . $bauzentrum ."<br>" .
		"ohne Bauzentrum: " . round($Gebäude["Bauzeit"],0) ." sek. sind " . get_timestamp_in_was_sinnvolles($Gebäude["Bauzeit"]) . "<br>";

		if ($bauzentrum > 0) { $Gebäude["Bauzeit"] = $Gebäude["Bauzeit"] / (1 + $bauzentrum); }
		$Gebäude["Wirkung"] = $Gebäude["Wirkung"]  .
		"mit Bauzentrum: " . round($Gebäude["Bauzeit"],0) ." sek. sind " . get_timestamp_in_was_sinnvolles($Gebäude["Bauzeit"]) . "<br>" .
		"Formel: Bauzeit = Bauzeit / (1 + Stufe BZ) ". "<br>";
	return $Gebäude;

}

	
function get_tech_level_player ($_playerID) {
	require 'inc/connect_galaxy_1.php';

	$_query = 'SELECT '.vsprintf('%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',datasetPlayer::techLevelType).','.datasetPlayer::researchLoopID
				.' FROM '.datasetPlayer::table.' WHERE '.datasetPlayer::playerID.' = \''.$_playerID.'\'';
	$_result = new datasetPlayer;
	$_result::loadRow(mysqli_fetch_object(our_sql_query($link,$_query,must_have_results,max_one_result)));

	return $_result;
}


function get_tech_sortierung() {

	for($i = 1; $i <= 12; $i++) {
		$tech = get_config_tech($i, 0);
		$sortierung[$i]["Postition"] = $tech["Sort"];
	}
	asort($sortierung);
	return $sortierung;

}

function get_tech_nächste_stufe($spieler_id, $planet_id, $tech_id, $speed_mod) {
	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");

	//spieler|aktuelle Stufe
	$abfrage = "SELECT `Tech_1`, `Tech_2`, `Tech_3`, `Tech_4`, `Tech_5`, `Tech_6`, `Tech_7`, `Tech_8`, `Tech_9`, `Tech_10`, `Tech_11`, `Tech_12`, `Tech_Schleife_ID` FROM `spieler` WHERE `Spieler_ID` = '$spieler_id'";

		$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_tech_nächste_stufe #1 ".$link));
		$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

		$row_aktuelle_Stufe_Tech = mysqli_fetch_array($result);

		$tabelle = "Tech_".$tech_id;
		$stufe = $row_aktuelle_Stufe_Tech["Tech_".$tech_id] + 1;

		$forschungszentrum = get_structure_level($spieler_id, $planet_id, 9);

	//Kosten für die Forschung

		$row_kosten_nächste_Forschung = get_config_tech($tech_id, $row_aktuelle_Stufe_Tech);

		$Tech["Name"] = $row_kosten_nächste_Forschung["Name"];
		$Tech["Bild"] = $row_kosten_nächste_Forschung["Bild"];
		$Tech["Beschreibung"] = $row_kosten_nächste_Forschung["Beschreibung"];
		$Tech["Wirkung"] = $row_kosten_nächste_Forschung["Wirkung"];
		$Tech["Kosten_Eisen"] = $row_kosten_nächste_Forschung["Kosten_Eisen"];
		$Tech["Kosten_Silizium"] = $row_kosten_nächste_Forschung["Kosten_Silizium"];
		$Tech["Kosten_Wasser"] = $row_kosten_nächste_Forschung["Kosten_Wasser"];
		$Tech["Kosten_Energie"] = $row_kosten_nächste_Forschung["Kosten_Energie"];
		$Tech["Level_Cap"] = $row_kosten_nächste_Forschung["Level_Cap"];
		$Tech["Bauzeit"] = $row_kosten_nächste_Forschung["Bauzeit"];
		$Tech["Erw_Bedingung"] = $row_kosten_nächste_Forschung["Erw_Bedingung"];
		$Tech["Kosten_Karma"] = $row_kosten_nächste_Forschung["Kosten_Karma"];

		$Tech["Stufe"] = $stufe;


		$Tech["Lab"] = $row_kosten_nächste_Forschung["Lab"];

		if($Tech["Erw_Bedingung"] == "nicht bestanden") { $Tech["Forschung"] = "Bedingungen fail" ; return $Tech; } else { $Tech["Forschung"] = "OK"; }
		if($Tech["Lab"] > $forschungszentrum) { $Tech["Forschung"] = "Labor ausbauen" ; return $Tech; } else { $Tech["Forschung"] = "OK"; }

		if($stufe > $Tech["Level_Cap"]) { $Tech["Forschung"] = "MAX" ; return $Tech; } else { $Tech["Forschung"] = "OK"; }

		$mod_gewinn_kapazität = 0;
		$mod_gewinn_energie = 0;
		$mod_ress = 0;
		$mod_gewinn_kapazität = 0;
		$mod_energie = 1.5;
		$mod_ress = 1.5; $mod_bauzeit = 2;

		for($i = 1; $i < $stufe; $i++) {

			$Tech["Kosten_Eisen"] = $Tech["Kosten_Eisen"] * $mod_ress * $speed_mod;
			$Tech["Kosten_Silizium"] = $Tech["Kosten_Silizium"] * $mod_ress * $speed_mod;
			$Tech["Kosten_Wasser"] = $Tech["Kosten_Wasser"] * $mod_ress * $speed_mod;
			$Tech["Kosten_Energie"] = $Tech["Kosten_Energie"] * $mod_energie * $speed_mod;
			$Tech["Bauzeit"] = ($Tech["Bauzeit"] * $mod_bauzeit);
		}

		$Tech["Kosten_Eisen"] = round($Tech["Kosten_Eisen"]);
		$Tech["Kosten_Silizium"] = round($Tech["Kosten_Silizium"]);
		$Tech["Kosten_Wasser"] = round($Tech["Kosten_Wasser"]);

		$Tech["Bauzeit"] = $Tech["Bauzeit"] / (1 * $forschungszentrum);

		$Tech["Bauzeit"] = $Tech["Bauzeit"];

		return $Tech;

}

function get_last_planet($spieler_id) {
	require 'inc/connect_galaxy_1.php';
	$sql = "SELECT `Letzter_Planet` FROM `spieler` WHERE `Spieler_ID` = '$spieler_id'";
	$result = mysqli_query($link, $sql) or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));
	$row = mysqli_fetch_object($result);
	return $row->Letzter_Planet;
}

function set_last_planet($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';


	$abfrage = "SELECT `Planet_ID` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row_cnt = $result->num_rows;
	if($row_cnt > 0) {
		$sql = "UPDATE `spieler` SET `Letzter_Planet` = " . $planet_id . " WHERE `Spieler_ID` = '$spieler_id'";
		$result = mysqli_query($link, $sql) or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));
		return true;
	} else {
		return false;
	}
}


function get_list_of_all_planets($spieler_id, $planet_id, $vorauswahl = true) {
	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");

	$abfrage = "SELECT `Planet_Name`, `Planet_ID`, `x`, `y`,`z` FROM `planet` WHERE `Spieler_ID` = '$spieler_id'";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
	$ausgabe ="";

	while($row = mysqli_fetch_object($result)) {
	 	if ($row->Planet_ID == $planet_id AND $vorauswahl == true) { $select = "selected"; } else { $select = "";}
		$ausgabe = $ausgabe . "<option $select value='" . ($row->Planet_ID + 1) . "'>" . $row->Planet_Name . " (" . $row->x . ":" . $row->y . ":" . $row->z . ")</option>";
	}

	return $ausgabe;
}

function get_list_of_all_planets_new($spieler_id, $planet_id, $vorauswahl = true) {
	//die get_list_of_all_planets ist mit Select Ausgabe, das war unüberlegter Mist
	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");

	$abfrage = "SELECT `Planet_Name`, `Planet_ID`, `x`, `y`, `z` FROM `planet` WHERE `Spieler_ID` = '$spieler_id'";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$ausgabe = array();

	$i = 0;

	while($row = mysqli_fetch_object($result)) {

		if ($row->Planet_ID == $planet_id AND $vorauswahl == true) { $ausgabe[$i]["Selected"] = true; } else { $ausgabe[$i]["Selected"] = false; }

		$ausgabe[$i]["Name"] = $row->Planet_Name;
		$ausgabe[$i]["X"] = $row->x;
		$ausgabe[$i]["Y"] = $row->y;
		$ausgabe[$i]["Z"] = $row->z;
		$i++;

	}

	return $ausgabe;
}


function get_koordinaten_planet($spieler_id, $planet_id) {

	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT `x`, `y`, `z`, `Planet_Name` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row = mysqli_fetch_object($result);

	$ausgabe["Anzeige"] = $row->x.":".$row->y.":".$row->z;
	$ausgabe["X"] = $row->x;
	$ausgabe["Y"] = $row->y;
	$ausgabe["Z"] = $row->z;
	$ausgabe["Planet_Name"] = $row->Planet_Name;

	return $ausgabe;

}

function get_Ressbunker_Inhalt($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT 	`Bunker_Kapa`, `Bunker_Eisen`, `Bunker_Silizium`, `Bunker_Wasser` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_Ressbunker_Inhalt #1 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row = mysqli_fetch_object($result);

	$bunker["vorhanden"] = 0;

	if($row->Bunker_Kapa > 0) {

		$bunker["vorhanden"] = 1;

		$bunker["Belegt_Prozent"] = (($row->Bunker_Eisen + $row->Bunker_Silizium + $row->Bunker_Wasser) * 100 / $row->Bunker_Kapa);
		$bunker["Eisen"] = (int)$row->Bunker_Eisen;
		$bunker["Silizium"] = (int)$row->Bunker_Silizium;
		$bunker["Wasser"] = (int)$row->Bunker_Wasser;
		$bunker["Kapazität"] = (int)$row->Bunker_Kapa;


		$bunker["Eisen_Prozent"] = (int)number_format($row->Bunker_Eisen * 100 / $row->Bunker_Kapa, 0, '','');
		$bunker["Silizium_Prozent"] = (int)number_format($row->Bunker_Silizium * 100 / $row->Bunker_Kapa, 0, '','');
		$bunker["Wasser_Prozent"] = (int)number_format($row->Bunker_Wasser * 100 / $row->Bunker_Kapa, 0, '','');

	} else {

		$bunker["Belegt_Prozent"] = 0;
		$bunker["Eisen"] = 0;
		$bunker["Silizium"] = 0;
		$bunker["Wasser"] = 0;
		$bunker["Kapazität"] = 0;


		$bunker["Eisen_Prozent"] = 0;
		$bunker["Silizium_Prozent"] = 0;
		$bunker["Wasser_Prozent"] = 0;


	}

	return $bunker;

}


function get_Handelsposten_Inhalt($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT 	`Handel_Kapa`, `Handel_Eisen`, `Handel_Silizium`, `Handel_Wasser` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: get_Ressbunker_Inhalt #1 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row = mysqli_fetch_object($result);

	if($row->Handel_Kapa > 0) {


		$ausgabe = (($row->Handel_Eisen + $row->Handel_Silizium + $row->Handel_Wasser) * 100 / $row->Handel_Kapa) . "%";

	} else {

		$ausgabe = "-";

	}

	return $ausgabe;

}


function get_ships_stationed($_playerID, $_planetID) {
	require 'inc/connect_galaxy_1.php';
	
	$_query = 'SELECT '.vsprintf('%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',datasetPlanet::stationedShipsType).' FROM '.datasetPlanet::table.
				' WHERE '.datasetPlanet::playerID.' = \''.$_playerID.'\' AND '.datasetPlanet::planetID.' = \''.$_planetID.'\'';
	datasetPlanet::loadRow(mysqli_fetch_object(our_sql_query($link,$_query,must_have_results,max_one_result)));

	foreach (datasetPlanet::$stationedShipsType as $_shipID => $_numberOfShips) {
		if ($_numberOfShips > 0) {
			if (!isset($_stationedShips)) {$_count = 0;} else {$_count = count($_stationedShips);}
			$_stationedShips[$_count] = new stdclass ; 
			$_stationedShips[$_count]->numberOfShips = number_format($_numberOfShips, 0, '.', '.');
			$_stationedShips[$_count]->shipID = $_shipID;
			if ($_numberOfShips == 1) {
				$_stationedShips[$_count]->name = spaceships::$shipID[$_shipID]->name;
			} else if ($_numberOfShips > 1) {
				$_stationedShips[$_count]->name = spaceships::$shipID[$_shipID]->namePlural;
			}
		}
	}

	if (isset($_stationedShips)) { return $_stationedShips; }
}


function get_stationed_defense ($player_id, $planet_id) {		// ex-function: get_Deff_stationiert

	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");
	$query = "SELECT `Deff_Typ_1`, `Deff_Typ_2`, `Deff_Typ_3`, `Deff_Typ_4`, `Deff_Typ_5`, `Deff_Typ_6` FROM `planet` WHERE `Spieler_ID` = '$player_id' AND `Planet_ID` = $planet_id";
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

	$row = mysqli_fetch_object($result);

	$defense_count = get_defense(0)['defense count'];
	for($i = 1; $i <= $defense_count; $i++) {

		$column = "Deff_Typ_" . $i;
		$quantity = $row->$column;

		if ($quantity > 0) {
			if ($quantity == 1) {
				$defense[$i]['name'] = get_defense($i)['name'];
			} else {
				$defense[$i]['name'] = get_defense($i)['name plural'];
			}
			$defense[$i]['quantity'] = number_format($quantity, 0, '.', '.');
		}

	}
	if (isset($defense)) { return $defense; }
}


function get_activity_planet_spieler_schiffe($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	//planet|gebäude
	$abfrage = "SELECT `Bauschleife_Gebaeude_Name`, `Bauschleife_Gebaeude_Bis`, `Bauschleife_Flotte_ID` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0010a ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row = mysqli_fetch_object($result);


	if ( $row->Bauschleife_Gebaeude_Bis <> 0) { $activity["Gebäude"]["Name"] = $row->Bauschleife_Gebaeude_Name; $activity["Gebäude"]["Zeit-Bis"] = $row->Bauschleife_Gebaeude_Bis - time(); } else { $activity["Gebäude"]["Name"] = ""; $activity["Gebäude"]["Zeit-Bis"] = "-"; }


	//spieler|forschung

	$abfrage = "SELECT `Tech_Schleife_Name`, `Tech_Schleife_Bauzeit_Bis` , `Tech_Schleife_Bauzeit_Start`  FROM `spieler` WHERE `Spieler_ID` = '$spieler_id'";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0010b ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row = mysqli_fetch_object($result);


	if ( $row->Tech_Schleife_Bauzeit_Bis <> 0) {  $activity["Forschung"]["Name"] = $row->Tech_Schleife_Name; $activity["Forschung"]["Zeit-Bis"] = $row->Tech_Schleife_Bauzeit_Bis - time(); } else { $activity["Forschung"]["Name"] = ""; $activity["Forschung"]["Zeit-Bis"] = "-"; }

	return $activity;

}

function get_list_of_ship_construction_activity($player_id, $planet_id) { 		// ex-function: get_activity_schiffe_Liste
	require 'inc/connect_galaxy_1.php';

	$link->set_charset("utf8");

	$query = "SELECT `ID`, `Name`, `Anzahl`, `Bauzeit_Bis` FROM `bauschleifeflotte` WHERE `Spieler_ID` = '$player_id' AND `Planet_ID` = $planet_id";

	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

	$i = 0;
	while($row = mysqli_fetch_object($result)) {

		$ship_list[$i]["ID"] = $row->ID;
		$ship_list[$i]["Anzahl"] = number_format($row->Anzahl, 0, '.', '.');
		$ship_list[$i]["Name"] = $row->Name;
		$ship_list[$i]["Zeit-Bis"] = $row->Bauzeit_Bis - time();

		$i++;
	}

	if (isset($ship_list)) { return $ship_list; }
}


function get_activity_schiffe_einzel($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	$link->set_charset("utf8");

	//schiffe

	$abfrage = "SELECT `Bauzeit_Von`, `Bauzeit_Einzel`, `Name` FROM `bauschleifeflotte` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id LIMIT 1";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0010c ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	if($row = mysqli_fetch_object($result)) {

		$Bauschleife_naechstes_Schiff["Name"] = $row->Name;
		$Bauschleife_naechstes_Schiff["Bauzeit"] = $row->Bauzeit_Von + $row->Bauzeit_Einzel - time();
		return $Bauschleife_naechstes_Schiff;
	}


	$Bauschleife_naechstes_Schiff["Bauzeit"] = "-";

	return $Bauschleife_naechstes_Schiff;

}

function get_single_defense_construction_activity ($player_id, $planet_id) { 			// ex-function: get_activity_deff_einzel
	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");

	$query = "SELECT `construction_time_start`, `construction_time`, `defense_id` FROM `construction_loops_defense` WHERE `player_id` = '$player_id' AND `planet_id` = $planet_id LIMIT 1";
	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

	if($row = mysqli_fetch_object($result)) {
		if ($row->construction_time_start <= time()) {			// only loops that are not finished
			$next_defense_construction_loop['name'] = get_defense ($row->defense_id)['name'];
			$next_defense_construction_loop['construction_time_end'] = $row->construction_time_start + $row->construction_time - time();
		}
	}
	if (!isset($next_defense_construction_loop['construction_time_end'])) {
		$next_defense_construction_loop['construction_time_end'] = '-';
	}

	return $next_defense_construction_loop;
}


function get_list_of_defense_construction_activity ($player_id, $planet_id) { 		// ex-function: get_activity_deff_Liste
	require 'inc/connect_galaxy_1.php';

	$link->set_charset("utf8");

	$query = "SELECT `id`, `name`, `defense_id`, `quantity`, `construction_time_end` FROM `construction_loops_defense` WHERE `player_id` = '$player_id' AND `planet_id` = $planet_id";

	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));

	$i = 0;
	while($row = mysqli_fetch_object($result)) {
		If ($row->construction_time_end > time()) {				// only loops that are not finished
			$defense_list[$i]['id'] = $row->id;
			$defense_list[$i]['qauntity'] = number_format($row->quantity, 0, '.', '.');
			$defense_list[$i]['name'] = get_defense($row->defense_id)['name'];
			$defense_list[$i]['remanining construction time'] = $row->construction_time_end - time();
			$i++;
		}
	}

	if (isset($defense_list)) { return $defense_list; }
}


function get_ressource($spieler_id, $planet_id) {
	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT `Ressource_Eisen`, `Ressource_Silizium`, `Ressource_Wasser`, `Ressource_Bot`, `Stationiert_Bot`, `Ressource_Energie`, `Ressource_Karma` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row = mysqli_fetch_object($result);


	$ressource["Eisen"] = $row->Ressource_Eisen;
	$ressource["Silizium"] = $row->Ressource_Silizium;
	$ressource["Wasser"] = $row->Ressource_Wasser;
	$ressource["Energie"] = $row->Ressource_Energie;
	$ressource["Bot"] = $row->Ressource_Bot;
	$ressource["Bot Stationiert"] = $row->Stationiert_Bot;
	$ressource["Bot Gesamt"] = floor($ressource["Bot"]) + $ressource["Bot Stationiert"]; //<- ich weiß ist voll unnötig aber so habe ich bessere kontrolle. steht schon im Trello das es weg muss.
	$ressource["Karma"] = $row->Ressource_Karma;


	//foreach($ressource as $key => $value) {
	//	$ressource[$key] = number_format(floor($value), 0, '.', '.');
	//}


	return $ressource;


}

function refresh_ressource($spieler_id, $planet_id, $zeitpunkt) {

	$produktion = get_produktion($spieler_id, $planet_id);
	$ressource = get_ressource($spieler_id, $planet_id);

	//echo "<pre>" . var_dump($produktion) . "</pre>";
	//echo "<pre>" . var_dump($ressource) . "</pre>";

	$minuten = ($zeitpunkt - $produktion["Letzte_Aktualisierung"]) / 60;

	if ($minuten >= 1) {

		$hours = abs($minuten  / 60);

		$produktion_eisen = round($ressource["Eisen"] + ($produktion["Eisen"] * $hours), 2);
		$produktion_silizium = round($ressource["Silizium"] + ($produktion["Silizium"] * $hours), 2);
		$produktion_wasser = round($ressource["Wasser"] + ($produktion["Wasser"] * $hours), 2);

		//echo "<pre>" . $produktion_eisen . "</pre>";
		//echo "<pre>" . $produktion_silizium . "</pre>";
		//echo "<pre>" . $produktion_wasser . "</pre>";

		require 'inc/connect_galaxy_1.php';

		$sql = "UPDATE `planet` SET `Ressource_Eisen`= $produktion_eisen , `Ressource_Silizium`= $produktion_silizium, `Ressource_Wasser`= $produktion_wasser, `Produktion_Zeit`= $zeitpunkt WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

		$query = $sql or die("Error in the consult.." . mysqli_error("Error:  refresh_ressource".$link));
		$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

		//echo "<pre>" . $sql . "</pre>";

	}
}


function get_produktion($spieler_id, $planet_id) {

	require 'inc/connect_galaxy_1.php';

	$abfrage = "SELECT `Prod_Eisen`, `Prod_Silizium`, `Prod_Wasser`, `Bunker_Kapa`, `Handel_Kapa`, `Ressource_Energie`, `Produktion_Zeit`, `Grund_Prod_Eisen`, `Grund_Prod_Silizium`, `Grund_Prod_Wasser` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row = mysqli_fetch_object($result);

	$produktion["Eisen"] = $row->Prod_Eisen + $row->Grund_Prod_Eisen;
	$produktion["Eisen_Grund"] = (int)$row->Grund_Prod_Eisen;
	$produktion["Eisen_Produktion"] = (int)$row->Prod_Eisen;
	$produktion["Eisen_24"] = ($row->Prod_Eisen + $row->Grund_Prod_Eisen) * 24;

	$produktion["Silizium"] = $row->Prod_Silizium + $row->Grund_Prod_Silizium;
	$produktion["Silizium_Grund"] = (int)$row->Grund_Prod_Silizium;
	$produktion["Silizium_Produktion"] = (int)$row->Prod_Silizium;
	$produktion["Silizium_24"] = ($row->Prod_Silizium + $row->Grund_Prod_Silizium) * 24;

	$produktion["Wasser"] = $row->Prod_Wasser + $row->Grund_Prod_Wasser;
	$produktion["Wasser_Grund"] = (int)$row->Grund_Prod_Wasser;
	$produktion["Wasser_Produktion"] = (int)$row->Prod_Wasser;
	$produktion["Wasser_24"] = ($row->Prod_Wasser + $row->Grund_Prod_Wasser) * 24;

	$produktion["Bunker_Kapa"] = (int)$row->Bunker_Kapa;
	$produktion["Handel_Kapa"] = (int)$row->Handel_Kapa;
	$produktion["Energie"]  = (int)$row->Ressource_Energie;
	$produktion["Letzte_Aktualisierung"]  = (int)$row->Produktion_Zeit;

	return $produktion;

}

function create_first_planet($spieler_id, $x, $y, $z, $username, $galaxy_number) {

	if ($galaxy_number == 1) { require 'inc/connect_galaxy_1.php'; }
	if ($galaxy_number == 2) { require 'inc/connect_galaxy_2.php'; }

	$link->set_charset("utf8");

	//Spieler

	$abfrage = "INSERT INTO `spieler`(`ID`, `Spieler_ID`, `Spieler_Name`, `Typ`, `Bot_Produktion_Zeit`, `Tech_1`, `Tech_2`, `Tech_3`, `Tech_4`, `Tech_5`, `Tech_6`, `Tech_7`, `Tech_8`, `Tech_9`, `Tech_10`, `Tech_11`, `Tech_12`, `Tech_Schleife_ID`, `Tech_Schleife_Eisen`, `Tech_Schleife_Name`, `Tech_Schleife_Silizium`, `Tech_Schleife_Wasser`, `Tech_Schleife_Bauzeit_Bis`, `Tech_Schleife_Bauzeit_Start` `Tech_Schleife_Planet`) VALUES ('','$spieler_id','$username','human',".time().",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	//Planet

	$planetname = $username."s Kolonie";

	$abfrage = "INSERT INTO `planet`(`Spieler_ID`, `Spieler_Name`, `Planet_Name`, `x`, `y`, `z`, `Grund_Prod_Eisen`, `Grund_Prod_Silizium`, `Grund_Prod_Wasser`) VALUES ('', '$username','$planetname', $x, $y, $z, 20,10,5)";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003b ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

}

function get_in_galaxy_name($spieler_id, $galaxy_number){
	require 'inc/connect_spieler.php';
	$link->set_charset("utf8");
	$query = "SELECT `spieler_ID`, `name_galaxy_1`, `name_galaxy_2`, `name_galaxy_3` FROM `spieler` WHERE `spieler_ID` = '".$spieler_id."'" or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );


	$row = mysqli_fetch_object($result);
	$tabelle = "name_galaxy_".$galaxy_number;

	$ruckgabe = $row->$tabelle;
	if ($ruckgabe == "") {$ruckgabe = "unbekannt";}

	return $ruckgabe;
}

function check_username_cleaner($value, $spieler_id){
	require 'inc/connect_spieler.php';

	$badword = "admin administrator error fehler gast";

	$newVal = substr($value, 0, 30);
	if (strlen($newVal) < 3) { return ""; }


	if (strpos($badword, strtolower($value)) !== false) {
	    return "fehler"; //Badword filter
	}

	$regex ='/[^.:a-zA-ZäüöÄÜÖß0-9-\/]/';
	$newVal = preg_replace($regex," ", $newVal);

	$newVal = htmlspecialchars($newVal);
	$newVal = stripslashes($newVal);
	//$newVal = filter_var($newVal, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);


	#mysqli_select_db($link, "spieler");
	mysql_query("SET NAMES 'utf8'");
	$abfrage = "FROM `spieler` WHERE `spieler_ID` <> '$spieler_id' AND (`spieler_name` = '$newVal' OR `name_galaxy_1` =  '$newVal' OR `name_galaxy_2` =  '$newVal' OR `name_galaxy_3` = '$newVal')";


	$result = $link->query("SELECT count(*) as total $abfrage")
	or die ("Error: #0004  " . mysql_error());

	$data = mysqli_fetch_assoc($result);

	$anzahl = $data['total'];

	if ($anzahl > 0) { return "fehler"; }

	return $newVal;

}

function check_koordinaten_besetzt($x, $y, $z) {
	// true := wenn dort schon jemand siedelt
	// false := wenn dort niemand ist;
	require 'inc/connect_galaxy_1.php';

	$result = $link->query("SELECT count(*) as total FROM `planet` WHERE `x` = $x AND `y` = $y AND `z` = $z")
	or die ("Error: #0005 " . mysql_error());

	$data = mysqli_fetch_assoc($result);

	$anzahl = $data['total'];
	if ($anzahl == 0) { return false; } else { return true; }
}

function check_valid_url() {



}

function check_koordinaten_cleaner($value) {
	$regex ='/[1-9]\:[1-9]/';

	if(preg_match($regex, $value)){

		$regex ='/[^0-9\:]/';
		$newVal = preg_replace($regex,"", $value);

		$koords = explode(":", $newVal);

		if(!isset($koords[0])) { return "nicht gültig"; }
		if(!isset($koords[1])) { return "nicht gültig"; }

		return $newVal;

	}else {	return "nicht gültig";	}

}

function usereingabe_cleaner ($value)
{
	$newVal = trim($value);
	$regex ='/[^a-zA-Z0-9\_]/';
	$newVal = preg_replace($regex,"", $newVal);

	$newVal = htmlspecialchars($newVal);
	//$newVal = htmlentities($newVal);
	$newVal = stripslashes($newVal);
	$newVal = filter_var($newVal, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
	#$newVal = mysql_real_escape_string($newVal);
	$newVal = str_replace("-", "", $newVal);
	$newVal = str_replace(".", "", $newVal);

	return $newVal;


}

function user_message_cleaner ($value)
{dVar ($value,  'vor: user_message_cleaner' );
	$newVal = trim($value);
//	$regex ='/[^.:a-zA-ZäüöÄÜÖß@ 0-9-\/]/';
//	$regex ='/[^\n<>{}.:a-zA-ZäüöÄÜÖß@ 0-9-\/]/';
//	$newVal = preg_replace($regex,"", $newVal);
dvar ($newVal,  'nach: user_message_cleaner');
	$newVal = htmlspecialchars($newVal);
	#$newVal = htmlentities($newVal);
	$newVal = stripslashes($newVal);
	#$newVal = filter_var($newVal, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
	#$newVal = mysql_real_escape_string($newVal);
	#$newVal = str_replace("-", "", $newVal);
	#$newVal = str_replace(".", "", $newVal);

	return $newVal;


}

function get_number_of_planets($spieler_id, $galaxy_number){
	if ($galaxy_number == 1) { require 'inc/connect_galaxy_1.php';}
	//if ($galaxy_number == 2) { require 'inc/connect_galaxy_2.php'; mysql_select_db("galaxy2");}

	if ($galaxy_number == 2) { return 0;}
	if ($galaxy_number == 3) { return 0;}


	$result = $link->query("SELECT count(*) as total FROM `planet` WHERE `spieler_ID` = '$spieler_id'")
	or die ("Error: #0006 " . mysql_error());

	$data = mysqli_fetch_assoc($result);
	$anzahl = $data['total'];
	return ($anzahl);

}

function session_generate () {
	return md5(random_float(1, 200).session_id());
}

function login($username, $passwort){
	require 'inc/connect_spieler.php';

	$abfrage = "SELECT `ID`, `spieler_ID`, `spieler_name`, `passwort`, `letzter_login`, `spieler_geloescht`, `name_gala_1`, `aktiv_gala_1`, `letzter_Planet`, `max_Planeten` FROM `spieler` WHERE spieler_name LIKE '$username' LIMIT 1";
	$query = $abfrage or die("Error: #0002 " . mysqli_error($link));

	//execute the query.

	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
	$row = mysqli_fetch_array($result);

	if($row["passwort"]== $passwort)
	{
		$_SESSION["username"] = $username;
		$_SESSION["spieler_ID"] = $row["spieler_ID"];
		$_SESSION["letzter_planet"] = $row["letzter_Planet"];
		$_SESSION["Max_Planeten"] = $row["max_Planeten"];

		$_SESSION["session_id"] = session_generate();
		$varHTTP_USER_AGENT = md5($_SERVER['HTTP_USER_AGENT']);

		$query = "UPDATE spieler SET session_id = '".$_SESSION["session_id"]."', letzter_login = ".time().", HTTP_USER_AGENT = '".$varHTTP_USER_AGENT."' WHERE spieler_ID = '".$_SESSION["spieler_ID"]."'" or die("Error: #0007 " . mysqli_error($link));

		$ergebnis =  mysqli_query($link, $query)
		OR die("Error: #0001 <br>".mysqli_error($link));

		return "ok";
	}
}

function check_auth($spieler_id, $session_id) {

	if(!$spieler_id || !$session_id) { return "nein"; }

	require 'inc/connect_spieler.php';
	/*#mysqli_select_db($link, "spieler");*/

	$query = "SELECT `ID`, `spieler_ID`, `session_id`, `HTTP_USER_AGENT` FROM `spieler` WHERE `spieler_ID` = '".$spieler_id."' AND `session_id` = '".$session_id."' LIMIT 1" or die("Error: #0009 " . mysqli_error($link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
	$row = mysqli_fetch_array($result);

	if($row !== null && $row["HTTP_USER_AGENT"] == md5($_SERVER['HTTP_USER_AGENT']))
	{
		return "ja";

	} else{

		return "nein";
	}
}
///////////////////////////////////////////////////
// Rücksprach ob set_news gelöscht werden kann !?
///////////////////////////////////////////////////

// function set_news($spieler_id, $planet_id, $typ, $text) {
// 	require 'inc/connect_galaxy_1.php';
// 	$time_now = time();
// 	$abfrage = "INSERT INTO `message`(
// 	`Spieler_ID`,
// 	`Planet_ID`,
// 	`typ`,
// 	`text`,
// 	`gelesen`,
// 	`erstellt`) VALUES (
// 	'$spieler_id',
// 	'$planet_id',
// 	'$typ',
// 	'$text',
// 	FALSE,
// 	$time_now
// 	)";

// 	$query = $abfrage or die("Error in the consult.." . mysqli_error("Fehler im Nachrichtensystem #1 ".$link));

// 	if (mysqli_query($link, $query)) {

// 	} else {
// 		die("Fehler im Nachrichtensystem " . mysqli_error($link));
// 	}


// }


function get_spieler_name($spieler_id) {
	require 'inc/connect_galaxy_1.php';
	$sql = "SELECT `Spieler_Name` FROM `spieler` WHERE `Spieler_ID` = '$spieler_id'";

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0003 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
	$row = mysqli_fetch_object($result);
	return $row->Spieler_Name;
}

function get_player_image($_playerID) {
	require 'inc/connect_galaxy_1.php';
	$_ds = new datasetPlayer;
	$_query = 'SELECT '.$_ds::playerImage.' AS playerImage FROM '.$_ds::table.' WHERE '.$_ds::playerID.' = \''.$_playerID.'\'';
	return mysqli_fetch_object(our_sql_query($link,$_query))->playerImage;
}

function get_player_id($_playerName) {
	require 'inc/connect_galaxy_1.php';
	$_ds = new datasetPlayer;
	$_query = 'SELECT '.$_ds::playerID.' AS playerID FROM '.$_ds::table.' WHERE '.$_ds::playerName.' like \''.$_playerName.'\'';
	return mysqli_fetch_object(our_sql_query($link,$_query))->playerID;
}

function get_messages($_senderID, $_recipientID, $_playerName) {
	require 'inc/connect_galaxy_1.php';

	$_ds = new datasetMessages;

	$_query = 'SELECT * FROM '.$_ds::table.'
				WHERE '.$_ds::recipientID.' LIKE \''.$_recipientID.'\'
				OR '.$_ds::senderID.' LIKE \''.$_senderID.'\'
				OR '.$_ds::messageText.' LIKE \'%@'.$_playerName.'%\'
				OR '.$_ds::messageText.' LIKE \'%@Galaxy%\'
				ORDER BY '.$_ds::messageID.' DESC' ;

	$_result = our_sql_query($link,$_query,);

	$_messages['noMessages'] = true;

	if($_result->num_rows > 0) {
		$_messages['noMessages'] = false;
		$_i = 0;

		while($_row = mysqli_fetch_assoc($_result)) {
			$_messages['item'][$_i] = new message;
			$_messages['item'][$_i]->messageID = $_row[$_ds::messageID];
			$_messages['item'][$_i]->messageSent = $_row[$_ds::messageSent];
			$_messages['item'][$_i]->senderID = $_row[$_ds::senderID];
			$_messages['item'][$_i]->senderName = $_row[$_ds::senderName];
			$_messages['item'][$_i]->recipientID = $_row[$_ds::recipientID];
			$_messages['item'][$_i]->recipientName = $_row[$_ds::recipientName];
			$_messages['item'][$_i]->messageHasBeenRead = $_row[$_ds::messageHasBeenRead];
			$_messages['item'][$_i]->messageSubject = $_row[$_ds::messageSubject];
			$_messages['item'][$_i]->messageText = $_row[$_ds::messageText];
			$_messages['item'][$_i]->logbookMessage = $_row[$_ds::logbookMessage];
			$_messages['item'][$_i]->chatbotMessage = $_row[$_ds::chatbotMessage];

			$_i++;
		}
	}

	return $_messages;
}


function set_message($fromId, $fromName, $toId, $toName, $subject, $text="", $chatbot=0, $logbook=0, $time=0) {	
	require 'inc/connect_pdo_galaxy_1.php';
	if($time == 0) { $time = time(); }
	$sql = "INSERT INTO `nachrichten`(`Zeit`, `Absender_ID`, `Absender_Name`, `Empfaenger_ID`, `Empfaenger_Name`, `Betreff`, `Text`,`Logbuch`,`Chatbot`) VALUES (?,?,?,?,?,?,?,?,?)";
	#echo $time . ";" . $fromId  . ";" .  $fromName  . ";" .  $toId  . ";" .  $toName  . ";" .  $subject  . ";" .  $text  . "<-;" .  $logbook  . ";" .  $chatbot;
	try {
		$db->prepare($sql)->execute([$time, $fromId, $fromName, $toId, $toName, $subject, $text, $logbook, $chatbot]);

	} catch (PDOException $e) {
		catchExeption ($e);              
	}
}

define("MAXIMALE_ROBOTS_GESAMT_PLANET", 3000);
define("SCHRANKE", MAXIMALE_ROBOTS_GESAMT_PLANET / 2);
define("PRODUKTION_JE_STUNDE_MAXIMAL", 5); //weil pro 24h waren es 120 Robots
define("PRODUKTION_JE_STUNDE_MINIMUM", .5); //0.0416666666666667
define("ZEIT_EINHEIT", 60 * 60);


function delete_message($messageID) {
	require 'inc/connect_galaxy_1.php';

	if (is_array($messageID)){
		$_isIn = '(';
		$_isFirst = true;
		foreach ($messageID as $_value) {
			if ($_isFirst) {$_isFirst = false;} else {$_isIn .= ',';}
			$_isIn .= $_value;
		}
		$_isIn .= ')';
	}else{
		$_isIn = '('.$messageID.')';
	}

	$_ds = new datasetMessages;
	$_query = 'DELETE FROM '.$_ds::table.' WHERE '.$_ds::messageID.' IN '.$_isIn;
	our_sql_query($link,$_query);
}


function berechne_robot_zuwachs($spieler_id, $zeit) {


//1. Prüfen wieviele Zyklen vergangen sind
//	 - brich ab wenn < 1
//2. Wieviele Bots auf dem Planeten vorhanden sind (`Gesamt_Bots`)
//3. Wieviele sollten es maximal werden können?
//	 - brich ab wenn das Maximum der Galaxy erreicht ist
//4. Lege fest wieviele Bots maximal geprodet werden dürfen
//   erstelle einen Zähler der mitzählt wieviele Bots dem Planeten zugerechnet werden
//5. Gehe alle Planeten der Reihe nach durch und verteile je Zyklus einpaar Bots.
//	 - Beende die Schleife wenn keine Bots mehr zu verteilen sind.
//	 - Zähle die Gesamt vorhanden Bots auf dem Planeten hoch, achte darauf das diese nicht mehr als MAXIMALE_ROBOTS_GESAMT_PLANET sein dürfen

//1.
	$zyklen = get_produktions_zyklen_seit_letzter_aktualisierung($spieler_id, $zeit);

	if ($zyklen < 1 ) { return 0; }

//2.
	$bots_vorhanden_planet = get_robots_galaxy_db($spieler_id);

//3.
	define("MAXIMALE_ROBOTS_GESAMT_GALAXY", sizeof($bots_vorhanden_planet) * MAXIMALE_ROBOTS_GESAMT_PLANET);

//4.

	$aktuell_auf_allen_planeten_vorhandene_bots = get_robots_galaxy_array($spieler_id, $bots_vorhanden_planet);

	$produziert_werden_dürfen = MAXIMALE_ROBOTS_GESAMT_GALAXY - $aktuell_auf_allen_planeten_vorhandene_bots;
	if($produziert_werden_dürfen <= 0) { return 0;}

	foreach ($bots_vorhanden_planet as $key => $value) { $planet_zuwachs[$key] = 0; $aktuelle_bots_merker[$key] = $value; } //Zähler

//5.

	for ($zyklus = 1; $zyklus <= $zyklen; $zyklus++) {

		foreach ($bots_vorhanden_planet as $key => $value) {

			if($value < MAXIMALE_ROBOTS_GESAMT_PLANET) {

				if($value > SCHRANKE) { $rechne_mit_anzahl = SCHRANKE - ($value - SCHRANKE); } else { $rechne_mit_anzahl = $value; }

				$berechneter_zuwachs = $rechne_mit_anzahl * PRODUKTION_JE_STUNDE_MAXIMAL / SCHRANKE;
				if ($berechneter_zuwachs < PRODUKTION_JE_STUNDE_MINIMUM) { $berechneter_zuwachs = PRODUKTION_JE_STUNDE_MINIMUM; } // wir wollen mindestens was handfestes proden

				if ($berechneter_zuwachs > $produziert_werden_dürfen) { $berechneter_zuwachs = $produziert_werden_dürfen; } //wir legen oben fest das wir nur eine bestimmte Anzahl Bots proden könne um das maximum nicht zu erreichen
				if ($bots_vorhanden_planet[$key] + $berechneter_zuwachs > MAXIMALE_ROBOTS_GESAMT_PLANET) { $berechneter_zuwachs = MAXIMALE_ROBOTS_GESAMT_PLANET - $bots_vorhanden_planet[$key]; } //wir legen oben fest das wir nur eine bestimmte Anzahl Bots proden könne um die Limits nicht zu erreichen


				$planet_zuwachs[$key] = $planet_zuwachs[$key] + $berechneter_zuwachs;
				$bots_vorhanden_planet[$key] = $bots_vorhanden_planet[$key] + $berechneter_zuwachs;

				$produziert_werden_dürfen = $produziert_werden_dürfen - $berechneter_zuwachs;

				//echo "geprodet werden dürfen: " . $produziert_werden_dürfen . "/ dazukommen würden: " . $berechneter_zuwachs . " Zyklus " . $zyklus . ". Planet #" . $key .  " Vorhanden: " . $bots_vorhanden_planet[$key] . " Maximum: " . MAXIMALE_ROBOTS_GESAMT_GALAXY . "<br>";

			}





		}

		if ($produziert_werden_dürfen == 0) { break; }

	}

	set_robots_galaxy_db($spieler_id, $bots_vorhanden_planet, $planet_zuwachs);
	set_produktions_zyklen_seit_letzter_aktualisierung($spieler_id);

}

function get_produktions_zyklen_seit_letzter_aktualisierung($spieler_id, $zeit) {

	require 'inc/connect_galaxy_1.php';

	$query = "SELECT `Bot_Produktion_Zeit` FROM `spieler` WHERE `Spieler_ID` = '$spieler_id'";

	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row = mysqli_fetch_object($result);

	$timestamp_in_der_db = $row->Bot_Produktion_Zeit; //1458638497 22.03. 10:21
	$vergangene_zyklen = ($zeit - $timestamp_in_der_db) / ZEIT_EINHEIT;

	return $vergangene_zyklen;
}

function set_produktions_zyklen_seit_letzter_aktualisierung($spieler_id) {

	require 'inc/connect_galaxy_1.php';

	$zeit = time();

	$query = "UPDATE `spieler` SET `Bot_Produktion_Zeit` = '$zeit' WHERE `Spieler_ID` = '$spieler_id'";

	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	if (mysqli_query($link, $query)) {
	} else {
		die("Fehler, Robots nicht aktualisisert. " . mysqli_error($link));
	}


}

function get_robots_galaxy_db($spieler_id) {
	//zähle Robots

	require 'inc/connect_galaxy_1.php';

	$query = "SELECT `Ressource_Bot`, `Stationiert_Bot`, `Planet_ID` FROM `planet` WHERE `Spieler_ID` = '$spieler_id'";

	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link), __FILE__ , __LINE__);

	$bots_vorhanden_planet = array();

	while($row = mysqli_fetch_object($result)) {
		$Gesamt_Bot = $row->Ressource_Bot + $row->Stationiert_Bot + 0 ;
		$bots_vorhanden_planet[$row->Planet_ID] = $Gesamt_Bot;
	}

	return($bots_vorhanden_planet);
}

function set_robots_galaxy_db($spieler_id, $bots_vorhanden_planet, $planet_zuwachs)  {
	require 'inc/connect_galaxy_1.php';

	$i = 0;

	foreach ($bots_vorhanden_planet as $key => $value) {

		$query = "UPDATE `planet` SET `Ressource_Bot` = `Ressource_Bot` +".$planet_zuwachs[$key]." WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = '$i'";

		$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link), __FILE__ , __LINE__);

		$i++;
	}


}


function get_explored_systems($_playerID, $_x1, $_y1, $_x2, $_y2) {
	require 'inc/connect_galaxy_1.php';

	$_query = '
    select Spieler_ID, x, y, case when ownSystem > 0 then \'true\' else \'false\' end as ownSystem, 
    case when foreignSystem > 0 then \'true\' else \'false\' end as foreignSystem, case when freeSystem > 0 then \'true\' else \'false\' end as freeSystem 
    from (select s.Spieler_ID, s.x, s.y
        ,sum(case when p.Spieler_ID collate latin1_german2_ci = s.Spieler_ID then 1 else 0 end) as ownSystem 
        ,sum(case when p.Spieler_ID is not null and p.Spieler_ID collate LATIN1_GERMAN2_CI <> s.Spieler_ID then 1 else 0 end) as foreignSystem
        ,sum(case when p.Spieler_ID is null then 1 else 0 end) as freeSystem
        from sonnensystem s
        left join planet p on p.x = s.x and p.y = s.y
        WHERE (case when Entdeckt < now() - interval 14 day then LOCKED != 0 else true end) and s.Spieler_ID = \''.$_playerID.'\' 
        group by s.x, s.y, s.Spieler_ID
       )tbl
    where x >= \''.$_x1.'\' and y >= \''.$_y1.'\' and x <= \''.$_x2.'\' and y <= \''.$_y2.'\'
    ';
	
	$_exploredSystems = array();
	$_result = our_sql_query($link,$_query);
	
	while ($_obj = mysqli_fetch_object($_result)){
		array_push($_exploredSystems,$_obj);
	}
	return $_exploredSystems;
}


function get_erkundete_systeme($spieler_id, $x1, $y1, $x2, $y2) {
	//INSERT INTO `galaxy1`.`sonnensystem` (`ID`, `Spieler_ID`, `X`, `Y`, `Entdeckt`, `locked`) VALUES (NULL, '571f0c61b59c602d44604ab830375186', '30', '28', CURRENT_TIMESTAMP, '1');
	require 'inc/connect_galaxy_1.php';

	$sql = "SELECT `Spieler_ID`, `x`, `y`, `Entdeckt`, `locked` FROM `sonnensystem` WHERE `Entdeckt` >= NOW() - INTERVAL 14 DAY and `Spieler_ID` = '". $spieler_id ."' and (`x` BETWEEN ".$x1." AND ".$x2.") and (`y` BETWEEN ".$y1." AND ".$y2.") OR `locked` = 1 and `Spieler_ID` = '". $spieler_id ."' and (`x` BETWEEN ".$x1." AND ".$x2.") and (`y` BETWEEN ".$y1." AND ".$y2.") ORDER BY y, x";

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
	$i = 0;
	$Erkundet["error"] = false;
	$Erkundet["message"] = "";

	while($row = mysqli_fetch_object($result)) {

		$Erkundet[$i]["X"] = $row->x;
		$Erkundet[$i]["Y"] = $row->y;
		$Erkundet[$i]["Locked"] = $row->locked;
		$i++;
	}

	if(isset($Erkundet)) {

		return $Erkundet;

	} else {

		$Erkundet["error"] = true;
		$Erkundet["message"] = "Keine Systeme im Bereich erkundet";

		return $Erkundet;

	}





}

function get_eigene_systeme($spieler_id) {
	//INSERT INTO `galaxy1`.`sonnensystem` (`ID`, `Spieler_ID`, `X`, `Y`, `Entdeckt`, `locked`) VALUES (NULL, '571f0c61b59c602d44604ab830375186', '30', '28', CURRENT_TIMESTAMP, '1');
	require 'inc/connect_galaxy_1.php';

	$sql = "SELECT `Spieler_ID`, `x`, `y`, `z`, `Planet_ID` FROM `planet` WHERE `Spieler_ID` = '$spieler_id'";
	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	while($row = mysqli_fetch_object($result)) {
		$Systeme["X"] = $row->x;
		$Systeme["Y"] = $row->y;
		$Systeme["Z"] = $row->z;
	}

	return $Systeme;


}

function get_robots_galaxy_array($spieler_id, $bots_vorhanden_planet) {
	//zähle Robots
	$robots_in_der_galaxy = 0;
	foreach ($bots_vorhanden_planet as $value) {
		$robots_in_der_galaxy = $robots_in_der_galaxy + $value;
	}

	return($robots_in_der_galaxy);
}

function flotte_senden($spieler_id, $planet_id, $flotte, $ziel_x, $ziel_y, $ziel_z, $mission, $speed, $ress_mitnehmen, $ress_abholen) {
	require 'inc/connect_galaxy_1.php';

	$ziel_x = abs(intval($ziel_x, 10));
	$ziel_y = abs(intval($ziel_y, 10));
	$ziel_z = abs(intval($ziel_z, 10));

	if($ziel_x < 1 || $ziel_y < 1 || $ziel_z < 1) { return "ungültige koordinaten"; }
	if($ziel_x > 50 || $ziel_y > 50 || $ziel_z > 12) { return "ungültige koordinaten"; }

	if(flotte_vorhanden ($spieler_id, $planet_id, $flotte) == "raus damit!") {
		if(flotte_slots_frei($spieler_id) == "einer geht noch!") {
			$koordinaten = get_koordinaten_planet($spieler_id, $planet_id);
			$systemflug_im_system = 0; // 1: gleicher planet; 2:gleiches System; 3: anderes System
			if($koordinaten["X"] == $ziel_x AND $koordinaten["Y"] == $ziel_y) { //Distanz im gleichen System
				$abstand = $koordinaten["Z"] - $ziel_z;
				if($abstand == 0 ) { //eigenen Planeten anfliegen - z.B. Orbitale Handelsstation
					$distanz = 0;
					$systemflug_im_system = 1;
				} else { //Flug bleibt trotzdem im gleichen System
					$distanz = $abstand;
					$systemflug_im_system = 2;
				}
			} else { //Distanz nicht im gleichen System
				$systemflug_im_system = 3;
				$distanz = sqrt( pow($ziel_x - $koordinaten["X"], 2) + pow($ziel_y - $koordinaten["Y"], 2));

				$distanz = round($distanz, 1);

				//var_dump($distanz);
			}

			// Mission check

			switch (intval($mission)) {
				case 1: $mission_str = "erkunden"; $ress_mitnehmen = array ( 0,0,0,0 ); $ress_abholen = array ( 0,0,0,0 ); break;
				case 2: $mission_str = "Stationierung"; break;
				case 3: $mission_str = "Transport"; break;
				case 4: $mission_str = "Sicherungsflug"; break;
				case 5: $mission_str = "Spionage"; $ress_mitnehmen = array ( 0,0,0,0 ); $ress_abholen = array ( 0,0,0,0 ); break;
				case 6: $mission_str = "Angriff"; $ress_mitnehmen = array ( 0,0,0,0 ); $ress_abholen = array ( 0,0,0,0 ); break;
				case 7: $mission_str = "Kolonisierung"; break;
			}

			//Ress püfen

			for($i = 0; $i <= 3; $i++) {

				if ($ress_mitnehmen[$i] == '') { $ress_mitnehmen[$i] = 0; }
				if ($ress_abholen[$i] == '') { $ress_abholen[$i] = 0; }

			}

			$ressource = get_ressource($spieler_id, $planet_id);

			if($ressource["Eisen"] < $ress_mitnehmen["0"]) { $ress_mitnehmen["0"] = $ressource["Eisen"]; }
			if($ressource["Silizium"] < $ress_mitnehmen["1"]) { $ress_mitnehmen["1"] = $ressource["Silizium"]; }
			if($ressource["Wasser"] < $ress_mitnehmen["2"]) { $ress_mitnehmen["2"] = $ressource["Wasser"]; }
			if($ressource["Bot"] < $ress_mitnehmen["3"]) { $ress_mitnehmen["3"] = $ressource["Bots"]; }
			$ress_mitnehmen["3"] = 0;

			$tech_spieler = get_tech_stufe_spieler($spieler_id); //Antrieb & Kappa

			//Kappa prüfen
			$kapazität = 0;
			foreach ($flotte as $item => $value) {
				$kapazität += $flotte[$item]["Anzahl"] * (spaceships::$shipID[$flotte[$item]["Schiff_ID"]]->loadingCapacity * ( 10 * $tech_spieler["Tech_5"]) / 100 + spaceships::$shipID[$flotte[$item]["Schiff_ID"]]->loadingCapacity);
				#$kapazität += $flotte[$item]["Anzahl"] * (spaceships::$shipID[$item]->loadingCapacity * ( 10 * $tech_spieler["Tech_5"]) / 100 + spaceships::$shipID[$item]->loadingCapacity);
			}

			if($kapazität < $ress_mitnehmen["0"] + $ress_mitnehmen["1"] + $ress_mitnehmen["2"]) {
				$benötigt = $ress_mitnehmen["0"] + $ress_mitnehmen["1"] + $ress_mitnehmen["2"];
				$platz = $benötigt / $kapazität;
				$ress_mitnehmen["0"] = floor($ress_mitnehmen["0"] / $platz);
				$ress_mitnehmen["1"] = floor($ress_mitnehmen["1"] / $platz);
				$ress_mitnehmen["2"] = floor($ress_mitnehmen["2"] / $platz);
			}

			/*verbleibende Ressourcen errechnen und eintragen*/
			$ressource["Eisen"] = $ressource["Eisen"] - $ress_mitnehmen["0"];
			$ressource["Silizium"] = $ressource["Silizium"] - $ress_mitnehmen["1"];
			$ressource["Wasser"]  = $ressource["Wasser"] - $ress_mitnehmen["2"];
			$ressource["Bot"] = $ressource["Bot"] - $ress_mitnehmen["3"];

			//langsamstes Schiff suchen für Geschwindigkeit
			$langsamstes_schiff = 10000000;
			foreach ($flotte as $item => $value) {
				if($langsamstes_schiff > spaceships::$shipID[$flotte[$item]["Schiff_ID"]]->maxSpeed)
					{$langsamstes_schiff = spaceships::$shipID[$flotte[$item]["Schiff_ID"]]->maxSpeed; }
			}	

			if($systemflug_im_system == 1) {
				$distanz_berechnen = 10440000 + 360000 * $distanz;
			}
			if($systemflug_im_system == 2) {

				$distanz_berechnen = 10440000 + 360000 * $distanz;
			}
			if($systemflug_im_system == 3) {
				$distanz_berechnen = 13912830 + 1087170 * $distanz;
			}

			//echo " $langsamstes_schiff ### $speed ### $distanz ### $distanz_berechnen ### " .  $antrieb["Tech_3"] . " <br>";

			$geschwindigkeit = ($langsamstes_schiff * (1 + $tech_spieler["Tech_3"] / 10) * $speed / 100);
			//var_dump($geschwindigkeit);
			$flugzeit = $distanz_berechnen / $geschwindigkeit;
			//echo get_timestamp_in_was_sinnvolles($flugzeit);
			$gesamt_flugdauer = $flugzeit;
			$startzeit = time();
			$ankunft = $startzeit + $gesamt_flugdauer + rand(2, 5);


			$tabelle_schiffe_id = "";
			$tabelle_schiffe_anzahl = "";

			foreach ($flotte as $item => $value) {
				$tabelle_schiffe_id = $tabelle_schiffe_id . ", `Schiff_Typ_" . $flotte[$item]["Schiff_ID"] . "`";
				$tabelle_schiffe_anzahl = $tabelle_schiffe_anzahl . ", " . $flotte[$item]["Anzahl"];
				$tabelle_schiffe_update_planet[] = "`Schiff_Typ_" . $flotte[$item]["Schiff_ID"] . "` = `Schiff_Typ_" . $flotte[$item]["Schiff_ID"] . "` - " . $flotte[$item]["Anzahl"];
			}

			$sql = "INSERT INTO `flotten` (`ID`, `Ankunft`, `Start`, `Spieler_ID`, `x1`, `y1`, `z1`, `x2`, `y2`, `z2`, `Ziel_Spieler_ID`, `Start_Planet_ID`, `Ziel_Planet_ID`, `Startplanet_Name`, `Zielplanet_Name`, `Besitzer_Spieler_Name`, `Ziel_Spieler_Name`, `Mission`, `Kapazitaet`, `Ausladen_Eisen`, `Ausladen_Silizium`, `Ausladen_Wasser`, `Einladen_Eisen`, `Einladen_Silizium`, `Einladen_Wasser` $tabelle_schiffe_id)
					VALUES (NULL, '$ankunft', '" . $startzeit . "', '$spieler_id', '" . $koordinaten["X"] . "', '" . $koordinaten["Y"] . "', '" . $koordinaten["Z"] . "', '$ziel_x', '$ziel_y', '$ziel_z', '0', '$planet_id', '0', '" . $koordinaten["Planet_Name"] ."', 'unbekanntes System', '" . $_SESSION["username"] . "', '', '$mission_str', $kapazität, " . $ress_mitnehmen["0"] . ", " . $ress_mitnehmen["1"] . ", " . $ress_mitnehmen["2"] . ", " . $ress_abholen["0"] . ", " . $ress_abholen["1"] . ", " . $ress_abholen["2"] . " $tabelle_schiffe_anzahl)";
			$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));
			
			if($result = mysqli_query($link, $query)) {

				//$tempString = ',`Ressource_Eisen`='.$ressource["Eisen"].', `Ressource_Silizium`= '.$ressource["Silizium"].', `Ressource_Wasser`= '.$ressource["Wasser"].', `Ressource_Bot`= '.$ressource["Bot"];
				$sql = "UPDATE `planet` SET " . implode(',', $tabelle_schiffe_update_planet) . ",`Ressource_Eisen`= " .$ressource["Eisen"]. ", `Ressource_Silizium`= " . $ressource["Silizium"] . ", `Ressource_Wasser`= " . $ressource["Wasser"] . " , `Ressource_Bot`= " . $ressource["Bot"] . " WHERE  `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

				$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

				if($result = mysqli_query($link, $query)) {


					return "ist eingereiht";
				}

			} else { return "fehler Zeile 2808"; }

		} else { return "keine Slots frei"; }	// war an falscher Stelle ES 24.06.2016  15:03
	} else { return "ungenügen Schiffe für den vorgang!"; }

}

function check_flotte_modul_vorhanden($flotte_schiffe, $modul) {
	$gefunden = false;
	foreach ($flotte_schiffe AS $Key => $value) {
		if($value["Anzahl"] > 0) {
			$schiff = get_config_spaceship($value["Schiff_ID"]);
			$a = strpos($schiff["Modul"], $modul);
			if(strpos($schiff["Modul"], $modul) !== false ) { $gefunden = true; };
		}
	}
	return $gefunden;
}

function flotte_vorhanden ($spieler_id, $planet_id, $flotte) {
	require 'inc/connect_galaxy_1.php';
	$sql = "SELECT `Schiff_Typ_1`, `Schiff_Typ_2`, `Schiff_Typ_3`, `Schiff_Typ_4`, `Schiff_Typ_5`, `Schiff_Typ_6`, `Schiff_Typ_7`, `Schiff_Typ_8`, `Schiff_Typ_9`, `Schiff_Typ_10`, `Schiff_Typ_11` FROM `planet` WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
	$row = mysqli_fetch_object($result);

	$flotte_vorhanden = true;

	foreach ($flotte as $item => $value) {

		//echo $flotte[$item]["Anzahl"] ."x " . $flotte[$item]["Schiff_ID"]
		$tabelle = "Schiff_Typ_" . $flotte[$item]["Schiff_ID"];

		if($flotte[$item]["Anzahl"] <= $row->$tabelle AND $flotte[$item]["Anzahl"] > 0) {


		} else {
			$flotte_vorhanden = false;
		}


	}

	if($flotte_vorhanden == true) {

		return("raus damit!");

	} else {

		return("nicht vorhanden");

	}

}

function flotte_slots_frei($spieler_id) {
	require 'inc/connect_galaxy_1.php';
	//Tech 6
	$sql = "SELECT `Tech_6` FROM `spieler` WHERE `Spieler_ID` = '$spieler_id'";

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
	$row = mysqli_fetch_object($result);

		$mögliche_slots = $row->Tech_6 + 1;

	$sql = "SELECT count(*) as total FROM `flotten` WHERE `Spieler_ID` = '$spieler_id'";

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
	$row = mysqli_fetch_object($result);

		$anzahl_slots = $row->total;

	if($mögliche_slots > $anzahl_slots) {

		return "einer geht noch!";

	} else {

		return "Slots belegt";
	}

}

function get_all_ships_stationed($_playerID) {
	require 'inc/connect_galaxy_1.php';
	
	$_query = 'SELECT '.vsprintf('IFNULL(sum(%s),0) as "1",IFNULL(sum(%s),0) as "2",IFNULL(sum(%s),0) as "3",IFNULL(sum(%s),0) as "4"
				,IFNULL(sum(%s),0) as "5",IFNULL(sum(%s),0) as "6",IFNULL(sum(%s),0) as "7",IFNULL(sum(%s),0) as "8"
				,IFNULL(sum(%s),0) as "9",IFNULL(sum(%s),0) as "10",IFNULL(sum(%s),0) as "11",IFNULL(sum(%s),0) as "12"'
				,datasetPlanet::stationedShipsType).' FROM '.datasetPlanet::table.' WHERE '.datasetPlanet::playerID.' = \''.$_playerID.'\'';

	return mysqli_fetch_object(our_sql_query($link,$_query,must_have_results,max_one_result));
}


function get_all_ships_in_the_air($_playerID) {
	require 'inc/connect_galaxy_1.php';

	$_query = 'SELECT '.vsprintf('IFNULL(sum(%s),0) as "1",IFNULL(sum(%s),0) as "2",IFNULL(sum(%s),0) as "3",IFNULL(sum(%s),0) as "4"
				,IFNULL(sum(%s),0) as "5",IFNULL(sum(%s),0) as "6",IFNULL(sum(%s),0) as "7",IFNULL(sum(%s),0) as "8"
				,IFNULL(sum(%s),0) as "9",IFNULL(sum(%s),0) as "10",IFNULL(sum(%s),0) as "11",IFNULL(sum(%s),0) as "12"'
				,datasetFleets::ShipsInFleetType).' FROM '.datasetFleets::table.' WHERE '.datasetFleets::ownerPlayerID.' = \''.$_playerID.'\'';

	return mysqli_fetch_object(our_sql_query($link,$_query,must_have_results,max_one_result));
}


function get_all_ships_in_galaxy($_playerID) {
	$_allShips = get_all_ships_stationed($_playerID);
	$_air = get_all_ships_in_the_air($_playerID);

	foreach ($_air as $_ID => $_ships){
		$_allShips->$_ID += $_ships;
	}

	return $_allShips;
}

function get_total_stationed_defense_in_galaxy ($player_id, $defense_id) { 			// ex-function:  get_addiere_deff_stationiert
	require 'inc/connect_galaxy_1.php';
	$query = "SELECT SUM(`Deff_Typ_" . $defense_id . "`) as total FROM `planet` WHERE `Spieler_ID` = '" . $player_id . "'";

	$result = mysqli_query($link, $query) or sql_error(mysqli_error($link));
	$row = mysqli_fetch_object($result);

	return $row->total;
}

function korrigiere_punkte($spieler_id, $punkte_structur,  $punkte_flotte, $punkte_forschung) {
	require 'inc/connect_galaxy_1.php';
	$sql = "UPDATE `spieler` SET `punkte_structur`=$punkte_structur,`punkte_flotte`=$punkte_flotte,`punkte_forschung`=$punkte_forschung WHERE `Spieler_ID` = '" . $spieler_id . "'";
	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));
	if (mysqli_query($link, $query)) {
		echo "koorigiert";
	}
}

function get_flotte_in_der_luft($spieler_id, $zeit, $abarbeiten = false) {
	require 'inc/connect_galaxy_1.php';

	if($abarbeiten == false) { $sql = "SELECT `ID`, `Ankunft`, `Start`, `Spieler_ID`, `x1`, `y1`, `z1`, `x2`, `y2`, `z2`, `Ziel_Spieler_ID`, `Start_Planet_ID`, `Ziel_Planet_ID`, `Startplanet_Name`, `Zielplanet_Name`, `Besitzer_Spieler_Name`, `Ziel_Spieler_Name`, `Mission`, `Kapazitaet`, `Ausladen_Eisen`, `Ausladen_Silizium`, `Ausladen_Wasser`, `Einladen_Eisen`, `Einladen_Silizium`, `Einladen_Wasser`, `Schiff_Typ_1`, `Schiff_Typ_2`, `Schiff_Typ_3`, `Schiff_Typ_4`, `Schiff_Typ_5`, `Schiff_Typ_6`, `Schiff_Typ_7`, `Schiff_Typ_8`, `Schiff_Typ_9`, `Schiff_Typ_10`, `Schiff_Typ_11`, `Schiff_Typ_12` FROM `flotten` WHERE `Spieler_ID` = '$spieler_id' ORDER BY Ankunft ASC"; }
	if($abarbeiten == true) { $sql = "SELECT `ID`, `Ankunft`, `Start`, `Spieler_ID`, `x1`, `y1`, `z1`, `x2`, `y2`, `z2`, `Ziel_Spieler_ID`, `Start_Planet_ID`, `Ziel_Planet_ID`, `Startplanet_Name`, `Zielplanet_Name`, `Besitzer_Spieler_Name`, `Ziel_Spieler_Name`, `Mission`, `Kapazitaet`, `Ausladen_Eisen`, `Ausladen_Silizium`, `Ausladen_Wasser`, `Einladen_Eisen`, `Einladen_Silizium`, `Einladen_Wasser`, `Schiff_Typ_1`, `Schiff_Typ_2`, `Schiff_Typ_3`, `Schiff_Typ_4`, `Schiff_Typ_5`, `Schiff_Typ_6`, `Schiff_Typ_7`, `Schiff_Typ_8`, `Schiff_Typ_9`, `Schiff_Typ_10`, `Schiff_Typ_11`, `Schiff_Typ_12` FROM `flotten` WHERE `Spieler_ID` = '$spieler_id' AND `Ankunft` <= " . $zeit . " OR  `Ziel_Spieler_ID` = '$spieler_id' AND `Ankunft` <= " . $zeit . "  ORDER BY Ankunft ASC"; }

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$i = 0;
	while($row = mysqli_fetch_object($result)) {
		$balken[$i]["ID"] = $row->ID;
		$balken[$i]["Ankunft"] = $row->Ankunft;
		$balken[$i]["Start"] = $row->Start;
		$balken[$i]["Spieler_ID"] = $row->Spieler_ID;
		$balken[$i]["x1"] = $row->x1;
		$balken[$i]["y1"] = $row->y1;
		$balken[$i]["z1"] = $row->z1;
		$balken[$i]["x2"] = $row->x2;
		$balken[$i]["y2"] = $row->y2;
		$balken[$i]["z2"] = $row->z2;
		$balken[$i]["Ziel_Spieler_ID"] = $row->Ziel_Spieler_ID;
		$balken[$i]["Start_Planet_ID"] = $row->Start_Planet_ID;
		$balken[$i]["Ziel_Planet_ID"] = $row->Ziel_Planet_ID;
		$balken[$i]["Startplanet_Name"] = $row->Startplanet_Name;
		$balken[$i]["Zielplanet_Name"] = $row->Zielplanet_Name;
		$balken[$i]["Besitzer_Spieler_Name"] = $row->Besitzer_Spieler_Name;
		$balken[$i]["Ziel_Spieler_Name"] = $row->Ziel_Spieler_Name;
		$balken[$i]["Mission"] = $row->Mission;
		$balken[$i]["Kapazitaet"] = $row->Kapazitaet;
		$balken[$i]["Ausladen_Eisen"] = $row->Ausladen_Eisen;
		$balken[$i]["Ausladen_Silizium"] = $row->Ausladen_Silizium;
		$balken[$i]["Ausladen_Wasser"] = $row->Ausladen_Wasser;
		$balken[$i]["Einladen_Eisen"] = $row->Einladen_Eisen;
		$balken[$i]["Einladen_Silizium"] = $row->Einladen_Silizium;
		$balken[$i]["Einladen_Wasser"] = $row->Einladen_Wasser;
		$balken[$i]["Schiff_Typ_1"] = $row->Schiff_Typ_1;
		$balken[$i]["Schiff_Typ_2"] = $row->Schiff_Typ_2;
		$balken[$i]["Schiff_Typ_3"] = $row->Schiff_Typ_3;
		$balken[$i]["Schiff_Typ_4"] = $row->Schiff_Typ_4;
		$balken[$i]["Schiff_Typ_5"] = $row->Schiff_Typ_5;
		$balken[$i]["Schiff_Typ_6"] = $row->Schiff_Typ_6;
		$balken[$i]["Schiff_Typ_7"] = $row->Schiff_Typ_7;
		$balken[$i]["Schiff_Typ_8"] = $row->Schiff_Typ_8;
		$balken[$i]["Schiff_Typ_9"] = $row->Schiff_Typ_9;
		$balken[$i]["Schiff_Typ_10"] = $row->Schiff_Typ_10;
		$balken[$i]["Schiff_Typ_11"] = $row->Schiff_Typ_11;
		$balken[$i]["Schiff_Typ_12"] = $row->Schiff_Typ_12;

		$i++;

	}

	if(isset($balken)) { return $balken; } else { return "leer"; }

}


function get_flotte_mit_id($spieler_id, $id) {
	require 'inc/connect_galaxy_1.php';

	$sql = "SELECT `ID`, `Ankunft`, `Start`, `Spieler_ID`, `x1`, `y1`, `z1`, `x2`, `y2`, `z2`, `Ziel_Spieler_ID`, `Start_Planet_ID`, `Ziel_Planet_ID`, `Startplanet_Name`, `Zielplanet_Name`, `Besitzer_Spieler_Name`, `Ziel_Spieler_Name`, `Mission`, `Kapazitaet`, `Ausladen_Eisen`, `Ausladen_Silizium`, `Ausladen_Wasser`, `Einladen_Eisen`, `Einladen_Silizium`, `Einladen_Wasser`, `Schiff_Typ_1`, `Schiff_Typ_2`, `Schiff_Typ_3`, `Schiff_Typ_4`, `Schiff_Typ_5`, `Schiff_Typ_6`, `Schiff_Typ_7`, `Schiff_Typ_8`, `Schiff_Typ_9`, `Schiff_Typ_10`, `Schiff_Typ_11`, `Schiff_Typ_12` FROM `flotten` WHERE `Spieler_ID` = '$spieler_id' AND `ID` = $id";


	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );
	$row_cnt = $result->num_rows;
	if($row_cnt > 0) {
		$row = mysqli_fetch_object($result);


		$balken["ID"] = $row->ID;
		$balken["Ankunft"] = $row->Ankunft;
		$balken["Start"] = $row->Start;
		$balken["Spieler_ID"] = $row->Spieler_ID;
		$balken["x1"] = $row->x1;
		$balken["y1"] = $row->y1;
		$balken["z1"] = $row->z1;
		$balken["x2"] = $row->x2;
		$balken["y2"] = $row->y2;
		$balken["z2"] = $row->z2;
		$balken["Ziel_Spieler_ID"] = $row->Ziel_Spieler_ID;
		$balken["Start_Planet_ID"] = $row->Start_Planet_ID;
		$balken["Ziel_Planet_ID"] = $row->Ziel_Planet_ID;
		$balken["Startplanet_Name"] = $row->Startplanet_Name;
		$balken["Zielplanet_Name"] = $row->Zielplanet_Name;
		$balken["Besitzer_Spieler_Name"] = $row->Besitzer_Spieler_Name;
		$balken["Ziel_Spieler_Name"] = $row->Ziel_Spieler_Name;
		$balken["Mission"] = $row->Mission;
		$balken["Kapazitaet"] = $row->Kapazitaet;
		$balken["Ausladen_Eisen"] = $row->Ausladen_Eisen;
		$balken["Ausladen_Silizium"] = $row->Ausladen_Silizium;
		$balken["Ausladen_Wasser"] = $row->Ausladen_Wasser;
		$balken["Einladen_Eisen"] = $row->Einladen_Eisen;
		$balken["Einladen_Silizium"] = $row->Einladen_Silizium;
		$balken["Einladen_Wasser"] = $row->Einladen_Wasser;
		$balken["Schiff_Typ_1"] = $row->Schiff_Typ_1;
		$balken["Schiff_Typ_2"] = $row->Schiff_Typ_2;
		$balken["Schiff_Typ_3"] = $row->Schiff_Typ_3;
		$balken["Schiff_Typ_4"] = $row->Schiff_Typ_4;
		$balken["Schiff_Typ_5"] = $row->Schiff_Typ_5;
		$balken["Schiff_Typ_6"] = $row->Schiff_Typ_6;
		$balken["Schiff_Typ_7"] = $row->Schiff_Typ_7;
		$balken["Schiff_Typ_8"] = $row->Schiff_Typ_8;
		$balken["Schiff_Typ_9"] = $row->Schiff_Typ_9;
		$balken["Schiff_Typ_10"] = $row->Schiff_Typ_10;
		$balken["Schiff_Typ_11"] = $row->Schiff_Typ_11;
		$balken["Schiff_Typ_12"] = $row->Schiff_Typ_12;
	} else {
		return "ID nicht gefunden";
	}


	return $balken;

}

function mission_erkunden($flotte_abarbeiten, $spieler_id) {
	require 'inc/connect_galaxy_1.php';

	$x2 = $flotte_abarbeiten["x2"];
	$y2 = $flotte_abarbeiten["y2"];
	$Ankunft = $flotte_abarbeiten["Ankunft"];

	$sql = "INSERT INTO `sonnensystem` (`Spieler_ID`, `x`, `y`, `Entdeckt`, `locked`) VALUES ('$spieler_id', '$x2', '$y2', '" . date("Y-m-d\TH:i:s", $Ankunft) . "', '0')";
	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));
	
	if($result = mysqli_query($link, $query)) {
		return true;
	} else { return false; }
}

function mission_transport($flotte_abarbeiten, $spieler_id) {
	//1. Ress ausladen
	//2. Wenn eingeladen werden soll vorhandene Ress prüfen
	//3. Ress einladen

	require 'inc/connect_galaxy_1.php';

	//Start: 1. Ress ausladen
	$sql_part_schiffe = array();
	$x2 = $flotte_abarbeiten["x2"];
	$y2 = $flotte_abarbeiten["y2"];
	$z2 = $flotte_abarbeiten["z2"];
	$kapazität = $flotte_abarbeiten["Kapazitaet"];
	$planet_id = get_planet_id_by_koordinaten($spieler_id, $x2, $y2, $z2);


	$sql_part_schiffe[] = "`Ressource_Eisen` = `Ressource_Eisen` + " . $flotte_abarbeiten["Ausladen_Eisen"];
	$sql_part_schiffe[] = "`Ressource_Silizium` = `Ressource_Silizium` + " . $flotte_abarbeiten["Ausladen_Silizium"];
	$sql_part_schiffe[] = "`Ressource_Wasser` = `Ressource_Wasser` + " . $flotte_abarbeiten["Ausladen_Wasser"];

	$flotte_id = $flotte_abarbeiten["ID"];

	$sql = "UPDATE `planet` SET " . implode(", ", $sql_part_schiffe) . " WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

	if($result = mysqli_query($link, $query)) {
		//2. Wenn eingeladen werden soll vorhandene Ress prüfen

		$einladen = array();
		$einladen["Eisen"] = 0;
		$einladen["Silizium"] = 0;
		$einladen["Wasser"] = 0;
		$einladen["Eisen_Wunsch"] = $flotte_abarbeiten["Einladen_Eisen"];
		$einladen["Silizium_Wunsch"] = $flotte_abarbeiten["Einladen_Silizium"];
		$einladen["Wasser_Wunsch"] = $flotte_abarbeiten["Einladen_Wasser"];

		$Ressource = get_ressource($spieler_id, $planet_id);
		//Eisen
		if($einladen["Eisen_Wunsch"] >= $Ressource["Eisen"]) {
			$einladen["Eisen"] = $Ressource["Eisen"];
		} else {
			$einladen["Eisen"] = $einladen["Eisen_Wunsch"];
		}

		//Silizium
		if($einladen["Silizium_Wunsch"] >= $Ressource["Silizium"]) {
			$einladen["Silizium"] = $Ressource["Silizium"];
		} else {
			$einladen["Silizium"] = $einladen["Silizium_Wunsch"];
		}

		//Wasser
		if($einladen["Wasser_Wunsch"] >= $Ressource["Wasser"]) {
			$einladen["Wasser"] = $Ressource["Wasser"];
		} else {
			$einladen["Wasser"] = $einladen["Wasser_Wunsch"];
		}

		//Kapazität prüfen und gg. anpassen
		if($kapazität < $einladen["Eisen"] + $einladen["Silizium"] + $einladen["Wasser"]) {
			$benötigt = $einladen["Eisen"] + $einladen["Silizium"] + $einladen["Wasser"];
			$platz = $benötigt / $kapazität;
			$einladen["Eisen"] = floor($einladen["Eisen"] / $platz);
			$einladen["Silizium"] = floor($einladen["Silizium"] / $platz);
			$einladen["Wasser"] = floor($einladen["Wasser"] / $platz);
		}

		$sql_part_ress = array();
		$sql_part_ress[] = "`Ressource_Eisen` = `Ressource_Eisen` - " . $einladen["Eisen"];
		$sql_part_ress[] = "`Ressource_Silizium` = `Ressource_Silizium` - " . $einladen["Silizium"];
		$sql_part_ress[] = "`Ressource_Wasser` = `Ressource_Wasser` - " . $einladen["Wasser"];

		$sql = "UPDATE `planet` SET " . implode(", ", $sql_part_ress) . " WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
		$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

		if($result = mysqli_query($link, $query)) {
			//Flotte füllen

			$sql_part_ress = array();
			$sql_part_ress[] = "`Ausladen_Eisen` =  " . $einladen["Eisen"];
			$sql_part_ress[] = "`Ausladen_Silizium` = " . $einladen["Silizium"];
			$sql_part_ress[] = "`Ausladen_Wasser` = " . $einladen["Wasser"];

			$sql = "UPDATE `flotten` SET " . implode(", ", $sql_part_ress) . " WHERE `Spieler_ID` = '$spieler_id' AND `ID` = $flotte_id";
			$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

			if($result = mysqli_query($link, $query)) {

				return true;
			}

		}

	}

	return false;
}

function mission_kolonisieren($flotte_abarbeiten, $spieler_id, $username) {
	//- Schauen ob der Planet besetzt ist
	//- Sonnensystem als permanent Entdeckt setzen
	//- Planet besiedeln
	//- Ress auspacken
	//- 1 Koloschiff löschen 30% Ress gutschreiben
	//- Flotte am neuen Planet stationieren
	require 'inc/connect_galaxy_1.php';

	$x2 = $flotte_abarbeiten["x2"];
	$y2 = $flotte_abarbeiten["y2"];
	$z2 = $flotte_abarbeiten["z2"];
	$Ankunft = $flotte_abarbeiten["Ankunft"];

	$tech_spieler = get_tech_stufe_spieler($spieler_id); //Kolotech: Tech_10
	$anzahl_planeten = get_number_of_planets($spieler_id, 1);
	if($tech_spieler["Tech_10"] <= $anzahl_planeten - 1) { return false; }
	if (check_koordinaten_besetzt($x2, $y2, $z2) == false) { //Schauen ob der Planet besetzt ist

		$sql = "INSERT INTO `sonnensystem` (`ID`, `Spieler_ID`, `x`, `y`, `Entdeckt`, `locked`) VALUES (NULL, '$spieler_id', '$x2', '$y2', '" . date("Y-m-d\TH:i:s", $Ankunft) . "', '1')";
		$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

		if($result = mysqli_query($link, $query)) { //Sonnensystem als permanent Entdeckt setzen

			if(create_next_planet($spieler_id, $x2, $y2, $z2, $username) == true) {

				//lösche ein Koloschiff aus der Flotte
				$flotte_abarbeiten["Schiff_Typ_9"] = $flotte_abarbeiten["Schiff_Typ_9"] - 1;

				//Stationiere die Flotte inklusive Ress auf dem neuen Planeten


				if(mission_stationiere($flotte_abarbeiten, $spieler_id) == true ) {

				} else { echo "Flotte nicht stationiert"; return false; }
			} else { echo "Planet nicht erstellt"; return false; }
		} else { echo "Fehler beim Sonnensystem auf locked setzen"; return false; }
	} else { echo "Planet bereist besetzt"; return false; }

}

function mission_stationiere($flotte_abarbeiten, $spieler_id) {
	require 'inc/connect_galaxy_1.php';
	$sql_part_schiffe = array();
	$x2 = $flotte_abarbeiten["x2"];
	$y2 = $flotte_abarbeiten["y2"];
	$z2 = $flotte_abarbeiten["z2"];
	$planet_id = get_planet_id_by_koordinaten($spieler_id, $x2, $y2, $z2);

	for ($i = 1; $i <= 12; $i++) {
		$sql_part_schiffe[] = "`Schiff_Typ_" . $i . "` = `Schiff_Typ_" . $i . "` + " . $flotte_abarbeiten["Schiff_Typ_" . $i];
	}

	$sql_part_schiffe[] = "`Ressource_Eisen` = `Ressource_Eisen` + " . $flotte_abarbeiten["Ausladen_Eisen"];
	$sql_part_schiffe[] = "`Ressource_Silizium` = `Ressource_Silizium` + " . $flotte_abarbeiten["Ausladen_Silizium"];
	$sql_part_schiffe[] = "`Ressource_Wasser` = `Ressource_Wasser` + " . $flotte_abarbeiten["Ausladen_Wasser"];

	$flotte_id = $flotte_abarbeiten["ID"];
	$anzahl_bots_in_fleet = get_zähle_bots($flotte_abarbeiten);

	$sql_part_schiffe[] = "`Stationiert_Bot` = `Stationiert_Bot` + " . $anzahl_bots_in_fleet;

	$sql = "UPDATE `planet` SET " . implode(", ", $sql_part_schiffe) . " WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id";
	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

	if($result = mysqli_query($link, $query)) {

		//Bots auf dem Startplaneten abziehen
		$planet_id_start = $flotte_abarbeiten["Start_Planet_ID"];
		$sql = "UPDATE `planet` SET `Stationiert_Bot` = `Stationiert_Bot` - " . $anzahl_bots_in_fleet . " WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $planet_id_start";
		$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));
		if($result = mysqli_query($link, $query)) {

			//Flotte löschen
			$sql = "DELETE FROM `flotten` WHERE `ID` = " . $flotte_id;
			$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

			if($result = mysqli_query($link, $query)) {
				return true;
			} else { echo "Flotte wurde nicht gelöscht ->" . $sql; return false; }
			return true;
			} else { echo "Bots auf dem Startplaneten löschen failed"; return false;	}

		} else {echo "Flotte wurde nicht auf den neuen Planeten übertragen ->" . $sql; return false; }

}

function get_zähle_bots($flotte_abarbeiten) {
	$bots = 0;
	for($i = 1; $i <= 12; $i++) {
		$anzahl = $flotte_abarbeiten["Schiff_Typ_" . $i];
		if($anzahl > 0) {
			$bots = spaceships::$shipID[$i]->requiredBots * $anzahl;
		}
	}
	return $bots;
}


function mission_rückkehr_set($flotte_abarbeiten, $spieler_id) {
	require 'inc/connect_galaxy_1.php';

	$ankunft = $flotte_abarbeiten["Ankunft"] - $flotte_abarbeiten["Start"] + $flotte_abarbeiten["Ankunft"];
	$start = $flotte_abarbeiten["Ankunft"];
	$x1 = $flotte_abarbeiten["x2"];
	$y1 = $flotte_abarbeiten["y2"];
	$z1 = $flotte_abarbeiten["z2"];

	$x2 = $flotte_abarbeiten["x1"];
	$y2 = $flotte_abarbeiten["y1"];
	$z2 = $flotte_abarbeiten["z1"];

	$Ziel_Spieler_ID = $flotte_abarbeiten["Spieler_ID"];
	$Ziel_Planet_ID = $flotte_abarbeiten["Start_Planet_ID"];

	$Start_Planet_ID = $flotte_abarbeiten["Ziel_Planet_ID"];


	$Startplanet_Name = $flotte_abarbeiten["Zielplanet_Name"];
	$Zielplanet_Name = $flotte_abarbeiten["Startplanet_Name"];

	$mission = "rückkehr";

	$sql = "UPDATE `flotten` SET `Ankunft` = $ankunft, `Start` = $start, `x1` = $x1, `y1` = $y1, `z1` = $z1, `x2` = $x2, `y2` = $y2, `z2` = $z2, `Mission` = '$mission', `Ziel_Spieler_ID` = '$Ziel_Spieler_ID', `Start_Planet_ID` = '$Start_Planet_ID', `Ziel_Planet_ID` = '$Ziel_Planet_ID', `Startplanet_Name` = '$Startplanet_Name', `Zielplanet_Name` = '$Zielplanet_Name' WHERE `ID` = " . $flotte_abarbeiten["ID"];

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #mission_rückkehr ".$link));
	
	if($result = mysqli_query($link, $query)) {
		return true;
	} else {
		return false;
	}


}

function mission_rückkehr_set_manuell($flotte_id, $spieler_id) {
	require 'inc/connect_galaxy_1.php';

	$flotte_mit_id = get_flotte_mit_id($spieler_id, $flotte_id);

	$jetzt = time();
	$ankunft = $jetzt - $flotte_mit_id["Start"] + $jetzt;
	$start = $jetzt;
	$x1 = $flotte_mit_id["x2"];
	$y1 = $flotte_mit_id["y2"];
	$z1 = $flotte_mit_id["z2"];

	$x2 = $flotte_mit_id["x1"];
	$y2 = $flotte_mit_id["y1"];
	$z2 = $flotte_mit_id["z1"];

	$Ziel_Spieler_ID = $flotte_mit_id["Spieler_ID"];
	$Ziel_Planet_ID = $flotte_mit_id["Start_Planet_ID"];

	$Start_Planet_ID = $flotte_mit_id["Ziel_Planet_ID"];


	$Startplanet_Name = $flotte_mit_id["Zielplanet_Name"];
	$Zielplanet_Name = $flotte_mit_id["Startplanet_Name"];

	$mission = "rückkehr";

	$sql = "UPDATE `flotten` SET `Ankunft` = $ankunft, `Start` = $start, `x1` = $x1, `y1` = $y1, `z1` = $z1, `x2` = $x2, `y2` = $y2, `z2` = $z2, `Mission` = '$mission', `Ziel_Spieler_ID` = '$Ziel_Spieler_ID', `Start_Planet_ID` = '$Start_Planet_ID', `Ziel_Planet_ID` = '$Ziel_Planet_ID', `Startplanet_Name` = '$Startplanet_Name', `Zielplanet_Name` = '$Zielplanet_Name' WHERE `ID` = " . $flotte_mit_id["ID"];

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #mission_rückkehr ".$link));

	if($result = mysqli_query($link, $query)) {
		return true;
	} else {
		return false;
	}


}

function flotte_erkunden($px, $py, $spieler_id) {
	require 'inc/connect_galaxy_1.php';
	$sql = "SELECT `Spieler_ID`, `x2`, `y2`, `Mission` FROM `flotten` WHERE `x2` = $px AND `y2` = $py AND `Mission` = 'erkunden' AND `Spieler_ID` = '$spieler_id'";

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

	if($result = mysqli_query($link, $query)) {
		if($result->num_rows > 0) {
			return true;
		} else {
			return false;
		}
		return true;
	} else { return false; }
}

function mission_rückkehr_auflösen($fa, $spieler_id) {
	require 'inc/connect_galaxy_1.php';

	$ID = $fa["ID"];
	$Spieler_ID = $fa["Spieler_ID"];
	$Ziel_Planet_ID = $fa["Ziel_Planet_ID"];
	$Mission = $fa["Mission"];
	$Ausladen_Eisen = $fa["Ausladen_Eisen"];
	$Ausladen_Silizium = $fa["Ausladen_Silizium"];
	$Ausladen_Wasser = $fa["Ausladen_Wasser"];

	$Schiff_Typ_1 = $fa["Schiff_Typ_1"] + 0;
	$Schiff_Typ_2 = $fa["Schiff_Typ_2"] + 0;
	$Schiff_Typ_3 = $fa["Schiff_Typ_3"] + 0;
	$Schiff_Typ_4 = $fa["Schiff_Typ_4"] + 0;
	$Schiff_Typ_5 = $fa["Schiff_Typ_5"] + 0;
	$Schiff_Typ_6 = $fa["Schiff_Typ_6"] + 0;
	$Schiff_Typ_7 = $fa["Schiff_Typ_7"] + 0;
	$Schiff_Typ_8 = $fa["Schiff_Typ_8"] + 0;
	$Schiff_Typ_9 = $fa["Schiff_Typ_9"] + 0;
	$Schiff_Typ_10 = $fa["Schiff_Typ_10"] + 0;
	$Schiff_Typ_11 = $fa["Schiff_Typ_11"] + 0;
	$Schiff_Typ_12 = $fa["Schiff_Typ_12"] + 0;

	$sql ="UPDATE `planet` SET
	`Ressource_Eisen` = `Ressource_Eisen` + $Ausladen_Eisen,
	`Ressource_Silizium` = `Ressource_Silizium` + $Ausladen_Silizium,
	`Ressource_Wasser` = `Ressource_Wasser` + $Ausladen_Wasser,
	`Schiff_Typ_1` = `Schiff_Typ_1` + $Schiff_Typ_1,
	`Schiff_Typ_2` = `Schiff_Typ_2` + $Schiff_Typ_2,
	`Schiff_Typ_3` = `Schiff_Typ_3` + $Schiff_Typ_3,
	`Schiff_Typ_4` = `Schiff_Typ_4` + $Schiff_Typ_4,
	`Schiff_Typ_5` = `Schiff_Typ_5` + $Schiff_Typ_5,
	`Schiff_Typ_6` = `Schiff_Typ_6` + $Schiff_Typ_6,
	`Schiff_Typ_7` = `Schiff_Typ_7` + $Schiff_Typ_7,
	`Schiff_Typ_8` = `Schiff_Typ_8` + $Schiff_Typ_8,
	`Schiff_Typ_9` = `Schiff_Typ_9` + $Schiff_Typ_9,
	`Schiff_Typ_10` = `Schiff_Typ_10` + $Schiff_Typ_10,
	`Schiff_Typ_11` = `Schiff_Typ_11` + $Schiff_Typ_11 WHERE `Spieler_ID` = '$spieler_id' AND `Planet_ID` = $Ziel_Planet_ID";

	$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));
	//var_dump($query);

	if($result = mysqli_query($link, $query)) {

		$sql = "DELETE FROM `flotten` WHERE `ID` = $ID";
		$query = $sql or die("Error in the consult.." . mysqli_error("Error: #0002302 ".$link));

		if($result = mysqli_query($link, $query)) {
			return true;
		} else { return false; }

	} else { return false; }

}

function create_next_planet($spieler_id, $x, $y, $z, $username) {

	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");

	//Planet
	$planetname = $username."s Kolonie";
	$nächste_id = get_number_of_planets($spieler_id, 1);
	$abfrage = "INSERT INTO `planet`(`Spieler_ID`, `Spieler_Name`, `Planet_Name`, `x`, `y`, `z`, `Grund_Prod_Eisen`, `Grund_Prod_Silizium`, `Grund_Prod_Wasser`, `Planet_ID`, `Produktion_Zeit`, `Ressource_Eisen`, `Ressource_Silizium`, `Ressource_Wasser`, `Ressource_Bot`, `Stationiert_Bot`, `Stufe_Gebaeude_1`, `Stufe_Gebaeude_2`, `Stufe_Gebaeude_3`, `Stufe_Gebaeude_4`, `Stufe_Gebaeude_5`, `Stufe_Gebaeude_6`, `Stufe_Gebaeude_7`, `Stufe_Gebaeude_8`, `Stufe_Gebaeude_9`, `Stufe_Gebaeude_10`, `Stufe_Gebaeude_11`, `Prod_Eisen`, `Prod_Silizium`, `Prod_Wasser`, `Ressource_Energie`, `Ressource_Karma`, `Bauschleife_Gebaeude_ID`, `Bauschleife_Gebaeude_Start`, `Bauschleife_Gebaeude_Bis`, `Bauschleife_Gebaeude_Name`, `Bunker_Kapa`, `Bunker_Eisen`, `Bunker_Silizium`, `Bunker_Wasser`, `Bauschleife_Flotte_ID`, `Schiff_Typ_1`, `Schiff_Typ_2`, `Schiff_Typ_3`, `Schiff_Typ_4`, `Schiff_Typ_5`, `Schiff_Typ_6`, `Schiff_Typ_7`, `Schiff_Typ_8`, `Schiff_Typ_9`, `Schiff_Typ_10`, `Schiff_Typ_11`, `Schiff_Typ_12`, `Deff_Typ_1`, `Deff_Typ_2`, `Deff_Typ_3`, `Deff_Typ_4`, `Deff_Typ_5`, `Deff_Typ_6`, `Handel_Kapa`, `Handel_Eisen`, `Handel_Silizium`, `Handel_Wasser`, `punkte`, `Gesamt_Bot`) VALUES ('$spieler_id', '$username','$planetname', $x, $y, $z, 20,10,5, " . $nächste_id . ", '" . time() . "', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";

	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #0003b ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	return true;

}

function get_planet_id_by_koordinaten($spieler_id, $x, $y, $p) {
	require 'inc/connect_galaxy_1.php';
	$link->set_charset("utf8");

	$abfrage = "SELECT `Planet_ID` FROM `planet` WHERE `Spieler_ID` = '" . $spieler_id. "' AND `x` = " . $x . " AND `y` = " . $y . " AND `z` = " . $p . " ORDER BY `Planet_ID` DESC LIMIT 1";
	$query = $abfrage or die("Error in the consult.." . mysqli_error("Error: #get_lastet_planet ".$link));
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	$row = mysqli_fetch_object($result);
	return $row->Planet_ID;

}

function get_timestamp_in_was_sinnvolles($value) {
	$secs = number_format($value, 0, '', '');
	$dtF = new DateTime("@0");
	$dtT = new DateTime("@$secs");

	$diff = $dtF->diff($dtT);
	$tage = $diff->days;

	if($tage == 0) {
		return $dtF->diff($dtT)->format('%H:%I:%S');
	} else {
		if ($tage==1) {
			return $dtF->diff($dtT)->format('%a Tag %H:%I:%S');
		} else {
			return $dtF->diff($dtT)->format('%a Tage %H:%I:%S');
		}
	}
}



function get_possible_languages () {}



function get_language_defaults ($lng_id = null) {
	// written by ES  Sep 2016

	static $last_call_lng_id;
	static $lng_defaults;
	$file = 'lng/lng.xml';

	// if first call of function and $lng_id is not set  use  english for default
	if (!isset($last_call_lng_id) && !isset($lng_id)) { $last_call_lng_id = 'en'; }

	if (!isset($lng_id)) {$lng_id = $last_call_lng_id;};

	$last_call_lng_id = $lng_id;

	if (isset($lng_defaults['id'])) {if ($lng_defaults['id'] <> $lng_id) {$lng_defaults['id'] = null;}}

	if (!isset($lng_defaults['id'])) {
		if (file_exists($file)) {
			$xml = simplexml_load_file($file);

			foreach ($xml->language as $language) {
				if ($language['id']->__toString() == $lng_id) {
					foreach ($language->attributes() as $key => $value) {
						$lng_defaults[$key] = $value->__toString();
					}
				}
			}
		} else {
			error_log ('>>><b>ERROR:</b> language file: <b>' . $file . '</b> don´t exits !<<<');
		}
	}
	return $lng_defaults;
}


function get_language_file ($lng_id, $filename, $lng) {
	// written by ES  Sep 2016

	$lngFile = 'lng/' . $lng_id . '_' . $filename . '.xml';

	if (file_exists($lngFile)) {
		$xml = simplexml_load_file($lngFile);
		foreach ($xml->string as $string) {
			$lng['~~' . $filename . '~~ ' . $string['id']->__toString()]=$string['text']->__toString();
		}
		$lng['language file for ' . $filename. '.php loaded'] = true;
	} else {
		$lng['language file for ' . $filename. '.php loaded'] = false;
		error_log ('>>><b>ERROR:</b> language file: <b>' . $lngFile . '</b> don´t exits !<<<');
	}
	return $lng;
}


function lng_echo ($id, $open_txt_file = false, $echo_on = true, $var_array = null){
	// written by ES  Sep 2016
	// return language string or file-content
	// string lng_echo (string $id [, bool  $open_txt_file = false [, $no_echo = false]] )
	// 						$id = string-id or filename
	// if  only $id  is set, lng_echo search for string-id in 'lng/' . $selected_lng_id . '_' . $function_called_from_file . '.xml'  (for example: file: lng/de_messages.xml)
	// if $open_txt_file is set, lng_echo search for file 'lng/' . $selected_lng_id . '_' . $id . '.txt'  (for example: file: lng/de_number_test.txt)
	// in both case, {variable_name} will be replaced with global defined variables with variable_name, the value can be formated
	// number format :  {#.#0,00@variable_name}  #.# set thousands_sep  / 0,00 set dezimal point and number of dezimals

	static $lng;

	$lng_defaults = get_language_defaults();

	$error_reading_file = false;

	$function_called_from_file = pathinfo(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,1)[0]['file'])['filename'];

	if (!$open_txt_file && !isset ($lng['language file for ' . $function_called_from_file. '.php loaded'])) {$lng = get_language_file ($lng_defaults['id'], $function_called_from_file, $lng);}

	if (!$open_txt_file && !isset ($lng['~~' . $function_called_from_file . '~~ ' . $id])) {
		//$string = '>>><b>Notice: </b>Undefined string-id:<b> ' . $id . '</b> in language file: <b>' . $selected_lng_id . '_' . $function_called_from_file . '.xml</b><<<';
		$string = $id;
	} else {
		if ($open_txt_file) {
			$txtFile = ('lng/' . $lng_defaults['id'] . '_' . $id . '.txt');
			if (file_exists($txtFile)) {
				$string = file_get_contents($txtFile);
				dVar ($string,'$string');
			} else {
				$error_reading_file = true;
				$string = '>>><b>ERROR:</b> language file: <b>' . $lng_defaults['id'] . '_' . $id . '.txt</b> don´t exits !<<<';
			}
		} else {
			$string = $lng['~~' . $function_called_from_file . '~~ ' . $id];
		}
	}

	if (!$error_reading_file) {
		$error = false;
		while (strpos($string, '{') !== false && !$error) {
			$pos1 = strpos($string, '{');
			$pos2 = strpos($string, '}');
			if ($pos2 === false) {								// check only {  without } and delete lonley {
				$string = substr($string, 0, $pos1).substr($string, $pos1+1, strlen($string));
			} else {
				$var_name = substr ($string , $pos1 +1, $pos2 - $pos1 -1);

				$formatted_output  = stripos ($var_name, '@');  // check for formatted  output
				if ($formatted_output !== false) {
					$format = substr ($var_name, 0, $formatted_output);
					$var_name = substr ($var_name, $formatted_output+1, strlen($var_name));
				} else {
					$format = 'n';
				}
				$value = get_value_of_variable ($var_name, $var_array);
				if (is_numeric($value)) {$value = lng_number_format ($value, $format);}

				if ($formatted_output !== false && (strpos ($value,'Notice:') === false)) {
					//if (is_numeric($value)) {$value = lng_format_number ($value, $format);}
				} else if (strpos ($value,'<b>Notice:</b>') !== false) {
					$error = true;
					if ($open_txt_file) {
						$value .= ' in language file: <b>' . $lng_defaults['id'] . '_' . $id . '.txt</b><<<';
					} else {
						$value .= ' in language file: <b>' . $lng_defaults['id'] . '_' . $function_called_from_file . '.xml </b> string-id: <b>' . $id . '</b><<<';
					}
				} 
				if ($error) {
					$string = $value;
				} else {
					$string = substr($string, 0, $pos1).$value.substr($string, $pos2+1, strlen($string)-$pos2-1);
				}
			}
		}
	}
	if ($echo_on) {echo $string;}
	return $string;
}

function get_value_of_variable ($variable, $var_array) {		// check for black / white listed variables
	// written by ES  Sep 2016

	if (!isset($var_array)) {$var_array = $GLOBALS;};
	if (is_object($var_array)) {$var_array = (array)$var_array;}

	$value = false;
	$variable_blocked = true;
	$block_variable_names_begin_with_underline = true;
	$blacklist = array ('spieler_id', 'session_id');

	if (!($block_variable_names_begin_with_underline && (substr($variable,0,1)=='_'))) {

		$variable_blocked = false;
		$index_undefined = false;

		$pos = strpos ($variable,'[');  // check for array
		if ($pos !== false) {
			$index = substr ($variable, $pos +2, strlen ($variable) - $pos -4);
			if (isset($var_array[substr ($variable, 0, $pos)])) {
				$variable = substr ($variable, 0, $pos);
				$array = $var_array[$variable];
				if (isset($array[$index])) {
					$value = $array[$index];
				} else {
					$index_undefined = true;
				}
			}
		} else {
			if (isset($var_array[$variable])) {
				$value = $var_array[$variable];
			}
		}
	}

	if (in_array($variable, $blacklist) || $variable_blocked) { 		// check Blacklist
		$value = '>>><b>Notice:</b> Blocked variable: <b>' . $variable . '</b>';}

	if ($value === false ) { 										// check variable name is defined in global scope
		if ($index_undefined) {
			$value = '>>><b>Notice:</b> Undefined index: <b>' . $variable . '["' . $index . '"]</b>';
		} else {
			$value = '>>><b>Notice:</b> Undefined variable: <b>' . $variable . '</b>';
		}
	}
	return $value;
}

function german_res_to_english_res ($resources) {
	// written by ES  Sep 2016

	$replace = 	array 	(	// for german variable $ressource
							'Eisen' 			=> 'iron' 				,	'Silizium'		=> 'silicon' 				,
							'Wasser'		=> 'water' 				, 	'Energie'		=> 'energy' 			,
							'Bot'			=> 'bots' 				,	'Bot Gesamt'	=>	'total bots'			,
							'Bot Stationiert'	=>	'stationed bots'		,	'Karma'			=>	'karma'

							//for german variable $constuction
							//'Kosten_Eisen'	=>	'required iron'		,	'Kosten_Karma'	=>	'required karma'	,
							//'Kosten_Silizium'=>	'required silicon'		,	'Kosten_Wasser' =>	'required water'		,
							//'Bots'			=>	'required bots'		,	'Max_Hold_Planet'=>'max hold planet'	,
							//'Max_Hold'		=>	'max hold'

						);

	foreach ($replace as $index => $replacement) {
		if (isset ($resources[$index])) {$resources [$replacement] = $resources [$index]; unset($resources [$index]);}
	}

	return ($resources);
}

function round_down($number) {
	// written by ES  Sep 2016

	$rounded_number = round($number);
	if ($rounded_number > $number) {$rounded_number--;}
	return $rounded_number;
}



function lng_number_format ($number, $format = 'n') {
	// written by ES  Sep 2016

	$lng_defaults = get_language_defaults();
	$number = floatval ($number);
	$formated_number = '';
	$last_number = 0;

	if (isset($format)) { 			// if only one letter set default , respectively set format for single placeholder
		if (strlen($format) == 1) {
			switch ($format) {
				case 'd'	: 	$format = $lng_defaults['date_format']; break;
				case 't'	:	$format = $lng_defaults['time_format']; break;
				case 'c'	:	$format = $lng_defaults['countdown_format']; break;
				case 'C'	:	$format = $lng_defaults['enhanced_countdown_format']; break;
				case 'n'	:	$format = $lng_defaults['number_format']; break;
			}
		}
	}

	// test for countdown
	$temp = explode("'", $format);
	$typ_check = '';
	foreach($temp as $key => $string) {	// for typ check delete all strings in format string
		if (round_down($key/2) == $key/2) {
			$typ_check .= $string;}}

	switch (true) {
		case (strpos($typ_check,'C') !== false) :		// typ is countdown
			$timestamp = round_down($number);
			$days = round_down($timestamp/(24*60*60)); 		$timestamp -= ($days*(24*60*60));
			$hours = round_down($timestamp/(60*60));		$timestamp -= ($hours*(60*60));
			$min = round_down($timestamp/(60));				$timestamp -= ($min*(60));
			$sec = $timestamp;

			$no_zero_value = false;
			$next_case_string = '';

			while (strlen($format) > 0) {
				$pos = 0;
				$case_string = substr($format,0,1);
				while ($case_string == substr($format,$pos,1)) {$pos++; }
				switch ($case_string) {
					case 'h'	:
					case 'm' :
					case 's'	:
					case 'C'	:
						if ($next_case_string <> $case_string) {$no_zero_value = false;}
						switch ($case_string) {
							case 'h'	:	$last_number = $hours;				break;
							case 'm' :	$last_number = $min;				break;
							case 's'	:	$last_number = $sec;				break;
							case 'C'	:	$last_number = $days;				break;
						}
						if (!(($last_number == 0) && $no_zero_value)) {
							if ($pos == 1) {
								$formated_number .= $last_number;
							} else {
								if ($last_number < 10) {$formated_number .= '0' . $last_number;}
										else {$formated_number .= $last_number;}
							}
						}
						break;

					case '~'	:
						$next_case_string = substr($format,1,1);
						$no_zero_value = true;
						break;

					case "'"	:
						$pos = strpos($format, "'", 1);
						if (!(($last_number == 0) && $no_zero_value)) {
							$temp = explode ('|',substr($format,1,$pos-1));
							if (count($temp) == 2) {
								if ($last_number == 1) {$formated_number .= $temp[0];}
									else {$formated_number .= $temp[1];}
							} else {
								$formated_number .= $temp[0];
							}
						}
						$no_zero_value = false;
						$pos++;
						break;

					default :
						for ($pos1 = 1; $pos1 <= strlen($format);) {
							switch (substr($format,$pos1,1)) {
								case 'h'	:	case 'm' :	case 's'	:
								case 'C'	:	case '~'	:	case "'"	:
									$pos = $pos1;
									$pos1 = strlen($format);
									break;

								default:
									$pos1++;
									break;
							}
						}
						if (!(($last_number == 0) && $no_zero_value)) {$formated_number .=substr($format,0,$pos);}
						break;
				}
				$format = substr($format,$pos,strlen($format));
			}
			break;

		case (strpos($typ_check,'#') !== false) :	// typ is formated number
		case (strpos($typ_check,'0') !== false) :
			$thousands_sep = '';	$decimal_point = '';
			$leading_zeros = 0;		$decimals = 0;			$last_case_number = false;
			while (strlen($format) > 0) {
				$pos = 0;
				$case_string = substr($format,0,1);
				while ($case_string == substr($format,$pos,1)) {$pos++; }
				switch ($case_string) {
					case '#'	:
						if ((substr($format,$pos,1) <> '#') && (substr($format,$pos+1,1) == '#')) {
							$thousands_sep = substr($format,$pos,1);
							$pos++;
						}
						$last_case_number = true;
						break;

					case '0' :
						if ((substr($format,$pos,1) <> '0') && (substr($format,$pos+1,1) === '0')) {
							$decimal_point = substr($format,$pos,1);
							$leading_zeros = $pos;
							$pos++;
						}
						if ($decimal_point <> '') {$decimals = $pos;} else {$leading_zeros = $pos;}
						$last_case_number = true;
						break;

					case "'":
					//default :
						if ($case_string == "'") {		// insert String
							$pos = strpos($format, "'", 1);
							$temp = explode ('|',substr($format,1,$pos-1));
							if (count($temp) == 2) {
								if ($number == 1) {$formated_number .= $temp[0];}
									else {$formated_number .= $temp[1];}
							} else {
								$formated_number .= $temp[0];
							}
							$pos++;
						} else {
						}
						break;
				}

				switch (true) {
					case ($last_case_number && $pos >= strlen($format)) :
					case ($last_case_number && $case_string <> '0' && $case_string <> '#') :
						// format number
						$thousand_fill = '000'; for ($i = 0; $i <=10; $i++) {$thousand_fill .=  $thousands_sep . '000'  ;}
						$number_of_thousands = round_down(strlen(number_format($number,0,'',''))/3);
						$number_remaing_length = strlen(number_format($number,0,'','')) - ($number_of_thousands * 3);

						$number_string = substr($thousand_fill, 0, strlen($thousand_fill) -  $number_remaing_length) ;
						if(!$number_remaing_length){$number_string .= $thousands_sep;}
						$number_string .= number_format ($number,$decimals,$decimal_point,$thousands_sep);

						if ($number > pow (10,$leading_zeros)) {
							for ($leading_zeros = $leading_zeros; $number >= pow (10,$leading_zeros); $leading_zeros++) {}
						}
						$pos_cut = strlen($number_string) - $leading_zeros - (round_down($leading_zeros/3) * strlen($thousands_sep)) - strlen($decimal_point) - $decimals;
						if (round_down($leading_zeros/3) == $leading_zeros/3)  {$pos_cut++;}

						$formated_number .= substr($number_string, $pos_cut) ;
						if ($case_string <> '0' && $case_string <> '#') {$formated_number .= substr($format,0,$pos);}

						$thousands_sep = '';	$decimal_point = '';						// clear parameter
						$leading_zeros = 0;		$decimals = 0;		$last_case_number = false;
						break;

					case (($case_string <> '0') && ($case_string <> '#')) :
							$formated_number .= substr($format,0,$pos);
						break;
				}

				$format = substr($format, $pos, strlen($format));

			}
			break;

		default:										// typ is date / time
			$am_pm = false;

			// new placeholder for am/pm
			while (($pos = strpos($format, 'am/pm')) !== false) {
				$format = substr($format,0,$pos) . '~!~!~!~' . substr($format,$pos+5,strlen($format));
				$am_pm = true;
			}

			while (($pos = strpos($format, 'AM/PM')) !== false) {
				$format = substr($format,0,$pos) . '~^~^~^~' . substr($format,$pos+5,strlen($format));
				$am_pm = true;
			}

			while (strlen($format) > 0) {
				$pos = 0;
				while (substr($format,0,1) == substr($format,$pos,1)) {$pos++; }
				switch (substr($format,0,1)) {
					case 'T'	:
					case 'D'	:
						switch ($pos) {
							case 1 :		$formated_number .= date ('j', $number);		break;
							case 2 :		$formated_number .= date ('d', $number);		break;
							case 3 :		$formated_number .= explode('|', $lng_defaults[strtolower(date ('l', $number))])[0];		break;
							case 4 :		$formated_number .= explode('|', $lng_defaults[strtolower(date ('l', $number))])[1];		break;
						}
						break;

					case 'M'	:
						switch ($pos) {
							case 1 :		$formated_number .= date ('n', $number);		break;
							case 2 :		$formated_number .= date ('m', $number);		break;
							case 3 :		$formated_number .= explode('|', $lng_defaults[strtolower(date ('F', $number))])[0];		break;
							case 4 :		$formated_number .= explode('|', $lng_defaults[strtolower(date ('F', $number))])[1];		break;
						}
						break;

					case 'Y'	:
					case 'J'	:
						switch ($pos) {
							case 1 :		case 2 :		$formated_number .= date ('y', $number);		break;
							case 3 :		case 4 :		$formated_number .= date ('Y', $number);		break;
						}
						break;

					case 'h'	:
						switch ($pos) {
							case 1 :		if ($am_pm) {$formated_number .= date ('g', $number);}
											else {$formated_number .= date ('G', $number);}			break;
							case 2 :		if ($am_pm) {$formated_number .= date ('h', $number);}
											else {$formated_number .= date ('H', $number);}			break;
						}
						break;

					case 'm'	:
						switch ($pos) {
							case 1 :		$temp = date ('i', $number);
										if (substr($temp,0,1) == '0') {$formated_number .= substr($temp,1,1);}
											else {$formated_number .= $temp;}						break;
							case 2 :		$formated_number .= date ('i', $number);		break;
						}
						break;

					case 's'	:
						switch ($pos) {
							case 1 :		$temp = date ('s', $number);
										if (substr($temp,0,1) == '0') {$formated_number .= substr($temp,1,1);}
											else {$formated_number .= $temp;}						break;
							case 2 :		$formated_number .= date ('s', $number);		break;
						}
						break;

					case "'"	:
						$pos = strpos($format, "'", 1) ;
						$formated_number .= substr($format,1,$pos-1);
						$pos++;
						break;

					default	:	$formated_number .=	substr($format,0,$pos);			break;
				}
				$format = substr($format,$pos,strlen($format));
			}

			// exchange placeholder for am/pm
			while (($pos = strpos($formated_number, '~!~!~!~')) !== false) {
				$formated_number = substr($formated_number,0,$pos) . date ('a', $number) . substr($formated_number,$pos+7,strlen($formated_number));
				$am_pm = true;
			}

			while (($pos = strpos($formated_number, '~^~^~^~')) !== false) {
				$formated_number = substr($formated_number,0,$pos) . date ('A', $number) . substr($formated_number,$pos+7,strlen($formated_number));
				$am_pm = true;
			}

			break;  // end date time
	}

	return $formated_number;
}
?>
