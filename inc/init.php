
<div class="flexcontainer-center">
<form action="galaxy.php" method="post" autocomplete="off">
	
	
		<div>
			<table class="ubersicht">
				<tr>
					<td>Spielername</td>
					<td><input type="text" name="spieler_name" placeholder="username" required value="<?php echo get_in_galaxy_name($spieler_ID, 1); ?>"></td>
				</tr>
				<tr>
					<td>Start Koordinaten<sup>*</sup></td>
					<td><input type="text" name="startkkordinate" required placeholder="xx:yy" value=""></td>
				</tr>
				<tr>
					<td colspan=2 style="text-align: center;"><input type="submit" class="btn_main" value="Initialisiere"></td>
				</tr>
				<tr>
					<td colspan=2><sup><i>*(RND +/-5) Format: xx:yy Max: 50</i></sup></td>
				</tr>
					
			</table>
		</div>
		

		<input type="hidden" name="s" value="create_gamer"><input type="hidden" name="galaxy" value="1">
</form>		
	

</div>
