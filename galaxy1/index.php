<?php 
$start = microtime(true);
//#######################################
//index.php im Galaxyverzeichnis
//#######################################
//error_reporting(0);
error_reporting(E_ALL);
session_start();
require (dirname(__FILE__) . '/inc/func_galaxy.php');
require (dirname(__FILE__) . '/inc/conf_structure.php');
require (dirname(__FILE__) . '/inc/conf_tech.php');
include (dirname(__FILE__) . '/inc/conf_ship.php');
include (dirname(__FILE__) . '/inc/conf_def.php');

$spieler_id = ""; $session_id = ""; $username = "";

if (isset($_SESSION["spieler_ID"])) { $spieler_id = $_SESSION["spieler_ID"]; } 
if (isset($_SESSION["session_id"])) { $session_id = $_SESSION["session_id"]; }

if (check_auth($spieler_id, $session_id) == "nein"){
	    session_unset(); session_destroy(); $_SESSION = array(); header('Location: ../index.html'); exit();
	    exit();	
}

if (isset($_SESSION["username"])) { $username = $_SESSION["username"]; } else { $_SESSION["username"] = get_spieler_name($spieler_id); $username = $_SESSION["username"]; }

//var_dump($_POST);

if(!isset($_POST["s"])){ 
	if(!isset($_GET["s"])){ $select = "index";} else { $select = $_GET["s"]; }
} else { $select = $_POST["s"]; }


if(!isset($_POST["p"])){
	if(isset($_GET["p"])){ $planet_wahl = intval($_GET["p"], 10); }
} else { $planet_wahl = intval($_POST["p"], 10); }

$planet_id = get_last_planet($spieler_id);

if(isset($planet_wahl)) {		
	if(is_numeric(usereingabe_cleaner($planet_wahl))) {
		if(set_last_planet($spieler_id, usereingabe_cleaner($planet_wahl) - 1) == true ) {
			$planet_id = usereingabe_cleaner($planet_wahl) - 1;
		}		
	}	
}
//prüf mal ob der Spieler überhaupt einen Planeten in der Gala hat

if (get_anzahl_planeten($spieler_id, 1) == 0) { session_unset(); session_destroy(); $_SESSION = array(); header('Location: ../index.html'); exit(); }

//ENDE: prüf mal ob der Spieler überhaupt einen Planten in der Gala hat ;)

switch ($select) {
	case "hypersprung": //hypersprung.php
		exit();
		$nav_page_title = "";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "display: none;";
		$bar_planet_info = false;
		$cache = true;
		break;
	case "index": //galaxy.php		
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		$cache = false;
		break;
	case "initialisiere": //init.php
		exit();
		$nav_page_title = "";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "display: none;";
		$bar_planet_info = false;
		$cache = true;
		break;
	case "create_gamer": //create_gamer.php
		exit();
		$nav_page_title = "";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "display: none;";
		$bar_planet_info = false;
		$cache = true;
		break;
	case "Gebaeude":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		$cache = true;
		break;
	case "Forschung":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		$cache = true;
		break;
	case "Nachrichten":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		$cache = true;
		break;
	case "Raumschiffe":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		$cache = true;
		break;
	case "Flotte-Info":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		$cache = true;
		break;
	case "Rangliste":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		$cache = true;
		break;
	case "Verteidigung":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		$cache = true;
		break;
	case "Sonnensystem":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		$cache = true;
		break;
	case "Einstellungen":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		$cache = true;
		break;
	default:
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		$cache = false;
		break;
}

//---- ToDo: C

//--- Flotte Aktion & Rückkehr
	$notfall_break = 0;	
	while($flotte_abarbeiten = get_flotte_in_der_luft($spieler_id, time(), true)) {			
		if($flotte_abarbeiten != "leer") {
			
			//var_dump($flotte_abarbeiten);
			foreach($flotte_abarbeiten as $key => $value) {
				
				switch ($flotte_abarbeiten[$key]["Mission"]) {
					
					case "erkunden": 
						if(mission_erkunden($flotte_abarbeiten[$key], $spieler_id) == true) {
							if(mission_rückkehr_set($flotte_abarbeiten[$key], $spieler_id) == false) {
								echo "Fehler mission_rückkehr index.php Zeile 154";
								echo "Wenn das hier jemand liest, sagt mal bitte bescheid.";
								exit;
							}
						}
					break;
					
					case "Sicherungsflug":
						if(mission_erkunden($flotte_abarbeiten[$key], $spieler_id) == true) {
							if(mission_rückkehr_set($flotte_abarbeiten[$key], $spieler_id) == false) {
								echo "Fehler mission_rückkehr index.php Zeile 164";
								echo "Wenn das hier jemand liest, sagt mal bitte bescheid.";
								exit;
							}
						}
						break;
					case "Angriff":
						if(mission_erkunden($flotte_abarbeiten[$key], $spieler_id) == true) {
							if(mission_rückkehr_set($flotte_abarbeiten[$key], $spieler_id) == false) {
								echo "Fehler mission_rückkehr index.php Zeile 164";
								echo "Wenn das hier jemand liest, sagt mal bitte bescheid.";
								exit;
							}
						}
						break;
					case "Kolonisierung":
						if(mission_kolonisieren($flotte_abarbeiten[$key], $spieler_id, $username) == true) {
							if(mission_rückkehr_auflösen($flotte_abarbeiten[$key], $spieler_id) == false) {
								echo "Fehler mission_rückkehr index.php Zeile 164";
								echo "Wenn das hier jemand liest, sagt mal bitte bescheid.";
								exit;
							}
						}
						break;
					case "Spionage":
						if(mission_erkunden($flotte_abarbeiten[$key], $spieler_id) == true) {
							if(mission_rückkehr_set($flotte_abarbeiten[$key], $spieler_id) == false) {
								echo "Fehler mission_rückkehr index.php Zeile 164";
								echo "Wenn das hier jemand liest, sagt mal bitte bescheid.";
								exit;
							}
						}
						break;
						
					case "Transport":
						if(mission_erkunden($flotte_abarbeiten[$key], $spieler_id) == true) {
							if(mission_rückkehr_set($flotte_abarbeiten[$key], $spieler_id) == false) {
								echo "Fehler mission_rückkehr index.php Zeile 164";
								echo "Wenn das hier jemand liest, sagt mal bitte bescheid.";
								exit;
							}
						}
						break;
					case "rückkehr":						
						if(mission_rückkehr_auflösen($flotte_abarbeiten[$key], $spieler_id) == true) {
							
						} else {
							echo "Fehler mission_rückkehr index.php Zeile 147";
							echo "Wenn das hier jemand liest, sagt mal bitte bescheid.";
							exit;
								
						}
				}
				
			}
					
			
		} else {
			break;
		}
		$notfall_break++;
		if($notfall_break > 30) { break; } //Notfall break wenn Flotte nicht aufgelöst werden kann 
	}	
	


//---- Abgelaufene Bauschleifen fertigstellen

	//--- Gebäude
	$bauschleife = check_bauschleife_activ($spieler_id, $planet_id, "Structure");
	if ($bauschleife["ID"] > 0 and $bauschleife["Bis"] <= time()) {
		
		$gebäude_id = $bauschleife["ID"];		
		set_bauschleife_struckture_fertig($spieler_id, $planet_id, $gebäude_id, $username);
		
	}

	//--- Forschung
	$bauschleife = check_bauschleife_activ($spieler_id, $planet_id, "Tech");
	if ($bauschleife["ID"] > 0 and $bauschleife["Bis"] <= time()) {
	
		$tech_id = $bauschleife["ID"];
		set_bauschleife_tech_fertig($spieler_id, $planet_id, $tech_id, $username);
	
	}
	
	//--- Schiffe
	
	$bauschleife = check_bauschleife_activ($spieler_id, $planet_id, "Ship");
	if ($bauschleife["ID"] > 0) {
		
		set_bauschleife_ship_fertig($spieler_id, $planet_id);
		
	
	}
	
	//--- Deff
	
	$bauschleife = check_bauschleife_activ($spieler_id, $planet_id, "Deff");
	if ($bauschleife["ID"] > 0) {
		set_bauschleife_deff_fertig($spieler_id, $planet_id);
	}
	
	
//---- ENDE: Abgelaufene Bauschleifen fertigstellen

//---- Bauschleife abbrechen

	//--- Gebäude
	if(isset($_POST["action-gebaeude-abbrechen"])) {
	
		if (is_numeric($_POST["action-gebaeude-abbrechen"])) {
	
			$bauschleife = check_bauschleife_activ($spieler_id, $planet_id, "Structure");
			
			if ($bauschleife["ID"] > 0) { 
				
				$gebäude_id = $_POST["action-gebaeude-abbrechen"];				

				set_bauschleife_structure_abbruch($spieler_id, $planet_id, $gebäude_id, $username);			
			}
		}
	}

	//--- Tech
	if(isset($_POST["action-forschung-abbrechen"])) {
	
		if (is_numeric($_POST["action-forschung-abbrechen"])) {
	
			$bauschleife = check_bauschleife_activ($spieler_id, $planet_id, "Tech");
				
			if ($bauschleife["ID"] > 0) {
	
				$tech_id = $_POST["action-forschung-abbrechen"];
	
				set_bauschleife_tech_abbruch($spieler_id, $planet_id, $tech_id, $username);
			}
		}	
	}
	//--- Schiffe
	if (isset($_POST["action-schiffe-abbrechen"])) {
		if (is_numeric($_POST["action-schiffe-abbrechen"])) {
			
			set_bauschleife_ship_abbruch($spieler_id, $planet_id, $_POST["action-schiffe-abbrechen"]);
			
		}
	}
	
	//--- Deff
	if (isset($_POST["action-deff-abbrechen"])) {
		if (is_numeric($_POST["action-deff-abbrechen"])) {
				
			set_bauschleife_deff_abbruch($spieler_id, $planet_id, $_POST["action-deff-abbrechen"]);
				
		}
	}
	
	
	
//---- Ende: Bauschleife abbrechen 
	
//---- Gebäude bauen

	if(isset($_POST["action-gebaeude-bauen"])) {
	
		if (is_numeric($_POST["action-gebaeude-bauen"])) {

			
			$kann_gebaut_werden = true;

			$bauschleife = check_bauschleife_activ($spieler_id, $planet_id, "Structure");
				
			if ($bauschleife["ID"] > 0) { $kann_gebaut_werden = false; } else {
				
				$gebäude_id = $_POST["action-gebaeude-bauen"];
				$ressource = get_ressource($spieler_id, $planet_id);
				$Gebäude = get_gebäude_nächste_stufe($spieler_id, $planet_id, $gebäude_id, 1);
		
				if($ressource["Eisen"] < $Gebäude["Kosten_Eisen"]) { $kann_gebaut_werden = false; }
				if($ressource["Silizium"] < $Gebäude["Kosten_Silizium"]) { $kann_gebaut_werden = false; }
				if($ressource["Wasser"] < $Gebäude["Kosten_Wasser"]) { $kann_gebaut_werden = false; }
				if($ressource["Energie"] < $Gebäude["Kosten_Energie"]) { $kann_gebaut_werden = false; }
				if($ressource["Karma"] < $Gebäude["Kosten_Karma"]) { $kann_gebaut_werden = false; }
				
				if ($kann_gebaut_werden == true) {
					
					$bauzeit = time() + $Gebäude["Bauzeit"];
					
					set_bauschleife_struckture($spieler_id, $planet_id, $gebäude_id, $Gebäude["Name"], $bauzeit, $ressource["Eisen"], $ressource["Silizium"], $ressource["Wasser"], $ressource["Energie"], $ressource["Karma"], $Gebäude["Kosten_Eisen"], $Gebäude["Kosten_Silizium"], $Gebäude["Kosten_Wasser"], $Gebäude["Kosten_Energie"], $Gebäude["Kosten_Karma"], $username);
					
				} else {
					
					die(""); //ToDo: Fehlermeldung einbauen
					
				}
			}
		}
	}


//---ENDE: Gebäude bauen

//--- Forschung einreihen
	
	
	if(isset($_POST["action-forschung-bauen"])) {
	
		if (is_numeric($_POST["action-forschung-bauen"])) {
	
				
			$kann_gebaut_werden = true;
	
			$bauschleife = check_bauschleife_activ($spieler_id, $planet_id, "Tech");
	
			if ($bauschleife["ID"] > 0) { $kann_gebaut_werden = false; } else {
	
				$tech_id = $_POST["action-forschung-bauen"];
				$ressource = get_ressource($spieler_id, $planet_id);
				$Tech = get_tech_nächste_stufe($spieler_id, $planet_id, $tech_id, 1);
	
				if($ressource["Eisen"] < $Tech["Kosten_Eisen"]) { $kann_gebaut_werden = false; }
				if($ressource["Silizium"] < $Tech["Kosten_Silizium"]) { $kann_gebaut_werden = false; }
				if($ressource["Wasser"] < $Tech["Kosten_Wasser"]) { $kann_gebaut_werden = false; }				
				if($ressource["Karma"] < $Tech["Kosten_Karma"]) { $kann_gebaut_werden = false; }
	
				if ($kann_gebaut_werden == true) {
						
					$bauzeit = time() + $Tech["Bauzeit"];
						
					//set_bauschleife_struckture($spieler_id, $planet_id, $gebäude_id, $Gebäude["Name"], $bauzeit, $ressource["Eisen"], $ressource["Silizium"], $ressource["Wasser"], $ressource["Energie"], $ressource["Karma"], $Tech["Kosten_Eisen"], $Tech["Kosten_Silizium"], $Tech["Kosten_Wasser"], $Tech["Kosten_Energie"], $Tech["Kosten_Karma"]);

					set_bauschleife_tech($spieler_id, $planet_id, $tech_id, $Tech["Name"], $bauzeit, $ressource["Eisen"], $ressource["Silizium"], $ressource["Wasser"], $ressource["Karma"], $Tech["Kosten_Eisen"], $Tech["Kosten_Silizium"], $Tech["Kosten_Wasser"], $Tech["Kosten_Karma"], $username);
					
				} else {
						
					die(""); //ToDo: Fehlermeldung einbauen
						
				}
			}
		}
	}
	
//--- ENDE: Forschung einreihen
	
//--- Schiffe einreihen


	if(isset($_POST["action-schiffe-bauen"])) {
	
		if (is_numeric($_POST["action-schiffe-bauen"])) {
	
	
			$kann_gebaut_werden = true;
	
			
				$ship_id = $_POST["action-schiffe-bauen"];
				$ressource = get_ressource($spieler_id, $planet_id);
				$Ship = get_ship($_POST["action-schiffe-bauen"]);
				$anzahl = usereingabe_cleaner ($_POST["vanzahl" . $_POST["action-schiffe-bauen"]]);
				$raumschiffwerft_stufe = get_gebäude_aktuelle_stufe($spieler_id, $planet_id, 7);

				if($anzahl <= 0 OR empty($anzahl) OR !is_numeric($anzahl)) { $kann_gebaut_werden = false; }
				if($Ship["Stufe_Werft"] > $raumschiffwerft_stufe) { $kann_gebaut_werden = false; }
				
				$tech_stufe = get_tech_stufe_spieler($spieler_id);
				
				for($t = 1; $t <= 12; $t++) {
					if ($tech_stufe["Tech_" . $t] < $Ship["Tech_" . $t]) {
						$kann_gebaut_werden = false;
					}
				}
						
					$schiff_in_Besitz = get_schiffe_in_Besitz($spieler_id, $planet_id, $Ship["Schiff_ID"]);
					$max = false;
				
					if($Ship["Max_Hold_Planet"] != -1) {
				
						if($schiff_in_Besitz["Planet"] + $anzahl > $Ship["Max_Hold_Planet"]) { $max = true; }
				
					}
				
					if($Ship["Max_Hold"] != -1) {
							
						if($schiff_in_Besitz["Galaxy"] + $anzahl > $Ship["Max_Hold"]) { $max = true; }
							
					}

				if($max == true) { $kann_gebaut_werden = false; }
				if($ressource["Eisen"] < ($Ship["Kosten_Eisen"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Silizium"] < ($Ship["Kosten_Silizium"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Wasser"] < ($Ship["Kosten_Wasser"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Karma"] < ($Ship["Kosten_Karma"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Bot"] < ($Ship["Bots"] * $anzahl)) { $kann_gebaut_werden = false; }

				if ($kann_gebaut_werden == true) {
					
					$bauzeit = $Ship['Bauzeit'] = $Ship['Bauzeit'] / (1 * $raumschiffwerft_stufe);
	
					set_bauschleife_ship($spieler_id, $planet_id, $ship_id, $Ship["Name"], $anzahl, $bauzeit, $ressource["Eisen"], $ressource["Silizium"], $ressource["Wasser"], $ressource["Bot"], $ressource["Karma"], $Ship["Kosten_Eisen"], $Ship["Kosten_Silizium"], $Ship["Kosten_Wasser"], $Ship["Bots"], $Ship["Kosten_Karma"]);					
						
				} else {
	
					echo(""); //ToDo: Fehlermeldung einbauen
	
				}
			
		}
	}
	

//--- ENDE: Schiffe einreihen

//--- Verteidigung einreihen


	if(isset($_POST["action-deff-bauen"])) {
	
		if (is_numeric($_POST["action-deff-bauen"])) {
	
	
			$kann_gebaut_werden = true;
	
			
				$ship_id = $_POST["action-deff-bauen"];
				$ressource = get_ressource($spieler_id, $planet_id);
				$Deff = get_def($_POST["action-deff-bauen"]);
				$waffenfabrik_stufe = get_gebäude_aktuelle_stufe($spieler_id, $planet_id, 8);
				$anzahl = usereingabe_cleaner ($_POST["vanzahl" . $_POST["action-deff-bauen"]]);
				
				if($anzahl <= 0 OR empty($anzahl) OR !is_numeric($anzahl)) { $kann_gebaut_werden = false; }
	
				$deff_in_Besitz = get_deff_in_Besitz($spieler_id, $planet_id, $Deff["Schiff_ID"]);
				
				$tech_stufe = get_tech_stufe_spieler($spieler_id);
				
				for($t = 1; $t <= 12; $t++) {
					if ($tech_stufe["Tech_" . $t] < $Deff["Tech_" . $t]) {
						$kann_gebaut_werden = false;
					}
				}
				
				
				$max = false;
					
				if($Deff["Max_Hold_Planet"] != -1) {				
					if($deff_in_Besitz["Planet"] + $anzahl > $Deff["Max_Hold_Planet"]) { $max = true; }				
				}
					
				if($Deff["Max_Hold"] != -1) {					
					if($deff_in_Besitz["Galaxy"] + $anzahl > $Deff["Max_Hold"]) { $max = true; }							
				}
			
				if($max == true) { $kann_gebaut_werden = false; }
				if($Deff["Stufe_Werft"] > $waffenfabrik_stufe) { $kann_gebaut_werden = false; }
				if($ressource["Eisen"] < ($Deff["Kosten_Eisen"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Silizium"] < ($Deff["Kosten_Silizium"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Wasser"] < ($Deff["Kosten_Wasser"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Karma"] < ($Deff["Kosten_Karma"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Bot"] < ($Deff["Bots"] * $anzahl)) { $kann_gebaut_werden = false; }
				
				if ($kann_gebaut_werden == true) {
					
					$bauzeit = $Deff["Bauzeit"];
					set_bauschleife_deff($spieler_id, $planet_id, $ship_id, $Deff["Name"], $anzahl, $bauzeit, $ressource["Eisen"], $ressource["Silizium"], $ressource["Wasser"], $ressource["Bot"], $ressource["Karma"], $Deff["Kosten_Eisen"], $Deff["Kosten_Silizium"], $Deff["Kosten_Wasser"], $Deff["Bots"], $Deff["Kosten_Karma"]);					
						
				} else {
	
					echo("$kann_gebaut_werden"); //ToDo: Fehlermeldung einbauen
	
				}
			
		}
	}
	

//--- ENDE: Verteidigung einreihen


// Robots produzieren

	berechne_robot_zuwachs($spieler_id, time());

// ENDE: Robots produzieren

	
// Flotte Abbrechen wenn gewünscht

	if(isset($_POST["action-flotte-abbrechen"])) {

		$id = intval($_POST["action-flotte-abbrechen"], 10);
		if(is_numeric($id)) {			
			mission_rückkehr_set_manuell($id, $spieler_id);
		}
	}
	
// ENDE: Flotte Abbrechen wenn gewünscht
?>
<!DOCTYPE HTML>
<html lang="de">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if($cache == false) { ?>
    <meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Expires" content="-1">
	<?php } ?>
	<link rel="icon" type="image/png" href="../favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="../favicon-16x16.png" sizes="16x16" />
    <link rel="stylesheet" href="../css/galaxy.css">    
    <title>spacefights</title>
    </head>
     

<body>




<script type="text/javascript"><!--
var ts = new Date();

function displayNone(name, par) {
	/* Hide & Show by ES 22.06.2016 */
	var elemente = document.getElementsByName(name);
	for(var i=0; i<elemente.length; i++) {
		elemente[i].style.display=par;
		
	}
}	


function details(name) {
	var eButton = document.getElementsByName(name+"Button");

	if (eButton[0].className=="detailsGeschlossen") {
		displayNone(name,"");
	}
	else {	
		window.setTimeout("displayNone('"+name+"','none')",300);
	}
	
	setTimeout("detailsT2('"+name+"')",10);
	

}
	
function detailsT2(name) {
	var elemente = document.getElementsByName(name);
	var eButton = document.getElementsByName(name+"Button");
	
	if (eButton[0].className=="detailsGeschlossen") {
		eButton[0].className="detailsOffen";
		eButton[0].innerHTML = "▼";
	} else {
		eButton[0].className="detailsGeschlossen";
		eButton[0].innerHTML = "▶";
	}

	for(var i=0; i<elemente.length; i++) {
		if (elemente[i].className=="detailsAusgeblendet") {
			elemente[i].className="detailsEingeblendet";
		} else {
			elemente[i].className="detailsAusgeblendet";	
		}
	}
}

function mPBarGlow(){
	/* Progressbar by ES 12.06.2016 */
	var elemente = document.getElementsByClassName("pBar");
	var weiterGluehen = true;
	
	for(var i=0; i<elemente.length; i++) {
		if (elemente[i].className=="pBar" && elemente[i].title != "-") {
			elemente[i].className="pBar pBarG";
		} else {
			elemente[i].className="pBar";	
		}
		if (elemente[i].title == "-") {weiterGluehen=false;}
	}
	if (weiterGluehen) {window.setTimeout("mPBarGlow()",3000);}
}

mPBarGlow();

function mPBar(soll, ist, maxWidth, name){
	/* Progressbar by ES 12.06.2016 */
	var e = document.getElementById(name);
	var w = 0;
	w = ist/ soll * maxWidth;
	e.style.width = w + "%";
	if (soll==ist) {e.title="-";}
}

function countdown_progress(sec, name, start, ende, beschriftung,maxWidth,ohnePBar){

	if (maxWidth == undefined) {maxWidth = 100;}
	if (ohnePBar == undefined) {ohnePBar = false;}
	
	var e = document.getElementById(name);
	var tn = new Date();
	var tl = ((sec*1000)-(tn.getTime()-ts.getTime()))/1000;

	if (tl>0.5){	
		if (!ohnePBar){mPBar(ende, (ende - tl),maxWidth,"mPBar_"+name);}
		var t = parseInt(tl/(24*60*60));
		tl = tl-(t*(24*60*60));		
		var h = parseInt(tl/(60*60));
		tl = tl-(h*(60*60));
		var m = parseInt(tl/(60));
		tl = tl-(m*(60));
		var s = parseInt(tl);
		if (h<10) h="0"+h;
		if (m<10) m="0"+m;
		if (s<10) s="0"+s;
		if (t == 0) { var tstr = h+":"+m+":"+s; } else { var tstr = t ; if (t==1) { tstr+= " Tag "; } else {tstr +=" Tage ";} tstr += h+":"+m+":"+s; }		
		e.innerHTML = tstr;
		window.setTimeout("countdown_progress("+sec+",'"+name+"',"+start+","+ende+",'"+beschriftung+"',"+maxWidth+","+ohnePBar+")",500);
	} else{
		e.innerHTML = "<a href='index.php?s=<?php echo $select; ?>'>" + beschriftung + "</a>";
		if (!ohnePBar){mPBar(100,100,maxWidth,"mPBar_"+name)};
	}
}

function countdown(sec, name){
	var e = document.getElementById(name);
	var tn = new Date();
	var tl = ((sec*1000)-(tn.getTime()-ts.getTime()))/1000;

	if (tl>1){				
		var t = parseInt(tl/(24*60*60));
		tl = tl-(t*(24*60*60));		
		var h = parseInt(tl/(60*60));
		tl = tl-(h*(60*60));
		var m = parseInt(tl/(60));
		tl = tl-(m*(60));
		var s = parseInt(tl);
		if (h<10) h="0"+h;
		if (m<10) m="0"+m;
		if (s<10) s="0"+s;
		if (t == 0) { var tstr = h+":"+m+":"+s; } else { var tstr = t ; if (t==1) { tstr+= " Tag "; } else {tstr +=" Tage ";} tstr += h+":"+m+":"+s; }		
		e.innerHTML = tstr;
		window.setTimeout("countdown("+sec+",'"+name+"')",500);
	} else{
		e.innerHTML = "<a href='index.php?s=<?php echo $select; ?>'>" + "abgelaufen" + "</a>";			
	}
}


// --></script>

<?php 

switch ($select) {
	case "hypersprung":
		$spalte_rechts = 0;
		break;
	case "index":
		$spalte_rechts = 1;
		break;
	case "initialisiere":
		$spalte_rechts = 0;
		break;
	case "create_gamer":
		$spalte_rechts = 0;
		break;

	case "Gebaeude":
		$spalte_rechts = 0;
		break;
	case "Nachrichten":
		$spalte_rechts = 1;
		break;
	case "Forschung":
		$spalte_rechts = 0;
		break;
	case "Raumschiffe":
		$spalte_rechts = 1;
		break;
	case "Flotte-Info":
		$spalte_rechts = 1;
		break;
	case "Verteidigung":
		$spalte_rechts = 1;
		break;
	case "Sonnensystem":
		$spalte_rechts = 0;
		break;
	case "Rohstoffe":
		$spalte_rechts = 0;
		break;
	case "Flotte":
		$spalte_rechts = 1;
		break;
	case "Rangliste":
		$spalte_rechts = 1;
		break;
	case "Einstellungen":
		$spalte_rechts = 0;
		break;
	default:
		$spalte_rechts = 1;
		break;

}
 

?>


<table width="950" border="0" align="center" cellspacing="0" cellpadding="0" style="width: 100%; min-width: 890px; max-width: 1218px;">
<tr>
<td>
<table border="0" width="100%">
<tr>
<td valign="top" width="150">
<!-- Menü -->
<table id="hauptmenue" width="100%"  cellspacing="0" cellpadding="1" style="margin-top: 2px;">
				 <tr><td><a class="navi" href="index.php">Übersicht</a></td></tr>
				 <tr><td>Imperium</td></tr>
				 <tr><td><a class="navi" href="index.php?s=Rohstoffe">Rohstoffe</a></td></tr>
				 <tr><td><hr></td></tr>
				 <tr><td><a class="navi" href="index.php?s=Gebaeude">Gebäude</a></td></tr>
				 <tr><td><a class="navi" href="index.php?s=Raumschiffe">Raumschiffe</a></td></tr>
				 <tr><td><a class="navi" href="index.php?s=Verteidigung">Verteidigung</a></td></tr>
				 <tr><td><a class="navi" href="index.php?s=Forschung">Forschung</a></td></tr>
				 <tr><td><hr></a></td></tr>
				 <tr><td><a class="navi" href="index.php?s=Sonnensystem">Sonnensystem</a></td></tr>
				 <tr><td>Koordinatenbuch</td></tr>
				 <tr><td><a class="navi" href="index.php?s=Flotte">Flotte</a></td></tr>
				 <tr><td>Handel</td></tr>
				 <tr><td><hr></a></td></tr>
				 <tr><td>Allianzen</td></tr>
				 <tr><td><a class="navi" href="index.php?s=Rangliste">Rangliste</a></td></tr>
				 <tr><td>Kampfstatistik</td></tr>
				 <tr><td>Technologie</td></tr>
				 <tr><td><a class="navi" href="index.php?s=Einstellungen">Einstellungen</a></td></tr>
				 <tr><td><hr></a></td></tr>
				 <tr><td><a class="navi" href="index.php?s=Nachrichten">Nachrichten</a></td></tr>
				 <tr><td><a class="navi" href="http://spacefights.darkbug.de/index.php?m=chat" target="starbug_chat">Chat</a></td></tr>
				 <tr><td><a class="navi" href="http://spacefights.org/forum/" target="_forum">Forum</a></td></tr>
				 <tr><td>Hilfe</td></tr>
				 <tr><td><hr></a></td></tr>
				 
				  <tr><td><a class="navi" href="../logout.php">Ausloggen</a></td></tr>
			</table>
<!-- ENDE: Menü -->
</td>
<td valign="top">					
<table border="0" width="100%"  cellspacing="0" cellpadding="2">
<tr>
<td colspan=<?php if ($spalte_rechts == 1) { echo "2"; } else { echo "1"; } ?>>
<!-- Ress -->
<?php if($bar_planet_info == true) { 
	
				 refresh_ressource($spieler_id, $planet_id, time());
				
				 $ressource = get_ressource($spieler_id, $planet_id);
					
					?>
					<table border=0 cellspacing="0" cellpadding="0" class="planetbar" width="100%">
						<tr>
							<td><img src="img/eisen.png" class="img_ress">Eisen</td>
							<td><img src="img/silizium.png" class="img_ress">Silizium</td>
							<td><img src="img/wasser.png" class="img_ress">Wasser</td>
							<td><img src="img/energie.png" class="img_ress">Energie</td>
							<td title="<?php  echo number_format($ressource["Bot"], 6, ',', '.') . " / Stationiert: " . number_format($ressource["Bot Stationiert"], 0, ',', '.'); ?>" ><img src="img/bot.png" class="img_ress">Robots</td>
							<td><img src="img/held.png" class="img_ress">Helden</td>
							<td><img src="img/karma.png" class="img_ress">Karma</td>
							<td rowspan=2 width=200px align="left">
								
								<table>
									<tr>
										<td>Planet</td>
										<td><</td>
										<td>></td>
								<tr>
								<td colspan=3>
								
									<form>
									<select name="p" size="1" style="width: 150px;" onchange="this.form.submit()">
									<?php echo get_list_of_all_planets($spieler_id, $planet_id); ?>
									</select>
									<input type="hidden" name="s" value="<?php echo $select; ?>">
									</form>   
								</td></tr>
								</table>
								
								     	
							</td>
						</tr>
						<tr>
							<td><?php  echo number_format($ressource["Eisen"], 0, '.', '.'); ?></td>
							<td><?php  echo number_format($ressource["Silizium"], 0, '.', '.'); ?></td>
							<td><?php  echo number_format($ressource["Wasser"], 0, '.', '.'); ?></td>
							<td><?php  echo number_format($ressource["Energie"], 0, '.', '.'); ?></td>
							<td title="<?php  echo number_format($ressource["Bot"], 6, ',', '.') . " / Stationiert: " . number_format($ressource["Bot Stationiert"], 0, ',', '.'); ?>"><?php  echo number_format(floor($ressource["Bot"]), 0, ',', '.') . "/" . number_format($ressource["Bot Gesamt"], 0, '.', '.'); ?></td>
							<td>0</td>
							<td><?php echo number_format($ressource["Karma"], 0, '.', '.'); ?></td>							
							</tr>
					</table>
					
				<?php } ?>
<!-- ENDE: Ress -->
</td>
</tr>
<tr>
<td valign="top">
<!-- Content -->
<?php 

//$punkte = number_format(sprintf('%d', get_punkte($spieler_id, $planet_id)), 0, ',', '.');
$punkte = get_punkte($spieler_id);
switch ($select) {
	case "hypersprung":
		require 'inc/galaxy_switch.php';
		break;
	case "index":
		require 'inc/home.php';
		break;
	case "initialisiere":
		require 'inc/init.php';
		break;		
	case "create_gamer":
		require 'inc/create_gamer.php';
		break;		

	case "Gebaeude":
		require 'inc/gebaeude.php';
		break;
	case "Nachrichten":
		require 'inc/nachrichten.php';
		break;
	case "Forschung":
		require 'inc/forschung.php';
		break;
	case "Raumschiffe":
		require 'inc/raumschiffe.php';
		break;
	case "Flotte-Info":
		require 'inc/flotte-info.php';
		break;
	case "Verteidigung":
		require 'inc/verteidigung.php';
		break;
	case "Sonnensystem":
		require 'inc/sonnensystem.php';
		break;
	case "Rohstoffe":
		require 'inc/rohstoffe.php';
		break;
	case "Flotte":
		require 'inc/flotte.php';
		break;
	case "Rangliste":
		require 'inc/rangliste.php';
	    break;
	case "Einstellungen":
		require 'inc/einstellungen.php';
	    break;
    case "punkte-berechnen":
    	require 'inc/punkte-berechnen.php';
    	break;
	default:
		require 'inc/home.php';
		break;
		
}

?>
<!-- ENDE: Content -->
<?php 

//var_dump(get_tech_stufe_spieler($spieler_id)); 
?>
</td>
<?php if ($spalte_rechts == 1) { ?>
<td width="180" valign="top" rowspan=2>

<!-- Punkte -->

<?php 
switch ($select) 
{
	case "Nachrichten":
		require 'inc/kontakte.php'; 
		break;
	case "Raumschiffe":
		require 'inc/bauschleife.php'; 
		break;
	case "Verteidigung":
		require 'inc/bauschleife.php'; 
		break;		
	default:
		require 'inc/punkte.php';
		require 'inc/bauschleife.php';
		break;
		
		}
?>
				
<!-- ENDE: Punkte -->

</td>
<?php } ?>
</tr>
</table>

</td>
</tr>
</table>
</td>
</tr>
<tr>
<td colspan="2">
<div class="time_elapsed">
<span ><?php $time_elapsed_secs = microtime(true) - $start; echo "Total execution time " . round($time_elapsed_secs * 1000) . " milliseconds. (" . $username . " // $planet_id)"; ?></span>
</div>

</td>
</tr>
</table>

</body>
</html>
