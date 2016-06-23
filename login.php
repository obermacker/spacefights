<?php
session_start();
// ini_set( 'display_errors', true );
//error_reporting( 0 );
require 'inc/func.php';
require 'inc/connect_spieler.php'; 
 
$fehler = "";
if(isset($_POST["sf_username"])) {
	if(isset($_POST["sf_password"])) {
		
		if (login(check_username_cleaner ($_POST["sf_username"], 0), $_POST["sf_password"]) == "ok"){
		    header('Location: galaxy.php');    
		    }
		else
		    {
		    	$fehler = "Benutzername und/oder Passwort waren falsch.";
		    }

    }
    
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
  <form name="loginform" method="post" action="login.php">
    <passbar>
				    <input type="text" name="sf_username" placeholder="Username">
				    <input type="password" name="sf_password" placeholder="Password">
				    <input type="submit" name="login" class="login login-submit" value="login">
    <a href="register.html">Neu anmelden!</a>
    </passbar>
				  </form>
<page_error>
<?php echo $fehler; ?>
</page_error>
<content>

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