<?php 
$start = microtime(true);
//#######################################
//index.php im Galaxyverzeichnis
//#######################################
session_start();
require (dirname(__FILE__) . '/inc/func_galaxy.php');
require (dirname(__FILE__) . '/inc/conf_structure.php');
require (dirname(__FILE__) . '/inc/conf_tech.php');
include (dirname(__FILE__) . '/inc/conf_ship.php');
include (dirname(__FILE__) . '/inc/conf_def.php');

$spieler_id = ""; $session_id = "";

if (isset($_SESSION["spieler_ID"])) { $spieler_id = $_SESSION["spieler_ID"]; } 
if (isset($_SESSION["session_id"])) { $session_id = $_SESSION["session_id"]; }


if (check_auth($spieler_id, $session_id) == "nein"){
	    //session_unset(); session_destroy(); $_SESSION = array(); header('Location: ../index.html'); exit();
	    exit();	
}

if(!isset($_POST["s"])){ 
	if(!isset($_GET["s"])){ $select = "index";} else { $select = $_GET["s"]; }
} else { $select = $_POST["s"]; }



switch ($select) {
	case "hypersprung": //hypersprung.php
		exit();
		$nav_page_title = "";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "display: none;";
		$bar_planet_info = false;
		break;
	case "index": //galaxy.php		
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		break;
	case "initialisiere": //init.php
		exit();
		$nav_page_title = "";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "display: none;";
		$bar_planet_info = false;
		break;
	case "create_gamer": //create_gamer.php
		exit();
		$nav_page_title = "";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "display: none;";
		$bar_planet_info = false;
		break;
	case "Gebäude":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		break;
	case "Forschung":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		break;
	case "Raumschiffe":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		break;
	case "Verteidigung":
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		break;
	default:
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		break;
}

//---- ToDo: C

//---- Abgelaufene Bauschleifen fertigstellen

	//--- Gebäude
	$bauschleife = check_bauschleife_activ($spieler_id, 0, "Structure");
	if ($bauschleife["ID"] > 0 and $bauschleife["Bis"] <= time()) {
		
		$gebäude_id = $bauschleife["ID"];		
		set_bauschleife_struckture_fertig($spieler_id, 0, $gebäude_id);
		
	}

	//--- Forschung
	$bauschleife = check_bauschleife_activ($spieler_id, 0, "Tech");
	if ($bauschleife["ID"] > 0 and $bauschleife["Bis"] <= time()) {
	
		$tech_id = $bauschleife["ID"];
		set_bauschleife_tech_fertig($spieler_id, 0, $tech_id);
	
	}
	
	//--- Schiffe
	
	$bauschleife = check_bauschleife_activ($spieler_id, 0, "Ship");
	if ($bauschleife["ID"] > 0) {
		
		set_bauschleife_ship_fertig($spieler_id, 0);
		
	
	}
	
	
	
//---- ENDE: Abgelaufene Bauschleifen fertigstellen

//---- Bauschleife abbrechen

	//--- Gebäude
	if(isset($_POST["action-gebaeude-abbrechen"])) {
	
		if (is_numeric($_POST["action-gebaeude-abbrechen"])) {
	
			$bauschleife = check_bauschleife_activ($spieler_id, 0, "Structure");
			
			if ($bauschleife["ID"] > 0) { 
				
				$gebäude_id = $_POST["action-gebaeude-abbrechen"];				

				set_bauschleife_structure_abbruch($spieler_id, 0, $gebäude_id);			
			}
		}
	}

	//--- Tech
	if(isset($_POST["action-forschung-abbrechen"])) {
	
		if (is_numeric($_POST["action-forschung-abbrechen"])) {
	
			$bauschleife = check_bauschleife_activ($spieler_id, 0, "Tech");
				
			if ($bauschleife["ID"] > 0) {
	
				$tech_id = $_POST["action-forschung-abbrechen"];
	
				set_bauschleife_tech_abbruch($spieler_id, 0, $tech_id);
			}
		}	
	}
	
	if (isset($_POST["action-schiffe-abbrechen"])) {
		if (is_numeric($_POST["action-schiffe-abbrechen"])) {
			
			set_bauschleife_ship_abbruch($spieler_id, 0, $_POST["action-schiffe-abbrechen"]);
			
		}
	}
	
	
//---- Ende: Bauschleife abbrechen 
	
//---- Gebäude bauen

	if(isset($_POST["action-gebaeude-bauen"])) {
	
		if (is_numeric($_POST["action-gebaeude-bauen"])) {

			
			$kann_gebaut_werden = true;

			$bauschleife = check_bauschleife_activ($spieler_id, 0, "Structure");
				
			if ($bauschleife["ID"] > 0) { $kann_gebaut_werden = false; } else {
				
				$gebäude_id = $_POST["action-gebaeude-bauen"];
				$ressource = get_ressource($spieler_id, 0);
				$Gebäude = get_gebäude_nächste_stufe($spieler_id, 0, $gebäude_id, 1);
		
				if($ressource["Eisen"] < $Gebäude["Kosten_Eisen"]) { $kann_gebaut_werden = false; }
				if($ressource["Silizium"] < $Gebäude["Kosten_Silizium"]) { $kann_gebaut_werden = false; }
				if($ressource["Wasser"] < $Gebäude["Kosten_Wasser"]) { $kann_gebaut_werden = false; }
				if($ressource["Energie"] < $Gebäude["Kosten_Energie"]) { $kann_gebaut_werden = false; }
				if($ressource["Karma"] < $Gebäude["Kosten_Karma"]) { $kann_gebaut_werden = false; }
				
				if ($kann_gebaut_werden == true) {
					
					$bauzeit = time() + $Gebäude["Bauzeit"];
					
					set_bauschleife_struckture($spieler_id, 0, $gebäude_id, $Gebäude["Name"], $bauzeit, $ressource["Eisen"], $ressource["Silizium"], $ressource["Wasser"], $ressource["Energie"], $ressource["Karma"], $Gebäude["Kosten_Eisen"], $Gebäude["Kosten_Silizium"], $Gebäude["Kosten_Wasser"], $Gebäude["Kosten_Energie"], $Gebäude["Kosten_Karma"]);
					
				} else {
					
					die("nope;"); //ToDo: Fehlermeldung einbauen
					
				}
			}
		}
	}


//---ENDE: Gebäude bauen

//--- Froschung einreihen
	
	
	if(isset($_POST["action-forschung-bauen"])) {
	
		if (is_numeric($_POST["action-forschung-bauen"])) {
	
				
			$kann_gebaut_werden = true;
	
			$bauschleife = check_bauschleife_activ($spieler_id, 0, "Tech");
	
			if ($bauschleife["ID"] > 0) { $kann_gebaut_werden = false; } else {
	
				$tech_id = $_POST["action-forschung-bauen"];
				$ressource = get_ressource($spieler_id, 0);
				$Tech = get_tech_nächste_stufe($spieler_id, 0, $tech_id, 1);
	
				if($ressource["Eisen"] < $Tech["Kosten_Eisen"]) { $kann_gebaut_werden = false; }
				if($ressource["Silizium"] < $Tech["Kosten_Silizium"]) { $kann_gebaut_werden = false; }
				if($ressource["Wasser"] < $Tech["Kosten_Wasser"]) { $kann_gebaut_werden = false; }				
				if($ressource["Karma"] < $Tech["Kosten_Karma"]) { $kann_gebaut_werden = false; }
	
				if ($kann_gebaut_werden == true) {
						
					$bauzeit = time() + $Tech["Bauzeit"];
						
					//set_bauschleife_struckture($spieler_id, 0, $gebäude_id, $Gebäude["Name"], $bauzeit, $ressource["Eisen"], $ressource["Silizium"], $ressource["Wasser"], $ressource["Energie"], $ressource["Karma"], $Tech["Kosten_Eisen"], $Tech["Kosten_Silizium"], $Tech["Kosten_Wasser"], $Tech["Kosten_Energie"], $Tech["Kosten_Karma"]);

					set_bauschleife_tech($spieler_id, 0, $tech_id, $Tech["Name"], $bauzeit, $ressource["Eisen"], $ressource["Silizium"], $ressource["Wasser"], $ressource["Karma"], $Tech["Kosten_Eisen"], $Tech["Kosten_Silizium"], $Tech["Kosten_Wasser"], $Tech["Kosten_Karma"]);
					
				} else {
						
					die("nope;"); //ToDo: Fehlermeldung einbauen
						
				}
			}
		}
	}
	
//--- ENDE: Froschung einreihen
	
//--- Schiffe einreihen


	if(isset($_POST["action-schiffe-bauen"])) {
	
		if (is_numeric($_POST["action-schiffe-bauen"])) {
	
	
			$kann_gebaut_werden = true;
	
			
				$ship_id = $_POST["action-schiffe-bauen"];
				$ressource = get_ressource($spieler_id, 0);
				$Ship = get_ship($_POST["action-schiffe-bauen"]);
				$anzahl = usereingabe_cleaner ($_POST["vanzahl" . $_POST["action-schiffe-bauen"]]);
				
				if($anzahl <= 0 OR empty($anzahl) OR !is_numeric($anzahl)) { $kann_gebaut_werden = false; }
	
				if($ressource["Eisen"] < ($Ship["Kosten_Eisen"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Silizium"] < ($Ship["Kosten_Silizium"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Wasser"] < ($Ship["Kosten_Wasser"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Karma"] < ($Ship["Kosten_Karma"] * $anzahl)) { $kann_gebaut_werden = false; }
				if($ressource["Bot"] < ($Ship["Bots"] * $anzahl)) { $kann_gebaut_werden = false; }
				echo $Ship["Bots"] * $anzahl;
				if ($kann_gebaut_werden == true) {
					
					$bauzeit = $Ship["Bauzeit"];
	
					set_bauschleife_ship($spieler_id, 0, $ship_id, $Ship["Name"], $anzahl, $bauzeit, $ressource["Eisen"], $ressource["Silizium"], $ressource["Wasser"], $ressource["Bot"], $ressource["Karma"], $Ship["Kosten_Eisen"], $Ship["Kosten_Silizium"], $Ship["Kosten_Wasser"], $Ship["Bots"], $Ship["Kosten_Karma"]);					
						
				} else {
	
					echo("nope;"); //ToDo: Fehlermeldung einbauen
	
				}
			
		}
	}
	

//--- ENDE: Schiffe einreihen
?>
<!DOCTYPE HTML>
<html lang="de">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/main.css">    
    <title>spacefights</title>
    </head>
     

<body>
<script type="text/javascript"><!--
var ts = new Date();
function countdown(sec, name){
var e = document.getElementById(name);
var tn = new Date();
var tl = ((sec*1000)-(tn.getTime()-ts.getTime()))/1000;

if (tl>=0){	
	if (tl>300){
		
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
		if (t == 0) { var tstr = h+":"+m+":"+s; } else { var tstr = t+" Tage "+h+":"+m+":"+s; }		
		e.innerHTML = tstr;
		window.setTimeout("countdown("+sec+",'"+name+"')",500);
	}else{
		var h = parseInt(tl/(60*60));
		tl = tl-(h*(60*60));
		var m = parseInt(tl/(60));
		tl = tl-(m*(60));
		var s = parseInt(tl);
		if (h<10) h="0"+h;
		if (m<10) m="0"+m;
		if (s<10) s="0"+s;
		var tstr = "<font color=\"#FF0000\">"+h+":"+m+":"+s+"</font>";
		e.innerHTML = tstr;
		window.setTimeout("countdown("+sec+",'"+name+"')",500);
	}
}else{
	if (name == "specialcountdown"){
		e.innerHTML = '<font color="#FF0000">abgelaufen</font>';
	}else{
		e.innerHTML = 'abgelaufen';
	}
}
}
// --></script>
    <div style="width: 100%;">


    <page_titel style="<?php echo $nav_page_title; ?>"><div id="title" style="text-align: right;">$seitentitel</div></page_titel>

    
    
    <header style="<?php echo $nav_startseite; ?>">
    <nav>
    <ul class="nav inline-items">
    <li><a href="index.php">Home</a></li>
    <li><a href="impressum.html">Kontakt</a></li>
    <li><a href="/forum/">Forum</a></li>
    </ul>
    </nav>
    </header>
    <navbar style="<?php echo $nav_bar_planet; ?>">
    <nav>
    <ul class="nav inline-items">
    <li><a class="menu" href="index.php">Übersicht</a></li>
    <li><a class="menu" href="">Taverne</a></li>
    <li><a class="menu" href="">Handel</a></li>
    <li><a class="menu" href="index.php?s=Gebäude">Gebäude</a></li>
    <li><a class="menu" href="index.php?s=Forschung">Forschung</a></li>
    <li><a class="menu" href="index.php?s=Raumschiffe">Raumschiffe</a></li>
    <li><a class="menu" href="index.php?s=Verteidigung">Verteidigung</a></li>
    <li><a class="menu" href="">Flotte</a> </li>
    <li><a class="menu" href="">Sonnensystem</a></li>
    <li>
    	<select name="planet" size="1" style="width: 150px;" onchange="this.form.submit()">
    	<?php echo get_list_of_all_planets($spieler_id, 0); ?>
    	</select>    	
    </li>
    		</ul>
    		</nav>
</navbar>
    
<?php if($bar_planet_info == true) { 

 $ressource = get_ressource($spieler_id, 0);
	
	?>
	<planetbar>
	<div class="flex_planet">
		    <div><img src="img/eisen.png" class="img_ress">Eisen<br><?php  echo number_format($ressource["Eisen"], 0, '.', '.'); ?></div>
			<div><img src="img/silizium.png" class="img_ress">Silizium<br><?php  echo number_format($ressource["Silizium"], 0, '.', '.'); ?></div>
			<div><img src="img/wasser.png" class="img_ress">Wasser<br><?php  echo number_format($ressource["Wasser"], 0, '.', '.'); ?></div>
			<div><img src="img/energie.png" class="img_ress">Energie<br><?php  echo number_format($ressource["Energie"], 0, '.', '.'); ?></div>
			<div><img src="img/bot.png" class="img_ress">Robots<br><?php  echo number_format($ressource["Bot"], 0, '.', '.') ."/". number_format($ressource["Bot Stationiert"], 0, '.', '.'); ?></div>
			<div><img src="img/held.png" class="img_ress">Helden<br>0</div>
			<div><img src="img/karma.png" class="img_ress">Karma<br><?php echo number_format($ressource["Karma"], 0, '.', '.'); ?></div>
	</div>	    
	</planetbar>
<?php } ?>
<content>
<?php 

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

	case "Gebäude":
		require 'inc/gebaeude.php';
		break;
		
	case "Forschung":
		require 'inc/forschung.php';
		break;
	case "Raumschiffe":
		require 'inc/raumschiffe.php';
		break;
	case "Verteidigung":
		require 'inc/verteidigung.php';
		break;
	default:
		require 'inc/home.php';
		break;
		
}




?>
</content>

<navbar style="">

<nav>
<ul class="nav inline-items">
<li><a class="menu" href="#">Nachrichten</a></li>
<li><a class="menu" href="#" target="chatfenster">Chat</a></li>
<li><a class="menu" href="../forum/" target="sf_forum">Forum</a></li>
<li><a class="menu" href="../logout.php">Ausloggen</a></li>
<li><a class="menu" href="#">Einstellungen</a></li>
<li><a class="menu" href="../galaxy.php">Switch Galaxy</a></li>
</ul>

</nav>
</navbar>
</div>
<div align="right" style="padding-right: 5px;">
<span class="time_elapsed"><?php $time_elapsed_secs = microtime(true) - $start; echo "Total execution time " . round($time_elapsed_secs * 1000) . " milliseconds."; ?></span>
</div>
</body>
</html>
