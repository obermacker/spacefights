
var ts = new Date();

function displayNone(name, par) {
	/* Hide & Show by ES 22.06.2016 */
	var elemente = document.getElementsByName(name);
	for(var i=0; i<elemente.length; i++) {
		elemente[i].style.display=par;
		
	}
}	


function details(name) {
	var eButton = document.getElementsByName(name+"Button");

	if (eButton[0].className=="detailsGeschlossen") {
		displayNone(name,"");
	}
	else {	
		window.setTimeout("displayNone('"+name+"','none')",300);
	}
	
	setTimeout("detailsT2('"+name+"')",10);
	

}
	
function detailsT2(name) {
	var elemente = document.getElementsByName(name);
	var eButton = document.getElementsByName(name+"Button");
	
	if (eButton[0].className=="detailsGeschlossen") {
		eButton[0].className="detailsOffen";
		eButton[0].innerHTML = "▼";
	} else {
		eButton[0].className="detailsGeschlossen";
		eButton[0].innerHTML = "▶";
	}

	for(var i=0; i<elemente.length; i++) {
		if (elemente[i].className=="detailsAusgeblendet") {
			elemente[i].className="detailsEingeblendet";
		} else {
			elemente[i].className="detailsAusgeblendet";	
		}
	}
}

function mPBarGlow(){
	/* Progressbar by ES 12.06.2016 */
	var elemente = document.getElementsByClassName("pBar");
	var weiterGluehen = true;
	var daGluehtNochWas=false;

for(var i=0; i<elemente.length; i++) {
		if (elemente[i].classList.contains("pBar") && elemente[i].title != "-") {
			elemente[i].classList.toggle("pBarG");
			daGluehtNochWas=true;
		} else {
			elemente[i].classList.remove("pBarG");
		}
		if (elemente[i].title == "-" && !daGluehtNochWas) {weiterGluehen=false;}else{weiterGluehen=true;};
	}
	if (weiterGluehen) {window.setTimeout("mPBarGlow()",3000);}
}

mPBarGlow();

function mPBar(soll, ist, maxWidth, name){
	/* Progressbar by ES 12.06.2016 */
	var e = document.getElementById(name);
	var w = 0;
	w = ist/ soll * maxWidth;
	e.style.width = w + "%";
	if (soll==ist) {e.title="-";}
}

function countdown_progress(sec, name, start, ende, beschriftung,maxWidth,ohnePBar){

	if (maxWidth == undefined) {maxWidth = 100;}
	if (ohnePBar == undefined) {ohnePBar = false;}
	
	var e = document.getElementById(name);
	var tn = new Date();
	var tl = ((sec*1000)-(tn.getTime()-ts.getTime()))/1000;

	if (tl>0.5){	
		if (!ohnePBar){mPBar(ende, (ende - tl),maxWidth,"mPBar_"+name);}
		var t = parseInt(tl/(24*60*60));
		tl = tl-(t*(24*60*60));		
		var h = parseInt(tl/(60*60));
		tl = tl-(h*(60*60));
		var m = parseInt(tl/(60));
		tl = tl-(m*(60));
		var s = parseInt(tl);
		if (h<10) h="0"+h;
		if (m<10) m="0"+m;
		if (s<10) s="0"+s;
		if (t == 0) { var tstr = h+":"+m+":"+s; } else { var tstr = t ; if (t==1) { tstr+= " Tag "; } else {tstr +=" Tage ";} tstr += h+":"+m+":"+s; }		
		e.innerHTML = tstr;
		window.setTimeout("countdown_progress("+sec+",'"+name+"',"+start+","+ende+",'"+beschriftung+"',"+maxWidth+","+ohnePBar+")",500);
	} else{
		e.innerHTML = "<a href='index.php?s="+document.getElementById("globalJsVariables" ).attributes.select.value+"'>" + "abgelaufen" + "</a>";			
		if (!ohnePBar){mPBar(100,100,maxWidth,"mPBar_"+name)};
	}
}

function countdown(sec, name){
	var e = document.getElementById(name);
	var tn = new Date();
	var tl = ((sec*1000)-(tn.getTime()-ts.getTime()))/1000;

	if (tl>1){				
		var t = parseInt(tl/(24*60*60));
		tl = tl-(t*(24*60*60));		
		var h = parseInt(tl/(60*60));
		tl = tl-(h*(60*60));
		var m = parseInt(tl/(60));
		tl = tl-(m*(60));
		var s = parseInt(tl);
		if (h<10) h="0"+h;
		if (m<10) m="0"+m;
		if (s<10) s="0"+s;
		if (t == 0) { var tstr = h+":"+m+":"+s; } else { var tstr = t ; if (t==1) { tstr+= " Tag "; } else {tstr +=" Tage ";} tstr += h+":"+m+":"+s; }		
		e.innerHTML = tstr;
		window.setTimeout("countdown("+sec+",'"+name+"')",500);
	} else{
		e.innerHTML = "<a href='index.php?s="+document.getElementById("globalJsVariables" ).attributes.select.value+"'>" + "abgelaufen" + "</a>";			
	}
}


// --></script>
