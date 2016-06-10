<?php 

$produktion = get_produktion($spieler_id, 0);
$bunker = get_Ressbunker_Inhalt($spieler_id, 0);

foreach ($produktion as &$value) {
	$value = number_format($value, 0, '.', '.');
}

?>

<table id="default" cellspacing="0" cellpadding="0" class="übersicht" width=100%>
	<tr>
		<th colspan=2 class="tbtb tbtb_linksbundig">Produktion</th>
		<th class="tbtb">Eisen</th>
		<th class="tbtb">Silizium</th>
		<th class="tbtb">Wasser</th>
		<th class="tbtb">Energie</th>
		<th class="tbtb tbtb_ohne_rechts">Robots</th>
	</tr>
	<tr>
		<td colspan=2 class="tbc">Grundproduktion</td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Eisen_Grund"]; ?></td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Silizium_Grund"]; ?></td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Wasser_Grund"]; ?></td>
		<td class="tbchell tbchell_rechts"></td>
		<td class="tbchell tbchell_rechts"></td>
		
	</tr>
	<tr>
		<td colspan=2 class="tbc tbc_oben">Eisen-Mine</td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Eisen_Produktion"]; ?></td>
		<td class="tbchell tbchell_rechts">-</td>
		<td class="tbchell tbchell_rechts">-</td>
		<td class="tbchell tbchell_rechts"></td>
		<td class="tbchell tbchell_rechts"></td>
		
	</tr>
	<tr>
		<td colspan=2 class="tbc">Silizium-Mine</td>
		<td class="tbchell tbchell_rechts">-</td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Silizium_Produktion"]; ?></td>
		<td class="tbchell tbchell_rechts">-</td>
		<td class="tbchell tbchell_rechts"></td>
		<td class="tbchell tbchell_rechts"></td>
		
	</tr>
	<tr>
		<td colspan=2 class="tbc">Wasser-Mine</td>
		<td class="tbchell tbchell_rechts">-</td>
		<td class="tbchell tbchell_rechts">-</td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Wasser_Produktion"]; ?></td>
		<td class="tbchell tbchell_rechts"></td>
		<td class="tbchell tbchell_rechts"></td>
		
	</tr>
			<tr>
		<td colspan=2 class="tbc">Kraftwerk</td>
		<td class="tbchell tbchell_rechts"></td>
		<td class="tbchell tbchell_rechts"></td>
		<td class="tbchell tbchell_rechts"></td>
		<td class="tbchell tbchell_rechts"></td>
		<td class="tbchell tbchell_rechts"></td>
	</tr>
		<tr>
		<td rowspan=2 class="tbc tbc_oben">Gesamtproduktion</td>
		<td class="tbc tbc_oben">pro Stunde</td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Eisen"]; ?></td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Silizium"]; ?></td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Wasser"]; ?></td>
		<td class="tbchell tbchell_rechts"></td>
		<td class="tbchell tbchell_rechts"></td>
	</tr>
		<tr>
		<td class="tbc tbc_oben">pro Tag</td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Eisen_24"]; ?></td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Silizium_24"]; ?></td>
		<td class="tbchell tbchell_rechts"><?php echo $produktion["Wasser_24"]; ?></td>
		<td class="tbchell tbchell_rechts"></td>
		<td class="tbchell tbchell_rechts"></td>
	</tr>
	</table>
	</div>
	

	



		<table id="default" class="ubersicht" width=100%>
		<caption>Rohstoffbunker</caption>
			<tr>
				<th></th>
				<th style="text-align: center;">%</th>
				<th style="text-align: center;">Gelagert</th>
				<th></th>
			</tr>
			<tr>
				<td>Eisen</td>
				<td><?php echo $bunker["Eisen_Prozent"]; ?></td>
				<td><input size=10 value="<?php echo $bunker["Eisen"]; ?>"></td>
				<td><button>-</button> <button>+</button></td>
			</tr>
			<tr>
				<td>Silizium</td>
				<td><?php echo $bunker["Silizium_Prozent"]; ?></td>
				<td><input size=10 value="<?php echo $bunker["Silizium"]; ?>"></td>
				<td><button>-</button> <button>+</button></td>
			</tr>
			<tr>
				<td>Wasser</td>
				<td><?php echo $bunker["Wasser_Prozent"]; ?></td>
				<td><input size=10 value="<?php echo $bunker["Wasser"]; ?>"></td>
				<td><button>-</button> <button>+</button></td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo $bunker["Belegt_Prozent"]; ?></td>
				<td><?php echo number_format($bunker["Kapazität"], 0, '.', '.'); ?></td>
				<td><button>-</button> <button>+</button></td>
			</tr>
		</table>

