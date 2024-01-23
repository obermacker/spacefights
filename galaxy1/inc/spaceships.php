<?php 
// -------------- only for the time , if all variables are translated !!! ------------------ //
if (!isset($planetID)) {$planetID = $planet_id;} // temporary de - en
$resources = german_res_to_english_res ($ressource);
// -------------- only for the time , if all variables are translated !!! ------------------ //			

// written by ES  Sep 2024

function get_max_number_of_possible_constructions ($_ship, $availableResources) {
	$_maxQuantity = 99;

	if ($_ship->requiredIron > 0) {$temp_quantity = round_down($availableResources['iron'] / $_ship->requiredIron);} else {$temp_quantity = $_maxQuantity;}
	if ($temp_quantity < $_maxQuantity) {$_maxQuantity = $temp_quantity;} 

	if ($_ship->requiredSilicon > 0) {$temp_quantity = round_down($availableResources['silicon'] / $_ship->requiredSilicon);} else {$temp_quantity = $_maxQuantity;}
	if ($temp_quantity < $_maxQuantity) {$_maxQuantity = $temp_quantity;} 

	if ($_ship->requiredWater > 0) {$temp_quantity = round_down($availableResources['water'] / $_ship->requiredWater);} else {$temp_quantity = $_maxQuantity;}
	if ($temp_quantity < $_maxQuantity) {$_maxQuantity = $temp_quantity;} 

	if ($_ship->requiredKarma > 0) {$temp_quantity = round_down($availableResources['karma'] / $_ship->requiredKarma);} else {$temp_quantity = $_maxQuantity;}
	if ($temp_quantity < $_maxQuantity) {$_maxQuantity = $temp_quantity;} 

	if ($_ship->requiredBots > 0) {$temp_quantity = round_down($availableResources['bots'] / $_ship->requiredBots);} else {$temp_quantity = $_maxQuantity;}
	if ($temp_quantity < $_maxQuantity) {$_maxQuantity = $temp_quantity;} 

	if($_ship->maxHoldPlanet != -1 && $_maxQuantity > $_ship->maxHoldPlanet) {$_maxQuantity = $_ship->maxHoldPlanet;}
	if($_ship->maxHold != -1 && $_maxQuantity > $_ship->maxHold) {$_maxQuantity = $_ship->maxHold;}
	
	return $_maxQuantity;
}

echo '<span id="lng_defaults" ' 	
	. 'thousands_sep="' . $lng_defaults ['thousands_sep'] . '" '
	. 'decimal_point="' . $lng_defaults ['decimal_point'] . '" '
	. 'decimals="' . $lng_defaults ['decimals'] . '" ' 
	. 'cd_single="' . $lng_defaults ['countdown_single'] . '" '
	. 'cd_plural="' . $lng_defaults ['countdown_plural'] . '" />';

echo '<span id="varTransfer" ' 
	. 'quantityOfConstructions = "' . count(spaceships::$shipID) . '" />'; 

?>
<script language="javascript" type="text/javascript" src="constructionGUI2.js"></script>

<form action="index.php" method="post" autocomplete="off" class="constructionGUI2">
	<input type="hidden" name="s" value="spaceships">
		
	<div class="GUI2GridContainer übersicht" id="default" cellspacing="0" cellpadding="0" width=100%>
		<div class="GUI2HeadConstruction tbtb" colspan=2 ><?php lng_echo('spaceship type'); ?></div>
		<div class="GUI2HeadQuantity tbtb" colspan=2 style="text-align: center;"><?php lng_echo('quantity'); ?></div>
		<div class="GUI2HeadResoures tbtb"  style="text-align: center;"><?php lng_echo('required resoures'); ?></div>
		<div class="GUI2HeadBuildTime tbtb"><?php lng_echo('construction time'); ?></div>	

		<?php 
		$_levelSpaceshipYard = get_structure_level($playerID, $planetID, 7);
		
		if ($_levelSpaceshipYard > 0) {
			$focus_id='';

			$_techLevel = get_tech_level_player($playerID);
			$_stationedShips = get_ships_stationed($playerID, $planetID); 
			$_allShips = get_all_ships_in_galaxy($playerID);	
			
			foreach (spaceships::$shipID as $_ID => $_ship) {
			
				// check whether enough research has been carried out in all areas
				$_techCheck = true; 
				foreach ($_ship->requiredTechLevelType as $_t => $_value) {
					if ($_techLevel::$techLevelType[$_t] < $_ship->requiredTechLevelType[$_t]) {
						$_techCheck = false; 				}
				}
				
				if($_ship->requiredLevelSpaceshipYard <= $_levelSpaceshipYard && $_techCheck == true) {

					// check maximum number of posible constructions is reached
					$_maxQuantity = false;  $_maxGalaxy = false;
					if($_ship->maxHoldPlanet != -1) { 
						if($_stationedShips[$_ID] >= $_ship->maxHoldPlanet) {
							$_maxQuantity = true; 
						}
					}
					if($_ship->maxHold != -1) { 
						if($_allShips[$_ID] >= $_ship->maxHold) { 
							$_maxQuantity = true;  $_maxGalaxy = true; 
						}			
					}
					
					// check for enough resources 
					$_canBeBuilt = true; 
					$colorI = ''; if($resources[iron] < $_ship->requiredIron) { $colorI = 'notEnoughRes'; $_canBeBuilt = false; }
					$colorS = ''; if($resources[silicon] < $_ship->requiredSilicon) { $colorS = 'notEnoughRes'; $_canBeBuilt = false; }
					$colorW = ''; if($resources[water] < $_ship->requiredWater) { $colorW = 'notEnoughRes'; $_canBeBuilt = false; }
					$colorB = ''; if($resources[bots] < $_ship->requiredBots) { $colorB = 'notEnoughRes'; $_canBeBuilt = false; }
					$colorK = ''; if($resources[karma] < $_ship->requiredKarma) { $colorK = 'notEnoughRes'; $_canBeBuilt = false; }

					// $classStr used for the graying or highlighting the menu line
					$classStr = '';
					if ($_maxQuantity || !$_canBeBuilt) {$classStr = 'passive';}
					if ($focus_id == '') {$focus_id = 'inputField'.$_ID ;} 
					?>
					<div class="GUI2DescriptionShortDetails tbchell"><a href="javascript:toggleDetails('G<?php echo $_ID; ?>');" id="detailsButton" name="G<?php echo $_ID; ?>Button" class="detailsNotShown">▶</a></div>	
					<div class="GUI2DescriptionShortConstruction tbchell <?php echo $classStr; ?>"><?php echo $_ship->name; ?></div>
					<?php 
					if ($_maxQuantity) { ?>
						<div class="GUI2DescriptionShortMaxHold tbchell tbMaxFS">
							<?php 
								if ($_maxGalaxy) {lng_echo ('max hold galaxy reached', no_file, echo_on, $_ship);}
								else {lng_echo ('max hold planet reached', no_file, echo_on, $_ship);}
							?>
						</div>
					<?php
					} else {?>
						<div class="GUI2DescriptionShortSlider tbchell tbchellRightBorderOff <?php echo $classStr; ?>">
							<input class="slider" id="slider<?php echo $_ID; ?>" type="range" max=<?php echo get_max_number_of_possible_constructions($_ship,$resources);?> value=0 oninput="slideAndCalculate('slider<?php echo $_ID; ?>')">
						</div>
						<div class="GUI2DescriptionShortQuantity tbchell tbchellLeftBorderOff tbchellRightBorderOff <?php echo $classStr; ?>">
							<input class="inputField" type="text" size=2 maxlength=2 id="inputField<?php echo $_ID; ?>" name="quantity<?php echo $_ID; ?>" value="0" tabindex=<?php echo $_ID; ?> oninput="slideAndCalculate('inputField<?php echo $_ID; ?>')" onClick="this.form.inputField<?php echo $_ID; ?>.select()">
						</div>
						<div class="GUI2DescriptionShortResoures tbchell <?php echo $classStr ?>">
							<div style="display: flex; flex-wrap: wrap; justify-content: flex-end;"> 
								<div class=" <?php echo $classStr . ' ' . $colorI; ?>" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									<span <?php echo 'title="' . lng_echo('required iron',no_file, echo_off) . '"  id="resI' . $_ID . '" rateForOneItem="' . $_ship->requiredIron .'"'; ?>> 
										<?php echo lng_number_format($_ship->requiredIron); ?>
									</span>
									<img src="img/eisen.png" class="img_ress">
								</div>
								<div class=" <?php echo $classStr . ' ' . $colorS; ?>" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									<span  id="resS<?php echo $_ID; ?>" rateForOneItem="<?php echo $_ship->requiredSilicon; ?>">
										<?php echo lng_number_format($_ship->requiredSilicon); ?>
									</span>
									<img src="img/silizium.png" class="img_ress">
								</div>
								<div class=" <?php echo $classStr . ' ' . $colorW; ?>" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									
									<span  id="resW<?php echo $_ID; ?>" rateForOneItem="<?php echo $_ship->requiredWater; ?>">
										<?php echo lng_number_format($_ship->requiredWater); ?>
									</span>
									<img src="img/wasser.png" class="img_ress"> 
								</div>
								<div class=" <?php echo $classStr . ' ' . $colorB; ?>" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									
									<span  id="resB<?php echo $_ID; ?>" rateForOneItem="<?php echo $_ship->requiredBots; ?>">
										<?php echo lng_number_format($_ship->requiredBots); ?>
									</span>
									<img src="img/bot.png" class="img_ress">
								</div>
								<div class=" <?php echo $classStr . ' ' . $colorK; ?>" style="text-align: right; flex: 1 1 33%; min-width: 8em; max-width: 33%">
									
									<span  id="resK<?php echo $_ID; ?>" rateForOneItem="<?php echo $_ship->requiredKarma; ?>">
										<?php echo lng_number_format($_ship->requiredKarma); ?>
									</span>						
									<img src="img/karma.png" class="img_ress"> 
								</div>
							</div>
						</div>
						<div class="GUI2DescriptionShortBuildTime tbchell <?php echo $classStr; ?> " >
							<span  id="constructionTime<?php echo $_ID; ?>" rateForOneItem="<?php echo $_ship->constructionTime/$_levelSpaceshipYard; ?>">
								<?php echo lng_number_format($_ship->constructionTime/$_levelSpaceshipYard,'c'); ?>
							</span>
						</div>
					<?php 
					}
					?>
					<div name="G<?php echo $_ID ?>" class="GUI2DescriptionLong detailsHidden" style="display:none;">
						<?php 
						//************   from here  long description !   *****************//
						?>
						<div class="GUI2DescriptionContainer overview"> 
								<?php if ($_ship->picture != '' && $load_pictures){ ?>
									<div class="GUI2DescriptionLongPicture">
										<img src="<?php echo($_ship->picture); ?>" class="picture">
									</div>
									<div class="GUI2DescriptionLongText"> 
							<?php } else { ?>
							<div class="GUI2DescriptionLongTextOnly">
							<?php } ?>
								<div><?php echo $_ship->description; ?></div>
								<div>
									<ul class="ress">
										<li class="<?php echo $colorB; ?>"><img src="img/bots.png" class="img_ress"> <?php echo lng_number_format($_ship->requiredBots); ?></li>
										<li class="<?php echo $colorI; ?>"><img src="img/iron.png" class="img_ress"> <?php echo lng_number_format($_ship->requiredIron); ?></li>
										<li class="<?php echo $colorS; ?>"><img src="img/silicon.png" class="img_ress"> <?php echo lng_number_format($_ship->requiredSilicon); ?></li>
										<li class="<?php echo $colorW; ?>"><img src="img/water.png" class="img_ress"> <?php echo lng_number_format($_ship->requiredWater); ?></li>
										<li class="<?php echo $colorK; ?>"><img src="img/karma.png" class="img_ress"> <?php echo lng_number_format($_ship->requiredKarma); ?></li>
									</ul>
								</div>
								<div>
									<ul class="nav inline-items-attr">
										<li><font style="font-size: x-small;"><?php lng_echo('attack strength'); ?></font><?php echo lng_number_format($_ship->attackStrength); ?></li>
										<li><font style="font-size: x-small;"><?php lng_echo('defense strength'); ?></font><?php echo lng_number_format($_ship->defenseStrength); ?></li>
										<li><font style="font-size: x-small;"><?php lng_echo('max speed'); ?></font><?php echo lng_number_format($_ship->maxSpeed); ?></li>
										<li><font style="font-size: x-small;"><?php lng_echo('loading capacity'); ?></font><?php echo lng_number_format($_ship->loadingCapacity); ?></li>
										<li><font style="font-size: x-small;"><?php lng_echo('max range'); ?></font><?php echo lng_number_format($_ship->maxRange); ?></li><BR>
										<li><font style="font-size: x-small;"><?php lng_echo('normal construction time'); ?></font><?php echo lng_number_format($_ship->constructionTime,'C'); ?></li>
										<li><font style="font-size: x-small;"><?php lng_echo('accelerated construction time'); ?></font><?php echo lng_number_format($_ship->constructionTime/$_levelSpaceshipYard,'C'); ?></li>
									</ul>
								</div>
							</div>
						</div>	
					</div>
				<?php 
				}
			}

			// *************  footer ************ 
			?>
			<div class="GUI2FooterConstruction tbtb"><?php lng_echo('total building time / costs'); ?></div>
			<div class="GUI2FooterConstructionTime tbtb">
				<span  id="totalConstructionTime" title="0">
					<?php echo lng_number_format(0,'c'); ?>
				</span>
			</div>
			<div class="GUI2FooterResoures tbtb">
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
					</div>
				</div>
			</div>
			<div class="GUI2FooterBuildButton tbtb tbchellRightBorderOff">
				<button class="bt" type="submit" name="action_built_spaceships" id="action_built_spaceships" value="-"><?php lng_echo('build'); ?></button>
			</div>
		<?php 
		} else {
		?>
			<div class="GUI2FooterBuildYard tbchell"><b><?php lng_echo('please build spaceship yard'); ?></b></div>
		<?php 
		} 
		?>
	</div>
</form>

<script> e=document.getElementById("<?php echo $focus_id; ?>"); e.focus(); e.select();</script>