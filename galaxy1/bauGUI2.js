
function timeInWasSinnvolles(time){
		var tg = parseInt(time/(24*60*60)); 	time -= (tg*(24*60*60));		
		var h = parseInt(time/(60*60));		time -= (h*(60*60));
		var m = parseInt(time/(60));			time -= (m*(60));
		var s = parseInt(time);
		
		if (h<10) h = "0"+h;  	if (m<10) m = "0"+m;	if (s<10) s="0"+s;
		
		var timeStr = "";  
		if (tg > 0) timeStr = tg;
		if (tg > 1) timeStr += " Tage "; else if (tg > 0) timeStr+= " Tag ";
		timeStr += h+":"+m+":"+s;
		
		return timeStr;
}

function formZahl(zahl, kommastellen, kSep, tSep ) {
	zahl = Math.round( zahl * Math.pow(10, kommastellen) ) / Math.pow(10, kommastellen);
	strZahl = zahl+"";
	arrInt = strZahl.split(".");
	if(!arrInt[0]) arrInt[0] = "0";
	if(!arrInt[1]) arrInt[1] = "";
	if(arrInt[1].length < kommastellen){
		nachkomma = arrInt[1];
		for(i=arrInt[1].length+1; i <= kommastellen; i++){  nachkomma += "0";  }
		arrInt[1] = nachkomma;
	}
	if(tSep != "" && arrInt[0].length > 3){
		Begriff = arrInt[0];
		arrInt[0] = "";
		for(j = 3; j < Begriff.length ; j+=3){
			Extrakt = Begriff.slice(Begriff.length - j, Begriff.length - j + 3);
			arrInt[0] = tSep + Extrakt +  arrInt[0] + "";
		}
		strFirst = Begriff.substr(0, (Begriff.length % 3 == 0)?3:(Begriff.length % 3));
		arrInt[0] = strFirst + arrInt[0];
		}
	return arrInt[0]+kSep+arrInt[1];
}
function getMaxAnzahlBauV (idNr, rE, rS, rW, rB, rK) {
	maxAnzahl = 99;  tempAnzahl = 0;
	ressE = document.getElementById("gRessE" ).title - rE;
	ressS = document.getElementById("gRessS" ).title - rS;
	ressW = document.getElementById("gRessW" ).title - rW;
	ressB = document.getElementById("gRessB" ).title - rB;
	ressK = document.getElementById("gRessK" ).title - rK;
	
	if (document.getElementById("ressE" + idNr).title > 0) {
		tempAnzahl = Math.floor (ressE / document.getElementById("ressE" + idNr).title);
	} else {tempAnzahl = 99;}
	if (tempAnzahl < maxAnzahl) {maxAnzahl = tempAnzahl;} 

	if (document.getElementById("ressS" + idNr).title > 0) {
		tempAnzahl = Math.floor (ressS / document.getElementById("ressS" + idNr).title);
	} else {tempAnzahl = 99;}
	if (tempAnzahl < maxAnzahl) {maxAnzahl = tempAnzahl;} 

	if (document.getElementById("ressW" + idNr).title > 0) {
		tempAnzahl = Math.floor (ressW / document.getElementById("ressW" + idNr).title);
	} else {tempAnzahl = 99;}
	if (tempAnzahl < maxAnzahl) {maxAnzahl = tempAnzahl;} 

	if (document.getElementById("ressK" + idNr).title > 0) {
		tempAnzahl = Math.floor (ressK / document.getElementById("ressK" + idNr).title);
	} else {tempAnzahl = 99;}
	if (tempAnzahl < maxAnzahl) {maxAnzahl = tempAnzahl;} 

	if (document.getElementById("ressB" + idNr).title > 0) {
		tempAnzahl = Math.floor (ressB / document.getElementById("ressB" + idNr).title);
	} else {tempAnzahl = 99;}
	if (tempAnzahl < maxAnzahl) {maxAnzahl = tempAnzahl;} 
	
	if (maxAnzahl > 99) {maxAnzahl = 99;}
	
	return maxAnzahl;
}

function gRessRechnenUndEintragen (idNr){
	var deffCount = document.getElementById("deffCount").title;
	var gRessE = 0; 	var gRessS = 0;	var gRessW = 0;
	var gRessB = 0;	var gRessK = 0;	var gBauzeit = 0;
	
	for (i = 1; i <= deffCount; i++) {
		if (idNr != i && document.getElementById("ressE"+i)!==null) {
			anzahl = document.getElementById("eingabeFeld"+i).value;
			gRessE += document.getElementById("ressE" + i).title * anzahl;
			gRessS += document.getElementById("ressS" + i).title * anzahl;
			gRessW += document.getElementById("ressW" + i).title * anzahl;
			gRessB += document.getElementById("ressB" + i).title * anzahl;
			gRessK += document.getElementById("ressK" + i).title * anzahl;
			gBauzeit += document.getElementById("bauzeit" + i).title * anzahl;

		}
	}
	
	maxAnzahl = getMaxAnzahlBauV (idNr, gRessE, gRessS, gRessW, gRessB, gRessK);
	anzahl = document.getElementById("eingabeFeld"+idNr).value
	if (maxAnzahl < anzahl) {
		anzahl = maxAnzahl;
		document.getElementById("eingabeFeld"+idNr).value = maxAnzahl;
		document.getElementById("schieber"+idNr).value = maxAnzahl;
	}
	gRessE += document.getElementById("ressE" + idNr).title * anzahl;
	gRessS += document.getElementById("ressS" + idNr).title * anzahl;
	gRessW += document.getElementById("ressW" + idNr).title * anzahl;
	gRessB += document.getElementById("ressB" + idNr).title * anzahl;
	gRessK += document.getElementById("ressK" + idNr).title * anzahl;
	gBauzeit += document.getElementById("bauzeit" + idNr).title * anzahl;

	document.getElementById("gRessE" ).textContent = formZahl(gRessE,0,'','.');
	document.getElementById("gRessS").textContent = formZahl(gRessS,0,'','.');
	document.getElementById("gRessW").textContent = formZahl(gRessW,0,'','.');
	document.getElementById("gRessB").textContent = formZahl(gRessB,0,'','.');
	document.getElementById("gRessK").textContent = formZahl(gRessK,0,'','.');
	document.getElementById("gBauzeit").textContent = timeInWasSinnvolles(gBauzeit);
	
	return anzahl;
}

function schiebenUndBerechnen(id) {
	
	var idNr = 0;
	
	if (id.search("schieber") != -1 ) { 
		idNr = id.replace("schieber", "");
		document.getElementById("eingabeFeld" + idNr).value = document.getElementById(id).value;
	}
	if (id.search("eingabeFeld") != -1 ) { 
		idNr = id.replace("eingabeFeld", "");
		if (document.getElementById(id).value == "" ) {
			document.getElementById(id).value='0';
		} else if (document.getElementById("schieber" + idNr).max < parseInt(document.getElementById(id).value)) {
			document.getElementById(id).value = document.getElementById("schieber" + idNr).max;
		} else {
			document.getElementById("schieber" + idNr).value = document.getElementById(id).value;
		}
	}
	
	var anzahl = document.getElementById(id).value;
	var ressE = document.getElementById("ressE" + idNr).title;
	var ressS = document.getElementById("ressS" + idNr).title;
	var ressW = document.getElementById("ressW" + idNr).title;
	var ressB = document.getElementById("ressB" + idNr).title;
	var ressK = document.getElementById("ressK" + idNr).title;
	var bauzeit = document.getElementById("bauzeit" + idNr).title;

	anzahl = gRessRechnenUndEintragen (idNr, anzahl);

	if (anzahl > 1) {
		document.getElementById("ressE" + idNr).textContent = formZahl(anzahl * ressE,0,'','.');
		document.getElementById("ressS" + idNr).textContent = formZahl(anzahl * ressS,0,'','.');
		document.getElementById("ressW" + idNr).textContent = formZahl(anzahl * ressW,0,'','.');
		document.getElementById("ressB" + idNr).textContent = formZahl(anzahl * ressB,0,'','.');
		document.getElementById("ressK" + idNr).textContent = formZahl(anzahl * ressK,0,'','.');
		document.getElementById("bauzeit" + idNr).textContent = timeInWasSinnvolles(anzahl * bauzeit);
	} else {
		document.getElementById("ressE" + idNr).textContent = formZahl(ressE,0,'','.');
		document.getElementById("ressS" + idNr).textContent = formZahl(ressS,0,'','.');
		document.getElementById("ressW" + idNr).textContent = formZahl(ressW,0,'','.');
		document.getElementById("ressB" + idNr).textContent = formZahl(ressB,0,'','.');
		document.getElementById("ressK" + idNr).textContent = formZahl(ressK,0,'','.');
		document.getElementById("bauzeit" + idNr).textContent = timeInWasSinnvolles(bauzeit);
	}
 }

