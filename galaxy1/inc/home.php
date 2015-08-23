<?php 
$activity = get_activity_planet_spieler_schiffe($spieler_id, 0);
$flotte = get_activity_schiffe_Liste($spieler_id, 0);
$schiffe = get_Schiffe_stationiert($spieler_id, 0);
?>
<div class="flex_uebersicht">
	<div><?php echo get_koordinaten_planet($spieler_id, 0); ?><br>
		<img src="img/planet.png" style="border-style: #555555 solid 1px;">
	</div>
	<div>
		<table id="default" class="ubersicht">
			<caption>Aktivität</caption>
			<tr><th>Gebäude</th><td><?php 
			
			if ($activity["Gebäude"]["Zeit-Bis"] <> "-") {
				
			
					echo $activity["Gebäude"]["Name"]; 
										?>
										[ <span id="Gebäude"><script type="text/javascript"><!--
										countdown(<?php echo $activity["Gebäude"]["Zeit-Bis"]; ?>, "Gebäude");
										</script></span> ]
								<?php 
			
			} else {
				
				
				echo $activity["Gebäude"]["Zeit-Bis"];
				
			}
			
			?></td></tr>
			<tr><th>Raumschiffe</th><td>dfdf</td></tr>
			<tr><th>Verteidigung</th><td>n/a</td></tr>
			<tr><th>Forschung</th><td>
			<?php
				if ($activity["Forschung"]["Zeit-Bis"] <> "-") {
					
					echo $activity["Forschung"]["Name"]; ?>
										[ <span id="forschung"><script type="text/javascript"><!--
										countdown(<?php echo $activity["Forschung"]["Zeit-Bis"]; ?>, "forschung");
										</script></span> ]
			<?php 
					} else {
						
						echo $activity["Forschung"]["Zeit-Bis"];
						
					}
			?>			
			</td></tr>
			<tr><th>Rohstoffbunker</th><td><?php  echo get_Ressbunker_Inhalt($spieler_id, 0); ?></td></tr>
			<tr><th>Handelssposten</th><td><?php  echo get_Handelsposten_Inhalt($spieler_id, 0); ?></td></tr>
			<tr><th>Verteidigung</th><td>[aktiviert]</td></tr>
		</table>
	</div>
<?php if (isset($schiffe)) { ?>	
	<div>
		<table id="default" class="ubersicht">
			<caption>Schiffe</caption>
			
	<?php 
		$i = 0;
	
		foreach($schiffe as $key => $value) {
			$anzahl = $schiffe[$key]["Anzahl"];
			$name = $schiffe[$key]["Name"];

?>
			
			<tr><th><?php echo $name; ?></th><td><?php echo str_replace(' ', '&nbsp;&nbsp;', str_pad($anzahl, 4 ," ", STR_PAD_LEFT)); ?></td></tr>

<?php } ?>
		</table>
	</div>
<?php } ?>
	<div>
<?php  if (isset($flotte)) { ?>
	
	<div>
		<table id="default" class="ubersicht">
						<caption>Bauschleife</caption>
<?php


	$i = 0;
	foreach($flotte as $key => $value) {
		$ID = $flotte[$key]["ID"];
		$anzahl = $flotte[$key]["Anzahl"];
		$name = $flotte[$key]["Name"];
		$zeit_bis = $flotte[$key]["Zeit-Bis"];
		
		?> 
		<tr><th><?php echo "$name"; ?></th><td><?php echo str_replace(' ', '&nbsp;&nbsp;', str_pad($anzahl, 2 ," ", STR_PAD_LEFT)) . "x "; ?>
										<span id="flotte<?php echo $i; ?>"><script type="text/javascript"><!--
										countdown(<?php echo $zeit_bis; ?>, "flotte<?php echo $i; ?>");
										</script></span>
		</td><td><form style="display: inline;" action="index.php" method="post" autocomplete="off"><button type="submit" name="action-schiffe-abbrechen" id="action-schiffe-abbrechen_<?php echo $i; ?>" value="<?php echo $ID; ?>">x</button></form></td></tr>
		<?php 
		$i++;
	}
	
	

		
	
			//<tr><th>Verteidigung</th><td>dd</td></tr>
?>		
		</table>
	</div>
<?php } ?>
</div>
</div>
