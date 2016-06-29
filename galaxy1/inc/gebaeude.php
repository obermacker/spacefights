<form action="index.php" method="post" autocomplete="off">
<input type="hidden" name="s" value="Gebaeude">

<?php 
$baut_gerade = check_bauschleife_activ($spieler_id, $planet_id, "Structure");

if ($baut_gerade["ID"] != 0) {
	$Gebäude = get_gebäude_nächste_stufe($spieler_id, $planet_id, $baut_gerade["ID"], 1);
	
	
	
	?>
	<table id="default" border=0 cellspacing="0" cellpadding="0" class="übersicht" width=100% style="margin-bottom: 2em; display:none; ">
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
	
			<?php 	if ($baut_gerade["ID"] == 0) {			//statuszeile ausgrauen , bzw. hervorheben
						if (!$kann_gebaut_werden) {echo ('<tr class="passiv">');}
					} else if ($baut_gerade["ID"] != $i) {
						echo ('<tr class="passiv">');
					} else {
						echo ('<tr class="imBau">');
					}
			?>
			<td class="tbchell"><a href="javascript:details('G<?php echo $i; ?>');" id="detailsButton" name="G<?php echo $i; ?>Button" class="detailsGeschlossen">▶</a></td>	
			<td class="tbchell"><?php echo $Gebäude["Name"]; ?></td>
			<td class="tbchell tbchell_ohne_right_border" style="padding-left: .5em; width: 2em;"><font color='#00FF00'>&#10138;</font></td>
			<td class="tbchell tbchell_ohne_left_border tbchell_ohne_right_border"><?php echo ($Gebäude["Stufe"]); ?></td>
			<td class="tbchell tbchell_ohne_left_border" style="width: 3em;">
				<?php if($kann_gebaut_werden == true && $baut_gerade["ID"] == 0) { ?> 				
				<button type="submit" name="action-gebaeude-bauen" style="width: 3em; margin-left: .5em;" value="<?php echo $i; ?>"><font color='#00FF00'>+</font></button>
				<?php } ?>
				<?php if ($baut_gerade["ID"] == $i) { ?>
					<button type="submit" name="action-gebaeude-abbrechen" style="width: 3em; margin-left: .5em;" value="<?php echo $i; ?>"><font color='#FF0000'>x</font></button>					
				<?php } ?>
				
			</td>			
			<td class="tbchell"><img src="img/eisen.png" class="img_ress"> <?php echo "<font color='$farbeE'>" . number_format($Gebäude["Kosten_Eisen"], 0, '.', '.') . "</font>"; ?></td>
			<td class="tbchell"><img src="img/silizium.png" class="img_ress"> <?php echo "<font color='$farbeS'>" . number_format($Gebäude["Kosten_Silizium"], 0, '.', '.') . "</font>"; ?></td>
			<td class="tbchell"><img src="img/wasser.png" class="img_ress"> <?php echo "<font color='$farbeW'>" . number_format($Gebäude["Kosten_Wasser"], 0, '.', '.') . "</font>"; ?></td>
			<td class="tbchell"><img src="img/energie.png" class="img_ress"> <?php echo "<font color='$farbeEn'>" . number_format($Gebäude["Kosten_Energie"], 0, '.', '.') . "</font>"; ?></td>
			<td class="tbchell" style="text-align: right; width: 12em;">
			<?php 				
			if($kann_gebaut_werden == true && $baut_gerade["ID"] == 0) {
				echo get_timestamp_in_was_sinnvolles($Gebäude["Bauzeit"]); ?> </td></tr><?php				
			} else {
				if ($baut_gerade["ID"] == $i) {
					?>
					
					<span id="cdKopf<?php echo $baut_gerade["ID"]; ?>" class="tbchell" style="padding-right: 0px;">
						<script type="text/javascript">
							countdown_progress(<?php echo $baut_gerade["Countdown"]; ?>, "cdKopf<?php echo $baut_gerade["ID"]; ?>", <?php echo time() - $baut_gerade["Start"]; ?> , <?php echo $baut_gerade["Bis"] - $baut_gerade["Start"]; ?>, 'fertiggestellt',0,true);
						</script>
					</span>
					</td></tr>
					<tr>
						<td colspan="10" align="center" class="BGpBar">
							<div id="mPBar_pbKopf<?php echo $baut_gerade["ID"]; ?>" class="pBar" style="margin-top: -1px; margin-left: 0.5%; height: 3px;"></div>
							<span id="pbKopf<?php echo $baut_gerade["ID"]; ?>" class="LpBar" style="display:none;">
								<script type="text/javascript">
									countdown_progress(<?php echo $baut_gerade["Countdown"]; ?>, "pbKopf<?php echo $baut_gerade["ID"]; ?>" , <?php echo time() - $baut_gerade["Start"]; ?> , <?php echo $baut_gerade["Bis"] - $baut_gerade["Start"]; ?>, 'fertiggestellt',99);
								</script>
							</span>
						</td>
					</tr>
				
				
					
					<?php 
				} else {
					echo get_timestamp_in_was_sinnvolles($Gebäude["Bauzeit"]); ?> <?php
				}
			}
			?>

			<tr name="G<?php echo $i ?>"class="detailsAusgeblendet" style="display:none;">
			<td  colspan="10" align="center">
				<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=99% style="margin: .5em;">
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
					<?php if($baut_gerade["ID"] == $i) { ?>
					<tr><td class="tbchell">Bau bis: <?php echo get_timestamp_in_was_lesbares($baut_gerade["Bis"]); ?></td></tr>
					<?php } ?>
					</tbody>
					
				</table>
	
			</td>
		</tr>
	
	
		
		
	<?php 
	
}

?>
</table>
</form>
<tt style="display:none">▲▼▶▼</tt>