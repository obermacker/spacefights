<?php  
$flotte = get_activity_schiffe_Liste($spieler_id, 0);
if (isset($flotte)) { ?>
	
	
		
						
<?php


	$i = 0;
	foreach($flotte as $key => $value) {
		$ID = $flotte[$key]["ID"];
		$anzahl = $flotte[$key]["Anzahl"];
		$name = $flotte[$key]["Name"];
		$zeit_bis = $flotte[$key]["Zeit-Bis"];
		
		?> 
		<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
		<tr><td class="tbtb tbtb_ohne_rechts"><?php echo str_replace(' ', '&nbsp;&nbsp;', str_pad($anzahl, 2 ," ", STR_PAD_LEFT)) . "x "; ?><?php echo "$name"; ?></td>
		<tr><td align="right" class="tbchell tbchell_rechts">
										<span id="flotte<?php echo $i; ?>"><script type="text/javascript"><!--
										countdown(<?php echo $zeit_bis; ?>, "flotte<?php echo $i; ?>");
										</script></span>
										<form style="display: inline;" action="index.php" method="post" autocomplete="off"><input type="hidden" name="s" value="<?php echo $select; ?>"><button type="submit" name="action-schiffe-abbrechen" id="action-schiffe-abbrechen_<?php echo $i; ?>" value="<?php echo $ID; ?>">x</button></form>
		</td></tr>
		</table>
		<?php 
		$i++;
	}
	
	

		
	
			//<tr><th>Verteidigung</th><td>dd</td></tr>
?>		
		
	
<?php } ?>

<?php  
$deff_schleife = get_activity_deff_Liste($spieler_id, 0);
if (isset($deff_schleife)) { ?>
	

		
						
<?php


	$i = 0;
	foreach($deff_schleife as $key => $value) {
		$ID = $deff_schleife[$key]["ID"];
		$anzahl = $deff_schleife[$key]["Anzahl"];
		$name = $deff_schleife[$key]["Name"];
		$zeit_bis = $deff_schleife[$key]["Zeit-Bis"];
		
		?> 
		<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
		<tr><td class="tbtb tbtb_ohne_rechts"><?php echo str_replace(' ', '&nbsp;&nbsp;', str_pad($anzahl, 2 ," ", STR_PAD_LEFT)) . "x "; ?><?php echo "$name"; ?></td></tr>
		<tr><td align="right" class="tbchell tbchell_rechts">
										<span id="deff<?php echo $i; ?>"><script type="text/javascript"><!--
										countdown(<?php echo $zeit_bis; ?>, "deff<?php echo $i; ?>");
										</script></span>
										<form style="display: inline;" action="index.php" method="post" autocomplete="off"><input type="hidden" name="s" value="<?php echo $select; ?>"><button type="submit" name="action-deff-abbrechen" id="action-deff-abbrechen_<?php echo $i; ?>" value="<?php echo $ID; ?>">x</button></form>
		</td></tr>
		</table>
		<?php 
		$i++;
	}
	
	

		
	
			//<tr><th>Verteidigung</th><td>dd</td></tr>
?>		
		
	
<?php } ?>