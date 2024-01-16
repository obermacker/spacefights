<?php
if ($_POST){    
    if ( $_POST['token'] == $_SESSION['token']){    

        $str = substr( $_POST['frmChatMessage'], 0, 255);
        
        if (strlen($str)){

            #$str =preg_replace("![][xX]([A-Fa-f0–9]{1,3})!", "", $str); #clean hex
            
            $str = strip_tags($str);
            $str = base64_encode($str);
        
            $chat_color = get_chat_color($spieler_id);

            require 'inc/connect_pdo_galaxy_1.php';

            $sql = "INSERT INTO `chat`(`PlayerId`, `MessageFromPlayerName`, `MessageText`, `chat_color`) VALUES (?,?,?,?)";
            try {
                $db->prepare($sql)->execute([$spieler_id, get_spieler_name($spieler_id), $str, $chat_color]);

            } catch (PDOException $e) {
                catchExeption ($e);              
            }
        }
    }
}

function get_chat_color($spieler_id) {
    require 'inc/connect_pdo_spieler.php';

	$stmt = $db->prepare("SELECT `chat_color` FROM spieler WHERE spieler_id=:spieler_id");
    $stmt->execute(['spieler_id' => $spieler_id]); 
    $chat_color = $stmt->fetch();              
    return  $chat_color["chat_color"];
}



$token =md5(uniqid(rand(), true));
$_SESSION['token']= $token;
?>
<table border=0 width="100%">

<tr><td>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" name="myform" method="post" autocomplete="off">
<label for="frmChatMessage" style="margin-right: 1em;">Nachricht:</label><input size="100" name="frmChatMessage" style="margin-top: 1em; margin-bottom: 1em;">
    <button style="margin-left: 5px">senden</button>
    
    <input type="hidden" name="s" value="Chat"><input type="hidden"name="token" value="<?php echo $token;?>"/>
</form>

</td>

</tr>
<tr><td>

<div id="result"></div>

<script>
setInterval(function load_chat() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "chat_history.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("result").innerHTML = xhr.responseText;
        }
    }
    xhr.send();
    return load_chat;
}(), 5000);
</script>

</td>
</tr>
<tr><td style="color:darkgray;">Emoji Picker: Windows & KDE [<?php echo "\u{229E}<small>Win</small> + . "; ?>] | Mac OS [fn] </td></tr>
</table>

<script type="text/javascript" language="javascript">
    document.myform.frmChatMessage.focus();
</script>