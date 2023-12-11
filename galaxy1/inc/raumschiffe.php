<form action="index.php" name="myform" method="post" autocomplete="off">
<input type="hidden" name="s" value="Raumschiffe">
<input type="hidden" name="ship_id" id="ship_id" value="">
<div class="ubersicht_gross" style="width: 100%">



<?php


$raumschiffwerft_stufe = get_gebäude_aktuelle_stufe($spieler_id, $planet_id, 7);
$tech_stufe = get_tech_level_player($spieler_id);

if($raumschiffwerft_stufe == 0) {
	
	echo "Baue erst eine Raumschiffwerft.";
	
} else {
	
	
	
	for($i = 1; $i <= 12; $i++) {
		
		$Ship = get_ship($i);
		
		$tech_probe = true;
		for($t = 1; $t <= 12; $t++) {
			
			if ($tech_stufe["Tech_" . $t] < $Ship["Tech_" . $t]) {
				
				$tech_probe = false;
				
				
			}
			
		}
		
	
		if($Ship["Stufe_Werft"] <= $raumschiffwerft_stufe AND $tech_probe == true) {
			
			
			
			$schiff_in_Besitz = get_schiffe_in_Besitz($spieler_id, $planet_id, $i);
			$max = false;
				
			if($Ship["Max_Hold_Planet"] != -1) {
		
				if($schiff_in_Besitz["Planet"] >= $Ship["Max_Hold_Planet"]) { $max = true; }
		
			}
				
			if($Ship["Max_Hold"] != -1) {
					
				if($schiff_in_Besitz["Galaxy"] >= $Ship["Max_Hold"]) { $max = true; }
					
			}
		
			
			
			if($max == true AND $Ship["Stufe_Werft"] <= $raumschiffwerft_stufe) {
				
				
				?>
						<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
							<th class="tbtb tbtb_ohne_links_rechts_oben" align="left"><?php echo $Ship["Name"]; ?> <span class="code">[<?php echo $Ship["Kuerzel"]; ?>] MAX</span></th>
							<tr>
								<td class="tbchell"><?php echo $Ship["Beschreibung"]; ?></td>
							</tr>
							<tr><td class="tbchell">
								<ul class="nav inline-items-attr">
									<li><font style="font-size: x-small;">Angriff: </font><?php echo number_format($Ship["Angriff"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Verteidigung: </font><?php echo number_format($Ship["Verteidigung"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Geschwindigkeit: </font><?php echo  number_format($Ship["Geschwindigkeit"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Kapazitaet: </font><?php echo number_format($Ship["Kapazitaet"], 0, '.', '.'); ?></li>
								</ul>
							</td></tr>
							
						</table>
				
				<?php
			} else {
			
			$kann_gebaut_werden = true;
			$farbeE = ""; if($ressource["Eisen"] < $Ship["Kosten_Eisen"]) { $farbeE = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeS = ""; if($ressource["Silizium"] < $Ship["Kosten_Silizium"]) { $farbeS = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeW = ""; if($ressource["Wasser"] < $Ship["Kosten_Wasser"]) { $farbeW = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeB = ""; if($ressource["Bot"] < $Ship["Bots"]) { $farbeB = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeK = ""; if($ressource["Karma"] < $Ship["Kosten_Karma"]) { $farbeK = "#FF0000"; $kann_gebaut_werden = false; }
			
			$Ship['Bauzeit'] = $Ship['Bauzeit'] / (1 * $raumschiffwerft_stufe);
		
			?>
			<div>
			
			<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
				<th class="tbtb tbtb_ohne_links_rechts_oben" align="left"><?php echo $Ship["Name"]; ?> <span class="code">[<?php echo $Ship["Kuerzel"]; ?>]</span></th>
				<tr>
					<td class="tbchell"><?php echo $Ship["Beschreibung"]; ?></td>
				</tr>
				<tr>
					<td class="tbchell">
						<ul class="ress">
							<li><img src="img/bot.png" class="img_ress"> <?php echo "<font color='$farbeB'>" . number_format($Ship["Bots"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/eisen.png" class="img_ress"> <?php echo "<font color='$farbeE'>" . number_format($Ship["Kosten_Eisen"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/silizium.png" class="img_ress"> <?php echo "<font color='$farbeS'>" . number_format($Ship["Kosten_Silizium"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/wasser.png" class="img_ress"> <?php echo "<font color='$farbeW'>" . number_format($Ship["Kosten_Wasser"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/karma.png" class="img_ress"> <?php echo "<font color='$farbeK'>" . number_format($Ship["Kosten_Karma"], 0, '.', '.') . "</font>"; ?></li>
					</ul>
					</td></tr>
				<tr><td class="tbchell">
				
				<ul class="nav inline-items-attr">					
					<li><font style="font-size: x-small;">Angriff: </font><?php echo number_format($Ship["Angriff"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Verteidigung: </font><?php echo number_format($Ship["Verteidigung"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Geschwindigkeit: </font><?php echo  number_format($Ship["Geschwindigkeit"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Kapazitaet: </font><?php echo number_format($Ship["Kapazitaet"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Reichweite: </font><?php echo number_format($Ship["Reichweite"], 0, '.', '.'); ?></li>
				</ul>
				</td></tr>
				<tr><td style="text-align: right;" class="tbchell">
				
				<?php 				
				if($kann_gebaut_werden == true) {
		
					
						echo get_timestamp_in_was_sinnvolles($Ship["Bauzeit"]); ?> <input type="text" size=2 maxlength=2 name="vanzahl<?php echo $i; ?>" onkeydown="if (event.keyCode == 13) document.getElementById('action-schiffe-bauen_<?php echo $i; ?>').click()"> <button type="submit" name="action-schiffe-bauen" id="action-schiffe-bauen_<?php echo $i; ?>" value="<?php echo $i; ?>">Bauen</button><?php				
						 
					
				} else {
					
					echo get_timestamp_in_was_sinnvolles($Ship["Bauzeit"]); ?> <button disabled style="visibility: hidden;">Bauen</button><?php
							
				}
				
						
				
				
				
				?>
				
					
								
				</td></tr>
				
				
			</table>
			
			</div>
			
			<?php 
			
			}
		}
	}
}
	
?>
	
	
	
	</div>
</form>