<form action="index.php" method="post" autocomplete="off">
<input type="hidden" name="s" value="Gebaeude">

<?php 
$baut_gerade = check_bauschleife_activ($spieler_id, $planet_id, "Structure");

if ($baut_gerade["ID"] != 0) {
	$Gebäude = get_gebäude_nächste_stufe($spieler_id, $planet_id, $baut_gerade["ID"], 1);
	
	
	
	?>
	<table id="default" border=0 cellspacing="0" cellpadding="0" class="übersicht" width=100% style="margin-bottom: 2em;">
		<tbody>
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
			<td class="tbchell BGpBar" colspan=2 >
			<div id="mPBar_gebaeudeOben<?php echo $baut_gerade["ID"]; ?>" class = "pBar"></div>
			<span id="gebaeudeOben<?php echo $baut_gerade["ID"]; ?>" class="tbchell LpBar"><script type="text/javascript"><!--
						countdown_progress(<?php echo $baut_gerade["Countdown"]; ?>, "gebaeudeOben<?php echo $baut_gerade["ID"]; ?>", <?php echo time() - $baut_gerade["Start"]; ?> , <?php echo $baut_gerade["Bis"] - $baut_gerade["Start"]; ?>, 'Fertiggestellt');
						</script></span>
			
			</td>			
		</tr>
		</tbody>
	</table>
	<?php 
	
}
?>

<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
<tr>
	<th class="tbtb "> </th>
	<th class="tbtb ">Gebäude</th>
	<th class="tbtb " colspan=3>Stufe</th>
	<th class="tbtb " colspan=4>Kosten</th>
	<th class="tbtb ">Bauzeit</th>	
</tr>
<?php 

for($i = 1; $i <= 10; $i++) {

	$baut_gerade = check_bauschleife_activ($spieler_id, $planet_id, "Structure");	
	
	$Gebäude = get_gebäude_nächste_stufe($spieler_id, $planet_id, $i, 1);

	$kann_gebaut_werden = true;
	$farbeE = ""; if($ressource["Eisen"] < $Gebäude["Kosten_Eisen"]) { $farbeE = "#FF0000"; $kann_gebaut_werden = false; }
	$farbeS = ""; if($ressource["Silizium"] < $Gebäude["Kosten_Silizium"]) { $farbeS = "#FF0000"; $kann_gebaut_werden = false; }
	$farbeW = ""; if($ressource["Wasser"] < $Gebäude["Kosten_Wasser"]) { $farbeW = "#FF0000"; $kann_gebaut_werden = false; }
	$farbeEn = ""; if($ressource["Energie"] < $Gebäude["Kosten_Energie"]) { $farbeEn = "#FF0000"; $kann_gebaut_werden = false; }
	
	?>
	
		<tr>
			<td class="tbchell"><a href="javascript:details('G<?php echo $i; ?>');" id="detailsButton" name="G<?php echo $i; ?>Button" class="detailsGeschlossen" >&#9654;</a></td>
			<td class="tbchell"><?php echo $Gebäude["Name"]; ?></td>
			<td class="tbchell tbchell_ohne_right_border" style="padding-left: .5em;"><font color='#00FF00'>&#10138;</font></td>
			<td class="tbchell tbchell_ohne_left_border tbchell_ohne_right_border"><?php echo ($Gebäude["Stufe"]); ?></td>
			<td class="tbchell tbchell_ohne_left_border">
				<?php if($kann_gebaut_werden == true && $baut_gerade["ID"] == 0) { ?> 				
				<button type="submit" name="action-gebaeude-bauen" style="width: 3em; margin-left: .5em;" value="<?php echo $i; ?>"><font color='#00FF00'>+</font></button>
				<?php } ?>
			</td>			
			<td class="tbchell"><img src="img/eisen.png" class="img_ress"> <?php echo "<font color='$farbeE'>" . number_format($Gebäude["Kosten_Eisen"], 0, '.', '.') . "</font>"; ?></td>
			<td class="tbchell"><img src="img/silizium.png" class="img_ress"> <?php echo "<font color='$farbeS'>" . number_format($Gebäude["Kosten_Silizium"], 0, '.', '.') . "</font>"; ?></td>
			<td class="tbchell"><img src="img/wasser.png" class="img_ress"> <?php echo "<font color='$farbeW'>" . number_format($Gebäude["Kosten_Wasser"], 0, '.', '.') . "</font>"; ?></td>
			<td class="tbchell"><img src="img/energie.png" class="img_ress"> <?php echo "<font color='$farbeEn'>" . number_format($Gebäude["Kosten_Energie"], 0, '.', '.') . "</font>"; ?></td>
			<td class="tbchell" style="text-align: right;">
			<?php 				
			if($kann_gebaut_werden == true && $baut_gerade["ID"] == 0) {
				echo get_timestamp_in_was_sinnvolles($Gebäude["Bauzeit"]); ?> <?php				
			} else {
				if ($baut_gerade["ID"] == $i) {
					?>
					<button type="submit" name="action-gebaeude-abbrechen" class="LpBarZ" value="<?php echo $i; ?>">Abbrechen</button><?php
				} else {
					echo get_timestamp_in_was_sinnvolles($Gebäude["Bauzeit"]); ?> <?php
				}
			}
			?>
			</td>
			</tr>
			<tr name="G<?php echo $i ?>"class="detailsAusgeblendet" style="display:none;">
			<td  colspan="10" align="center">
				<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=98% style="margin: .5em;">
					<tbody>
					
					<tr>
						<td class="tbchell"><?php echo $Gebäude["Beschreibung"]; ?></td>
					</tr>
					<tr>
						<td class="tbchell">
							<ul class="ress"><!-- class="nav inline-items" -->
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
					<tr style=""><td class="tbchell">
					<?php echo $Gebäude["Wirkung"]; ?>
					</td></tr>
					<tr><td style="text-align: right;"  class="tbchell BGpBar">
					
					<?php 				
					if($kann_gebaut_werden == true && $baut_gerade["ID"] == 0) {
			
						
							echo get_timestamp_in_was_sinnvolles($Gebäude["Bauzeit"]); ?> <button type="submit" name="action-gebaeude-bauen" value="<?php echo $i; ?>">Bauen</button><?php				
						 
						
					} else {
						
						if ($baut_gerade["ID"] == $i) {
								
								
							?>
							<div id="mPBar_gebaeude<?php echo $i; ?>" class = "pBar"></div>
							<span id="gebaeude<?php echo $i; ?>" class="LpBar"><script type="text/javascript"><!--
									countdown_progress(<?php echo $baut_gerade["Countdown"]; ?>, "gebaeude<?php echo $i; ?>", <?php echo time() - $baut_gerade["Start"]; ?> , <?php echo $baut_gerade["Bis"] - $baut_gerade["Start"]; ?>, 'Fertiggestellt');
									</script></span>
									<button type="submit" name="action-gebaeude-abbrechen" class="LpBarZ" value="<?php echo $i; ?>">Abbrechen</button><?php
								} else {
									
									
						
						echo get_timestamp_in_was_sinnvolles($Gebäude["Bauzeit"]); ?> <button disabled style="visibility: hidden;">Bauen</button><?php
								}
					}
					
							
					
					
					
					?>
					
						
									
					</td></tr>
					</tbody>
					
				</table>
	
			</td>
		</tr>
	
	
		
		
	<?php 
	
}

?>
</table>
</form>
<tt>▲▼▶▼</tt>