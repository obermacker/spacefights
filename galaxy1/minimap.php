<?php 
require (dirname(__FILE__) . '/inc/func_galaxy.php');
session_start();
$spieler_id = ""; $session_id = "";

if (isset($_SESSION["spieler_ID"])) { $spieler_id = $_SESSION["spieler_ID"]; }
if (isset($_SESSION["session_id"])) { $session_id = $_SESSION["session_id"]; }
if (check_auth($spieler_id, $session_id) == "nein"){
	//session_unset(); session_destroy(); $_SESSION = array(); header('Location: ../index.html'); exit();
	exit();
}

if(isset($_GET)) {
	
	$x1 = $_GET["x1"] - 1;
	$x2 = $_GET["x2"] - 1;
	$y1 = $_GET["y1"] - 1;
	$y2 = $_GET["y2"] - 1;
	
} else {
	
	die();
}

	
	
create_image($spieler_id, $x1, $x2, $y1, $y2);
	
exit();

function create_image($spieler_id, $x1, $x2, $y1, $y2)
{


	$Systeme = get_explored_systems($spieler_id, 1, 1, 50, 50);
	$bild = imagecreatetruecolor(100, 100);
	imagecolorallocate($bild, 0, 0, 0);
	
	$orange = imagecolorallocate($bild, 255, 144, 0);
	$rot_hell = imagecolorallocate($bild, 73, 25, 25);
	$rot_dunkel = imagecolorallocate($bild, 21, 5, 5);
	$grau = imagecolorallocate($bild, 25, 25, 25);
	$hellgrau = imagecolorallocate($bild, 95, 95, 95);
	$rot = imagecolorallocate($bild, 240, 50, 50);
	
	//imagerectangle($bild, 1, 1, 99, 99, $grau);
	
	imagerectangle($bild, $x1 * 2, $y1 * 2, ($x2 + 1) * 2, ($y2 + 1) * 2, $rot_hell);
	imagefilledrectangle($bild, $x1 * 2 + 1, $y1 * 2 + 1, ($x2 + 1) * 2 - 1, ($y2 + 1) * 2 - 1, $rot_dunkel);
	
	//imagefill ( $bild, ($x1 + (($x2 - $x1) / 2)) * 2, ($y1 + (($y2 - $y1) / 2)) * 2, $rot_dunkel );
	
	//imagesetpixel ($bild,($x1 + (($x2 - $x1) / 2)) * 2, ($y1 + (($y2 - $y1) / 2)) * 2, $orange);
	
	foreach($Systeme as $key => $value) {
		switch (true) {
			case $value->ownSystem == 'true' : 
				$color = $orange; break;
			case $value->foreignSystem  == 'true' : 
				$color = $rot; break;
			case $value->freeSystem == 'true'  : 
				$color = $hellgrau; break;
		}

		imagesetpixel ($bild, 2 * $value->x - 1, 2 * $value->y - 1, $color);
	}
	
 
    //Tell the browser what kind of file is come in 
    header("Content-type: image/png"); 

    //Output the newly created image in jpeg format 
    ImagePng($bild);
   
    //Free up resources
    ImageDestroy($bild);
} 
?>