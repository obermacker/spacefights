<?php
$recipient = get_Spielerliste($spieler_id);
?>

<table id="default" cellspacing="0" cellpadding="0" class="übersicht"  width="100%" >
<tr>
	<th class="tbtb tbtb_ohne_links_rechts_oben" align="left"><?php lng_echo ('recipients'); ?></th>
</tr>
<tr>
<td class="kontakte" align="left" style="text-align: left;">
<ul class="kontakte">
	<li><a href="javascript: add_recipient('@Galaxy1');" class="kontakte">@Galaxy1</a>	
	<?php 
	if($recipient["Error"] == false) {

		foreach ($recipient["result"] as $key => $value) {
			echo "<li><a href=\"javascript: add_recipient('@" . $value["Name"] . "');\" class='kontakte'>@" . $value["Name"] . "</a>";
		}
			
			
	} else {
		echo "<li>" . $recipient["Message"]; 
	}
	
	
	?>
</ul>
</td></tr></table>
