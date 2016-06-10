<?php 
//Flotte starten

if(isset($_POST["action-flotte-starten"])) {
	
	$out = str_replace('.', '', $_POST);
	$out = str_replace(',', '', $out);
	$out = str_replace('-', '', $out);
	
	$flotte_kann_abheben = true;
	
	if(!isset($out["x"])) { $flotte_kann_abheben = false; }
	if(!isset($out["y"])) { $flotte_kann_abheben = false; }
	if(!isset($out["z"])) { $flotte_kann_abheben = false; }

	if(!isset($out["mission"])) { $flotte_kann_abheben = false; }
	
	if(!isset($out["schiff_anzahl"])) { $flotte_kann_abheben = false; }
	if(!isset($out["mitnehmen"])) { $flotte_kann_abheben = false; }
	if(!isset($out["abholen"])) { $flotte_kann_abheben = false; }

	if($flotte_kann_abheben == true) {

		if(!is_array($out["schiff_anzahl"])) { $flotte_kann_abheben = false; }
		if(!is_array($out["mitnehmen"])) { $flotte_kann_abheben = false; }
		if(!is_array($out["abholen"])) { $flotte_kann_abheben = false; }
		
		if($flotte_kann_abheben == true) {
						
			for($i = 0; $i<2; $i++) {
				if($i == 0) { $check = $out["x"]; $max = 50;  $min = 1;  } 
				if($i == 1) { $check = $out["y"]; $max = 50;  $min = 1;  }
				if($i == 2) { $check = $out["z"]; $max = 12;  $min = 1;  }
				
				if($check == '') { $flotte_kann_abheben = false; }
				if(intval($check) < $min ) { $flotte_kann_abheben = false; }
				if(intval($check) > $max ) { $flotte_kann_abheben = false; }				
			}

			if($flotte_kann_abheben == true) {
				$flotte_schiffe = array();
				$i = 0;
				foreach ($out["schiff_anzahl"] as $key => $value) {
					if($value > 0) {
						$flotte_schiffe[$i]["Schiff_ID"] = intval($key);
						$flotte_schiffe[$i]["Anzahl"] = intval($value);
						$i++;
					}					
				}
				$mission_start = flotte_senden($spieler_id, 0, $flotte_schiffe, $out["x"], $out["y"], $out["z"], $out["mission"], $out["flugzeit"], $out["mitnehmen"], $out["abholen"]);
				echo $mission_start;		
			}
		}		
	}
	//var_dump($flotte_kann_abheben);
	//var_dump($out);	
}

//ENDE: Flotte starten

$schiffe = get_Schiffe_stationiert($spieler_id, 0);

if(is_null($schiffe)) { echo "keine Schiffe"; exit(); } 

$koordinaten = get_koordinaten_planet($spieler_id, 0);
$ressource = get_ressource($spieler_id, 0);


if(isset($_GET["x"]) AND isset($_GET["y"]) AND isset($_GET["z"])) {
	$px = intval($_GET["x"]);
	$py = intval($_GET["y"]);
	$pz = intval($_GET["z"]);
} else {
	$px = "";
	$py = "";
	$pz = "";
}

?>
<form action="index.php?s=Flotte" name="myform" method="post" autocomplete="off">

<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
	<tr>
		<td rowspan=2 class="tbc" style="width: 12em;">Koordinaten</td>
		<td class="tbchell">
			<lable for="x">X: <input id="x" name="x" size="2" value="<?php echo $px; ?>" type="text" onchange="document.getElementById('Distanz').value = Distanzen(<?php echo $koordinaten["X"]; ?>, <?php echo $koordinaten["Y"]; ?>, <?php echo $koordinaten["Z"]; ?>, document.getElementById('x').value, document.getElementById('y').value, document.getElementById('z').value); func_geschwindigkeit();" onkeypress="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"></lable>
			<lable for="y"> Y: <input id="y" name="y" size="2" value="<?php echo $py; ?>" type="text" onchange="document.getElementById('Distanz').value = Distanzen(<?php echo $koordinaten["X"]; ?>, <?php echo $koordinaten["Y"]; ?>, <?php echo $koordinaten["Z"]; ?>, document.getElementById('x').value, document.getElementById('y').value, document.getElementById('z').value); func_geschwindigkeit();" onkeypress="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"></lable>
			<lable for="z"> Z: <input id="z" name="z" size="2" value="<?php echo $pz; ?>" type="text" onchange="document.getElementById('Distanz').value = Distanzen(<?php echo $koordinaten["X"]; ?>, <?php echo $koordinaten["Y"]; ?>, <?php echo $koordinaten["Z"]; ?>, document.getElementById('x').value, document.getElementById('y').value, document.getElementById('z').value); func_geschwindigkeit();" onkeypress="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"></lable>			
		</td>		
	</tr>
	<tr>
		<td class="tbchell">
			<?php 
			$ausgabe_planeten_flotte = get_list_of_all_planets_new($spieler_id, 0, false); 			
			?>
		
			<select size="1" id="Planiwahl" style="width: 15em;" onchange="Koordinaten_vorauswahl(); func_geschwindigkeit();">
			<option value="" selected="selected">- - -</option>

			<?php 
			foreach($ausgabe_planeten_flotte as $key => $value) {
				echo "<option value='" . $ausgabe_planeten_flotte[$key]["X"] . ":" . $ausgabe_planeten_flotte[$key]["Y"] . ":" . $ausgabe_planeten_flotte[$key]["Z"] . "'>" . $ausgabe_planeten_flotte[$key]["Name"] . " (" . $ausgabe_planeten_flotte[$key]["X"] . ":" . $ausgabe_planeten_flotte[$key]["Y"] . ":" . $ausgabe_planeten_flotte[$key]["Z"] . ")" . "</option>";
			}
			?>			
			
			
			
			</select>
		</td>	
	</tr>
	<tr>
		<td class="tbc">Mission</td>
		<td class="tbchell">
			<select size=1 name="mission" id="mission"  style="width: 15em;" onchange="fuenfer10er(); func_geschwindigkeit();"  onkeypress="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();">
			<option value="1">Entdeckung</option>
			<option value="2">Transport</option>
			<option value="3" selected="selected">Sicherungsflug</option>
			<option value="4">Spionage</option>
			<option value="5">Angriff</option>
			<option value="6">Kolonisierung</option>
			</select>
		</td>		
	</tr>
	</table>
	
	<table id="default" cellspacing="0" border=0 cellpadding="0" class="übersicht" width=100%>
		<?php 
		$i = 0;		
		foreach($schiffe as $key => $value) {
			$anzahl = $schiffe[$key]["Anzahl"];
			$name = $schiffe[$key]["Name"];
			$id = $schiffe[$key]["ID"];
		?>
		<tr>	
			<td class="tbc" style="width: 12em;"><?php echo $name; ?></td>
			<td class="tbchell"><input id="schiff_anzahl[<?php echo $i; ?>]" name="schiff_anzahl[<?php echo $id; ?>]" size="2" value="" type="text" onchange="func_geschwindigkeit();" onkeypress="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();">
			<input type="button" class="btn_main btn_main_klein" value="+" onclick="document.getElementById('schiff_anzahl[<?php echo $i; ?>]').value = '<?php echo $anzahl; ?>'; func_geschwindigkeit();" >
			<input type="button" class="btn_main btn_main_klein" value="-" onclick="document.getElementById('schiff_anzahl[<?php echo $i; ?>]').value = ''; func_geschwindigkeit();">
			
			</td>			
		</tr>
		<?php $i++; } ?>
		<tr>
			<td class="tbc"></td>
			<td class="tbchell">
				<input size="2" style="visibility: hidden;">
				<input type="button" class="btn_main btn_main_klein" value="+" onclick="alleaufmax();" >
				<input type="button" class="btn_main btn_main_klein" value="-" onclick="alleaufnull();">
			</td>
		</tr>

		</table>
	

		<table id="default" cellspacing="0" border=0 cellpadding="0" class="übersicht" width=100%>
		<tr>
			

				<td class="tbc" style="width: 12em;" rowspan=4>Flugzeit:</td>
				<td class="tbchell"><lable for="flugzeit"><select size=1 id="flugzeit" name="flugzeit"  style="width: 15em;">
					
					<?php 
					//$flugzeit = 14400;
					//for($z = 100; $z >= 10; $z+=-5) { ?>
					
					<!--  <option value="1">--><?php 
					//$antrieb = 10;
					//$geschwindigkeit = (1500 * (1+ $antrieb / 10) * $z / 100);
					//$strecke = 45005892;
					
					//$flugzeit = $strecke / $geschwindigkeit;  
					
					//echo sprintf('% 2d', $z) . "% " . get_timestamp_in_was_sinnvolles(floor($flugzeit)) ; ?><!-- </option>  -->
					
					<?php //} ?>
					
					</select> <input type="checkbox" id="10er5er" name="10er5er" value="10er" onchange="func_geschwindigkeit();"><font style="font-size: xx-small;">5er Schritte</font></lable>
				</td>				
			
			
			
		</tr>
	</table>
	
	
	<table id="default" cellspacing="0" border=0 cellpadding="0" class="übersicht" width=100%>
		<tr>
			<td class="tbc" style="width: 12em;" rowspan=4>Mitnehmen</td>
			<td class="tbchell">Eisen</td>
			<td class="tbchell">Silizium</td>
			<td class="tbchell">Wasser</td>
			<td class="tbchell">Robots</td>
		</tr>
		<tr>	
			<td class="tbchell"><input id="mitnehmen[0]" name="mitnehmen[0]" style="width: 100%;" type="text"></td>
			<td class="tbchell"><input id="mitnehmen[1]" name="mitnehmen[1]" style="width: 100%;" type="text"></td>
			<td class="tbchell"><input id="mitnehmen[2]" name="mitnehmen[2]" style="width: 100%;" type="text"></td>
			<td class="tbchell"><input id="mitnehmen[3]" name="mitnehmen[3]" style="width: 100%;" type="text"></td>
						
		</tr>
		<tr>
			<td class="tbchell" style="text-align: right;"><input type="button" class="btn_main btn_main_klein" value="+" onclick="maxe_einzeln(0);"><input type="button" class="btn_main btn_main_klein" value="-" onclick="document.getElementById('mitnehmen[0]').value = '';"></td>
			<td class="tbchell" style="text-align: right;"><input type="button" class="btn_main btn_main_klein" value="+" onclick="maxe_einzeln(1);"><input type="button" class="btn_main btn_main_klein" value="-" onclick="document.getElementById('mitnehmen[1]').value = '';"></td>
			<td class="tbchell" style="text-align: right;"><input type="button" class="btn_main btn_main_klein" value="+" onclick="maxe_einzeln(2);"><input type="button" class="btn_main btn_main_klein" value="-" onclick="document.getElementById('mitnehmen[2]').value = '';"></td>
			<td class="tbchell" style="text-align: right;"><input type="button" class="btn_main btn_main_klein" value="+"><input type="button" class="btn_main btn_main_klein" value="-"></td>
		</tr>	
		<tr>
			<td class="tbchell" style="text-align: right;"></td>
			<td class="tbchell" style="text-align: right;"></td>
			<td class="tbchell" style="text-align: right;"><input type="button" class="btn_main btn_main_klein" value="+" onclick="alleressaufmax();"><input type="button" class="btn_main btn_main_klein" value="-" onclick="alleressaufmin();"></td>
			<td class="tbchell" style="text-align: right;"></td>
		</tr>	
	</table>
	<table id="default" cellspacing="0" border=0 cellpadding="0" class="übersicht" width=100%>
		<tr>	
			<td class="tbc" style="width: 12em;">Abholen</td>
			<td class="tbchell"><input name="abholen[0]" style="width: 100%;" type="text"></td>
			<td class="tbchell"><input name="abholen[1]" style="width: 100%;" type="text"></td>
			<td class="tbchell"><input name="abholen[2]" style="width: 100%;" type="text"></td>
			<td class="tbchell"><input name="abholen[3]" style="width: 100%;" type="text"></td>			
		</tr>
	</table>
	
	<table id="default" cellspacing="0" border=0 cellpadding="0" class="übersicht" width=100%>
		<tr>
			<td class="tbchell" style="text-align: right;"><button class="btn_main" type="submit" name="action-flotte-starten" value="action-flotte-starten">Experimentell (Nur Sicherungsflug ist halbwegs sicher)</button></td>
		</tr>
	</table>
	<input id="Distanz"  type="" placeholder="Distanz"><br>
	<input id="DistanzPS" type="" placeholder="Diszanz P|S"><br>
	<input id="DistanzB" type="" placeholder="Diszanz Excel"><br>
</form>
	<?php 
	$tech_spieler = get_tech_stufe_spieler($spieler_id);
	$i = 0;
	$js_schiffe_id = array();
	$js_schiffe_anzahl = array();
	$js_schiffe_Geschwindigkeit = array();
	$js_schiffe_Kapazität = array();
	echo "<!-- Transportstufe: " . $tech_spieler["Tech_5"] .  "  -->";
	foreach($schiffe as $key => $value) {		
		$anzahl = $schiffe[$key]["Anzahl"];
		$id = $schiffe[$key]["ID"];
		$schiff_detail = get_config_ships($id);
		
		$js_schiffe_id[] = $id; 
		$js_schiffe_anzahl[] = $anzahl;		
		
		$js_schiffe_Kapazität[] =  $schiff_detail["Kapazitaet"] * (10 * $tech_spieler["Tech_5"]) / 100 + $schiff_detail["Kapazitaet"];
		$js_schiffe_Geschwindigkeit[] = $schiff_detail["Geschwindigkeit"];		
		//echo "<input id='schiff_id[$i]' placeholder='schiff_id[$i]' value='" . $id . "'>";
		//echo "<input id='schiff_geschwindigkeit[$i]' placeholder='schiff_geschwindigkeit[$i]' value='" . $schiff_detail["Geschwindigkeit"] . "'><br>";
		//echo "<input id='schiff_kapazitaet[$i]' placeholder='schiff_kapazitaet[$i]' value='" . $schiff_detail["Kapazitaet"] . "'><br>";
		
		$i++;
	}
	
	?>
	
	<script language="javascript" type="text/javascript" src="flotte.js"></script>
	
	<script type="text/javascript">

	
	js_schiffe_id = new Array(<?php echo implode(", ", $js_schiffe_id); ?>,-1);
	js_schiffe_anzahl = new Array(<?php echo implode(", ", $js_schiffe_anzahl); ?>,-1);
	js_schiffe_Geschwindigkeit = new Array(<?php echo implode(", ", $js_schiffe_Geschwindigkeit); ?>,-1);
	js_schiffe_Kapazität = new Array(<?php echo implode(", ", $js_schiffe_Kapazität); ?>,-1);


	function fuenfer10er() {
		var x = document.getElementById("10er5er");
		if(document.getElementById("mission").value == 5) {
		    x.setAttribute("disabled", "true");
		    document.getElementById("10er5er").disabled = true;
		} else {
		    x.setAttribute("disabled", "false");
		    document.getElementById("10er5er").disabled = false;
		}
	}
	
	function alleaufnull() {
		for (i=0; i < js_schiffe_anzahl.length; i++){
	
			if(js_schiffe_anzahl[i] > -1){
	
				document.getElementById("schiff_anzahl[" + i + "]").value = "";
	
			}
		}
		func_geschwindigkeit();
	}
	
	function alleaufmax() {
		for (i=0; i < js_schiffe_anzahl.length; i++){
	
			if(js_schiffe_anzahl[i] > -1){
	
				document.getElementById("schiff_anzahl[" + i + "]").value = js_schiffe_anzahl[i];
	
			}
		}
		func_geschwindigkeit();
	}

	function func_geschwindigkeit() {
		document.getElementById('Distanz').value = Distanzen(<?php echo $koordinaten["X"]; ?>, <?php echo $koordinaten["Y"]; ?>, <?php echo $koordinaten["Z"]; ?>, document.getElementById('x').value, document.getElementById('y').value, document.getElementById('z').value);
		var langsamstes_schiff = 3e5;
		for (i=0; i < js_schiffe_Geschwindigkeit.length; i++){

			

			if(js_schiffe_anzahl[i] > -1){

				if(document.getElementById("schiff_anzahl[" + i + "]").value + 0 > 0) {
					if(langsamstes_schiff > js_schiffe_Geschwindigkeit[i]) { langsamstes_schiff = js_schiffe_Geschwindigkeit[i]; }
				}
				
				
			}
		}
		
		
		document.getElementById('flugzeit').innerHTML = "";

		if(langsamstes_schiff == 3e5) { return 0; }

		var kord_x = document.getElementById('x').value;
		var kord_y = document.getElementById('y').value;
		var kord_z = document.getElementById('z').value;
		
		if( kord_x == '') { return 0; }
		if( kord_y == '') { return 0; }
		if( kord_z == '') { return 0; }
		

		var distanz = document.getElementById('Distanz').value;
		var distanzPS = document.getElementById('DistanzPS').value;
		
		
		if(distanzPS == "S") {
			distanz = 13912830 + 1087170 * distanz;			 
		} else {
			distanz = 10440000 + 360000 * distanz;
		}

		var flugzeit = distanz / langsamstes_schiff;
		var antrieb = <?php echo $tech_spieler["Tech_3"]; ?>;
		var flugzeit = 0;
	
		if(document.getElementById("10er5er").checked == true && document.getElementById("mission").value != 5) {
			var schritte = 5;
		} else {
			var schritte = 10;
		} 
		
		for(z = 100; z >= schritte; z+=-schritte) {
			
			geschwindigkeit = (langsamstes_schiff * (1 + antrieb / 10) * z / 100);
			var flugzeit = distanz / geschwindigkeit;  

			document.getElementById("DistanzB").value = distanz; 


			var tl = (flugzeit);
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

			var flugzeit_anzeige = z + "% " + tstr; 
			
			var x = document.getElementById("flugzeit");
			var option = document.createElement("option");
			option.text = flugzeit_anzeige;
			option.value = z;
			x.add(option);
			}		
		}
		
		
	}
function alleressaufmin() {
	for(i = 0; i <= 2; i++) {

		document.getElementById("mitnehmen[" + i + "]").value = "";
	}
		
}

function alleressaufmax() {
	
	var kappa_haben = 0;
	var ressource = new Array(<?php echo floor($ressource["Eisen"]) . ", " . floor($ressource["Silizium"]) . ", " . floor($ressource["Wasser"]); ?>);

	var kappa_belegt = new Array(0, 0, 0);
	
	for(i = 0; i <= 2; i++) {

		if(document.getElementById("mitnehmen[" + i + "]").value != '') {
			kappa_belegt[i] = parseInt(document.getElementById("mitnehmen[" + i + "]").value, 10);
		}

	}

	var	kappa_belegt_gesamt = kappa_belegt[0] + kappa_belegt[1] + kappa_belegt[2];
	
	for (i=0; i < js_schiffe_Kapazität.length; i++){
		if(js_schiffe_anzahl[i] > -1){

			
			if (document.getElementById("schiff_anzahl[" + i + "]").value == '') { anzahl = 0; } else { anzahl = 0 + parseInt(document.getElementById("schiff_anzahl[" + i + "]").value, 10); }			
			if(anzahl > 0) {
				kappa_haben = kappa_haben + (anzahl * js_schiffe_Kapazität[i]);				
			}
			
		}
	}
	
	var kappa_frei = kappa_haben - kappa_belegt_gesamt;
	if(kappa_frei <= 0) { return "Fehler: Keine Kapazität frei"; }
	
	var ignoriere = new Array(false, false, false);
	if(kappa_belegt[0] > 0) { ignoriere[0] = true; } 
	if(kappa_belegt[1] > 0) { ignoriere[1] = true; }
	if(kappa_belegt[2] > 0) { ignoriere[2] = true; }


	if(ignoriere[0] == true & ignoriere[1] == true & ignoriere[2] == true) { 
		ignoriere = new Array(false, false, false);
	}

	var einlagern = kappa_frei;
	for(z = 0; z <= einlagern; z++) {

		for(i = 0; i <= 2; i++) {
			if(ignoriere[i] == false) {
				if(i == 0) { addiere = 4; }
				if(i == 1) { addiere = 2; }
				if(i == 2) { addiere = 1; }

				if(kappa_belegt[i] + addiere <= ressource[i] & kappa_frei - addiere >= 0) {
					kappa_belegt[i] = kappa_belegt[i] + addiere; 
					kappa_frei = kappa_frei - addiere;
				}				
			} 
		}		
	} 
	for(i = 0; i <= 2; i++) {
		document.getElementById("mitnehmen[" + i + "]").value = kappa_belegt[i];		 	 					
	}
		
}

function maxe_einzeln(z) {
	var kappa_haben = 0;
	var ressource = new Array(<?php echo floor($ressource["Eisen"]) . ", " . floor($ressource["Silizium"]) . ", " . floor($ressource["Wasser"]); ?>);

	var kappa_belegt = new Array(0, 0, 0);
	
	for(i = 0; i <= 2; i++) {

		if(document.getElementById("mitnehmen[" + i + "]").value != '') {
			kappa_belegt[i] = parseInt(document.getElementById("mitnehmen[" + i + "]").value, 10);
		}

	}

	var	kappa_belegt_gesamt = kappa_belegt[0] + kappa_belegt[1] + kappa_belegt[2];
	
	for (i=0; i < js_schiffe_Kapazität.length; i++){
		if(js_schiffe_anzahl[i] > -1){

			
			if (document.getElementById("schiff_anzahl[" + i + "]").value == '') { anzahl = 0; } else { anzahl = 0 + parseInt(document.getElementById("schiff_anzahl[" + i + "]").value, 10); }			
			if(anzahl > 0) {
				kappa_haben = kappa_haben + (anzahl * js_schiffe_Kapazität[i]);				
			}
			
		}
	}
	
	var kappa_frei = kappa_haben - kappa_belegt_gesamt;
	//if(kappa_frei <= 0) { return "Fehler: Keine Kapazität frei"; }

	if(ressource[z] >= kappa_belegt[z] + kappa_frei) { document.getElementById("mitnehmen[" + z + "]").value = kappa_belegt[z] + kappa_frei; return true; } else
	{
		document.getElementById("mitnehmen[" + z + "]").value = ressource[z];
		return true;
	}	
}
</script>	
	