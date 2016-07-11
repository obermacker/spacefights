<?php 
//********** Übernahme der GUI vereinfachen **********//
// $menuZweig = 'Tech';  		
$bezArt = 'Verteidigungsanlage';
$bezInput = 'Verteidigung';
$textZeit = 'Bauzeit';
$textFertig = 'fertiggestellt';
$bilderEinblenden = true;

function roundDown($zahl) {
	$rZahl = round($zahl);
	if ($rZahl > $zahl) {$rZahl--;}
	return $rZahl;
}

function getMaxAnzahlBauV ($objekt, $ressVorhanden) {
	$maxAnzahl = 99;

	$ress = 'Eisen'; 
		if ($objekt['Kosten_' . $ress] > 0) {
			$tempAnzahl = roundDown($ressVorhanden[$ress] / $objekt['Kosten_' . $ress]);
		} else {$tempAnzahl = 99;}
	if ($tempAnzahl<$maxAnzahl) {$maxAnzahl=$tempAnzahl;} 

	$ress = 'Silizium'; 
		if ($objekt['Kosten_' . $ress] > 0) {
			$tempAnzahl = roundDown($ressVorhanden[$ress] / $objekt['Kosten_' . $ress]);
		} else {$tempAnzahl = 99;}
	if ($tempAnzahl<$maxAnzahl) {$maxAnzahl=$tempAnzahl;} 

	$ress = 'Wasser'; 
		if ($objekt['Kosten_' . $ress] > 0) {
			$tempAnzahl = roundDown($ressVorhanden[$ress] / $objekt['Kosten_' . $ress]);
		} else {$tempAnzahl = 99;}
	if ($tempAnzahl<$maxAnzahl) {$maxAnzahl=$tempAnzahl;} 

	$ress = 'Karma'; 
		if ($objekt['Kosten_' . $ress] > 0) {
			$tempAnzahl = roundDown($ressVorhanden[$ress] / $objekt['Kosten_' . $ress]);
		} else {$tempAnzahl = 99;}
	if ($tempAnzahl<$maxAnzahl) {$maxAnzahl=$tempAnzahl;} 

	$ress = 'Bots'; 
		if ($objekt[$ress] > 0) {
			$tempAnzahl = roundDown($ressVorhanden['Bot'] / $objekt[$ress]);
		} else {$tempAnzahl = 99;}
	if ($tempAnzahl<$maxAnzahl) {$maxAnzahl=$tempAnzahl;} 

	if($objekt["Max_Hold_Planet"] != -1 && $maxAnzahl > $objekt["Max_Hold_Planet"]) {$maxAnzahl = $objekt["Max_Hold_Planet"];}
	if($objekt["Max_Hold"] != -1 && $maxAnzahl > $objekt["Max_Hold"]) {$maxAnzahl = $objekt["Max_Hold"];}
	
	if ($maxAnzahl > 99) {$maxAnzahl = 99;}
	return $maxAnzahl;
}

?>

<script language="javascript" type="text/javascript" src="bauGUI2.js"></script>

<form action="index.php" method="post" autocomplete="off" class="bauGUI2">
	<input type="hidden" name="s" value="<?php echo($bezInput); ?>">
	<input type="hidden" name="ship_id__" id="ship_id__" value="">
	
	<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
		<tr>
			<th class="tbtb " colspan=2><?php echo($bezArt); ?></th>
			<th class="tbtb " colspan=2><center>Anzahl</center></th>
			<th class="tbtb " colspan=5>Kosten</th>
			<th class="tbtb tbBauzeit"><?php echo($textZeit); ?></th>	
		</tr>
		
		<?php 
		
		$waffenfabrik_stufe = get_gebäude_aktuelle_stufe($spieler_id, $planet_id, 8);
		$tech_stufe = get_tech_stufe_spieler($spieler_id);
		
		if ($waffenfabrik_stufe > 0) {
		
			for($i = 1; $i <= $deffCount; $i++) {

				$objekt = get_deff($i);
				$deff_in_Besitz = get_deff_in_Besitz($spieler_id, $planet_id, $i); 
				
				// prüfen, ob in allen Bereichen genug geforscht wurde
				$tech_probe = true;
				for($t = 1; $t <= $techCount; $t++) {
					if ($tech_stufe["Tech_" . $t] < $objekt["Tech_" . $t]) {
						$tech_probe = false;
					}
				}
				
				if($objekt["Stufe_Werft"] <= $waffenfabrik_stufe && $tech_probe == true) {
					
					
					// prüfen, ob maximale Anzahl Verteidigungsanlagen errecht 
					$maxAnzahl = false;  $maxGalaxy = false;
					if($objekt["Max_Hold_Planet"] != -1) { 
						if($deff_in_Besitz["Planet"] >= $objekt["Max_Hold_Planet"]) {
							$maxAnzahl = true; 
						}
					}
					if($objekt["Max_Hold"] != -1) { 
						if($deff_in_Besitz["Galaxy"] >= $objekt["Max_Hold"]) { 
							$maxAnzahl = true;  $maxGalaxy = true; 
						}			
					}

					// prüfen, ob genug Ressourcen vorhanden 
					$kann_gebaut_werden = true; 
					$farbeE = ""; if($ressource["Eisen"] < $objekt["Kosten_Eisen"]) { $farbeE = "zuWenigRess"; $kann_gebaut_werden = false; }
					$farbeS = ""; if($ressource["Silizium"] < $objekt["Kosten_Silizium"]) { $farbeS = "zuWenigRess"; $kann_gebaut_werden = false; }
					$farbeW = ""; if($ressource["Wasser"] < $objekt["Kosten_Wasser"]) { $farbeW = "zuWenigRess"; $kann_gebaut_werden = false; }
					$farbeB = ""; if($ressource["Bot"] < $objekt["Bots"]) { $farbeB = "zuWenigRess"; $kann_gebaut_werden = false; }
					$farbeK = ""; if($ressource["Karma"] < $objekt["Kosten_Karma"]) { $farbeK = "zuWenigRess"; $kann_gebaut_werden = false; }

					// $classStr für das ausgrauen der Statuszeile , bzw. hervorheben
					$classStr = "";
					if ($maxAnzahl || !$kann_gebaut_werden) {$classStr = 'passiv';}
					?>
					
					<tr>
						<td width=1% class="tbchell"><a href="javascript:details('G<?php echo $i; ?>');" id="detailsButton" name="G<?php echo $i; ?>Button" class="detailsGeschlossen">▶</a></td>	
						<td width=1% class="tbchell tbBezeichnung <?php echo $classStr; ?>"><?php echo $objekt["Name"]; ?></td>
						<?php if ($maxAnzahl) { ?>
							<td colspan=8 class="tbchell tbMaxFS">
								<?php if ($maxGalaxy) { ?> 
									Maximale Anzahl <?php echo $objekt['Name_Plural']; ?> in der Galaxy bereits erreicht ! 
								<?php } else { ?> 
									Maximale Anzahl <?php echo $objekt['Name_Plural']; ?> auf dem Planeten bereits erreicht !
								<?php }?>
							</td>
						<?php } else { ?>
							<td width=1% class="tbchell <?php echo $classStr; ?> tbchell_ohne_right_border stufenPfeil">
								<input class="schieber" id="schieber<?php echo $i; ?>" type="range" max=<?php echo getMaxAnzahlBauV($objekt,$ressource);?> value=0 oninput="schiebenUndBerechnen('schieber<?php echo $i; ?>')">
							</td>
							<td width=1% class="tbchell <?php echo $classStr; ?> tbchell_ohne_left_border tbchell_ohne_right_border tbStufe">
								<input class="eingabeFeld" type="text" size=2 maxlength=2 id="eingabeFeld<?php echo $i; ?>" name="vanzahl<?php echo $i; ?>" value="0" tabindex=<?php echo $i; ?> oninput="schiebenUndBerechnen('eingabeFeld<?php echo $i; ?>')" onClick="this.form.eingabeFeld<?php echo $i; ?>.select()">
							</td>
							<td class="tbchell tbSechsStellig <?php echo $classStr . ' ' . $farbeE; ?>" align="right">
								<span  id="ressE<?php echo $i; ?>" title="<?php echo $objekt["Kosten_Eisen"]; ?>">
									<?php echo number_format($objekt["Kosten_Eisen"], 0, '.', '.'); ?>
								</span>
								<img src="img/eisen.png" class="img_ress">
							 </td>
							<td class="tbchell tbSechsStellig <?php echo $classStr . ' ' . $farbeS; ?>" align="right">
								<span  id="ressS<?php echo $i; ?>" title="<?php echo $objekt["Kosten_Silizium"]; ?>">
									<?php echo number_format($objekt["Kosten_Silizium"], 0, '.', '.'); ?>
								</span>
								<img src="img/silizium.png" class="img_ress"> 
							</td>
							<td class="tbchell tbSechsStellig <?php echo $classStr . ' ' . $farbeW; ?>" align="right">
								<span  id="ressW<?php echo $i; ?>" title="<?php echo $objekt["Kosten_Wasser"]; ?>">
									<?php echo number_format($objekt["Kosten_Wasser"], 0, '.', '.'); ?>
								</span>
								<img src="img/wasser.png" class="img_ress"> 
							</td>
							<td width=1% class="tbchell tbVierStellig <?php echo $classStr . ' ' . $farbeB; ?>" align="right">
								<span  id="ressB<?php echo $i; ?>" title="<?php echo $objekt["Bots"]; ?>">
									<?php echo number_format($objekt["Bots"], 0, '.', '.'); ?>
								</span>
								<img src="img/bot.png" class="img_ress"> 
							</td>
							<td width=1% class="tbchell tbVierStellig <?php echo $classStr . ' ' . $farbeK; ?>" align="right">
								<span  id="ressK<?php echo $i; ?>" title="<?php echo $objekt["Kosten_Karma"]; ?>">
									<?php echo number_format($objekt["Kosten_Karma"], 0, '.', '.'); ?>
								</span>						
								<img src="img/karma.png" class="img_ress"> 
							</td>
							<td width=1% class="tbchell tbBauzeit <?php echo $classStr; ?> " >
								<span  id="bauzeit<?php echo $i; ?>" title="<?php echo $objekt["Bauzeit"]; ?>">
									<?php echo get_timestamp_in_was_sinnvolles($objekt["Bauzeit"]); ?>
								</span>
							</td>
						<?php } ?>
						</tr>
						<tr name="G<?php echo $i ?>"class="detailsAusgeblendet" style="display:none;">
							<?php 
							//************  ab hier Beschreibung lang !   *****************//
							?>
							<td  class="tbchell tbBeschreibungLang" colspan="11" align="center">
								<table cellspacing="0" cellpadding="0" class="übersicht tbBeschreibungLang" width=99%>
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
																	<li class="<?php echo $farbeB; ?>"><img src="img/bot.png" class="img_ress"> <?php echo number_format($objekt["Bots"], 0, '.', '.'); ?></li>
																	<li class="<?php echo $farbeE; ?>"><img src="img/eisen.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Eisen"], 0, '.', '.'); ?></li>
																	<li class="<?php echo $farbeS; ?>"><img src="img/silizium.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Silizium"], 0, '.', '.'); ?></li>
																	<li class="<?php echo $farbeW; ?>"><img src="img/wasser.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Wasser"], 0, '.', '.'); ?></li>
																	<li class="<?php echo $farbeK; ?>"><img src="img/karma.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Karma"], 0, '.', '.'); ?></li>
																</ul>
															</td>
														</tr>
														<tr>
															<td class="tbchell">
																<ul class="nav inline-items-attr">
																	<li><font style="font-size: x-small;">Angriff: </font><?php echo number_format($objekt["Angriff"], 0, '.', '.'); ?></li>
																	<li><font style="font-size: x-small;">Verteidigung: </font><?php echo number_format($objekt["Verteidigung"], 0, '.', '.'); ?></li>
																	<li><font style="font-size: x-small;">Geschwindigkeit: </font><?php echo  number_format($objekt["Geschwindigkeit"], 0, '.', '.'); ?></li>
																	<li><font style="font-size: x-small;">Kapazitaet: </font><?php echo number_format($objekt["Kapazitaet"], 0, '.', '.'); ?></li>
																	<li><font style="font-size: x-small;">Reichweite: </font><?php echo number_format($objekt["Reichweite"], 0, '.', '.'); ?></li>
																</ul>
															</td>
														</tr>
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
			}?>
			<tr>
				<?php
					// *************  fußzeile ************ 
				?>
				<td colspan=10> 
					<table cellspacing="0" cellpadding="0" class="" width=100%>
						<tbody>
							<tr>
								<td class="tbtb">Gesamtbauzeit / -kosten<span  id="deffCount" title="<?php echo $deffCount; ?>"></span></td>
								<td class="tbtb tbchell_ohne_right_border">
									<button class="bt" type="submit" name="action-deff-bauen" id="action-deff-bauen" value="-">bauen</button>
								</td>
								<td width=1% class="tbtb tbBauzeit">
									<span  id="gBauzeit" title="0">
										<?php echo get_timestamp_in_was_sinnvolles(0); ?>
									</span>
								</td>
								<td class="tbtb tbAchtStellig" align="right">
									<span  id="gRessE" title="<?php echo $ressource['Eisen']; ?>">0</span>
									<img src="img/eisen.png" class="img_ress">
								 </td>
								<td class="tbtb tbAchtStellig" align="right">
									<span  id="gRessS" title="<?php echo $ressource['Silizium']; ?>">0</span>
									<img src="img/silizium.png" class="img_ress"> 
								</td>
								<td class="tbtb tbAchtStellig" align="right">
									<span  id="gRessW" title="<?php echo $ressource['Wasser']; ?>">0</span>
									<img src="img/wasser.png" class="img_ress"> 
								</td>
								<td width=1% class="tbtb tbVierStellig" align="right">
									<span  id="gRessB" title="<?php echo $ressource['Bot']; ?>">0</span>
									<img src="img/bot.png" class="img_ress"> 
								</td>
								<td width=1% class="tbtb tbVierStellig" align="right">
									<span  id="gRessK" title="<?php echo $ressource['Karma']; ?>">0</span>						
									<img src="img/karma.png" class="img_ress"> 
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		<?php 
		} else {
			// Meldung keine Waffenfabrik
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
			<tr><td colspan=9 class="tbchell tbBezeichnung"><b>Bitte zunächst Waffenfabrik bauen !</b></td></tr>
			<tr  style="visibility:collapse"><td colspan=9 > </td></tr>
		<?php 
		} ?>
	</table>
</form>
