<?php 
// lng_echo('number_test'); 
if(isset($_POST["send-message"])) {
	
	if ($_POST["send-message"] == "send-message" & $_POST["toName"] != '') {
		
		//$toTemp=array_unique (array_map('trim',explode('@',$_POST["toName"])));
		$to=array();
		foreach (array_unique (array_map('trim',explode('@',$_POST["toName"]))) as $value) {
			$toName = preg_replace ('/ /','',$value);
			$toID = get_spieler_id ($toName);
			if ($toName != "" && $toID != NULL) {
				$to[] = array ('toName' => $toName, 'toID' => $toID);
			}
		}
		
		foreach ($to as $value) {
			$subject = user_message_cleaner($_POST["subject"]);		
			$text = user_message_cleaner($_POST["text"]);		
			set_message($spieler_id, $username,$value['toID'],$value['toName'], $subject,  $text);
		}
	}
}
?>

<script type="text/javascript">
function add_recipient(toName) {
	if(document.getElementById("toName").value.length == 0) {
		document.getElementById("toName").value = toName;
	} else {
		document.getElementById("toName").value = document.getElementById("toName").value + " " + toName;
	}
	document.getElementById("toName").focus(); 
}
</script>

<form class="messages" action="index.php?s=Nachrichten" name="myform" method="post" autocomplete="off">
<table id="default" class="übersicht" cellspacing="0" cellpadding="0" width=100%>
	<tr>
		<td class="tbchell tbchell_ohne_left_padding" style="width:20%;" >
			<input tabindex="1" placeholder="<?php lng_echo('mail recipients');?>" name="toName" id="toName" style="width: 100%;" autofocus>
		</td>
		<td class="tbchell tbchell_ohne_left_padding" >
			<input tabindex="2" placeholder="<?php lng_echo('mail subject');?>" name="subject" id="subject" style="width: 100%;">
		</td>
		<td class="tbchell" style="text-align:right; width: 1%;">
			<button tabindex="4"class="btn_main btn_main_senden" type="submit" name="send-message" value="send-message"><?php lng_echo('send message');?></button>
		</td>
</tr>
	<tr>
		<td colspan=3 class="tbchell tbchell_ohne_left_padding" style="width: 100%;">
			<textarea tabindex="3" placeholder="<?php lng_echo('mail content');?>" name="text" id="text" rows=5 style="width: 100%;" ></textarea>
		</td>
	</tr>
</table>

<table id="default" class="übersicht" cellspacing="0" cellpadding="0" width=100%>
	<select name="action" onchange="this.form.submit()">
		<option selected value="0"><?php lng_echo('chose message action'); ?></option>
		<option value="1"><?php lng_echo('export marked messages'); ?></option>
		<option value="2"><?php lng_echo('delete marked messages'); ?></option>
		<option value="3"><?php lng_echo('archive marked messages'); ?></option>
		<option value="4" disabled><?php lng_echo('report marked messages'); ?></option>
	</select>
</table>

<?php

//usereingabe_cleaner ($value)
$nachrichten = get_message($spieler_id, $spieler_id, $username);


if($nachrichten["Error"] == false) {
	foreach($nachrichten["result"] as $key => $value) {		
	//dVar($value["Empfaenger_ID"],'$value["Empfaenger_ID"]');
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
				<td rowspan=2 class="tbchell tbchell_ohne_left_padding" style="width: 50px;" ><img src="<?php echo $image; ?>" style="vertical-align: middle;" width=50 height=50></td>
				<td class="tbchell"><span style="color: #00aed8"><?php echo $value["Absender_Name"].'    =->    '.$value["Empfaenger_Name"]; ?></span></td><td class="tbchell" style="width: 25em; text-align: right;"><span style="font-size: x-small; padding-right: 5px;"><input type="checkbox"  class="btn"></input>&nbsp;<?php lng_echo ('{DD.MM.YYYY hh:mm:ss@timestamp}',no_file,echo_on,array ('timestamp' => $value["Zeit"])); ?> &nbsp;&nbsp;<button class="btn">M</button> <button class="btn">E</button> <button class="btn">X</button></span></td>
			<tr>
				<td class="tbchell" colspan=2>
					<b><?php if($value["Betreff"]=="") {echo ' ';} else {echo $value["Betreff"];} ?> </b>
				</td>
			</tr>
			<?php if($value["Text"] != "") { ?>
				<tr>
					<td class="tbchell wordBreak" colspan=3>
						<?php echo preg_replace ('/\n/','<br>',$value["Text"]); ?> 
					</td>
				</tr>
			<?php } ?>
		</table>
		<?php 
	}	
	
} else {
	
	echo $nachrichten["Message"];
	
}
?>
</form>
<script> document.getElementById("toName").focus();</script>
