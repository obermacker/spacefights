<?php
$spieler = get_Spielerliste($spieler_id);
?>

<table id="default" cellspacing="0" cellpadding="0" class="übersicht"  width="100%" >
<tr>
	<th class="tbtb tbtb_ohne_links_rechts_oben" align="left">Kontakte:</th>
</tr>
<tr>
<td class="kontakte" align="left" style="text-align: left;">
<ul class="kontakte">
	<li><a href="javascript: empfänger_hinzufügen('@Galaxy1');" class="kontakte">@Galaxy1</a>	
	<?php 
	if($spieler["Error"] == false) {

		foreach ($spieler["result"] as $key => $value) {
			echo "<li><a href=\"javascript: empfänger_hinzufügen('@" . $value["Name"] . "');\" class='kontakte'>@" . $value["Name"] . "</a>";
		}
			
			
	} else {
		echo "<li>" . $spieler["Message"]; 
	}
	
	
	?>
</ul>
</td></tr></table>
