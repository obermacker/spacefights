<div class="flex_uebersicht">
<div>
				<form action="galaxy.php" method="post" autocomplete="off">	
				<div><label for="spieler_name">Spielername</label><input type="text" name="spieler_name" placeholder="username" required value="<?php echo get_in_galaxy_name($spieler_ID, 1); ?>"></div>
				<div><label for="startkkordinate">Start Koordinaten<sup>*</sup></label><input type="text" name="startkkordinate" required placeholder="xx:yy" value=""><br>				
				</div>
    			<input type="hidden" name="s" value="create_gamer">
    			<input type="hidden" name="galaxy" value="1"><br>
    			<input type="submit" class="btn_main" value="Initialisiere"><br>
    			<sup><i>*(RND +/-5) Format: xx:yy Max: 50</i></sup>
    			</form>
		    
	    </div>
	</div>

