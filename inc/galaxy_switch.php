<?php $anzahl_planeten[2] = get_anzahl_planeten($spieler_ID, 3); ?>

<?php 


for ($i = 0; $i <= 2; $i++){
	if (get_anzahl_planeten($spieler_ID, $i + 1) == 0) {
		$url[$i] = "galaxy.php";
		$Beschriftung[$i] = "Initialisiere";
		$s[$i] = "initialisiere";
	} else{
		$url[$i] = "galaxy".($i + 1)."/index.php";
		$Beschriftung[$i] = "Sprung";
		$s[$i] = "index";
	}
	
	if ($i <> 0) { 		
		$url[$i] = "#";
		$Beschriftung[$i] = "n/v";
		$s[$i] = "#";
	}
	
}




?>

	<div class="flex">
	    <div>
		    <h2>Galaxy 1</h2>
		    <form action="<?php echo $url[0]; ?>" method="post">
		    	<?php echo get_in_galaxy_name($spieler_ID, 1); ?>
    			<input type="hidden" name="s" value="<?php  echo $s[0]; ?>">
    			<input type="hidden" name="galaxy" value="1"><br>
    			<input type="submit" class="btn_main" value="<?php echo $Beschriftung[0]; ?>">
			</form>		    
	    </div>
	    
	    <div>
		    <h2>Galaxy 2</h2>
				<form action="<?php echo $url[1]; ?>">
				<?php echo get_in_galaxy_name($spieler_ID, 2); ?>
    			<input type="hidden" name="s" value="<?php  echo $s[1]; ?>">
    			<input type="hidden" name="galaxy" value="2"><br>
    			<input type="submit" class="btn_main" value="<?php echo $Beschriftung[1]; ?>">
			</form>		    
		    	    </div>
	    
	    <div>
		    <h2>Galaxy 3</h2>
		    <form action="<?php echo $url[2]; ?>">
		        <?php echo get_in_galaxy_name($spieler_ID, 3); ?>
		    	<input type="hidden" name="s" value="<?php  echo $s[2]; ?>">
    			<input type="hidden" name="galaxy" value="3"><br>
    			<input type="submit" class="btn_main" value="<?php echo $Beschriftung[2]; ?>">
			</form>		    
		    	    </div>
	    
	</div>