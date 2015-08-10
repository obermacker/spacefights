<form action="index.php" method="post" autocomplete="off">
<input type="hidden" name="s" value="Forschung">

<div class="flex_gebaeude_info">



<?php 

for($i = 1; $i <= 10; $i++) {

	$baut_gerade = check_bauschleife_activ($spieler_ID, 0);	
	
	$Tech = get_tech_nächste_stufe($spieler_ID, 0, $i, 1);
	
	if ($Tech["Forschung"] == "OK") {

		$kann_geforscht_werden = true;
		$farbeE = ""; if($ressource["Eisen"] < $Tech["Kosten_Eisen"]) { $farbeE = "#FF0000"; $kann_geforscht_werden = false; }
		$farbeS = ""; if($ressource["Silizium"] < $Tech["Kosten_Silizium"]) { $farbeS = "#FF0000"; $kann_geforscht_werden = false; }
		$farbeW = ""; if($ressource["Wasser"] < $Tech["Kosten_Wasser"]) { $farbeW = "#FF0000"; $kann_geforscht_werden = false; }
		
		?>
		<div>
		
		<table id="default" class="ubersicht" width=100%>
			<th><h3 style="display: inline;"><?php echo $Tech["Name"]; ?></h3> <span class="code">[<?php echo ($Tech["Stufe"] - 1) . " >> " . $Tech["Stufe"]; ?>]</span></th>
			<tr>
				<td><?php echo $Tech["Beschreibung"]; ?></td>
			</tr>
			<tr>
				<td>
					<ul class="ress">
						<li><img src="img/eisen.png" class="img_ress"> <?php echo "<font color='$farbeE'>" . number_format($Tech["Kosten_Eisen"], 0, '.', '.') . "</font>"; ?></li>
						<li><img src="img/silizium.png" class="img_ress"> <?php echo "<font color='$farbeS'>" . number_format($Tech["Kosten_Silizium"], 0, '.', '.') . "</font>"; ?></li>
						<li><img src="img/wasser.png" class="img_ress"> <?php echo "<font color='$farbeW'>" . number_format($Tech["Kosten_Wasser"], 0, '.', '.') . "</font>"; ?></li>
				</ul>
				</td></tr><tr><td>
				<ul class="ress"><li class="img_ress">
				<?php 
				?>		<span style="visibility: hidden;">f</span>	
				</li></ul>
				</td>
			</tr>
			<tr><td>
			<?php echo $Tech["Wirkung"]; ?>
			</td></tr>
			<tr><td align="right">
			
			<?php 				
			if($kann_geforscht_werden == true && $baut_gerade["ID"] == 0) {
	
				
					echo $Tech["Bauzeit"]; ?> <button type="submit" name="action-forschung-bauen" value="<?php echo $i; ?>">Bauen</button><?php				
				 
				
			} else {
				
				if ($baut_gerade["ID"] == $i) {
						
						
					?><span id="forschung<?php echo $i; ?>"><script type="text/javascript"><!--
							countdown(<?php echo $baut_gerade["Bis"]; ?>, "forschung<?php echo $i; ?>");
							</script></span>
							<button type="submit" name="action-forschung-abbrechen" value="<?php echo $i; ?>">Abbrechen</button><?php
						} else {
							
							
				
				echo $Tech["Bauzeit"]; ?> <button disabled style="visibility: hidden;">Bauen</button><?php
						}
			}
			
					
			
			
			
			?>
			
				
							
			</td></tr>
			
			
		</table>
		
		</div>
		
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
	
	
	
	</div>
</form>