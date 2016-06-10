<form action="index.php" method="post" autocomplete="off">
<input type="hidden" name="s" value="Gebaeude">

<?php 
$baut_gerade = check_bauschleife_activ($spieler_id, 0, "Structure");

if ($baut_gerade["ID"] != 0) {
	$Gebäude = get_gebäude_nächste_stufe($spieler_id, 0, $baut_gerade["ID"], 1);
	
	
	
	?>
	<table id="default" border=0 cellspacing="0" cellpadding="0" class="übersicht" width=100% style="margin-bottom: 2em;">
		<tr>
			<th class="tbtb tbtb_ohne_links_rechts_oben" align="left" width="255" colspan=2><?php echo $Gebäude["Name"]; ?> (Stufe <?php echo ($Gebäude["Stufe"]); ?>) wird gebaut </th>
			<th class="tbtb tbtb_ohne_links_rechts_oben" align="right"><button type="submit" name="action-gebaeude-abbrechen" value="<?php echo $baut_gerade["ID"]; ?>">Abbrechen</button></th>
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

for($i = 1; $i <= 10; $i++) {

	$baut_gerade = check_bauschleife_activ($spieler_id, 0, "Structure");	
	
	$Gebäude = get_gebäude_nächste_stufe($spieler_id, 0, $i, 1);

	$kann_gebaut_werden = true;
	$farbeE = ""; if($ressource["Eisen"] < $Gebäude["Kosten_Eisen"]) { $farbeE = "#FF0000"; $kann_gebaut_werden = false; }
	$farbeS = ""; if($ressource["Silizium"] < $Gebäude["Kosten_Silizium"]) { $farbeS = "#FF0000"; $kann_gebaut_werden = false; }
	$farbeW = ""; if($ressource["Wasser"] < $Gebäude["Kosten_Wasser"]) { $farbeW = "#FF0000"; $kann_gebaut_werden = false; }
	$farbeEn = ""; if($ressource["Energie"] < $Gebäude["Kosten_Energie"]) { $farbeEn = "#FF0000"; $kann_gebaut_werden = false; }
	
	?>
	
	
	<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
		<th class="tbtb tbtb_ohne_links_rechts_oben" align="left"><?php echo $Gebäude["Name"]; ?> <span class="code">(Stufe <?php echo ($Gebäude["Stufe"] - 1); ?>)</span></th>
		<tr>
			<td class="tbchell"><?php echo $Gebäude["Beschreibung"]; ?></td>
		</tr>
		<tr>
			<td class="tbchell">
				<ul class="ress">
					<li><img src="img/eisen.png" class="img_ress"> <?php echo "<font color='$farbeE'>" . number_format($Gebäude["Kosten_Eisen"], 0, '.', '.') . "</font>"; ?></li>
					<li><img src="img/silizium.png" class="img_ress"> <?php echo "<font color='$farbeS'>" . number_format($Gebäude["Kosten_Silizium"], 0, '.', '.') . "</font>"; ?></li>
					<li><img src="img/wasser.png" class="img_ress"> <?php echo "<font color='$farbeW'>" . number_format($Gebäude["Kosten_Wasser"], 0, '.', '.') . "</font>"; ?></li>
					<li><img src="img/energie.png" class="img_ress"> <?php echo "<font color='$farbeEn'>" . number_format($Gebäude["Kosten_Energie"], 0, '.', '.') . "</font>"; ?></li>
			</ul>
			</td></tr><tr><td class="tbchell">
			<ul class="ress"><li class="img_ress">
			<?php 
			if($i == 1) { echo "<img src='img/eisen.png' class='img_ress'> + " . $Gebäude["Gewinn_Ress"] . "/h"; }
			if($i == 2) { echo "<img src='img/silizium.png' class='img_ress'> + ". $Gebäude["Gewinn_Ress"] . "/h"; }
			if($i == 3) { echo "<img src='img/wasser.png' class='img_ress'> + ". $Gebäude["Gewinn_Ress"] . "/h"; }	

			if($Gebäude["Gewinn_Energie"] > 0) { echo "<img src='img/energie.png' class='img_ress'> + " . $Gebäude["Gewinn_Energie"] . " Einheiten"; }
			if($Gebäude["Kapazitaet"] > 0) { echo "+ " . $Gebäude["Kapazitaet"] . " Einheiten"; }
			
			?>		<span style="visibility: hidden;">f</span>	
			</li></ul>
			</td>
		</tr>
		<tr><td class="tbchell">
		<?php echo $Gebäude["Wirkung"]; ?>
		</td></tr>
		<tr><td style="text-align: right;"  class="tbchell">
		
		<?php 				
		if($kann_gebaut_werden == true && $baut_gerade["ID"] == 0) {

			
				echo get_timestamp_in_was_sinnvolles($Gebäude["Bauzeit"]); ?> <button type="submit" name="action-gebaeude-bauen" value="<?php echo $i; ?>">Bauen</button><?php				
			 
			
		} else {
			
			if ($baut_gerade["ID"] == $i) {
					
					
				?><span id="gebaeude<?php echo $i; ?>"><script type="text/javascript"><!--
						countdown(<?php echo $baut_gerade["Countdown"]; ?>, "gebaeude<?php echo $i; ?>");
						</script></span>
						<button type="submit" name="action-gebaeude-abbrechen" value="<?php echo $i; ?>">Abbrechen</button><?php
					} else {
						
						
			
			echo get_timestamp_in_was_sinnvolles($Gebäude["Bauzeit"]); ?> <button disabled style="visibility: hidden;">Bauen</button><?php
					}
		}
		
				
		
		
		
		?>
		
			
						
		</td></tr>
		
		
	</table>
	
	
	
	<?php 
	
}

?>
	
	
	
	
</form>