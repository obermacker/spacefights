<table id="default" cellspacing="0" cellpadding="0" class="übersicht"  width="100%" >
<tr>
<th class="tbtb tbtb_ohne_links_rechts_oben" align="left"><a href="index.php?s=punkte-berechnen">&#12484;</a> Punkte</th>
</tr><tr>
<td  class="tbchell">
Gebäude:<br>
<?php echo number_format(sprintf('%d', $punkte["punkte_structur"]), 0, ',', '.'); ?><br>
Forschung:<br>
<?php echo number_format(sprintf('%d', $punkte["punkte_forschung"]), 0, ',', '.'); ?><br>
Flotte:<br>
<?php echo number_format(sprintf('%d', $punkte["punkte_flotte"]), 0, ',', '.'); ?><br>
Gesamt:<br>
				<?php echo number_format(sprintf('%d', array_sum($punkte)), 0, ',', '.'); ?>
				</td></tr></table>
