<?php 

if(isset($_GET["x"]) AND isset($_GET["y"])) {
	$px = abs(intval($_GET["x"], 10));
	$py = abs(intval($_GET["y"], 10));	
	
	if($px > 50) { $px = 50; }
	if($py > 50) { $py = 50; }

	if($px < 1) { $px = 1; }
	if($py < 1) { $py = 1; }
	
	if(isset($_GET["a"]) == "erkunden") {
		
		$flotte[0]["Schiff_ID"] = 7;
		$flotte[0]["Anzahl"] = 1;
		$mission = array("erkunden");
		$erkunden_start = flotte_senden($spieler_id, $planet_id, $flotte, $px, $py, 12, $mission, 100, 0, 0);
	}
	
} else {

	$koordinaten = get_koordinaten_planet($spieler_id, $planet_id);
	
	$px = $koordinaten["X"];
	$py = $koordinaten["Y"];
	
}


$x_start = $px - 6;
$y_start = $py - 6;
	
if( $x_start < 1) { $x_start = 1; }
$x_ende = $x_start + 12;
if($x_ende > 50) { $x_ende = 50; $x_start = $x_ende - 12; }

	
if( $y_start < 1) {$y_start = 1; }
$y_ende = $y_start + 12;
if($y_ende > 50) { $y_ende = 50; $y_start = $y_ende - 12; }
	
$erkundeteSysteme = get_explored_systems($spieler_id, $x_start, $y_start, $x_ende, $y_ende);

$wurde_erkundet = false; foreach($erkundeteSysteme as $key => $value) {if($value->x == $px && $value->y == $py) {$wurde_erkundet = true; break;}}

$liste_planeten  = get_liste_planeten_im_system($px, $py, $spieler_id);

?>
<table id="default" border=0 cellspacing="0" cellpadding="0" class="übersicht" width=100%>
<tr>
<form action="index.php" name="myform" method="get" autocomplete="off">
<input type="hidden" name="s" value="Sonnensystem">
<td class="tbchell">Sonnensystem</td>
<td class="tbchell tbchell_mitte"> <label for="x">X: < <input name="x" type="text" size=2 value="<?php echo $px; ?>"> ></label></td>
<td class="tbchell tbchell_mitte"><label for="x">Y: < <input name="y" type="text" size=2 value="<?php echo $py; ?>"> ></label></td>
<td class="tbchell tbchell_rechts"><button type="submit">Anzeigen</button>
</form>
</tr>

</table>

<table id="default" border=0 cellspacing="0" cellpadding="0" class="übersicht" width=100%>
<tr>
	<td class="tbtb tbtb_linksbundig">Nr.</td>
	<td class="tbtb">Planet</td>
	<td class="tbtb">Spieler</td>
	<td class="tbtb">Allianz</td>
	<td class="tbtb tbtb_ohne_rechts">Funktionen</td>
</tr>

<?php 
if($wurde_erkundet == false) {
	if(flotte_erkunden($px, $py, $spieler_id) == true) {

		?>
					<tr><td class="tbchell">1</td><td class="tbchell" rowspan=12 colspan=3 style="text-align: center;">Sonde ist auf dem Weg
					
					</td><td class="tbchell"></td></tr>
					<?php
					
					for($i = 2; $i <= 12; $i++) {
						?>
						<tr><td class="tbchell"><?php echo $i; ?>
						
						</td>
						<td class="tbchell"></td>
						</tr>
						<?php 
					}
		
	} else {

		?>
			<tr><td class="tbchell">1</td><td class="tbchell" rowspan=12 colspan=3 style="text-align: center;"><a href="index.php?s=Sonnensystem&x=<?php echo $px; ?>&y=<?php echo $py; ?>&a=erkunden">System noch nicht erkundet. Sonde starten</a>
			
			</td><td class="tbchell"></td></tr>
			<?php
			
			for($i = 2; $i <= 12; $i++) {
				?>
				<tr><td class="tbchell"><?php echo $i; ?>
				
				</td>
				<td class="tbchell"></td>
				</tr>
				<?php 
			}
	}

	
} else {
	

	for($i = 1; $i <= 12; $i++) {
	
	?>
	<tr>
	<td class="tbchell"><a href="index.php?s=Flotte&x=<?php echo $px; ?>&y=<?php echo $py; ?>&z=<?php echo $i; ?>"><?php echo $i . "." ?></a></td>
	<td class="tbchell"><?php echo $liste_planeten[$i]["Spieler"]; ?></td>
	<td class="tbchell"><?php echo $liste_planeten[$i]["Planet"]; ?></td>
	<td class="tbchell"></td>
	<td class="tbchell"></td>
	</tr>
	<?php 
	
	} 
}
?>
</table>

<table cellspacing="0" cellpadding="0" width=100%>
	<tr>
		<td width=100%>
		
		<!-- Sonnenssystem -->
		
		<table id="default" border=0 cellspacing="0" cellpadding="0" class="übersicht" width=100%>
			
			<?php 
			
			
			
			$map = array();
			
			for($y = $y_start - 1; $y <= $y_ende; $y++) { $map[$x_start - 1][$y] = "<td class='tbtb tbtb_mitte'>" . sprintf('%02d', $y) . ".</td>"; }
			for($x = $x_start - 1; $x <= $x_ende; $x++) { $map[$x][$y_start - 1] = "<td  class='tbtb tbtb_mitte'>" . sprintf('%02d', $x) . ".</td>"; }
			
			$map[$x_ende][$y_start - 1] = "<td  class='tbtb tbtb_mitte tbtb_ohne_rechts'>" . sprintf('%02d', $x_ende) . ".</td>";
			$map[$x_start - 1][$y_ende] = "<td  class='tbtb tbtb_mitte tbtb_ohne_unten'>" . sprintf('%02d', $y_ende) . ".</td>";				
			$map[$x_start - 1][$y_start - 1] = "<td class='tbtb tbtb_mitte tbtb_linksbundig'><sub>y</sub>\<sup>x</sup></td>";
			
			
			
				
			for($y = $y_start; $y <= $y_ende; $y++) {				
				for($x = $x_start; $x <= $x_ende; $x++) {
				 	if($y == $y_ende) {
				 		if($x == $x_ende) {
				 			$map[$x][$y] = "<td class='tbchell_minimap tbchell_minimap_ohne_unten tbchell_minimap_ohne_rechts' title='" . ($x) . ":" . ($y) . "'><a href=''>&nbsp;&nbsp;&nbsp;</a></td>";
				 		} else {
				 			$map[$x][$y] = "<td class='tbchell_minimap tbchell_minimap_ohne_unten' title='" . ($x) . ":" . ($y) . "'><a href='index.php?s=Sonnensystem&x=$x&y=$y'>&nbsp;&nbsp;&nbsp;</a></td>";
				 		}
				 			
				 	} else {
				 		
				 		if($x == $x_ende) {
				 			$map[$x][$y] = "<td class='tbchell_minimap tbchell_minimap_ohne_rechts' title='" . ($x) . ":" . ($y) . "'><a href='index.php?s=Sonnensystem&x=$x&y=$y'>&nbsp;&nbsp;&nbsp;</a></td>";
				 		} else {
				 			$map[$x][$y] = "<td class='tbchell_minimap' title='" . ($x) . ":" . ($y) . "'><a href='index.php?s=Sonnensystem&x=$x&y=$y'>&nbsp;&nbsp;&nbsp;</a></td>";
				 		}
				 			
					
					}	

					if($x == $px AND $y == $py) { 
						$map[$x][$y] = "<td class='tbtb_minimap_selected' title='" . ($x) . ":" . ($y) . "'><a href='index.php?s=Sonnensystem&x=$x&y=$y'>&nbsp;&nbsp;&nbsp;</a></td>";
					}
					
					$map[$x][$y] = str_replace("td", "td onClick=\"location.href='index.php?s=Sonnensystem&x=$x&y=$y'\"", $map[$x][$y]);
					
				}				
			}
			
			foreach ($erkundeteSysteme as $key => $value){
				switch (true) {	
					case $value->ownSystem == 'true' : 
						$map[$value->x][$value->y] = str_replace("&nbsp;&nbsp;&nbsp;", "<img src='img/star_orange.png'>", $map[$value->x][$value->y]); break;
					case $value->foreignSystem  == 'true' : 
						$map[$value->x][$value->y] = str_replace("&nbsp;&nbsp;&nbsp;", "<img src='img/star_blau.png'>", $map[$value->x][$value->y]); break;
					case $value->freeSystem == 'true'  : 
						$map[$value->x][$value->y] = str_replace("&nbsp;&nbsp;&nbsp;", "<img src='img/star_weiss.png'>", $map[$value->x][$value->y]); break;
				}
			}
	
			for($y = $y_start - 1; $y <= $y_ende; $y++) {
				echo "<tr>";
				for($x = $x_start - 1; $x <= $x_ende; $x++) {
					echo $map[$x][$y]; 
				}
				echo "</tr>";				
			}
			?>
		
		</table>
		
		
		</td>
		<td width=1><img src="img/5px.png"></td>
		<td valign=top>
		<!-- Minimap -->
		<table id="default" border=0 cellspacing="0" cellpadding="0" class="übersicht">
			<tr>
				<td class="tbtb tbtb_minimap">Minikarte</td>
			</tr>
			<tr>
				<td class="tbchell_minimap tbchell_minimap_ohne_unten tbchell_minimap_ohne_rechts"><img height="300" alt="" src="minimap.php<?php echo "?x1=$x_start&y1=$y_start&x2=$x_ende&y2=$y_ende"?>" width="300" usemap="#minimap">
				<map name="minimap">
<?php 

$_step = 10; $_max = 300; $_maxPlanets = 50;
for($shape_y=0; $shape_y < $_max; $shape_y+=$_step) {
	for($shape_x= 0; $shape_x < $_max; $shape_x+=$_step) {
		
		//echo "<area shape='rect' coords='$shape_x, $shape_y, " . $shape_x + 12.5 . "," . $shape_y + 12.5 . "' href='index.php?s=Sonnensystem&x=5&y=5'>";
		
		echo "<area shape='rect' coords='" . $shape_x  . "," . $shape_y  . "," . ($shape_x + $_step) . "," . ($shape_y + $_step) . 
			"' href='index.php?s=Sonnensystem&x=" . intval(($shape_x + $_step ) / ($_max / $_maxPlanets)) . "&y=" . intval(($shape_y + $_step) / ($_max / $_maxPlanets)) . "'>\r";
	}
}
?>


</map>
				</td>
			</tr>
		</table>
				
		</td>
	</tr>
</table>

 