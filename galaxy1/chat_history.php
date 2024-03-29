<?php
//ToDo: 
//
// Als Function nach func_galaxy.hp auslagern
//
session_start();

//rememberme cookie check
require (dirname(__FILE__) . '/inc/func_galaxy.php');


if(isset($_COOKIE["rememberme"])) {
    if($_COOKIE["rememberme"] == "yes"){
        $spieler_id = $_COOKIE["user_id"];
        $session_id = $_COOKIE["auth_token"];
    } else {
        if (isset($_SESSION["spieler_ID"])) { $spieler_id = $_SESSION["spieler_ID"]; }
        if (isset($_SESSION["session_id"])) { $session_id = $_SESSION["session_id"]; }
    }    
}
//end: rememberme cookie check

if(!isset($spieler_id)) { $spieler_id = 0;}
if(!isset($session_id)) { $session_id = 0;}

if (check_auth($spieler_id, $session_id) == "nein"){
    session_unset(); session_destroy(); $_SESSION = array(); header('Location: ../index.html'); exit();
    exit();	
}

?>
<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
<tr>
			<th class="tbtb ">Zeit</th>
			<th class="tbtb ">Name: Text</th>
</tr>
<?php
require 'inc/connect_pdo_galaxy_1.php';

$data = $db->query("SELECT * FROM chat ORDER BY `MessageTime` DESC LIMIT 25")->fetchAll();

foreach ($data as $row) {    
    $msg_Date = chat_get_timestamp_date($row['MessageTime'])->format('d.m.Y');
    $msg_Time = chat_get_timestamp_date($row['MessageTime'])->format('H:i:s');
    echo "<tr>\n";
    echo "<td class='tbchell_with_right_border' valign='top' title='" . $msg_Date . "' width='8'>" . 
    $msg_Time . "</td><td class='tbchell' style='word-break: break-all; color: #" . $row['chat_color'] . "'><b>" . $row['MessageFromPlayerName'] . "</b>: " . base64_decode($row['MessageText']) . "</td>\n";
    echo "</tr>\n";
}

function chat_get_timestamp_date($value) {	
    $dateTimeZoneEuropeBerlin= new DateTimeZone("Europe/Berlin");
    $dateTimeZoneEuropeBerlin = new DateTime($value, $dateTimeZoneEuropeBerlin);
    return $dateTimeZoneEuropeBerlin;
}
?>
</table>