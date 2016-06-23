<form action="index.php" method="post" autocomplete="off">
<input type="hidden" name="s" value="Verteidigung">
<input type="hidden" name="ship_id" id="ship_id" value="">
<div class="ubersicht_gross" style="width: 100%">

<?php


$waffenfabrik_stufe = get_gebäude_aktuelle_stufe($spieler_id, $planet_id, 8);
$tech_stufe = get_tech_stufe_spieler($spieler_id);

//$waffenfabrik_stufe = 20;

if($waffenfabrik_stufe == 0) {
	
	echo "Baue erst eine Waffenfabrik.";
	
} else {
	
	
	
	for($i = 1; $i <= 6; $i++) {
		
		$Def = get_def($i);
		
		//var_dump($Def);
		
		$deff_in_Besitz["Planet"] = 0;
		$deff_in_Besitz["Galaxy"] = 0;
		
		$deff_in_Besitz = get_deff_in_Besitz($spieler_id, $planet_id, $i); 
		
		$tech_probe = true;
		for($t = 1; $t <= 12; $t++) {
				
			if ($tech_stufe["Tech_" . $t] < $Def["Tech_" . $t]) {
					
				$tech_probe = false;
					
					
			}
				
		}
			
		if($Def["Stufe_Werft"] <= $waffenfabrik_stufe AND $tech_probe == true) {
			
			
		
			
			$max = false;
			
			if($Def["Max_Hold_Planet"] != -1) { 
				
				if($deff_in_Besitz["Planet"] >= $Def["Max_Hold_Planet"]) { $max = true; }			
				
			}
			
			if($Def["Max_Hold"] != -1) {
			
				if($deff_in_Besitz["Galaxy"] >= $Def["Max_Hold"]) { $max = true; }
			
			}
				
			if($max == true AND $Def["Stufe_Werft"] <= $waffenfabrik_stufe) {
				
				
				?>
						<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
							<th class="tbtb tbtb_ohne_links_rechts_oben" align="left"><?php echo $Def["Name"]; ?> <span class="code">[<?php echo $Def["Kuerzel"]; ?>] MAX (<?php echo "Planet: " . $deff_in_Besitz["Planet"] . "/" . $Def["Max_Hold_Planet"]; ?>)</span></th>
							<tr>
								<td class="tbchell"><?php echo $Def["Beschreibung"]; ?></td>
							</tr>
							<tr><td class="tbchell">
								<ul class="nav inline-items-attr">
									<li><font style="font-size: x-small;">Angriff: </font><?php echo number_format($Def["Angriff"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Verteidigung: </font><?php echo number_format($Def["Verteidigung"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Geschwindigkeit: </font><?php echo  number_format($Def["Geschwindigkeit"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Kapazitaet: </font><?php echo number_format($Def["Kapazitaet"], 0, '.', '.'); ?></li>
								</ul>
							</td></tr>
							
						</table>
				
				<?php
			} else {
			
			$kann_gebaut_werden = true;
			$farbeE = ""; if($ressource["Eisen"] < $Def["Kosten_Eisen"]) { $farbeE = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeS = ""; if($ressource["Silizium"] < $Def["Kosten_Silizium"]) { $farbeS = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeW = ""; if($ressource["Wasser"] < $Def["Kosten_Wasser"]) { $farbeW = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeB = ""; if($ressource["Bot"] < $Def["Bots"]) { $farbeB = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeK = ""; if($ressource["Karma"] < $Def["Kosten_Karma"]) { $farbeK = "#FF0000"; $kann_gebaut_werden = false; }
				
		
			?>
			<div>
			
			<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
				<th class="tbtb tbtb_ohne_links_rechts_oben" align="left"><?php echo $Def["Name"]; ?> <span class="code">[<?php echo $Def["Kuerzel"]; ?>]</span></th>
				<tr>
					<td class="tbchell"><?php echo $Def["Beschreibung"]; ?></td>
				</tr>
				<tr>
					<td class="tbchell">
						<ul class="ress">
							<li><img src="img/bot.png" class="img_ress"> <?php echo "<font color='$farbeB'>" . number_format($Def["Bots"], 0, '.', '.') . "</font>"; ?></li>						
							<li><img src="img/eisen.png" class="img_ress"> <?php echo "<font color='$farbeE'>" . number_format($Def["Kosten_Eisen"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/silizium.png" class="img_ress"> <?php echo "<font color='$farbeS'>" . number_format($Def["Kosten_Silizium"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/wasser.png" class="img_ress"> <?php echo "<font color='$farbeW'>" . number_format($Def["Kosten_Wasser"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/karma.png" class="img_ress"> <?php echo "<font color='$farbeK'>" . number_format($Def["Kosten_Karma"], 0, '.', '.') . "</font>"; ?></li>
					</ul>
					</td></tr>
				<tr><td class="tbchell">
				
				<ul class="nav inline-items-attr">
					<li><font style="font-size: x-small;">Angriff: </font><?php echo number_format($Def["Angriff"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Verteidigung: </font><?php echo number_format($Def["Verteidigung"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Geschwindigkeit: </font><?php echo  number_format($Def["Geschwindigkeit"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Kapazitaet: </font><?php echo number_format($Def["Kapazitaet"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Reichweite: </font><?php echo number_format($Def["Reichweite"], 0, '.', '.'); ?></li>
				</ul>
				</td></tr>
				<tr><td style="text-align: right;" class="tbchell">
				
				<?php 				
				if($kann_gebaut_werden == true) {
		
					
						echo get_timestamp_in_was_sinnvolles($Def["Bauzeit"]); ?> <input type="text" size=2 maxlength=2 name="vanzahl<?php echo $i; ?>" onkeydown="if (event.keyCode == 13) document.getElementById('action-deff-bauen_<?php echo $i; ?>').click()"> <button type="submit" name="action-deff-bauen" id="action-deff-bauen_<?php echo $i; ?>" value="<?php echo $i; ?>">Bauen</button><?php				
					 
					
				} else {
					
					echo get_timestamp_in_was_sinnvolles($Def["Bauzeit"]); ?> <button disabled style="visibility: hidden;">Bauen</button><?php
							
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