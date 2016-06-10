<?php

$rangliste = get_rangliste($spieler_id);

?>
<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
	<tr>
		<th class="tbtb tbtb_linksbundig" style="width: 5em;">Platz</th>
		<th class="tbtb tbtb_mitte">Spieler</th>
		<th class="tbtb tbtb_mitte">Punkte</th>
		<th class="tbtb tbtb_mitte">Allianz</th>
		<th class="tbtb tbtb_mitte">#</th>
	</tr>
	
	<?php 
	$z = 1;
	foreach ($rangliste as $key => $value) {
		?>
		<tr>
		<td class="tbchell tbchell_rechts" align="right"><?php echo $z; ?>.</td>
		<td class="tbchell" ><?php echo $rangliste[$key]["Name"]; ?></td>
		<td class="tbchell tbchell_rechts" ><?php echo number_format(sprintf('%d', $rangliste[$key]["Punkte"]), 0, ',', '.'); ?></td>
		<td class="tbchell" ></td>
		<td class="tbchell" ></td>
		</tr>
		
		<?php
		$z++;
	}
	?>
	<tr>
		
	</tr>
	
</table>