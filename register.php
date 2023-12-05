<?php
session_start();
// ini_set( 'display_errors', true );
//error_reporting( 0 );
require 'inc/func.php';


if (isset($_POST["regeln"])) {
	
	if ((registrieren($_POST["sf_reg_username"], $_POST["sf_reg_password"]) == "Yeahh!") AND $_POST["regeln"] == "verstanden") {
		
		$fehler = 0;
		$meldung = "Herzlich Willkommen!";
		
		
	} else {
		$fehler = 1;
		$meldung = "Fehler!";
		
	} 
	
} else {
	$fehler = 1;
	$meldung = "Fehler!";
		
}

?>
<!DOCTYPE HTML>
<html lang="de">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/main.css">
<title>spacefights</title>
</head>
<body>
<div style="width: 100%;">


<page_titel><div id="title" style="text-align: right;">spacefights.org</div></page_titel>

<?php if($fehler == 1) { ?>
<page_error>
<?php echo $meldung ?>
</page_error>
<?php } ?>

<?php if($fehler == 0) { ?>
<navbar>
<?php echo $meldung ?>
</navbar>
<?php } ?>

<content>
<?php if($fehler == 1) { echo "<a href='/'>Hier</a> geht es zurück."; } ?>
<?php if($fehler == 0) { echo "Dein Account steht jetzt zur Verfügung <a href='/'>klicke hier</a>"; } ?>
</content>
<navbar style="">

<nav>
	<ul class="nav inline-items">
		<li><a class="menu" href="/">Home</a></li>
		<li><a class="menu" href="#">News</a></li>
		<li><a class="menu" href="#">Chat</a></li>
		<li><a class="menu" href="#">Forum</a></li>
		<li><a class="menu" href="#">Impressum</a></li>
	</ul>

</nav>
</navbar>  
</div>
  </body>
</html>