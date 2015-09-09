<form action="index.php" method="post" autocomplete="off">
<input type="hidden" name="s" value="Verteidigung">
<input type="hidden" name="ship_id" id="ship_id" value="">
<div class="flex_gebaeude_info">



<?php


$waffenfabrik_stufe = get_gebäude_aktuelle_stufe($spieler_id, 0, 8);


$waffenfabrik_stufe = 20;

if($waffenfabrik_stufe == 0) {
	
	echo "Baue erst eine Waffenfabrik.";
	
} else {
	
	
	
	for($i = 1; $i <= 6; $i++) {
		
		$Def = get_def($i);
		
		//var_dump($Def);
		
		$Def_in_ownership = 1; //<-------------- INSERT CODE
	
		if($Def["Stufe_Werft"] <= $waffenfabrik_stufe) {
			
			
			if($Def["Max_Hold"] == $Def_in_ownership AND $Def["Stufe_Werft"]) {
				
				
				?>
						<div><table id="default" class="ubersicht" width=100%>
							<th><h3 style="display: inline;"><?php echo $Def["Name"]; ?></h3> <span class="code">[<?php echo $Def["Kuerzel"]; ?>] MAX</span></th>
							<tr>
								<td><?php echo $Def["Beschreibung"]; ?></td>
							</tr>
							<tr><td>
								<ul class="nav inline-items-attr">
									<li><font style="font-size: x-small;">Angriff: </font><?php echo number_format($Def["Angriff"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Verteidigung: </font><?php echo number_format($Def["Verteidigung"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Geschwindigkeit: </font><?php echo  number_format($Def["Geschwindigkeit"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Kapazitaet: </font><?php echo number_format($Def["Kapazitaet"], 0, '.', '.'); ?></li>
								</ul>
							</td></tr>
							
						</table></div>
				
				<?php
			} else {
			
			$kann_gebaut_werden = true;
			$farbeE = ""; if($ressource["Eisen"] < $Def["Kosten_Eisen"]) { $farbeE = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeS = ""; if($ressource["Silizium"] < $Def["Kosten_Silizium"]) { $farbeS = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeW = ""; if($ressource["Wasser"] < $Def["Kosten_Wasser"]) { $farbeW = "#FF0000"; $kann_gebaut_werden = false; }
		
			?>
			<div>
			
			<table id="default" class="ubersicht" width=100%>
				<th><h3 style="display: inline;"><?php echo $Def["Name"]; ?></h3> <span class="code">[<?php echo $Def["Kuerzel"]; ?>]</span></th>
				<tr>
					<td><?php echo $Def["Beschreibung"]; ?></td>
				</tr>
				<tr>
					<td>
						<ul class="ress">
							<li><img src="img/eisen.png" class="img_ress"> <?php echo "<font color='$farbeE'>" . number_format($Def["Kosten_Eisen"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/silizium.png" class="img_ress"> <?php echo "<font color='$farbeS'>" . number_format($Def["Kosten_Silizium"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/wasser.png" class="img_ress"> <?php echo "<font color='$farbeW'>" . number_format($Def["Kosten_Wasser"], 0, '.', '.') . "</font>"; ?></li>
					</ul>
					</td></tr>
				<tr><td>
				
				<ul class="nav inline-items-attr">
					<li><font style="font-size: x-small;">Angriff: </font><?php echo number_format($Def["Angriff"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Verteidigung: </font><?php echo number_format($Def["Verteidigung"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Geschwindigkeit: </font><?php echo  number_format($Def["Geschwindigkeit"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Kapazitaet: </font><?php echo number_format($Def["Kapazitaet"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Reichweite: </font><?php echo number_format($Def["Reichweite"], 0, '.', '.'); ?></li>
				</ul>
				</td></tr>
				<tr><td style="text-align: right;">
				
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