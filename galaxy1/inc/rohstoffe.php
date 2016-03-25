<?php 

$produktion = get_produktion($spieler_id, 0);
$bunker = get_Ressbunker_Inhalt($spieler_id, 0);

foreach ($produktion as &$value) {
	$value = number_format($value, 0, '.', '.');
}

?>
<div class="ubersicht_gross" style="width: 100%">
<table  id="default" class="" width=100% style="">
	<tr>
		<th colspan=2>Produktion</td><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Energie</th><th><th>Robots</th>
	</tr>
	<tr>
		<td colspan=2>Grundproduktion</td>
		<td><?php echo $produktion["Eisen_Grund"]; ?></td>
		<td><?php echo $produktion["Silizium_Grund"]; ?></td>
		<td><?php echo $produktion["Wasser_Grund"]; ?></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan=2>Eisen-Mine</td>
		<td><?php echo $produktion["Eisen_Produktion"]; ?></td>
		<td>-</td>
		<td>-</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan=2>Silizium-Mine</td>
		<td>-</td>
		<td><?php echo $produktion["Silizium_Produktion"]; ?></td>
		<td>-</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan=2>Wasser-Mine</td>
		<td>-</td>
		<td>-</td>
		<td><?php echo $produktion["Wasser_Produktion"]; ?></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
			<tr>
		<td colspan=2>Kraftwerk</td><td></td><td></td><td></td><td></td><td></td><td></td>
	</tr>
		<tr>
		<td rowspan=2>Gesamtproduktion</td><td>pro Stunde</td><td></td><td></td><td></td><td></td><td></td><td></td>
	</tr>
		<tr>
		<td>pro Tag</td><td></td><td></td><td></td><td></td><td></td><td></td>
	</tr>
	</table>
	</div>
	

	<div  class="ubersicht_klein">
	
	
<div class="flexcontainer-center">

<div style="min-width: 250px; width: 100%;">
	<table id="default" class="ubersicht" width=100%>
		<tr>
			<th colspan=2>Eisen-Mine</th>			
		</tr>
		<tr><td>Grundprod.</td><td style="text-align: right;"><?php echo $produktion["Eisen_Grund"]; ?></td></tr>
		<tr><td>Stufe n</td><td style="text-align: right;">+<?php echo $produktion["Eisen_Produktion"]; ?></td></tr>
		<tr><td>Energie</td><td style="text-align: right;">-???</td></tr>
		<tr><td colspan=2 style="text-align: center;"><lable for="robot_eisen">Robot <input id="robot_eisen" name="robot_eisen" size=4></lable> <button>-</button> <button>+</button> </td></tr>
	</table>
</div>

<div style="min-width: 250px; width: 100%;">
	<table id="default" class="ubersicht" width=100%>
		<tr>
			<th colspan=2>Slizium-Mine</th>			
		</tr>
		<tr><td>Grundprod.</td><td style="text-align: right;"><?php echo $produktion["Silizium_Grund"]; ?></td></tr>
		<tr><td>Stufe n</td><td style="text-align: right;">+<?php echo $produktion["Silizium_Produktion"]; ?></td></tr>
		<tr><td>Energie</td><td style="text-align: right;">-???</td></tr>
		<tr><td colspan=2 style="text-align: center;"><lable for="robot_silizium">Robot <input id="robot_silizium" name="robot_silizium" size=4></lable> <button>-</button> <button>+</button> </td></tr>
	</table>
</div>

<div style="min-width: 250px; width: 100%;">
	<table id="default" class="ubersicht" width=100%>
		<tr>
			<th colspan=2>Wasserbrunnen</th>			
		</tr>
		<tr><td>Grundprod.</td><td style="text-align: right;"><?php echo $produktion["Wasser_Grund"]; ?></td></tr>
		<tr><td>Stufe n</td><td style="text-align: right;">+<?php echo $produktion["Wasser_Produktion"]; ?></td></tr>
		<tr><td>Energie</td><td style="text-align: right;">-???</td></tr>
		<tr><td colspan=2 style="text-align: center;"><lable for="robot_wasser">Robot <input id="robot_wasser" name="robot_wasser" size=4></lable> <button>-</button> <button>+</button> </td></tr>
	</table>
</div>

<div style="min-width: 250px; width: 100%;">
	<table id="default" class="ubersicht" width=100%>
		<tr>
			<th>Gesamt+</th>
			<th>1h</th>			
			<th>24h</th>
		</tr>		
		<tr><td>Eisen</td><td style="text-align: right;"><?php echo $produktion["Eisen"]; ?></td><td style="text-align: right;"><?php echo $produktion["Eisen_24"]; ?></td></tr>
		<tr><td>Silitium</td><td style="text-align: right;"><?php echo $produktion["Silizium"]; ?></td><td style="text-align: right;"><?php echo $produktion["Silizium_24"]; ?></td></tr>
		<tr><td>Wasser</td><td style="text-align: right;"><?php echo $produktion["Wasser"]; ?></td><td style="text-align: right;"><?php echo $produktion["Wasser_24"]; ?></td></tr>		
	</table>
</div>


</div>

</div>


<div class="flexcontainer-center">

	<div style="min-width: 250px; width: 100%;">
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
	</div>

</div>