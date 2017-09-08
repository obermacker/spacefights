<?php 
//#######################################
//Galaxy.php im Homeverzeichnis fÃ¼r die Initsialisierung
//#######################################
session_start();
require 'inc/func.php';

$spieler_ID = ""; $session_id = "";
if (isset($_SESSION["spieler_ID"])) { $spieler_ID = $_SESSION["spieler_ID"]; } 
if (isset($_SESSION["session_id"])) { $session_id = $_SESSION["session_id"]; }

if (check_auth($spieler_ID, $session_id) == "nein"){
	    session_unset(); session_destroy(); $_SESSION = array(); header('Location: index.php'); exit();	
}

if(!isset($_POST["s"])){ $select = "hypersprung";} else { $select = $_POST["s"]; } 


switch ($select) {
	case "hypersprung": //hypersprung.php
		$nav_page_title = "";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "display: none;";
		$bar_planet_info = false;
		break;
	case "index": //galaxy.php
		exit();
		$nav_page_title = "display: none;";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "";
		$bar_planet_info = true;
		break;
	case "initialisiere": //init.php
		$nav_page_title = "";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "display: none;";
		$bar_planet_info = false;
		break;
	case "create_gamer": //create_gamer.php
		$nav_page_title = "";
		$nav_startseite = "display: none;";
		$nav_bar_planet = "display: none;";
		$bar_planet_info = false;
		break;
	default:
		exit();
}
?>
<!DOCTYPE HTML>
<html lang="de">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
    <link rel="stylesheet" href="css/main.css">
    <title>spacefights</title>
    </head>
     

    <body>

    <div style="width: 100%;">


    <page_titel style="<?php echo $nav_page_title; ?>"><div id="title" style="text-align: right;">spacefights.org</div></page_titel>

    <header style="<?php echo $nav_startseite; ?>">
    <nav>
    <ul class="nav inline-items">
    <li><a href="/">Home</a></li>
    <li><a href="impressum.html">Kontakt</a></li>
    <li><a href="/forum/">Forum</a></li>
    </ul>
    </nav>
    </header>
    <navbar style="<?php echo $nav_bar_planet; ?>">
    <nav>
    <ul class="nav inline-items">
    <li><a class="menu" href="#">Ãœbersicht</a></li>
    <li><a class="menu" href="#">Taverne</a></li>
    <li><a class="menu" href="#">Handel</a></li>
    <li><a class="menu" href="#">GebÃ¤ude</a></li>
    <li><a class="menu" href="#">Forschung</a></li>
    <li><a class="menu" href="#">Raumschiffe</a></li>
    <li><a class="menu" href="#">Flotte</a> </li>
    <li><a class="menu" href="#">Sonnensystem</a></li>
    <li>
    	<select name="planet" size="1" style="width: 150px;" onchange="this.form.submit()">
    	<option>p1</option>
    	<option>p1</option>
    	<option>p1</option>
    	<option>p1</option>
    	<option>p1</option>
    	<option>p1</option>
    	</select>    	
    </li>
    		</ul>
    		</nav>
</navbar>

<?php if($bar_planet_info == true) { ?>
	<planetbar>
	<div class="flex_planet">
		    <div><img src="img/eisen.png" class="img_ress"> Eisen<br>100.000.000</div>
			<div><img src="img/silizium.png" class="img_ress">Silizium<br>100.000.000</div>
			<div><img src="img/wasser.png" class="img_ress">Wasser<br>100.000.000</div>
			<div><img src="img/energie.png" class="img_ress">Energie<br>1.000</div>
			<div><img src="img/bot.png" class="img_ress">Robots<br>30.000</div>
			<div><img src="img/held.png" class="img_ress">Helden<br>100</div>
			<div><img src="img/karma.png" class="img_ress">Karma<br>1.000</div>
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
}




?>
</content>

<navbar style="">

<nav>
<ul class="nav inline-items">
<li><a class="menu" href="#">Nachrichten</a></li>
<li><a class="menu" href="#" target="chatfenster">Chat</a></li>
<li><a class="menu" href="/forum/" target="sf_forum">Forum</a></li>
<li><a class="menu" href="logout.php">Ausloggen</a></li>
<li><a class="menu" href="#">Einstellungen</a></li>
<li><a class="menu" href="galaxy.php">Switch Galaxy</a></li>
</ul>

</nav>
</navbar>
</div>
</body>
</html>