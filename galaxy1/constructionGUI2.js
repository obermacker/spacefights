function timeToUsefullOutput(time){
	// written by ES  Sep 2016

	var tg = parseInt(time/(24*60*60)); 	time -= (tg*(24*60*60));		
	var h = parseInt(time/(60*60));		time -= (h*(60*60));
	var m = parseInt(time/(60));			time -= (m*(60));
	var s = parseInt(time);
	
	if (h<10) h = "0"+h;  	if (m<10) m = "0"+m;	if (s<10) s="0"+s;
	
	var timeStr = "";  
	if (tg > 0) timeStr = tg;
	if (tg > 1) timeStr += ' ' + document.getElementById("lng_defaults").attributes.cd_plural.value + ' ';  
		else if (tg > 0) timeStr+= ' ' + document.getElementById("lng_defaults").attributes.cd_single.value + ' ';
	timeStr += h+":"+m+":"+s;
	
	return timeStr;
}

function formatNumber(number, maxDecimals ) {
	// written by ES  Sep 2016

	tSep = document.getElementById("lng_defaults").attributes.thousands_sep.value;
	dSep = document.getElementById("lng_defaults").attributes.decimal_point.value;
	if(maxDecimals == 0) dSep = ''; 
	number = Math.round( number * Math.pow(10, maxDecimals) ) / Math.pow(10, maxDecimals);
	strNumber = number+"";
	arrInt = strNumber.split(".");
	if(!arrInt[0]) arrInt[0] = "0";
	if(!arrInt[1]) arrInt[1] = "";
	if(arrInt[1].length < maxDecimals){
		decimals = arrInt[1];
		for(i=arrInt[1].length+1; i <= maxDecimals; i++){  decimals += "0";  }
		arrInt[1] = decimals;
	}
	if(tSep != "" && arrInt[0].length > 3){
		tempArray = arrInt[0];
		arrInt[0] = "";
		for(j = 3; j < tempArray.length ; j+=3){
			extract = tempArray.slice(tempArray.length - j, tempArray.length - j + 3);
			arrInt[0] = tSep + extract +  arrInt[0] + "";
		}
		strFirst = tempArray.substr(0, (tempArray.length % 3 == 0)?3:(tempArray.length % 3));
		arrInt[0] = strFirst + arrInt[0];
		}
	return arrInt[0]+dSep+arrInt[1];
}

function getMaxNumberOfPossibleConstructions (idNumber, rI, rS, rW, rB, rK) {
	// written by ES  Sep 2016

	maxQuantity = 99;  tempQuantity = 0;
	
	resI = document.getElementById("totalResI" ).attributes.availableRes.value - rI;
	resS = document.getElementById("totalResS" ).attributes.availableRes.value - rS;
	resW = document.getElementById("totalResW" ).attributes.availableRes.value - rW;
	resB = document.getElementById("totalResB" ).attributes.availableRes.value - rB;
	resK = document.getElementById("totalResK" ).attributes.availableRes.value - rK;
	
	if (document.getElementById("resI" + idNumber).attributes.rateForOneItem.value > 0) {
		tempQuantity = Math.floor (resI / document.getElementById("resI" + idNumber).attributes.rateForOneItem.value);
	} else {tempQuantity = 99;}
	if (tempQuantity < maxQuantity) {maxQuantity = tempQuantity;} 

	if (document.getElementById("resS" + idNumber).attributes.rateForOneItem.value > 0) {
		tempQuantity = Math.floor (resS / document.getElementById("resS" + idNumber).attributes.rateForOneItem.value);
	} else {tempQuantity = 99;}
	if (tempQuantity < maxQuantity) {maxQuantity = tempQuantity;} 

	if (document.getElementById("resW" + idNumber).attributes.rateForOneItem.value > 0) {
		tempQuantity = Math.floor (resW / document.getElementById("resW" + idNumber).attributes.rateForOneItem.value);
	} else {tempQuantity = 99;}
	if (tempQuantity < maxQuantity) {maxQuantity = tempQuantity;} 

	if (document.getElementById("resK" + idNumber).attributes.rateForOneItem.value > 0) {
		tempQuantity = Math.floor (resK / document.getElementById("resK" + idNumber).attributes.rateForOneItem.value);
	} else {tempQuantity = 99;}
	if (tempQuantity < maxQuantity) {maxQuantity = tempQuantity;} 

	if (document.getElementById("resB" + idNumber).attributes.rateForOneItem.value > 0) {
		tempQuantity = Math.floor (resB / document.getElementById("resB" + idNumber).attributes.rateForOneItem.value);
	} else {tempQuantity = 99;}
	if (tempQuantity < maxQuantity) {maxQuantity = tempQuantity;} 
	
	if (maxQuantity > 99) {maxQuantity = 99;}
	
	return maxQuantity;
}

function totalResCalculateAndOutput (idNumber){
	// written by ES  Sep 2016

	var quantityOfConstructions = document.getElementById("varTransfer").attributes.quantityOfConstructions.value;
	var totalResI = 0; 	var totalResS = 0;	var totalResW = 0;
	var totalResB = 0;	var totalResK = 0;	var totalConstructionTime = 0;
	
	for (i = 1; i <= quantityOfConstructions; i++) {
		if (idNumber != i && document.getElementById("resI"+i)!==null) {
			quantity = document.getElementById("inputField"+i).value;
			totalResI += document.getElementById("resI" + i).attributes.rateForOneItem.value * quantity;
			totalResS += document.getElementById("resS" + i).attributes.rateForOneItem.value * quantity;
			totalResW += document.getElementById("resW" + i).attributes.rateForOneItem.value * quantity;
			totalResB += document.getElementById("resB" + i).attributes.rateForOneItem.value * quantity;
			totalResK += document.getElementById("resK" + i).attributes.rateForOneItem.value * quantity;
			totalConstructionTime += document.getElementById("constructionTime" + i).attributes.rateForOneItem.value * quantity;

		}
	}
	
	maxQuantity = getMaxNumberOfPossibleConstructions (idNumber, totalResI, totalResS, totalResW, totalResB, totalResK);
	quantity = document.getElementById("inputField"+idNumber).value
	if (maxQuantity < quantity) {
		quantity = maxQuantity;
		document.getElementById("inputField"+idNumber).value = maxQuantity;
		document.getElementById("slider"+idNumber).value = maxQuantity;
	}
	totalResI += document.getElementById("resI" + idNumber).attributes.rateForOneItem.value * quantity;
	totalResS += document.getElementById("resS" + idNumber).attributes.rateForOneItem.value * quantity;
	totalResW += document.getElementById("resW" + idNumber).attributes.rateForOneItem.value * quantity;
	totalResB += document.getElementById("resB" + idNumber).attributes.rateForOneItem.value * quantity;
	totalResK += document.getElementById("resK" + idNumber).attributes.rateForOneItem.value * quantity;
	totalConstructionTime += document.getElementById("constructionTime" + idNumber).attributes.rateForOneItem.value * quantity;

	document.getElementById("totalResI" ).textContent = formatNumber(totalResI,0);
	document.getElementById("totalResS").textContent = formatNumber(totalResS,0);
	document.getElementById("totalResW").textContent = formatNumber(totalResW,0);
	document.getElementById("totalResB").textContent = formatNumber(totalResB,0);
	document.getElementById("totalResK").textContent = formatNumber(totalResK,0);
	document.getElementById("totalConstructionTime").textContent = timeToUsefullOutput(totalConstructionTime);
	
	return quantity;
}

function slideAndCalculate(id) {
	// written by ES  Sep 2016

	var idNumber = 0;
	
	if (id.search("slider") != -1 ) { 
		idNumber = id.replace("slider", "");
		document.getElementById("inputField" + idNumber).value = document.getElementById(id).value;
	}
	if (id.search("inputField") != -1 ) { 
		idNumber = id.replace("inputField", "");
		if (document.getElementById(id).value == "" ) {
			document.getElementById(id).value='0';
		} else if (document.getElementById("slider" + idNumber).max < parseInt(document.getElementById(id).value)) {
			document.getElementById(id).value = document.getElementById("slider" + idNumber).max;
		} else {
			document.getElementById("slider" + idNumber).value = document.getElementById(id).value;
		}
	}
	
	var quantity = document.getElementById(id).value;
	var resI = document.getElementById("resI" + idNumber).attributes.rateForOneItem.value;
	var resS = document.getElementById("resS" + idNumber).attributes.rateForOneItem.value;
	var resW = document.getElementById("resW" + idNumber).attributes.rateForOneItem.value;
	var resB = document.getElementById("resB" + idNumber).attributes.rateForOneItem.value;
	var resK = document.getElementById("resK" + idNumber).attributes.rateForOneItem.value;
	var constructionTime = document.getElementById("constructionTime" + idNumber).attributes.rateForOneItem.value;

	quantity = totalResCalculateAndOutput  (idNumber, quantity);

	if (quantity > 1) {
		document.getElementById("resI" + idNumber).textContent = formatNumber(quantity * resI,0);
		document.getElementById("resS" + idNumber).textContent = formatNumber(quantity * resS,0);
		document.getElementById("resW" + idNumber).textContent = formatNumber(quantity * resW,0);
		document.getElementById("resB" + idNumber).textContent = formatNumber(quantity * resB,0);
		document.getElementById("resK" + idNumber).textContent = formatNumber(quantity * resK,0);
		document.getElementById("constructionTime" + idNumber).textContent = timeToUsefullOutput(quantity * constructionTime);
	} else {
		document.getElementById("resI" + idNumber).textContent = formatNumber(resI,0);
		document.getElementById("resS" + idNumber).textContent = formatNumber(resS,0);
		document.getElementById("resW" + idNumber).textContent = formatNumber(resW,0);
		document.getElementById("resB" + idNumber).textContent = formatNumber(resB,0);
		document.getElementById("resK" + idNumber).textContent = formatNumber(resK,0);
		document.getElementById("constructionTime" + idNumber).textContent = timeToUsefullOutput(constructionTime);
	}
 }


 /************ Hide & Show by ES 2024 ***************/

 function displayNone(name, par) {
	var elemente = document.getElementsByName(name);
	for(var i=0; i<elemente.length; i++) {
		elemente[i].style.display=par;
	}
}	

 
function toggleDetails(name) {
	var eButton = document.getElementsByName(name+'Button');
	 
	if (eButton[0].className.match('detailsNotShown')) {
		displayNone(name,'');
	} else {	
		setTimeout('displayNone("'+name+'","none")',300);
	}
	setTimeout('toggleDetailsPart2("'+name+'")',10);
}
	 

function toggleDetailsPart2(name) {
	var elemente = document.getElementsByName(name);
	var eButton = document.getElementsByName(name+"Button");
	 
	if (eButton[0].className.match('detailsNotShown')) {
		eButton[0].className = eButton[0].className.replace('detailsNotShown','detailsAreShown');
		eButton[0].innerHTML = "▼";
	} else {
		eButton[0].className = eButton[0].className.replace('detailsAreShown','detailsNotShown');
		eButton[0].innerHTML = "▶";
	}
 
	for(var i=0; i<elemente.length; i++) {
		if (elemente[i].className.match('detailsHidden')) {
			elemente[i].className=elemente[i].className.replace('detailsHidden','detailsShown');
		} else {
			elemente[i].className=elemente[i].className.replace('detailsShown','detailsHidden');	
		}
	}
}