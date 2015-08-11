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

$spieler_ID = ""; $session_id = "";

if (isset($_SESSION["spieler_ID"])) { $spieler_ID = $_SESSION["spieler_ID"]; } 
if (isset($_SESSION["session_id"])) { $session_id = $_SESSION["session_id"]; }


if (check_auth($spieler_ID, $session_id) == "nein"){
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



//---- Gebäude bauen

	if(isset($_POST["action-bauen"])) {
	
		if (is_numeric($_POST["action-bauen"])) {

			
			$kann_gebaut_werden = true;
				
			if (check_bauschleife_activ($spieler_ID, 0) > 0) { $kann_gebaut_werden = false; } else {
				
				$gebäude_id = $_POST["action-bauen"];
				$ressource = get_ressource($spieler_ID, 0);
				$Gebäude = get_gebäude_nächste_stufe($spieler_ID, 0, $gebäude_id);
		
				if($ressource["Eisen"] < $Gebäude["Kosten_Eisen"]) { $kann_gebaut_werden = false; }
				if($ressource["Silizium"] < $Gebäude["Kosten_Silizium"]) { $kann_gebaut_werden = false; }
				if($ressource["Wasser"] < $Gebäude["Kosten_Wasser"]) { $kann_gebaut_werden = false; }
				if($ressource["Energie"] < $Gebäude["Kosten_Energie"]) { $kann_gebaut_werden = false; }
				
				if ($kann_gebaut_werden == true) {
					
					echo "wird gebaut";
					
				}
			
			
			}
			
	
	
		}
	
	}


//---

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


    <page_titel style="<?php echo $nav_page_title; ?>"><div id="title" style="text-align: right;">spacefights.org</div></page_titel>

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
    	<?php echo get_list_of_all_planets($spieler_ID, 0); ?>
    	</select>    	
    </li>
    		</ul>
    		</nav>
</navbar>

<?php if($bar_planet_info == true) { 

 $ressource = get_ressource($spieler_ID, 0);
	
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
