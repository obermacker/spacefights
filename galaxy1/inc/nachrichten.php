<?php 

#var_dump($_POST);

#echo user_message_cleaner ($_POST["Nachricht"]) . "<br>";

#echo html_entity_decode(user_message_cleaner ($_POST["Nachricht"]));

if(isset($_POST["nachricht-senden"]) & isset($_POST["Nachricht"])) {
	
	if ($_POST["nachricht-senden"] == "nachricht-senden" & $_POST["Nachricht"] != '') {
		
		$text = user_message_cleaner($_POST["Nachricht"]);		
		set_message($spieler_id, $username, '', '', $text, 0, 0);
	}
	
}


?>
<script type="text/javascript">
function empfänger_hinzufügen(empfänger) {
	if(document.getElementById("Nachricht").value.length == 0) {
		document.getElementById("Nachricht").value = empfänger;
	} else {
		document.getElementById("Nachricht").value = document.getElementById("Nachricht").value + " " + empfänger;
	}
	
	document.getElementById("Nachricht").focus(); 
}
</script>
<form action="index.php?s=Nachrichten" name="myform" method="post" autocomplete="off">
<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
	<tr>
		<td class="tbchell tbchell_ohne_left_padding" style="width: 50px;">
			<input name="Nachricht" id="Nachricht" size="" style="width: 100%;" autofocus >
		</td>
	</tr>
	<tr>
		<td class="tbchell" style="text-align: right;">
			<button class="btn_main btn_main_senden" type="submit" name="nachricht-senden" value="nachricht-senden">Senden</button>
		</td>
	</tr>
</table>
</form>
<?php

//usereingabe_cleaner ($value)
$nachrichten = get_message($spieler_id, $spieler_id, $username);


if($nachrichten["Error"] == false) {
	
	foreach($nachrichten["result"] as $key => $value) {		
		?>
		<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
			<tr>
				<?php 
					$image = "img/default_user_50x50.png";
					if($value["Chatbot"] == 1) { 
						$image = "img/chatbot_50x50.png"; 
					} else {
						$avatar = get_spieler_image($value["Absender_ID"]);
						if(!$avatar == '') {							
							$image = "img/spieler/" . $avatar;
						}
					}
						 
				
				?>
				<td rowspan=2 class="tbchell tbchell_ohne_left_padding" style="width: 50px;"><img src="<?php echo $image; ?>" width=50 height=50></td>
				<td class="tbchell"><span style="color: #00aed8"><?php echo $value["Absender_Name"]; ?></span></td><td class="tbchell" style="width: 14em; text-align: right;"><span style="font-size: x-small; padding-right: 5px;"><?php echo get_timestamp_in_was_lesbares($value["Zeit"]); ?> X</span></td>
			<tr>
				<td class="tbchell" colspan=2>
					<?php echo $value["Text"]; ?>
				</td>
			</tr>
		</table>
		<?php 
	}	
	
} else {
	
	echo $nachrichten["Message"];
	
}



?>