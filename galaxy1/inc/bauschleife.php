<?php  
$ship_construction_loops = get_list_of_ship_construction_activity ($spieler_id, $planet_id);

if (isset($ship_construction_loops)) {
	$i = 0;
	foreach($ship_construction_loops as $key => $value) {
		$id = $ship_construction_loops[$key]["ID"];
		$qauntity = $ship_construction_loops[$key]["Anzahl"];
		$name = $ship_construction_loops[$key]["Name"];
		$remanining_construction_time = $ship_construction_loops[$key]["Zeit-Bis"];
		
		?> 
		<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
			<tr>
				<td class="tbtb tbtb_ohne_rechts">
					<?php echo str_replace(' ', '&nbsp;&nbsp;', str_pad($qauntity, 2 ," ", STR_PAD_LEFT)) . "x "; ?><?php echo "$name"; ?>
				</td>
			</tr>
			<tr>
				<td align="right" class="tbchell tbchell_rechts">
					<span id="flotte<?php echo $i; ?>">
						<script type="text/javascript"><!--
							countdown(<?php echo $remanining_construction_time; ?>, "flotte<?php echo $i; ?>");
						</script>
					</span>
					<form style="display: inline;" action="index.php" method="post" autocomplete="off">
						<input type="hidden" name="s" value="<?php echo $select; ?>">
						<button type="submit" name="action-schiffe-abbrechen" id="action-schiffe-abbrechen_<?php echo $i; ?>" value="<?php echo $id; ?>">
							x
						</button>
					</form>
				</td>
			</tr>
		</table>
		<?php 
		$i++;
	} 
} 

$defense_construction_loops = get_list_of_defense_construction_activity ($spieler_id, $planet_id);

if (isset($defense_construction_loops)) { 
	$i = 0;
	foreach($defense_construction_loops as $key => $value) {
		$id = $defense_construction_loops[$key]['id'];
		$qauntity = $defense_construction_loops[$key]['qauntity'];
		$name = $defense_construction_loops[$key]['name'];
		$remanining_construction_time = $defense_construction_loops[$key]['remanining construction time'];
		
		?> 
		<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
			<tr>
				<td class="tbtb tbtb_ohne_rechts">
					<?php echo str_replace(' ', '&nbsp;&nbsp;', str_pad($qauntity, 2 ," ", STR_PAD_LEFT)) . "x "; ?><?php echo "$name"; ?>
				</td>
			</tr>
			<tr>
				<td align="right" class="tbchell tbchell_rechts">
					<span id="deff<?php echo $i; ?>">
						<script type="text/javascript"><!--
							countdown(<?php echo $remanining_construction_time; ?>, "deff<?php echo $i; ?>");
						</script>
					</span>
						<form style="display: inline;" action="index.php" method="post" autocomplete="off">
							<input type="hidden" name="s" value="<?php echo $select; ?>">
							<button type="submit" name="action_abort_defense_loop" id="action_abort_defense_loop<?php echo $i; ?>" value="<?php echo $id; ?>">
								x
							</button>
						</form>
				</td>
			</tr>
		</table>
		<?php 
		$i++;
	}
}

// if there are no loops, show placeholder in construction gui
if (!isset($ship_construction_loops) && !isset($defense_construction_loops) 
	&& ($select == 'defense' || $select == 'Raumschiffe')) {?>

		
		<table id="default" cellspacing="0" cellpadding="0" class="übersicht" height=100% width=100%>
			<tr>
				<td class="tbtb tbtb_ohne_rechts">
					Keine Bauaufträge
				</td>
			</tr>
			<tr>
				<td align="right" class="tbchell tbchell_rechts">
				&nbsp;</td>
			</tr>
		</table>
<?php }?>