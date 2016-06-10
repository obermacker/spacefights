/**
 * Flotte v15.04.2016
 */

function Distanzen(x1, y1, z1, x2, y2, z2) {
    
	var x1 = Math.abs(x1); 
	var y1 = Math.abs(y1);
	var z1 = Math.abs(z1);
	
	var x2 = Math.abs(x2); 
	var y2 = Math.abs(y2);
	var z2 = Math.abs(z2);
	
	if(x2 == 0 || y2 == 0 || z2 == 0) { return "err";}
	
	if(x1 == x2 & y1 == y2) { //Distanz im eigenen System
		document.getElementById('DistanzPS').value = "P";
		var distanz = Math.abs(z1 - z2);		
		
		return distanz;
		
		
	} else { //Distanz zum entfernten System
		document.getElementById('DistanzPS').value = "S";
		var distanz = Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
		
		distanz = distanz * 10;
		distanz = Math.round(distanz);
		distanz = distanz / 10;

		
		return distanz;
	}
		
}

function Koordinaten_vorauswahl() {
	
	var e = document.getElementById("Planiwahl");
	var koords_gesamt = e.options[e.selectedIndex].value;
	if(koords_gesamt != '') {

		var kord_einzel = koords_gesamt.split(':');
		
		kord_alt = new Array();
		
		kord_alt[0] = document.getElementById("x").value + 0; 
		kord_alt[1] = document.getElementById("y").value + 0;
		kord_alt[2] = document.getElementById("z").value + 0;

		
		document.getElementById("x").value = kord_einzel[0]; 
		document.getElementById("y").value = kord_einzel[1];
		document.getElementById("z").value = kord_einzel[2];
		
		for(i = 0; i<= 2; i++) {
			if(kord_alt[i] != kord_einzel[i]) {
				
				switch(i) {
			    case 0:
			    	document.getElementById("x").onchange();			        
			        break;
			    case 1:
			    	document.getElementById("y").onchange();
			        break;
			    case 2:
			    	document.getElementById("z").onchange();
			        break;
				} 
				
			}
		}
		
		
	}
	
	
}