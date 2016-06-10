<?php 
$activity = get_activity_planet_spieler_schiffe($spieler_id, 0);
$schiffe = get_Schiffe_stationiert($spieler_id, 0);
$Bauschleife_naechstes_Schiff = get_activity_schiffe_einzel($spieler_id, 0);
$Bauschleife_naechste_deff = get_activity_deff_einzel($spieler_id, 0);

if(!isset($schiffe)) {
	$schiffe[0]["Name"] = "-";
	$schiffe[0]["Anzahl"] = "-";
}

	
$deff = get_Deff_stationiert($spieler_id, 0);

if(!isset($deff)) {
	$deff[0]["Name"] = "-";
	$deff[0]["Anzahl"] = "-";
}


$bunker = get_Ressbunker_Inhalt($spieler_id, 0);
$koordinaten = get_koordinaten_planet($spieler_id, 0);

$balken = get_flotte_in_der_luft($spieler_id, time(), false);

if($balken != "leer") {
	$flotten_timer = array();
	?>
	<table width="100%" id="default" border=0 cellspacing="0" cellpadding="0" class="übersicht " style="">
		<tr>
			<th class="tbtb tbtb_ohne_unten">Flugdauer</th>			
			<th class="tbtb tbtb_ohne_unten" >Besitzer</th>
			<th class="tbtb tbtb_ohne_unten">Startplanet</th>
			<th class="tbtb tbtb_ohne_unten">Zielplanet</th>
			<th class="tbtb tbtb_ohne_unten tbtbr">Mission</th>
		</tr>
	<?php
	$countown_balken = 0;
	foreach($balken as $key => $value) {
		
		switch($balken[$key]["Mission"]) {

					default:
					$flotten_timer[] = $balken[$key]["Ankunft"];
					?>
						<tr>
							<td class="tbc tbc_oben">
								<span id="balken<?php echo $key; ?>"><script type="text/javascript">countdown(<?php echo $balken[$key]["Ankunft"] - time(); ?>, "balken<?php echo $key; ?>");</script></span>
							</td>
							<td class="tbc tbc_oben"><?php echo $balken[$key]["Besitzer_Spieler_Name"]; ?></td>
							<td class="tbc tbc_oben">
								<?php echo "" . sprintf('%02d', $balken[$key]["x1"]) . ":" . sprintf('%02d', $balken[$key]["y1"]) . ":" . sprintf('%02d', $balken[$key]["z1"]) . ""; ?>
							</td>
							<td class="tbc tbc_oben">
								<?php echo "" . sprintf('%02d', $balken[$key]["x2"]) . ":" . sprintf('%02d', $balken[$key]["y2"]) . ":" . sprintf('%02d', $balken[$key]["z2"])  . ""; ?>
							</td>
							<td class="tbc tbc_oben tbcOhneRandRechts"><a href="index.php?s=Flotte-Info&id=<?php echo $balken[$key]["ID"]; ?>"><?php echo $balken[$key]["Mission"]; ?></a></td>
						</tr>
						<?php 
						break;
		}
		
		$countown_balken++;
		
	}
	?>
	</table>
	
	<script type="text/javascript">
<!--

var ta = new Array(<?php echo implode(", ", $flotten_timer); ?>,-1);
function countdownFlotten(){
	for (i=0;i<ta.length;i++){
		if(ta[i]>-1){
				var e = document.getElementById("balkenNeu"+i);
				var ts = Math.floor(Date.now() / 1000); 
				var tl = (ta[i] - ts);
				var tl_s = tl;
			if (tl>0){
			var t = parseInt(tl/(24*60*60));
			tl = tl-(t*(24*60*60));		
			var h = parseInt(tl/(60*60));
			tl = tl-(h*(60*60));
			var m = parseInt(tl/(60));
			tl = tl-(m*(60));
			var s = parseInt(tl);
			if (h<10) h="0"+h;
			if (m<10) m="0"+m;
			if (s<10) s="0"+s;
			if (t == 0) { var tstr = h+":"+m+":"+s; } else { 
				if( t == 1 ) {
					var tstr = t+" Tag "+h+":"+m+":"+s;
				} else {
					var tstr = t+" Tage "+h+":"+m+":"+s; 
				}	
			}	
		e.innerHTML = tstr + " xxx " + tl_s; }
		else{
		e.innerHTML = '00:00:00'; }
		}
}
window.setTimeout("countdownFlotten()", 500);
}
countdownFlotten();
//-->
</script>
	
	<?php 
}

?>

	<table width="100%" id="default" border=0 cellspacing="0" cellpadding="0" class="übersicht " style="display: none;">
			<tr>
				<th class="tbtb tbtb_ohne_unten">Flugdauer</th>			
				<th class="tbtb tbtb_ohne_unten" >Besitzer</th>
				<th class="tbtb tbtb_ohne_unten">Startplanet</th>
				<th class="tbtb tbtb_ohne_unten">Zielplanet</th>
				<th class="tbtb tbtb_ohne_unten tbtbr">Mission</th>
			</tr>
			<tr>
				<td class="tbc tbc_oben">01:00:00</td>
				<td class="tbc tbc_oben">monk-of-doom</td>
				<td class="tbc tbc_oben">25:25:4</td>
				<td class="tbc tbc_oben">01:10:6</td>
				<td class="tbc tbc_oben tbcOhneRandRechts">Sicherung</td>
			</tr>
			<tr>
				<td colspan="5" class="fleetdetail">					
					<ul class="ress">Ladung
					<li><img src="img/eisen.png" class="img_ress"> <?php echo "<font color=''>" . number_format(2500, 0, '.', '.') . "</font>"; ?></li>
					<li><img src="img/silizium.png" class="img_ress"> <?php echo "<font color=''>" . number_format(1005, 0, '.', '.') . "</font>"; ?></li>
					<li><img src="img/wasser.png" class="img_ress"> <?php echo "<font color=''>" . number_format(2, 0, '.', '.') . "</font>"; ?></li>					
					</ul>
				</td>
			</tr>
		<tr>
		
		</tr>			
			<tr>
				<td class="tbcr">04:32:00</td>
				<td class="tbcr">Rolf</td>
				<td class="tbcr">34:10</td>
				<td class="tbcr"><?php echo $koordinaten["Anzeige"]; ?></td>
				<td class="tbcr tbcr_ende">Angriff</td>
			</tr>
			<tr>
				<td class="tbcr">04:32:20</td>
				<td class="tbcr">Rolf</td>
				<td class="tbcr">34:10</td>
				<td class="tbcr"><?php echo $koordinaten["Anzeige"]; ?></td>
				<td class="tbcr tbcr_ende">Angriff</td>
			</tr>
			
						<tr>
				<td class="tbc tbc_oben">06:00:00</td>
				<td class="tbc tbc_oben">monk-of-doom</td>
				<td class="tbc tbc_oben">25:25:4</td>
				<td class="tbc tbc_oben">01:10:6</td>
				<td class="tbc tbc_oben tbcOhneRandRechts">Rückkehr</td>
			</tr>
			<tr>
				<td colspan="5" class="fleetdetail">					
					<ul class="ress">Ladung
					<li><img src="img/eisen.png" class="img_ress"> <?php echo "<font color=''>" . number_format(2500000, 0, '.', '.') . "</font>"; ?></li>
					<li><img src="img/silizium.png" class="img_ress"> <?php echo "<font color=''>" . number_format(1005000, 0, '.', '.') . "</font>"; ?></li>
					<li><img src="img/wasser.png" class="img_ress"> <?php echo "<font color=''>" . number_format(20000, 0, '.', '.') . "</font>"; ?></li>					
					</ul>
				</td>
			</tr>
			
						<tr>
				<td class="tbc tbc_oben">06:00:00</td>
				<td class="tbc tbc_oben">monk-of-doom</td>
				<td class="tbc tbc_oben">25:25:4</td>
				<td class="tbc tbc_oben">01:10:6</td>
				<td class="tbc tbc_oben tbcOhneRandRechts">Rückkehr</td>
			</tr>
			<tr>
				<td colspan="5" class="fleetdetail">					
					<ul class="ress">Ladung
					<li><img src="img/eisen.png" class="img_ress"> <?php echo "<font color=''>" . number_format(2500000, 0, '.', '.') . "</font>"; ?></li>
					<li><img src="img/silizium.png" class="img_ress"> <?php echo "<font color=''>" . number_format(1005000, 0, '.', '.') . "</font>"; ?></li>
					<li><img src="img/wasser.png" class="img_ress"> <?php echo "<font color=''>" . number_format(20000, 0, '.', '.') . "</font>"; ?></li>					
					</ul>
				</td>
			</tr>
			</table>
		
		

		<table id="default" width="100%" border=0 cellspacing="0" cellpadding="0" class="übersicht" >
			<tr>
				<th width="150" class="tbtb tbtbk"><center><?php echo $koordinaten["Anzeige"]; ?></center></th>			
				<th colspan=2 width="458" class="tbtb tbtb_ohne_rechts" align="left">Aktivität</th>				
			</tr>
			<tr>
				<td rowspan=8 class="tbchellk">
				<canvas id="planet" width="150" height="150"></canvas>
    <script>
        var canvas = document.getElementById('planet');
        var context = canvas.getContext('2d');
        var centerX = 150 / 2;
        var centerY = 150 / 2;
        var radius = 70;

    	//var startwinkel = 2.0;
    	//var endwinkel = 1.6 * Math.PI;
    	var startwinkel = -1.3;
    	var endwinkel = 1.9;
    	
        context.beginPath();
        context.arc(centerX, centerY, radius, startwinkel, endwinkel , false);
        context.fillStyle = '#0e3800';
        context.fill();


        context.beginPath();
        context.arc(centerX, centerY, radius, endwinkel , startwinkel, false);
        context.fillStyle = '#5c8646';
        context.fill();
        
    </script>
				</td>
				<td  width=100px class="tbc">Gebäude</td><td width=600 class="tbchell"><?php 
			
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
			
			?></td>
	
			</tr>
			
			<tr>
				<td class="tbc">Raumschiffe</td><td class="tbchell">
				<?php
				if ($Bauschleife_naechstes_Schiff["Bauzeit"] <> "-") {
						
									echo $Bauschleife_naechstes_Schiff["Name"]; ?>
														[ <span id="einzel_schiff"><script type="text/javascript"><!--
														countdown(<?php echo $Bauschleife_naechstes_Schiff["Bauzeit"]; ?>, "einzel_schiff");
														</script></span> ]
							<?php 
									} else {
										
										echo $Bauschleife_naechstes_Schiff["Bauzeit"];
										
									}  
				?></td>
			</tr>
			<tr>
				<td class="tbc">Verteidigung</td><td class="tbchell">
				<?php
				if ($Bauschleife_naechste_deff["Bauzeit"] <> "-") {
						
									echo $Bauschleife_naechste_deff["Name"]; ?>
														[ <span id="einzel_deff"><script type="text/javascript"><!--
														countdown(<?php echo $Bauschleife_naechste_deff["Bauzeit"]; ?>, "einzel_deff");
														</script></span> ]
							<?php 
									} else {
										
										echo $Bauschleife_naechste_deff["Bauzeit"];
										
									}  
				?>
				</td>
			</tr>
			<tr>
				<td class="tbc">Forschung</td><td class="tbchell"><?php
				if ($activity["Forschung"]["Zeit-Bis"] <> "-") {
					
					echo $activity["Forschung"]["Name"]; ?>
										[ <span id="forschung"><script type="text/javascript"><!--
										countdown(<?php echo $activity["Forschung"]["Zeit-Bis"]; ?>, "forschung");
										</script></span> ]
			<?php 
					} else {
						
						echo $activity["Forschung"]["Zeit-Bis"];
						
					}
			?>		</td>
			</tr>
			<tr>
				<td class="tbc tbc_oben">Rohstoffbunker</td><td class="tbchell"><?php  echo $bunker["Belegt_Prozent"] . "<font style='font-size: x-small;'>%</font>"; ?></td>
			</tr>
			<tr>
				<td class="tbc">Handelssposten</td><td class="tbchell"><?php  echo get_Handelsposten_Inhalt($spieler_id, 0); ?></td>
			</tr>
			<tr>
				<td class="tbc">Verteidigung</td><td class="tbchell">[aktiviert]</td>
			</tr>
			
			
		
			
		</table>

<!-- Stationierte Schiffe & Deff -->
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td style="padding-right: 5px;" valign="top">
					<table id="default" cellspacing="0" cellpadding="0" class="übersicht">
						<tr>
							<td colspan=2 class="tbtb tbtb_ohne_rechts">Raumschiffe Stationiert</td>
							
						</tr>
						
							<?php 
							foreach($schiffe as $key => $value) {
								$anzahl = $schiffe[$key]["Anzahl"];
								$name = $schiffe[$key]["Name"];
							?>
							<tr>
								<td class="tbc"><?php echo $name; ?></td>
								<td class="tbchell"><?php echo str_replace(' ', '&nbsp;&nbsp;', str_pad($anzahl, 5 ," ", STR_PAD_LEFT)); ?></td>
							</tr>
							<?php } ?>
					</table>
					
				</td>
				<td  valign="top">
					<table id="default" cellspacing="0" cellpadding="0" class="übersicht">
						<tr>
							<td colspan=2 class="tbtb tbtb_ohne_rechts">Verteidigung Stationiert</td>
							
						</tr>
							<?php 
							foreach($deff as $key => $value) {
								$anzahl = $deff[$key]["Anzahl"];
								$name = $deff[$key]["Name"];
							?>
							<tr>
								<td class="tbc"><?php echo $name; ?></td>
								<td class="tbchell"><?php echo str_replace(' ', '&nbsp;&nbsp;', str_pad($anzahl, 5 ," ", STR_PAD_LEFT)); ?></td>
							</tr>
							<?php } ?>
					</table>
					
				</td>
			</tr>
		</table>
		
<!-- ENDE: Stationierte Schiffe & Deff -->		

	
<?php  if (isset($flotte)) { ?>
	
	
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
	
<?php } ?>

<?php  if (isset($deff_schleife)) { ?>
	

		<table id="default" class="ubersicht">
						<caption>Deff Bauschleife</caption>
<?php


	$i = 0;
	foreach($deff_schleife as $key => $value) {
		$ID = $deff_schleife[$key]["ID"];
		$anzahl = $deff_schleife[$key]["Anzahl"];
		$name = $deff_schleife[$key]["Name"];
		$zeit_bis = $deff_schleife[$key]["Zeit-Bis"];
		
		?> 
		<tr><th><?php echo "$name"; ?></th><td><?php echo str_replace(' ', '&nbsp;&nbsp;', str_pad($anzahl, 2 ," ", STR_PAD_LEFT)) . "x "; ?>
										<span id="deff<?php echo $i; ?>"><script type="text/javascript"><!--
										countdown(<?php echo $zeit_bis; ?>, "deff<?php echo $i; ?>");
										</script></span>
		</td><td><form style="display: inline;" action="index.php" method="post" autocomplete="off"><button type="submit" name="action-deff-abbrechen" id="action-deff-abbrechen_<?php echo $i; ?>" value="<?php echo $ID; ?>">x</button></form></td></tr>
		<?php 
		$i++;
	}
	
	

		
	
			//<tr><th>Verteidigung</th><td>dd</td></tr>
?>		
		</table>
	
<?php } ?>


				
			
			

