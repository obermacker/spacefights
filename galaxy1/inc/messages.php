<?php 

switch (true) {
	
	case (isset($_POST['send-message'])): 
		if ($_POST['send-message'] == 'send-message' & $_POST['toName'] != '') {
			
			$to=array();
			foreach (array_unique (array_map('trim',explode('@',$_POST['toName']))) as $value) {
				$toName = preg_replace ('/ /','',$value);
				$toID = get_player_id ($toName);
				if ($toName != "" && $toID != NULL) {
					$to[] = array ('toName' => $toName, 'toID' => $toID);
				}
			}
			
			foreach ($to as $value) {
				$subject = user_message_cleaner($_POST['subject']);		
				$text = user_message_cleaner($_POST['text']);		
				set_message($spieler_id, $username,$value['toID'],$value['toName'], $subject,  $text);
			}
		}
		break;

	case (isset($_POST['delete'])):
		delete_message($_POST['delete']);
		break;

	case (isset($_POST['select_action'])):
		switch ($_POST['select_action']):
			case 'delete_marked':
				delete_message($_POST['marked']);
				break;
		endswitch;
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
<div id="default" class="messagesGrid übersicht">
		<div class="sendMessagesRecipient tbchell tbchell_ohne_left_padding">
			<input tabindex="1" placeholder="<?php lng_echo('mail recipients');?>" name="toName" id="toName" style="width: 100%;" autofocus>
		</div>
		<div class="sendMessagesSubject tbchell tbchell_ohne_left_padding">
			<input tabindex="2" placeholder="<?php lng_echo('mail subject');?>" name="subject" id="subject" style="width: 100%;">
		</div>
		<div class="sendMessagesSendBtn tbchell">
			<button tabindex="4" class="btn_main btn_main_senden" style="width: 100%;" type="submit" name="send-message" value="send-message"><?php lng_echo('send message');?></button>
		</div>
		<div class="sendMessagesContent tbchell tbchell_ohne_left_padding">
			<textarea tabindex="3" placeholder="<?php lng_echo('mail content');?>" name="text" id="text" rows=5 style="width: 100%;" ></textarea>
		</div>
</div>

<div id="default" class="übersicht">  <!-- für GRID anpassen !? -->
	<select name="select_action" onchange="this.form.submit()">
	<option selected value=""><?php lng_echo('chose message action'); ?></option>
		<option value="export_marked" disabled><?php lng_echo('export marked messages'); ?></option>
		<option value="delete_marked"><?php lng_echo('delete marked messages'); ?></option>
		<option value="archive_marked" disabled><?php lng_echo('archive marked messages'); ?></option>
		<option value="report_marked" disabled><?php lng_echo('report marked messages'); ?></option>
	</select>
</div>

<?php

$_messages = get_messages($playerID, $playerID, $playerName);

if($_messages['noMessages']) {
	
	echo lng_echo('no messages');

} else {

	foreach($_messages['item'] as $_item) {		
	?> 
		<div id="default" class="messagesGrid übersicht">
			<?php 
				$_playerImageFile = "img/default_user_50x50.png";
				if($_item->chatbotMessage == 1) { 
					$_playerImageFile = "img/chatbot_50x50.png"; 
				} else {
					$_playerImage = get_player_image($_item->senderID);
					if($_playerImage != '') {$_playerImageFile = 'img/spieler/'.$_playerImage;}
				}
			?>
			<div class="messagesImage tbchell tbchell_ohne_left_padding"><img src="<?= $_playerImageFile ?>" style="vertical-align: middle;" width=50 height=50></div>
			<div class="messagesSenderRecipient tbchell"><span style="color: #00aed8"><?= $_item->senderName ?>    =->    <?= $_item->recipientName ?></span></div>
			<div class="messagesDateButtons tbchell" style="text-align: right;"><span style="font-size: x-small; padding-right: 5px;">
				<input type="checkbox" class="btn" name="marked[]" value="<?= $_item->messageID ?>"></input>
				&nbsp;<?php lng_echo ('{DDD YYYY/MM/DD hh:mm:ss am/pm@timestamp}',no_file,echo_on,array ('timestamp' => $_item->messageSent)); ?> 
				&nbsp;&nbsp;<button disabled class="btn" type=submit name="report" value="<?= $_item->messageID ?>">M</button> 
				<button disabled class="btn" type=submit name="export" value="<?= $_item->messageID ?>">E</button> 
				<button class="btn" type=submit name="delete" value="<?= $_item->messageID ?>">X</button></span>
			</div>
			<div class="messagesSubject tbchell">
				<b><?php if($_item->messageSubject =="") {echo ' ';} else {echo $_item->messageSubject;} ?> </b>
			</div>
			<?php if($_item->messageText != "") { ?>
			<div class="messagesContent tbchell wordBreak">
				<?= preg_replace ('/\n/','<br>',$_item->messageText) ?> 
			</div>
			<?php } ?>
		</div>
		<?php 
	}	
}
?>
</form>
<script> document.getElementById("toName").focus();</script>
