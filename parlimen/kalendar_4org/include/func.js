function explode(inputstring, separators, includeEmpties) {
	inputstring = new String(inputstring);
	separators = new String(separators);

	if(separators == "undefined") { 
		separators = " :;";
	}

	fixedExplode = new Array(1);
	
	currentElement = "";
	count = 0;
	for(x=0; x < inputstring.length; x++) {
		charX = inputstring.charAt(x);
		if(separators.indexOf(charX) != -1) {
		if ( ( (includeEmpties <= 0) || (includeEmpties == false)) && (currentElement == "")) { }
		else {
			fixedExplode[count] = currentElement;
			count++;
			currentElement = ""; } }
		else { currentElement += charX; }
	}

	if (( ! (includeEmpties <= 0) && (includeEmpties != false)) || (currentElement != "")) {
			fixedExplode[count] = currentElement; 
	}
		
	return fixedExplode;
}

//Rich Text Editor
//Untuk tukar skin
function FCKeditor_OnComplete( editorInstance ){
	var oCombo = document.getElementById( 'cmbSkins' ) ;

	// Get the active skin.
	var sSkin = editorInstance.Config['SkinPath'] ;
	sSkin = sSkin.match( /[^\/]+(?=\/$)/g ) ;
	
	oCombo.value = sSkin ;
	oCombo.style.visibility = '' ;
}

function ChangeSkin( skinName ){
	window.location.href = window.location.pathname + "?Skin=" + skinName ;
}
//Rich Text Editor