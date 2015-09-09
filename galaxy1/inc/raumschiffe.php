<form action="index.php" name="myform" method="post" autocomplete="off">
<input type="hidden" name="s" value="Raumschiffe">
<input type="hidden" name="ship_id" id="ship_id" value="">
<div class="flex_gebaeude_info">



<?php


$raumschiffwerft_stufe = get_gebäude_aktuelle_stufe($spieler_id, 0, 7);

if($raumschiffwerft_stufe == 0) {
	
	echo "Baue erst eine Raumschiffwerft.";
	
} else {
	
	
	
	for($i = 1; $i <= 12; $i++) {
		
		$Ship = get_ship($i);
		
		//var_dump($Ship);
		
		$ship_in_ownership = 1; //<-------------- INSERT CODE
	
		if($Ship["Stufe_Werft"] <= $raumschiffwerft_stufe) {
			
			
			if($Ship["Max_Hold"] == $ship_in_ownership AND $Ship["Stufe_Werft"]) {
				
				
				?>
						<div><table id="default" class="ubersicht" width=100%>
							<th><h3 style="display: inline;"><?php echo $Ship["Name"]; ?></h3> <span class="code">[<?php echo $Ship["Kuerzel"]; ?>] MAX</span></th>
							<tr>
								<td><?php echo $Ship["Beschreibung"]; ?></td>
							</tr>
							<tr><td>
								<ul class="nav inline-items-attr">
									<li><font style="font-size: x-small;">Angriff: </font><?php echo number_format($Ship["Angriff"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Verteidigung: </font><?php echo number_format($Ship["Verteidigung"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Geschwindigkeit: </font><?php echo  number_format($Ship["Geschwindigkeit"], 0, '.', '.'); ?></li>
									<li><font style="font-size: x-small;">Kapazitaet: </font><?php echo number_format($Ship["Kapazitaet"], 0, '.', '.'); ?></li>
								</ul>
							</td></tr>
							
						</table></div>
				
				<?php
			} else {
			
			$kann_gebaut_werden = true;
			$farbeE = ""; if($ressource["Eisen"] < $Ship["Kosten_Eisen"]) { $farbeE = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeS = ""; if($ressource["Silizium"] < $Ship["Kosten_Silizium"]) { $farbeS = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeW = ""; if($ressource["Wasser"] < $Ship["Kosten_Wasser"]) { $farbeW = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeB = ""; if($ressource["Bot"] < $Ship["Bots"]) { $farbeB = "#FF0000"; $kann_gebaut_werden = false; }
			$farbeK = ""; if($ressource["Karma"] < $Ship["Kosten_Karma"]) { $farbeK = "#FF0000"; $kann_gebaut_werden = false; }
		
			?>
			<div>
			
			<table id="default" class="ubersicht" width=100%>
				<th><h3 style="display: inline;"><?php echo $Ship["Name"]; ?></h3> <span class="code">[<?php echo $Ship["Kuerzel"]; ?>]</span></th>
				<tr>
					<td><?php echo $Ship["Beschreibung"]; ?></td>
				</tr>
				<tr>
					<td>
						<ul class="ress">
							<li><img src="img/bot.png" class="img_ress"> <?php echo "<font color='$farbeB'>" . number_format($Ship["Bots"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/eisen.png" class="img_ress"> <?php echo "<font color='$farbeE'>" . number_format($Ship["Kosten_Eisen"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/silizium.png" class="img_ress"> <?php echo "<font color='$farbeS'>" . number_format($Ship["Kosten_Silizium"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/wasser.png" class="img_ress"> <?php echo "<font color='$farbeW'>" . number_format($Ship["Kosten_Wasser"], 0, '.', '.') . "</font>"; ?></li>
							<li><img src="img/karma.png" class="img_ress"> <?php echo "<font color='$farbeK'>" . number_format($Ship["Kosten_Karma"], 0, '.', '.') . "</font>"; ?></li>
					</ul>
					</td></tr>
				<tr><td>
				
				<ul class="nav inline-items-attr">					
					<li><font style="font-size: x-small;">Angriff: </font><?php echo number_format($Ship["Angriff"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Verteidigung: </font><?php echo number_format($Ship["Verteidigung"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Geschwindigkeit: </font><?php echo  number_format($Ship["Geschwindigkeit"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Kapazitaet: </font><?php echo number_format($Ship["Kapazitaet"], 0, '.', '.'); ?></li>
					<li><font style="font-size: x-small;">Reichweite: </font><?php echo number_format($Ship["Reichweite"], 0, '.', '.'); ?></li>
				</ul>
				</td></tr>
				<tr><td style="text-align: right;">
				
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