<?php 
//********** Übernahme der GUI vereinfachen **********//
$menuZweig = 'Structure';  		
$bezArt = 'Gebäude';
$bezInput = 'Gebaeude';
$textZeit = 'Bauzeit';
$textFertig = 'fertiggestellt';
$bilderEinblenden = true;
?>

<form action="index.php" method="post" autocomplete="off" class="bauGUI">
	<input type="hidden" name="s" value="<?php echo($bezInput); ?>">

	<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
		<tr>
			<th class="tbtb " colspan=2><?php echo($bezArt); ?></th>
			<th class="tbtb " colspan=3>Stufe</th>
			<th class="tbtb " colspan=4>Kosten</th>
			<th class="tbtb tbConstructionTime"><?php echo($textZeit); ?></th>	
		</tr>
		
		<?php 
		for($i = 1; $i <= 10; $i++) {

			$baut_gerade = check_bauschleife_activ($spieler_id, $planet_id, "$menuZweig");	
			
			//********** hier bei Übernahme der GUI auch ändern **********//
			$objekt = get_gebäude_nächste_stufe($spieler_id, $planet_id, $i, 1);	

			$kann_gebaut_werden = true;
			$farbeE = ""; if($ressource["Eisen"] < $objekt["Kosten_Eisen"]) { $farbeE = "notEnoughRes"; $kann_gebaut_werden = false; }
			$farbeS = ""; if($ressource["Silizium"] < $objekt["Kosten_Silizium"]) { $farbeS = "notEnoughRes"; $kann_gebaut_werden = false; }
			$farbeW = ""; if($ressource["Wasser"] < $objekt["Kosten_Wasser"]) { $farbeW = "notEnoughRes"; $kann_gebaut_werden = false; }
			$farbeEn = ""; if($ressource["Energie"] < $objekt["Kosten_Energie"]) { $farbeEn = "notEnoughRes"; $kann_gebaut_werden = false; }
			
			// $classStr für Statuszeile ausgrauen , bzw. hervorhebensetzen
			$classStr = "";
			if (is_null($baut_gerade)) {$baut_gerade["ID"] = 0;}
			if ($baut_gerade["ID"] == 0) {if (!$kann_gebaut_werden) { $classStr='passive';}} else if ($baut_gerade["ID"] != $i) {$classStr='passive';} else {$classStr='imBau';}
			?>
			
			<tr <?php if ($baut_gerade["ID"] == $i) { ?>  class ="trMitPBar" <?php } ?> >
				<td width=1% class="tbchell"><a href="javascript:details('G<?php echo $i; ?>');" id="detailsButton" name="G<?php echo $i; ?>Button" class="detailsGeschlossen">▶</a></td>	
				<td width=1% class="tbchell tbBezeichnung <?php echo $classStr; ?>"><?php echo $objekt["Name"]; ?></td>
				<td width=1% class="tbchell <?php echo $classStr; ?> tbchell_ohne_right_border stufenPfeil">&#10138;</td>
				<td width=1% class="tbchell <?php echo $classStr; ?> tbchell_ohne_left_border tbchell_ohne_right_border tbStufe"><?php echo ($objekt["Stufe"]); ?></td>
				<td width=1% class="tbchell <?php echo $classStr; ?> tbchell_ohne_left_border" >
				<?php	//********** hier bei Übernahme der GUI auch ändern **********//
						if($kann_gebaut_werden == true && $baut_gerade["ID"] == 0) {?> 				
							<button class="bt btPlus" type="submit" name="action-gebaeude-bauen" value="<?php echo $i; ?>">	
								<span>+</span>
							</button>
				<?php 	} else if ($baut_gerade["ID"] == $i) { ?>
							<button class="bt btMinus" type="submit" name="action-gebaeude-abbrechen" value="<?php echo $i; ?>">
								<span>X</span>
							</button>					
				<?php 	} else { ?>
								<button class="bt btPlatzhalter" type="submit" name="" value="">
									<span>*</span>
								</button>					
				<?php	} ?>
				</td>			
				<td class="tbchell <?php echo $classStr . ' ' . $farbeE; ?> "><img src="img/eisen.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Eisen"], 0, '.', '.'); ?></td>
				<td class="tbchell <?php echo $classStr . ' ' . $farbeS; ?> "><img src="img/silizium.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Silizium"], 0, '.', '.'); ?></td>
				<td class="tbchell <?php echo $classStr . ' ' . $farbeW; ?> "><img src="img/wasser.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Wasser"], 0, '.', '.'); ?></td>
				<td class="tbchell <?php echo $classStr . ' ' . $farbeEn; ?> "><img src="img/energie.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Energie"], 0, '.', '.');?></td>
				<td  width=1% class="tbchell tbConstructionTime <?php echo $classStr; ?> " >
					<?php
					if($baut_gerade["ID"] != $i) {
						echo lng_number_format($objekt["Bauzeit"],'c'); 				
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
														<li class="<?php echo $farbeEn; ?>"><img src="img/energie.png" class="img_ress"> <?php echo number_format($objekt["Kosten_Energie"], 0, '.', '.'); ?></li>
													</ul>
												</td>
											</tr>
											<tr>
												<td>
													<ul class="ress">
														<li class="img_ress">
														<?php 
														if($i == 1) { echo "<img src='img/eisen.png' class='img_ress'> + " . $objekt["Gewinn_Ress"] . "/h"; }
														if($i == 2) { echo "<img src='img/silizium.png' class='img_ress'> + ". $objekt["Gewinn_Ress"] . "/h"; }
														if($i == 3) { echo "<img src='img/wasser.png' class='img_ress'> + ". $objekt["Gewinn_Ress"] . "/h"; }	
									
														if($objekt["Gewinn_Energie"] > 0) { echo "<img src='img/energie.png' class='img_ress'> + " . $objekt["Gewinn_Energie"] . " Einheiten"; }
														if($objekt["Kapazitaet"] > 0) { echo "+ " . $objekt["Kapazitaet"] . " Einheiten"; }
														?>		
														</li>
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
		?>
	</table>
</form>
