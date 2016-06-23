<form action="index.php" method="post" autocomplete="off">
<input type="hidden" name="s" value="Forschung">
<?php
$baut_gerade = check_bauschleife_activ($spieler_id, $planet_id, "Tech");

if ($baut_gerade["ID"] != 0) {
	
	$Tech = get_tech_nächste_stufe($spieler_id, $planet_id, $baut_gerade["ID"], 1);
	
	?>
	<table id="default" border=0 cellspacing="0" cellpadding="0" class="übersicht" width=100% style="margin-bottom: 2em;">
		<tr>
			<th class="tbtb tbtb_ohne_links_rechts_oben" align="left" width="255" colspan=2><?php echo $Tech["Name"]; ?> (Stufe <?php echo ($Tech["Stufe"]); ?>) wird geforscht </th>
			<th class="tbtb tbtb_ohne_links_rechts_oben" align="right"><button type="submit" name="action-forschung-abbrechen" value="<?php echo $baut_gerade["ID"]; ?>">Abbrechen</button></th>
		</tr>
		<tr>
			<td class="tbc" width="155" >Bau bis:</td>
			<td class="tbchell" colspan=2><?php echo get_timestamp_in_was_lesbares($baut_gerade["Bis"]); ?></td>			
		</tr>
		<tr>			
			<td class="tbc">Restliche Bauzeit:</td>
			<td class="tbchell" colspan=2 >
			
			<span id="gebaeudeOben<?php echo $baut_gerade["ID"]; ?>"><script type="text/javascript"><!--
						countdown(<?php echo $baut_gerade["Countdown"]; ?>, "gebaeudeOben<?php echo $baut_gerade["ID"]; ?>");
						</script></span>
			
			</td>			
		</tr>
		
	</table>
	<?php 
	
}
?>



<?php 

$Sortierung = get_tech_sortierung();

foreach ($Sortierung as $key => $value) {
	$i = $key;
	$baut_gerade = check_bauschleife_activ($spieler_id, $planet_id, "Tech");	
	
	$Tech = get_tech_nächste_stufe($spieler_id, $planet_id, $i, 1);
	
	if ($Tech["Forschung"] == "OK") {

		$kann_geforscht_werden = true;
		$farbeE = ""; if($ressource["Eisen"] < $Tech["Kosten_Eisen"]) { $farbeE = "#FF0000"; $kann_geforscht_werden = false; }
		$farbeS = ""; if($ressource["Silizium"] < $Tech["Kosten_Silizium"]) { $farbeS = "#FF0000"; $kann_geforscht_werden = false; }
		$farbeW = ""; if($ressource["Wasser"] < $Tech["Kosten_Wasser"]) { $farbeW = "#FF0000"; $kann_geforscht_werden = false; }
		
		?>
		
		
		<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
			<th class="tbtb tbtb_ohne_links_rechts_oben" align="left"><?php echo $Tech["Name"]; ?> <span class="code">(Stufe <?php echo ($Tech["Stufe"] - 1); ?>)</span></th>
			<tr>
				<td class="tbchell"><?php echo $Tech["Beschreibung"]; ?></td>
			</tr>
			<tr>
				<td class="tbchell">
					<ul class="ress">
						<li><img src="img/eisen.png" class="img_ress"> <?php echo "<font color='$farbeE'>" . number_format($Tech["Kosten_Eisen"], 0, '.', '.') . "</font>"; ?></li>
						<li><img src="img/silizium.png" class="img_ress"> <?php echo "<font color='$farbeS'>" . number_format($Tech["Kosten_Silizium"], 0, '.', '.') . "</font>"; ?></li>
						<li><img src="img/wasser.png" class="img_ress"> <?php echo "<font color='$farbeW'>" . number_format($Tech["Kosten_Wasser"], 0, '.', '.') . "</font>"; ?></li>
				</ul>
				</td></tr><tr><td class="tbchell">
				<ul class="ress"><li class="img_ress">
				<?php 
				?>		<span style="visibility: hidden;">f</span>	
				</li></ul>
				</td>
			</tr>
			<tr><td class="tbchell">
			<?php echo $Tech["Wirkung"]; ?>
			</td></tr>
			<tr><td style="text-align: right;" class="tbchell">
			
			<?php 				
			if($kann_geforscht_werden == true && $baut_gerade["ID"] == 0) {
	
				
					echo get_timestamp_in_was_sinnvolles($Tech["Bauzeit"]); ?> <button type="submit" name="action-forschung-bauen" value="<?php echo $i; ?>">Bauen</button><?php				
				 
				
			} else {
				
				if ($baut_gerade["ID"] == $i) {
						
						
					?><span id="forschung<?php echo $i; ?>"><script type="text/javascript"><!--
							countdown(<?php echo $baut_gerade["Countdown"]; ?>, "forschung<?php echo $i; ?>");
							</script></span>
							<button type="submit" name="action-forschung-abbrechen" value="<?php echo $i; ?>">Abbrechen</button><?php
						} else {
							
							
				
				echo get_timestamp_in_was_sinnvolles($Tech["Bauzeit"]); ?> <button disabled style="visibility: hidden;">Bauen</button><?php
						}
			}
			
					
			
			
			
			?>
			
				
							
			</td></tr>
			
			
		</table>
		
		
		
		<?php 
	}	
	
	
	if($Tech["Forschung"] == "MAX") {
?>
		<table id="default" class="ubersicht" width=100%>
			<th><h3 style="display: inline;"><?php echo $Tech["Name"]; ?></h3> <span class="code">[MAX]</span></th>
			<tr>
				<td><?php echo $Tech["Beschreibung"]; ?></td>
			</tr>
		</table>

<?php
		
	}
	
}

?>
	
	
	
	
</form>