var ff = new Array();var ft = new Array(); var fm = new Array();
var toValidate = false;
function inputValidation(form,fields,fieldsType,fieldsMsg){		
	for(var i=0;i<fields.length;i++){				
		switch (fieldsType[i]){
			case "text":
				if((eval('form.'+fields[i]+'.value'))==''){
					alert(fieldsMsg[i]);
					eval('form.'+fields[i]+'.focus()');				
					return false;
				}
				break;
			case "select":
				if(eval('form.'+fields[i]+'[form.'+fields[i]+'.selectedIndex].text')==''){
					alert(fieldsMsg[i]);
					return false;
				}
				break;
			case "hidden":
				if((eval('form.'+fields[i]+'.value'))==''){
					alert(fieldsMsg[i]);
					return false;
				}
				break;			
		}
	}
	return true;
}