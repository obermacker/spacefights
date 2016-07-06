<?php 
//********** Übernahme der GUI vereinfachen **********//
$menuZweig = 'Tech';  		
$bezArt = 'Forschungsgebiet';
$bezInput = 'Forschung';
$textZeit = 'Forschungszeit';
$textFertig = 'erforscht';
$bilderEinblenden = true;
?>

<form action="index.php" method="post" autocomplete="off" class="bauGUI">
	<input type="hidden" name="s" value="<?php echo($bezInput); ?>">

	<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
		<tr>
			<th class="tbtb " colspan=2><?php echo($bezArt); ?></th>
			<th class="tbtb " colspan=3>Stufe</th>
			<th class="tbtb " colspan=3>Kosten</th>
			<th class="tbtb tbBauzeit"><?php echo($textZeit); ?></th>	
		</tr>
		
		<?php 
		
		$Sortierung = get_tech_sortierung();
		$keinForschungslabor = true;
		
		foreach ($Sortierung as $key => $value) {
			$i = $key;
			$baut_gerade = check_bauschleife_activ($spieler_id, $planet_id, "$menuZweig");	
			
			//********** hier bei Übernahme der GUI auch ändern **********//
			$objekt = get_tech_nächste_stufe($spieler_id, $planet_id, $i, 1);
			dVar($objekt);
			if ($objekt["Forschung"] == "OK" || $objekt["Forschung"] == "MAX") {
				
				$keinForschungslabor = false;
				if ($objekt["Forschung"] == "MAX") {$maxBaustufe = true;} else {$maxBaustufe = false;} 
				
				$kann_gebaut_werden = true; 
				$farbeE = ""; if($ressource["Eisen"] < $objekt["Kosten_Eisen"]) { $farbeE = "zuWenigRess"; $kann_gebaut_werden = false; }
				$farbeS = ""; if($ressource["Silizium"] < $objekt["Kosten_Silizium"]) { $farbeS = "zuWenigRess"; $kann_gebaut_werden = false; }
				$farbeW = ""; if($ressource["Wasser"] < $objekt["Kosten_Wasser"]) { $farbeW = "´zuWenigRess"; $kann_gebaut_werden = false; }
				
				// $classStr für Statuszeile ausgrauen , bzw. hervorhebensetzen
				$classStr = "";
				if ($baut_gerade["ID"] == 0) {if (!$kann_gebaut_werden || $maxBaustufe) { $classStr='passiv';}} else if ($baut_gerade["ID"] != $i) {$classStr='passiv';} else {$classStr='imBau';}
				?>
				
				<tr class ="<?php if ($baut_gerade["ID"] == $i) {echo('trMitPBar');} else {echo('');}?>">
					<td width=1% class="tbchell"><a href="javascript:details('G<?php echo $i; ?>');" id="detailsButton" name="G<?php echo $i; ?>Button" class="detailsGeschlossen">▶</a></td>	
					<td width=1% class="tbchell tbBezeichnung <?php echo $classStr; ?>"><?php echo $objekt["Name"]; ?></td>
					<?php if ($maxBaustufe) { ?>
						<td width=1% class="tbchell <?php echo $classStr; ?> tbchell_ohne_right_border stufenPfeil"> </td>
					<?php } else { ?>
						<td width=1% class="tbchell <?php echo $classStr; ?> tbchell_ohne_right_border stufenPfeil">&#10138;</td>
					<?php } ?>
					<td width=1% class="tbchell <?php echo $classStr; ?> tbchell_ohne_left_border tbchell_ohne_right_border tbStufe"><?php if ($maxBaustufe) {echo ($objekt["Stufe"]-1);} else {echo ($objekt["Stufe"]);} ?></td>
					<td width=1% class="tbchell <?php echo $classStr; ?> tbchell_ohne_left_border btTdWidth" > 
					<?php	//********** hier bei Übernahme der GUI auch ändern **********//
							if($kann_gebaut_werden == true && $baut_gerade["ID"] == 0) {?> 				
								<button class="bt btPlus" type="submit" name="action-forschung-bauen" value="<?php echo $i; ?>">	
									<span>+</span>
								</button>
					<?php 	} else if ($baut_gerade["ID"] == $i) { ?>
								<button class="bt btMinus" type="submit" name="action-forschung-abbrechen" value="<?php echo $i; ?>">
									<span>X</span>
								</button>					
					<?php 	} else { ?>
								<button class="bt btPlatzhalter" type="submit" name="" value="">
									<span>*</span>
								</button>					
					<?php	} ?>
					</td>			
					<?php if ($maxBaustufe) { ?>
						<td colspan=4 class="tbchell tbMaxFS <?php echo $classStr ?> ">Maximale Forschungsstufe erreicht, keine weitere Forschung möglich !</td>
					<?php } else { ?>
						<td class="tbchell <?php echo $classStr . ' ' . $farbeE; ?> "><img src="img/eisen.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Eisen"], 0, '.', '.'); ?></td>
						<td class="tbchell <?php echo $classStr . ' ' . $farbeS; ?> "><img src="img/silizium.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Silizium"], 0, '.', '.'); ?></td>
						<td class="tbchell <?php echo $classStr . ' ' . $farbeW; ?> "><img src="img/wasser.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Wasser"], 0, '.', '.'); ?></td>
						<td width=1% class="tbchell tbBauzeit <?php echo $classStr; ?> " >
							<?php
							if($baut_gerade["ID"] != $i) {
								echo get_timestamp_in_was_sinnvolles($objekt["Bauzeit"]); 				
							} else {
								if ($baut_gerade["ID"] == $i) {?>
									<span id="cdKopf<?php echo $baut_gerade["ID"]; ?>">
										<script type="text/javascript">countdown_progress(<?php echo $baut_gerade["Countdown"]; ?>, "cdKopf<?php echo $baut_gerade["ID"]; ?>", <?php echo time() - $baut_gerade["Start"]; ?> , <?php echo $baut_gerade["Bis"] - $baut_gerade["Start"];?> , '<?php echo ($textFertig); ?>',0,true);
										</script>
									</span>
									</td></tr>
									<tr><td colspan="10" align="center" class="BGpBar">
										<div id="mPBar_background<?php echo $baut_gerade["ID"]; ?>" class="pBar pBarBkGrd"></div>
										<div id="mPBar_pbKopf<?php echo $baut_gerade["ID"]; ?>" class="pBar" ></div>
										<span id="pbKopf<?php echo $baut_gerade["ID"]; ?>" class="LpBar" style="display:none;">
											<script type="text/javascript">countdown_progress(<?php echo $baut_gerade["Countdown"]; ?>, "pbKopf<?php echo $baut_gerade["ID"]; ?>" , <?php echo time() - $baut_gerade["Start"]; ?> , <?php echo $baut_gerade["Bis"] - $baut_gerade["Start"];?> , '<?php echo ($textFertig); ?>',99);
											</script>
										</span>
								<?php	
								}
							}
							?>
						</td>
					<?php } ?>
				</tr>
				<tr name="G<?php echo $i ?>"class="detailsAusgeblendet" style="display:none;">
					<?php 
					//************  ab hier Beschreibung lang !   *****************//
					?>
					<td  class="tbchell tbBeschreibungLang" colspan="10" align="center">
						<table cellspacing="0" cellpadding="0" class="übersicht tbBeschreibungLang" width=99%;>
							<tbody>
								<tr> 
									<?php if ($objekt["Bild"] != "" && $bilderEinblenden){ ?>
											<td width="25%">
												<img src="<?php echo($objekt["Bild"]); ?>" class="bildDetails">
											</td>
									<?php } ?>
									<td class="tbBeschreibungLangText">
										<table id="default" class="tbBeschreibungLangText">
											<tbody>
												<tr>
													<td><?php echo $objekt["Beschreibung"]; ?></td>
												</tr>
												<tr>
													<td >
														<ul class="ress">
															<li class="<?php echo $farbeE; ?>"><img src="img/eisen.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Eisen"], 0, '.', '.'); ?></li>
															<li class="<?php echo $farbeS; ?>"><img src="img/silizium.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Silizium"], 0, '.', '.'); ?></li>
															<li class="<?php echo $farbeW; ?>"><img src="img/wasser.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Wasser"], 0, '.', '.'); ?></li>
														</ul>
													</td>
												</tr>
												<tr>
													<td><?php echo $objekt["Wirkung"]; ?></td>
												</tr>
												<?php if($baut_gerade["ID"] == $i) { ?>
													<tr>
														<td>Bau bis: <?php echo get_timestamp_in_was_lesbares($baut_gerade["Bis"]); ?></td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			<?php 
			}
		}
		if ($keinForschungslabor) { 
		
		// Paltzhalter, damit Überschriften richtig formatiert werden?>
			<tr  style="visibility:collapse">
				<td width=1% class="tbchell"> ▶</td>	
				<td width=1% class="tbchell tbBezeichnung"> </td>
				<td width=1% class="tbchell tbchell_ohne_right_border stufenPfeil">&#10138;</td>
				<td width=1% class="tbchell tbchell_ohne_left_border tbchell_ohne_right_border tbStufe"> </td>
				<td width=1% class="tbchell tbchell_ohne_left_border btTdWidth"><button class="bt btPlatzhalter" type="submit" name="" value=""><span>*</span></button></td>			
				<td class="tbchell"> </td>
				<td class="tbchell"> </td>
				<td class="tbchell"> </td>
				<td width=1% class="tbchell tbBauzeit"> </td>
			</tr>
			<tr><td colspan=9 class="tbchell tbBezeichnung"><b>Bitte zunächst Forschungslabor bauen !</b></td></tr>
			<tr  style="visibility:collapse"><td colspan=9 > </td></tr>
		<?php } ?>
	</table>
</form>
