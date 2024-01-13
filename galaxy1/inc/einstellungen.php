<?php
// ToDo:
// was soll denn unter Einstellungen erscheinen ?
//
//Chatfarbe
//Planetennamen
//Account Anpassen/Ändern
//
if ($_POST){    
    if ($_POST['token'] == $_SESSION['token_configmenu'] && $_POST['btn_send_frm_chat_color']){   
        
        $new_chat_color = $_POST['input_chat_color'];
        

        if (preg_match('/^#([a-f0-9]{3}){1,2}\b$/', $new_chat_color) == true) {
            
            $new_chat_color = str_replace("#", "", $new_chat_color);

            require 'inc/connect_pdo_spieler.php';
            
            try {
                $sql = "UPDATE spieler SET chat_color=? WHERE spieler_Id=?";
                $db->prepare($sql)->execute([$new_chat_color, $spieler_id]);

            } catch (PDOException $e) {
                $pdo_error = $e->getMessage();              
            }

        } else {
            //ungültiger Value
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

$chat_color = get_chat_color($spieler_id);
$token_configmenu = md5(uniqid(rand(), true));
$_SESSION['token_configmenu']= $token_configmenu;
?>
<h2>Chatfarbe</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" name="frm_chat_color" method="post" autocomplete="off">
  <label for="favcolor">Select your chat color:</label>
  <input type="color" id="chat_color" name="input_chat_color" value="#<?php echo $chat_color; ?>" style="width: 3em; height: 1.5em; border: 0;">
  <input type="hidden" value="Im interstellaren Tanz der Galaxien erkunden wir mutig das Universum, wo Sterne zu Geschichten werden und Raumzeit unsere Neugierde entfacht.">
  <input type="hidden" name="s" value="Einstellungen"><input type="hidden"name="token" value="<?php echo $token_configmenu;?>"/>
  <input name="btn_send_frm_chat_color" type="submit" value="update">
</form>