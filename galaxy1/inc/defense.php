<?php 

// written by ES  Sep 2016

function get_max_number_of_possible_constructions ($construction, $available_resources) {
	$max_quantity = 99;

	$resource = 'iron'; 
		if ($construction['required ' . $resource] > 0) {
			$temp_quantity = round_down($available_resources[$resource] / $construction['required ' . $resource]);
		} else {$temp_quantity = 99;}
	if ($temp_quantity < $max_quantity) {$max_quantity = $temp_quantity;} 

	$resource = 'silicon'; 
		if ($construction['required ' . $resource] > 0) {
			$temp_quantity = round_down($available_resources[$resource] / $construction['required ' . $resource]);
		} else {$temp_quantity = 99;}
	if ($temp_quantity < $max_quantity) {$max_quantity = $temp_quantity;} 

	$resource = 'water'; 
		if ($construction['required ' . $resource] > 0) {
			$temp_quantity = round_down($available_resources[$resource] / $construction['required ' . $resource]);
		} else {$temp_quantity = 99;}
	if ($temp_quantity < $max_quantity) {$max_quantity = $temp_quantity;} 

	$resource = 'karma'; 
		if ($construction['required ' . $resource] > 0) {
			$temp_quantity = round_down($available_resources[$resource] / $construction['required ' . $resource]);
		} else {$temp_quantity = 99;}
	if ($temp_quantity < $max_quantity) {$max_quantity = $temp_quantity;} 

	$resource = 'bots'; 
		if ($construction['required ' . $resource] > 0) {
			$temp_quantity = round_down($available_resources[$resource] / $construction['required ' . $resource]);
		} else {$temp_quantity = 99;}
	if ($temp_quantity < $max_quantity) {$max_quantity = $temp_quantity;} 

	if($construction['max hold planet'] != -1 && $max_quantity > $construction['max hold planet']) {$max_quantity = $construction['max hold planet'];}
	if($construction['max hold'] != -1 && $max_quantity > $construction['max hold']) {$max_quantity = $construction['max hold'];}
	
	if ($max_quantity > 99) {$max_quantity = 99;}
	return $max_quantity;
}

?>

<?php 
	echo '<span id="lng_defaults" ' 	
		. 'thousands_sep="' . $lng_defaults ['thousands_sep'] . '" '
		. 'decimal_point="' . $lng_defaults ['decimal_point'] . '" '
		. 'decimals="' . $lng_defaults ['decimals'] . '" ' 
		. 'cd_single="' . $lng_defaults ['countdown_single'] . '" '
		. 'cd_plural="' . $lng_defaults ['countdown_plural'] . '" />';
	
	echo '<span id="varTransfer" ' 
		. 'quantityOfConstructions = "' . get_defense_count() . '" />'; 
?>


<script language="javascript" type="text/javascript" src="constructionGUI2.js"></script>

<form action="index.php" method="post" autocomplete="off" class="constructionGUI2">
	<input type="hidden" name="s" value="defense">
	<?php // <input type="hidden" name="ship_id__" id="ship_id__" value=""> ?>
	
	<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
		<tr>
			<th class="tbtb " colspan=2 ><?php lng_echo('defensive fortification'); ?></th>
			<th class="tbtb " colspan=2 style="text-align: center;"><?php lng_echo('quantity'); ?></th>
			<th class="tbtb "  style="text-align: center;"><?php lng_echo('required resoures'); ?></th>
			<th class="tbtb tbConstructionTime"><?php lng_echo('construction time'); ?></th>	
		</tr>
		
		<?php 
		
		$level_weapon_factory = get_structure_level($spieler_id, $planet_id, 8);
		$tech_level = get_tech_stufe_spieler($spieler_id);
		
		if ($level_weapon_factory > 0) {
			$def_count = get_defense_count();
			$focus_id='';
			
			for($i = 1; $i <= $def_count; $i++) {

				$construction = get_defense($i);
				$existing_defense = get_existing_defense($spieler_id, $planet_id, $i); 
				
		// -------------- only for the time , if all variables are translated !!! ------------------ //
				$resources = german_res_to_english_res ($ressource);
		// -------------- only for the time , if all variables are translated !!! ------------------ //
			
				// prüfen, ob in allen Bereichen genug geforscht wurde
				$tech_probe = true; 
				for($t = 1; $t <= $techCount; $t++) {
					if ($tech_level["Tech_" . $t] < $construction['required tech level typ ' . $t]) {
						$tech_probe = false; 				}
				}
				
				if($construction['required level weapon factory'] <= $level_weapon_factory && $tech_probe == true) {

					// check maximum number of posible constructions is reached
					$max_quantity = false;  $maxGalaxy = false;
					if($construction['max hold planet'] != -1) { 
						if($existing_defense['planet'] >= $construction['max hold planet']) {
							$max_quantity = true; 
						}
					}
					if($construction['max hold'] != -1) { 
						if($existing_defense['galaxy'] >= $construction['max hold']) { 
							$max_quantity = true;  $maxGalaxy = true; 
						}			
					}
					
					// check for enough resources 
					$can_be_built = true; 
					$colorI = ""; if($resources['iron'] < $construction['required iron']) { $colorI = "notEnoughRes"; $can_be_built = false; }
					$colorS = ""; if($resources['silicon'] < $construction['required silicon']) { $colorS = "notEnoughRes"; $can_be_built = false; }
					$colorW = ""; if($resources['water'] < $construction['required water']) { $colorW = "notEnoughRes"; $can_be_built = false; }
					$colorB = ""; if($resources['bots'] < $construction['required bots']) { $colorB = "notEnoughRes"; $can_be_built = false; }
					$colorK = ""; if($resources['karma'] < $construction['required karma']) { $colorK = "notEnoughRes"; $can_be_built = false; }

					// $classStr used for the graying or highlighting the menu line
					$classStr = ''; 
					if ($max_quantity || !$can_be_built) {$classStr = 'passive';}
						if ($focus_id == '') {$focus_id = 'inputField' . $i ;} 
						
						?>
						<tr>
							<td width=1% class="tbchell"><a href="javascript:details('G<?php echo $i; ?>');" id="detailsButton" name="G<?php echo $i; ?>Button" class="detailsGeschlossen">▶</a></td>	
							<td width=1% class="tbchell tbBezeichnung <?php echo $classStr; ?>"><?php echo $construction['name']; ?></td>
							<?php if ($max_quantity) { ?>
								<td colspan=4 class="tbchell tbMaxFS" style="padding:0.7em;">
									<?php if ($maxGalaxy) {lng_echo ('max hold galaxy reached', no_file, echo_on, $construction);} 
												else {lng_echo ('max hold planet reached', no_file, echo_on, $construction);}?>
								</td>
							<?php } else { ?>
								<td width=1% class="tbchell <?php echo $classStr; ?> tbchell_ohne_right_border tbSlider">
									<input class="slider" id="slider<?php echo $i; ?>" type="range" max=<?php echo get_max_number_of_possible_constructions($construction,$resources);?> value=0 oninput="slideAndCalculate('slider<?php echo $i; ?>')">
								</td>
								<td width=1% class="tbchell <?php echo $classStr; ?> tbchell_ohne_left_border tbchell_ohne_right_border tbStufe">
									<input class="inputField" type="text" size=2 maxlength=2 id="inputField<?php echo $i; ?>" name="quantity<?php echo $i; ?>" value="0" tabindex=<?php echo $i; ?> oninput="slideAndCalculate('inputField<?php echo $i; ?>')" onClick="this.form.inputField<?php echo $i; ?>.select()">
								</td>
								<td class="tbchell <?php echo $classStr . ' ' . $colorI; ?>" align="right" style="padding:0;">
								<div style="display: flex; flex-wrap: wrap; justify-content: flex-end;"> 
								<div class=" <?php echo $classStr . ' ' . $colorI; ?>" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									<span <?php echo 'title="' . lng_echo('required iron',no_file, echo_off) . '"  id="resI' . $i . '" rateForOneItem="' . $construction['required iron'] .'"'; ?>> 
										<?php echo lng_number_format($construction['required iron']); ?>
									</span>
									<img src="img/eisen.png" class="img_ress">
								 </div>
								<div class=" <?php echo $classStr . ' ' . $colorS; ?>" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									<span  id="resS<?php echo $i; ?>" rateForOneItem="<?php echo $construction['required silicon']; ?>">
										<?php echo lng_number_format($construction['required silicon']); ?>
									</span>
									<img src="img/silizium.png" class="img_ress">
								</div>
								<div class=" <?php echo $classStr . ' ' . $colorW; ?>" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									
									<span  id="resW<?php echo $i; ?>" rateForOneItem="<?php echo $construction['required water']; ?>">
										<?php echo lng_number_format($construction['required water']); ?>
									</span>
									<img src="img/wasser.png" class="img_ress"> 
								</div>
								
								<div class=" <?php echo $classStr . ' ' . $colorB; ?>" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									
									<span  id="resB<?php echo $i; ?>" rateForOneItem="<?php echo $construction['required bots']; ?>">
										<?php echo lng_number_format($construction['required bots']); ?>
									</span>
									<img src="img/bot.png" class="img_ress">
								</div>
								<div class=" <?php echo $classStr . ' ' . $colorK; ?>" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									
									<span  id="resK<?php echo $i; ?>" rateForOneItem="<?php echo $construction['required karma']; ?>">
										<?php echo lng_number_format($construction['required karma']); ?>
									</span>						
									<img src="img/karma.png" class="img_ress"> 
								</div>
								</div></td>
								<td width=1% class="tbchell tbConstructionTime <?php echo $classStr; ?> " >
									<span  id="constructionTime<?php echo $i; ?>" rateForOneItem="<?php echo $construction['construction time']; ?>">
										<?php echo lng_number_format($construction['construction time'],'c'); ?>
									</span>
								</td>
							<?php } ?>
						</tr>
						<tr name="G<?php echo $i ?>"class="detailsAusgeblendet" style="display:none;">
							<?php 
							//************   from here  long description !   *****************//
							?>
							<td  class="tbchell tbBeschreibungLang" colspan="11" align="center">
								<table cellspacing="0" cellpadding="0" class="übersicht tbBeschreibungLang" width=99%>
									<tbody>
										<tr> 
											<?php if ($construction['picture'] != "" && $load_pictures){ ?>
													<td width="25%">
														<img src="<?php echo($construction['picture']); ?>" class="bildDetails">
													</td>
											<?php } ?>
											<td class="tbBeschreibungLangText">
												<table id="default" class="tbBeschreibungLangText">
													<tbody>
														<tr>
															<td><?php echo $construction['description']; ?></td>
														</tr>
														<tr>
															<td >
																<ul class="ress">
																	<li class="<?php echo $colorB; ?>"><img src="img/bots.png" class="img_ress"> <?php echo lng_number_format($construction['required bots']); ?></li>
																	<li class="<?php echo $colorI; ?>"><img src="img/iron.png" class="img_ress"> <?php echo lng_number_format($construction['required iron']); ?></li>
																	<li class="<?php echo $colorS; ?>"><img src="img/silicon.png" class="img_ress"> <?php echo lng_number_format($construction['required silicon']); ?></li>
																	<li class="<?php echo $colorW; ?>"><img src="img/water.png" class="img_ress"> <?php echo lng_number_format($construction['required water']); ?></li>
																	<li class="<?php echo $colorK; ?>"><img src="img/karma.png" class="img_ress"> <?php echo lng_number_format($construction['required karma']); ?></li>
																</ul>
															</td>
														</tr>
														<tr>
															<td>
																<ul class="nav inline-items-attr">
																	<li><font style="font-size: x-small;"><?php lng_echo('attack'); ?></font><?php echo lng_number_format($construction['attack strength']); ?></li>
																	<li><font style="font-size: x-small;"><?php lng_echo('defense'); ?></font><?php echo lng_number_format($construction['defense strength']); ?></li>
																	<!-- 
																	<li><font style="font-size: x-small;">Geschwindigkeit: </font><?php //echo  number_format($construction["Geschwindigkeit"], 0, '.', '.'); ?></li>
																	<li><font style="font-size: x-small;">Kapazitaet: </font><?php //echo number_format($construction["Kapazitaet"], 0, '.', '.'); ?></li>
																	<li><font style="font-size: x-small;">Reichweite: </font><?php //echo number_format($construction["Reichweite"], 0, '.', '.'); ?></li>
																	-->
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
					// *************  footer ************ 
				?>
				<!--<td colspan=10> 
					<table cellspacing="0" cellpadding="0" class="" width=100%>
						<tbody>
							<tr> -->
								<tr class="tbchell"><td colspan=6 style="font-size: 30%;">&nbsp; </td></tr>
								<td colspan=2 class="tbtb"><?php lng_echo('total building time / costs'); ?></td>
								<td  colspan=2 width=1% class="tbtb tbConstructionTime">
									<span  id="totalConstructionTime" title="0">
										<?php echo lng_number_format(0,'c'); ?>
									</span>
								</td>
								<td class="tbtb" align="right" style="padding:0;">
								<div style="display: flex; flex-wrap: wrap; justify-content: flex-end;"> 
								<div class="" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									<span  id="totalResI" availableRes="<?php echo $resources['iron']; ?>">0</span>
									<img src="img/eisen.png" class="img_ress">
								 </div>
								<div class="" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									<span  id="totalResS" availableRes="<?php echo $resources['silicon']; ?>">0</span>
									<img src="img/silizium.png" class="img_ress"> 
								</div>
								<div class="" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									<span  id="totalResW" availableRes="<?php echo $resources['water']; ?>">0</span>
									<img src="img/wasser.png" class="img_ress"> 
								</div>
								<div class="" style="text-align: right; flex: 1 1 33% min-width: 8em; max-width: 33%">
								</div>
								<div class="" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									<span  id="totalResB" availableRes="<?php echo $resources['bots']; ?>">0</span>
									<img src="img/bot.png" class="img_ress"> 
								</div>
								<div class="" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									<span  id="totalResK" availableRes="<?php echo $resources['karma']; ?>">0</span>						
									<img src="img/karma.png" class="img_ress"> 
								</div></td>
								<td class="tbtb tbchell_ohne_right_border" style="text-align:right;">
									<button class="bt" type="submit" name="action_built_defense" id="action_built_defense" value="-"><?php lng_echo('build'); ?></button>
								</td>

<!--		</tr>
						</tbody>
					</table> 
				</td> -->
			</tr>
		<?php 
		} else {
			// wildcard so that headings are formatted correctly
			// message: no weapon factory ?>
			<tr  style="visibility:collapse">
				<td width=1% class="tbchell"> ▶</td>	
				<td width=6% class="tbchell tbBezeichnung"> </td>
				<td width=10% class="tbchell tbchell_ohne_right_border stufenPfeil">&#10138;</td>
				<td width=1% class="tbchell tbchell_ohne_left_border tbchell_ohne_right_border tbStufe"> </td>
				<td width=43% class="tbchell tbchell_ohne_left_border btTdWidth"><button class="bt btPlatzhalter" type="submit" name="" value=""><span>*</span></button></td>			
				<td width=1% class="tbchell tbConstructionTime"> </td>
			</tr>
			<tr><td colspan=9 class="tbchell tbBezeichnung"><b><?php lng_echo('please build weapons factory'); ?></b></td></tr>
			<tr  style="visibility:collapse"><td colspan=6 > </td></tr>
		<?php 
		} ?>
	</table>
</form>

<script> e=document.getElementById("<?php echo $focus_id; ?>"); e.focus(); e.select();</script>