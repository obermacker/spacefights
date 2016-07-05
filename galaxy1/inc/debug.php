<?php

/* ES sein DEBUG-Zeugs ANFANG*/

function dVar( $variable, $vName = "? ? ?") { /* Variablen Dump an Konsole */		
	$output = '<script>console.info ( \'Debug Dump Variable: ';
	if ($vName == "? ? ?") {
		foreach($GLOBALS as $key => $value){
			if($variable===$value){$vName='$'.$key;}
		}
	}
	$output .= $vName.' \' );console.log(' .json_encode( $variable ). ');</script>';
	echo $output; 
}
function dInfo( $text ) { /*  Einfache Text-Ausgabe an Konsole */	
	echo "<script>console.info( 'Debug Info: " . $text . "' );</script>";
}
function dCount( $text ) { /*  Einfache Text-Ausgabe an Konsole */	
	echo "<script>console.count( 'Debug Count - " . $text . "' );</script>";
}
/* ES sein DEBUG-Zeugs ENDE*/

?>